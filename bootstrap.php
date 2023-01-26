<?php

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/const.php';
require_once __DIR__.'/functions.php';

foreach (\array_keys(TRANSLATE_MAP) as $lang) {
    $path = sprintf("%s/%s", XLSX_DEST_PATH, $lang);
    if (file_exists($path)) {
        foreach (new DirectoryIterator($path) as $fileInfo) {
            $fileName = $fileInfo->getFilename();
            if ($fileInfo->isFile())
                unlink($fileName);
        }
        rmdir($path);
    } else {
        mkdir($path);
    }
}