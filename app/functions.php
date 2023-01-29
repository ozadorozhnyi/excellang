<?php

if (!function_exists('recurse')) {
    function recurse($a, $keys = [], $top_level_key = '')
    {
        global $nested_key_rows;

        if (!is_array($a)) {
            $nested_keys = implode("|", $keys);
            $nested_key_rows[$top_level_key][$nested_keys] = $a;
            return;
        }

        foreach($a as $k => $v) {
            $new_keys = array_merge($keys, [$k]);
            recurse($v, $new_keys, $top_level_key);
        }
    }
}

if (!function_exists('cleanupDirectory')) {
    function cleanupDirectory($path) {
        if (is_dir($path)) {
            $dir = new \DirectoryIterator($path);
            foreach ($dir as $fileinfo) {
                if (!$fileinfo->isDot()) {
                    unlink($fileinfo->getFilename());
                }
            }
        }
    }
}


