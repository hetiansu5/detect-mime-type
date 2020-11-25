<?php

namespace MimeType;

class FileType
{

    public $header;

    public $headerOffset;

    public $extension;

    public $mime;

    public function __construct($header, $offset, $extension, $mime)
    {
        $this->header = $header;
        $this->headerOffset = $offset;
        $this->extension = $extension;
        $this->mime = $mime;
    }

    /**
     * @param $fileType
     * @return bool
     */
    public function equal($fileType)
    {
        if (!$fileType instanceof FileType) {
            return false;
        }
        return $this->extension == $fileType->extension && $this->mime == $fileType->mime;
    }
}