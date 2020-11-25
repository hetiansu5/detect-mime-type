<?php

namespace MimeType;

class MimeType
{

    //office and documents
    const WORD = 1;
    const EXCEL = 2;
    const PPT = 3;

    //ms office and openoffice docs (they're zip files: rename and enjoy!)
    //don't add them to the list, as they will be 'subtypes' of the ZIP type
    const WORDX = 4;
    const EXCELX = 5;
    const ODT = 6;
    const ODS = 7;

    // common documents
    const RTF = 8;
    const PDF = 9;
    const MSDOC = 10;
    //application/xml text/xml
    const XML = 11;

    //text files
    const TXT = 20;
    const TXT_UTF8 = 21;
    const TXT_UTF16_BE = 22;
    const TXT_UTF16_LE = 23;
    const TXT_UTF32_BE = 24;
    const TXT_UTF32_LE = 25;

    //Graphics jpeg, png, gif, bmp, ico
    const JPEG = 100;
    const PNG = 101;
    const GIF = 102;
    const BMP = 103;
    const ICO = 104;

    //Zip, 7zip, rar, dll_exe, tar, bz2, gz_tgz
    const GZ_TGZ = 200;
    const ZIP_7Z = 201;
    const ZIP_7Z_2 = 202;
    const ZIP = 203;
    const RAR = 204;
    const DLL_EXE = 205;
    //Compressed tape archive file using standard (Lempel-Ziv-Welch) compression
    const TAR_ZV = 206;
    //Compressed tape archive file using LZH (Lempel-Ziv-Huffman) compression
    const TAR_ZH = 207;
    //bzip2 compressed archive
    const BZ2 = 208;


    //Media ogg, midi, flv, dwg, pst, psd
    const OGG = 300;
    const MIDI = 301;
    const FLV = 302;
    const WAVE = 303;
    const PST = 304;
    const DWG = 305;
    const PSD = 306;


    const LIB_COFF = 350;

    //AES Crypt file format. (The fourth byte is the version number.)
    const AES = 400;
    //SKR	 	PGP secret keyring file
    const SKR = 401;
    //SKR	 	PGP secret keyring file
    const SKR_2 = 402;
    //PKR	 	PGP public keyring file
    const PKR = 403;

    /*
     * 46 72 6F 6D 20 20 20 or	 	From
    46 72 6F 6D 20 3F 3F 3F or	 	From ???
    46 72 6F 6D 3A 20	 	From:
    EML	 	A commmon file extension for e-mail files. Signatures shown here
    are for Netscape, Eudora, and a generic signature, respectively.
    EML is also used by Outlook Express and QuickMail.
     */
    const EML_FROM = 500;
    //EVTX	 	Windows Vista event log file
    const ELF = 501;

    const MAX_HEADER_SIZE = 560;

    private static $config = [];

    public static function getMimeTypes()
    {
        return [
            self::WORD,
            self::EXCEL,
            self::PPT,
            self::RTF,
            self::PDF,
            self::MSDOC,
            self::XML,
            self::TXT_UTF8,
            self::TXT_UTF16_BE,
            self::TXT_UTF16_LE,
            self::TXT_UTF32_BE,
            self::TXT_UTF32_LE,
            self::JPEG,
            self::PNG,
            self::GIF,
            self::BMP,
            self::ICO,
            self::GZ_TGZ,
            self::ZIP_7Z,
            self::ZIP_7Z_2,
            self::ZIP,
            self::RAR,
            self::DLL_EXE,
            self::TAR_ZV,
            self::TAR_ZH,
            self::BZ2,
            self::OGG,
            self::MIDI,
            self::FLV,
            self::WAVE,
            self::PST,
            self::DWG,
            self::PSD,
            self::LIB_COFF,
            self::AES,
            self::SKR,
            self::SKR_2,
            self::PKR,
            self::EML_FROM,
            self::ELF,
        ];
    }

    /**
     * @param int $constValue
     * @return FileType|null
     */
    public static function getFileType($constValue)
    {
        $config = self::getConfig();
        return isset($config[$constValue]) ? $config[$constValue] : null;
    }

    private static function getConfig()
    {
        if (!empty(self::$config)) {
            return self::$config;
        }

        return self::$config = [
            self::WORD => new FileType([0xEC, 0xA5, 0xC1, 0x00], 512, 'doc', 'application/msword'),
            self::EXCEL => new FileType([0x09, 0x08, 0x10, 0x00, 0x00, 0x06, 0x05, 0x00], 512, "xls", "application/excel"),
            self::PPT => new FileType([0xFD, 0xFF, 0xFF, 0xFF, null, 0x00, 0x00, 0x00], 512, "ppt", "application/mspowerpoint"),
            self::WORDX => new FileType([0], 512, "docx", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"),
            self::EXCELX => new FileType([0], 512, "xlsx", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"),
            self::ODT => new FileType([0], 512, "odt", "application/vnd.oasis.opendocument.text"),
            self::ODS => new FileType([0], 512, "ods", "application/vnd.oasis.opendocument.spreadsheet"),
            self::RTF => new FileType([0x7B, 0x5C, 0x72, 0x74, 0x66, 0x31], 0, "rtf", "application/rtf"),
            self::PDF => new FileType([0x25, 0x50, 0x44, 0x46], 0, "pdf", "application/pdf"),
            self::MSDOC => new FileType([0xD0, 0xCF, 0x11, 0xE0, 0xA1, 0xB1, 0x1A, 0xE1], 0, "", "application/octet-stream"),
            self::XML => new FileType([0x72, 0x73, 0x69, 0x6F, 0x6E, 0x3D, 0x22, 0x31, 0x2E, 0x30, 0x22, 0x3F, 0x3E], 0, "xml,xul", "text/xml"),
            self::TXT => new FileType([0], 0, "txt", "text/plain"),
            self::TXT_UTF8 => new FileType([0xEF, 0xBB, 0xBF], 0, "txt", "text/plain"),
            self::TXT_UTF16_BE => new FileType([0xFE, 0xFF], 0, "txt", "text/plain"),
            self::TXT_UTF16_LE => new FileType([0xFF, 0xFE], 0, "txt", "text/plain"),
            self::TXT_UTF32_BE => new FileType([0x00, 0x00, 0xFE, 0xFF], 0, "txt", "text/plain"),
            self::TXT_UTF32_LE => new FileType([0xFF, 0xFE, 0x00, 0x00], 0, "txt", "text/plain"),
            self::JPEG => new FileType([0xFF, 0xD8, 0xFF], 0, "jpg", "image/jpeg"),
            self::PNG => new FileType([0x89, 0x50, 0x4E, 0x47, 0x0D, 0x0A, 0x1A, 0x0A], 0, "png", "image/png"),
            self::GIF => new FileType([0x47, 0x49, 0x46, 0x38, null, 0x61], 0, "gif", "image/gif"),
            self::BMP => new FileType([66, 77], 0, "bmp", "image/gif"),
            self::ICO => new FileType([0, 0, 1, 0], 0, "ico", "image/x-icon"),
            self::GZ_TGZ => new FileType([0x1F, 0x8B, 0x08], 0, "gz, tgz", "application/x-gz"),
            self::ZIP_7Z => new FileType([66, 77], 0, "7z", "application/x-compressed"),
            self::ZIP_7Z_2 => new FileType([0x37, 0x7A, 0xBC, 0xAF, 0x27, 0x1C], 0, "7z", "application/x-compressed"),
            self::ZIP => new FileType([0x50, 0x4B, 0x03, 0x04], 0, "zip", "application/x-compressed"),
            self::RAR => new FileType([0x52, 0x61, 0x72, 0x21], 0, "rar", "application/x-compressed"),
            self::DLL_EXE => new FileType([0x4D, 0x5A], 0, "dll, exe", "application/octet-stream"),
            self::TAR_ZV => new FileType([0x1F, 0x9D], 0, "tar.z", "application/x-tar"),
            self::TAR_ZH => new FileType([0x1F, 0xA0], 0, "tar.z", "application/x-tar"),
            self::BZ2 => new FileType([0x42, 0x5A, 0x68], 0, "bz2,tar,bz2,tbz2,tb2", "application/x-bzip2"),
            self::OGG => new FileType([103, 103, 83, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0], 0, "oga,ogg,ogv,ogx", "application/ogg"),
            self::MIDI => new FileType([0x4D, 0x54, 0x68, 0x64], 0, "midi,mid", "audio/midi"),
            self::FLV => new FileType([0x46, 0x4C, 0x56, 0x01], 0, "flv", "application/unknown"),
            self::WAVE => new FileType([0x52, 0x49, 0x46, 0x46, null, null, null, null, 0x57, 0x41, 0x56, 0x45, 0x66, 0x6D, 0x74, 0x20], 0, "wav", "audio/wav"),
            self::PST => new FileType([0x21, 0x42, 0x44, 0x4E], 0, "pst", "application/octet-stream"),
            self::DWG => new FileType([0x41, 0x43, 0x31, 0x30], 0, "dwg", "application/acad"),
            self::PSD => new FileType([0x38, 0x42, 0x50, 0x53], 0, "psd", "application/octet-stream"),
            self::LIB_COFF => new FileType([0x21, 0x3C, 0x61, 0x72, 0x63, 0x68, 0x3E, 0x0A], 0, "lib", "application/octet-stream"),
            self::AES => new FileType([0x41, 0x45, 0x53], 0, "aes", "application/octet-stream"),
            self::SKR => new FileType([0x95, 0x00], 0, "skr", "application/octet-stream"),
            self::SKR_2 => new FileType([0x95, 0x01], 0, "skr", "application/octet-stream"),
            self::PKR => new FileType([0x99, 0x01], 0, "pkr", "application/octet-stream"),
            self::EML_FROM => new FileType([0x46, 0x72, 0x6F, 0x6D], 0, "eml", "message/rfc822"),
            self::ELF => new FileType([0x45, 0x6C, 0x66, 0x46, 0x69, 0x6C, 0x65, 0x00], 0, "elf", "text/plain"),
        ];
    }
}