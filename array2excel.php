<?php

use Spatie\SimpleExcel\SimpleExcelWriter;

require_once __DIR__."/bootstrap.php";

$rows = [];
$filtered = [];
$nested_key_rows = [];

foreach (new \DirectoryIterator(LANG_SOURCE_PATH) as $fileInfo) {
    if ($fileInfo->isFile()) {
        $srcFilePath = sprintf("%s/%s", LANG_SOURCE_PATH, $fileInfo->getFilename());
        $data = require_once $srcFilePath;
        foreach (TRANSLATE_MAP as $lang => $options) {
            if ($options['enabled']) {
                $destFilePath = sprintf("%s/%s/%s.%s", XLSX_DEST_PATH, $lang, $fileInfo->getBasename('.php'), XLSX_EXT);
                if (is_array($data) && count($data)) {
                    foreach ($data as $key => $value) {
                        if (is_string($value)) $rows[$lang][$destFilePath][$key] = trim($value);
                        elseif (0 === count($value)) $rows[$lang][$destFilePath][$key] = '';
                        else $filtered[$destFilePath][$key] = $value;
                    }
                }
            }
        }
    }
}

foreach ($filtered as $filename => $items) {
    if (count($items)) {
        recurse($items, [], $filename);
    }
}

foreach ($nested_key_rows as $filename => $nested_keys) {
    $lang = basename(pathinfo($filename)['dirname']);
    foreach ($nested_keys as $key => $value) {
        $rows[$lang][$filename][$key] = $value;
    }
}

foreach ($rows as $lang => $files) {
    foreach ($files as $fileName => $rows) {
        $writer = SimpleExcelWriter::create($fileName);
        foreach ($rows as $key => $vaule) {
            $writer->addRow([
                XLSX_HEADER_KEY => $key,
                XLSX_HEADER_TRANSLATE => $vaule
            ]);
        }
    }
}