<?php

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/const.php';
require_once __DIR__.'/functions.php';

if ('array2excel.php' === $_SERVER['SCRIPT_NAME']) {
    foreach (\array_keys(TRANSLATE_MAP) as $lang) {
        $path = sprintf("%s/%s", XLSX_DEST_PATH, $lang);
        if (!file_exists($path)) {
            mkdir($path, 0755);
        } else {
            foreach (new \DirectoryIterator($path) as $fileInfo) {
                if ($fileInfo->isFile()) {
                    unlink($fileInfo->getPathname());
                }
            }
        }
    }
}
