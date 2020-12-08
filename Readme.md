[![Test Coverage](https://codecov.io/gh/hetiansu5/detect-mime-type/branch/master/graph/badge.svg)](https://codecov.io/gh/hetiansu5/detect-mime-type)
![GitHub all releases](https://img.shields.io/github/downloads/hetiansu5/detect-mime-type/total)

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


## How to Implement Detecting
Each type of file have its unique scheme protocol, found them and compare.

## Other

- Check Code Style
[https://github.com/squizlabs/PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)

- Check Syntax 
[https://github.com/php-parallel-lint/PHP-Parallel-Lint](https://github.com/php-parallel-lint/PHP-Parallel-Lint)

- Code Checker
[https://github.com/phpmd/phpmd](https://github.com/phpmd/phpmd)
