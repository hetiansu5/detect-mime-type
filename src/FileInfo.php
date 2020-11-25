<?php

namespace MimeType;

use MimeType\Exception\FileException;

class FileInfo extends \SplFileInfo
{

    /**
     * @param $maxHeaderSize
     * @return string
     * @throws FileException
     */
    public function getFileHeader($maxHeaderSize)
    {
        if (!$this->isReadable()) {
            throw new FileException("could not read file:" . $this->getPath());
        }
        $fileObject = $this->openFile('r');
        return $fileObject->fread($maxHeaderSize);
    }

}