[![Test Coverage](https://codecov.io/gh/hetiansu5/detect-mime-type/branch/master/graph/badge.svg)](https://codecov.io/gh/hetiansu5/detect-mime-type)

## Introduction
Detect mime type for files.

Based on [https://github.com/Muraad/Mime-Detective](https://github.com/Muraad/Mime-Detective)

## Quick Start
```
    try {
        $detector = new \MimeTypeDetector('/path/to/file.doc');
        $type = $detector->getFileType();
        var_dump($type);
    } catch (\MimeType\Exception\FileException $e) {
        echo $e->getMessage();       
    }
```