#!/bin/php
<?php
/****
 * @since 2021-05-24
 * @author stev leibelt <artodeto@bazzline.net>
 */

/**
 * Reads content of the path and sorts them per date
 *  Expected file strings are "IMG_20210417_212229.jpg", "PANO_20210313_140126.vr.jpg" or "VID_20210404_091542.mp4"
 */
function _move_and_sort_files_from_upload_to_cached_path(string $sourcePath, string $destinationPath)
{
    if (!is_dir($sourcePath)) {
        echo ":: Invalid source path!" . PHP_EOL;
        echo "   Path >>${sourcePath}<< does not exist." . PHP_EOL;
    }
}

_move_and_sort_files_from_upload_to_cached_path $argv[1] $argv[2]
