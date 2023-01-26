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

//echo "ROWS".PHP_EOL;
//print_r($rows);
//exit;
//echo PHP_EOL."===========================".PHP_EOL;

//echo "FILTERED";
//print_r($filtered);
//exit;

foreach ($filtered as $filename => $items) {
    if (count($items)) {
        recurse($items, [], $filename);
    }
}

//echo PHP_EOL."===========================".PHP_EOL;
//print_r($nested_key_rows);
//exit;

foreach ($nested_key_rows as $filename => $nested_keys) {
    $lang = basename(pathinfo($filename)['dirname']);
    //echo $lang.PHP_EOL;
    //echo PHP_EOL.'=============='.$filename.PHP_EOL;
    foreach ($nested_keys as $key => $value) {
        $rows[$lang][$filename][$key] = $value;
        //print_r("{$key} ====> {$value}");
        //echo PHP_EOL;
    }
}

//echo PHP_EOL."============FINAL===============".PHP_EOL;
//print_r($rows);
//exit;

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