<?php

namespace MimeType;

use MimeType\Exception\FileException;

class Detector
{

    /**
     * @var FileInfo
     */
    private $fileInfo;

    public function __construct($filePath)
    {
        $this->setFile($filePath);
    }

    public function setFile($filePath)
    {
        $this->fileInfo = new FileInfo($filePath);
        return $this;
    }

    /**
     * @return FileType|null
     * @throws Exception\FileException
     */
    public function getFileType()
    {
        $mimeTypes = MimeType::getMimeTypes();
        $zipFileType = MimeType::getFileType(MimeType::ZIP);
        $fullFileName = $this->fileInfo->getRealPath();
        $fileType = null;

        $fileHeader = $this->fileInfo->getFileHeader(MimeType::MAX_HEADER_SIZE);
        if (!$this->stringMatchAny($fileHeader, function ($value) {
            return ord($value) == 0;
        })) {
            $fileType = MimeType::getFileType(MimeType::TXT);
        } else {
            // compare the file header to the stored file headers
            foreach ($mimeTypes as $constValue) {
                $type = MimeType::getFileType($constValue);
                $matchingCount = $this->getFileMatchingCount($fileHeader, $type);
                $length = count($type->header);
                if ($matchingCount == $length) {
                    // check for docx and xlsx only if a file name is given
                    // there may be situations where the file name is not given
                    // or it is unpracticable to write a temp file to get the FileInfo
                    if ($type->equal($zipFileType) && !empty($fullFileName)) {
                        $fileType = $this->checkForDocxAndXlsx($fullFileName);
                    } else {
                        // if all the bytes match, return the type
                        $fileType = $type;
                    }
                    break;
                }
            }
        }
        return $fileType;
    }

    protected function getFileMatchingCount($fileHeader, FileType $type)
    {
        $matchingCount = 0;
        $length = count($type->header);
        for ($i = 0; $i < $length; $i++) {
            // if file offset is not set to zero, we need to take this into account when comparing.
            // if byte in type.header is set to null, means this byte is variable, ignore it
            if (isset($type->header) && $type->header[$i] != ord($fileHeader{$i + $type->headerOffset})) {
                // if one of the bytes does not match, move on to the next type
                $matchingCount = 0;
                break;
            } else {
                $matchingCount++;
            }
        }
        return $matchingCount;
    }

    /**
     * @param string $str
     * @param \Closure $callable
     * @return bool
     */
    protected function stringMatchAny($str, $callable)
    {
        $length = strlen($str);
        for ($i = 0; $i < $length; $i++) {
            if ($callable($str{$i})) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $fileFullName
     * @return FileType|null
     * @throws FileException
     */
    protected function checkForDocxAndXlsx($fileFullName)
    {
        $zip = new \ZipArchive();
        if (!$zip->open($fileFullName)) {
            throw new FileException("cannot open file:" . $fileFullName);
        }
        if ($this->zipMatchAny($zip, 'word/')) {
            return MimeType::getFileType(MimeType::WORDX);
        }
        if ($this->zipMatchAny($zip, 'xl/')) {
            return MimeType::getFileType(MimeType::EXCELX);
        }
        return $this->checkForOdtAndOds($zip);
    }

    /**
     * @param \ZipArchive $zip
     * @return FileType|null
     */
    protected function checkForOdtAndOds($zip)
    {
        $index = $zip->locateName('mimetype');
        if ($index === false) {
            $index = 1;
        }
        $mimeType = $zip->getFromIndex($index);

        $odt = MimeType::getFileType(MimeType::ODT);
        if ($odt->mime == $mimeType) {
            return $odt;
        }

        $ods = MimeType::getFileType(MimeType::ODS);
        if ($ods->mime == $mimeType) {
            return $ods;
        }

        return null;
    }

    /**
     * @param \ZipArchive $zip
     * @param $prefix
     * @return bool
     */
    protected function zipMatchAny($zip, $prefix)
    {
        $index = 0;
        $len = strlen($prefix);
        while ($index < 100) {
            $name = $zip->getNameIndex($index++);
            if ($name === false) {
                break;
            }
            if (substr($name, 0, $len) == $prefix) {
                return true;
            }
        }
        return false;
    }

}