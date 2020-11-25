<?php

use MimeType\Detector;
use PHPUnit\Framework\TestCase;
use MimeType\MimeType;

class DetectorTest extends TestCase
{

    public function testGetFileType_Docx()
    {
        $detector = new Detector($this->storagePath('b.docx'));
        $type = $detector->getFileType();
        $this->assertTrue(MimeType::getFileType(MimeType::WORDX)->equal($type));
    }

    public function testGetFileType_Txt()
    {
        $detector = new Detector($this->storagePath('t.txt'));
        $type = $detector->getFileType();
        $this->assertTrue(MimeType::getFileType(MimeType::TXT)->equal($type));
    }

    public function testGetFileType_Xlsx()
    {
        $detector = new Detector($this->storagePath('x.xlsx'));
        $type = $detector->getFileType();
        $this->assertTrue(MimeType::getFileType(MimeType::EXCELX)->equal($type));
    }

    public function testGetFileType_CSV()
    {
        $detector = new Detector($this->storagePath('c.csv'));
        $type = $detector->getFileType();
        $this->assertTrue(MimeType::getFileType(MimeType::TXT)->equal($type));
    }

    public function testGetFileType_Jpg()
    {
        $detector = new Detector($this->storagePath('8.jpg'));
        $type = $detector->getFileType();
        $this->assertTrue(MimeType::getFileType(MimeType::JPEG)->equal($type));
    }

    private function storagePath($fileName)
    {
        return $this->getStoragePath() . DIRECTORY_SEPARATOR . $fileName;
    }

    private function getStoragePath()
    {
        return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'storage';
    }

}