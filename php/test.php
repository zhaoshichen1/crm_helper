<?php
/**
 * Created by PhpStorm.
 * User: SZHAO
 * Date: 3/25/2016
 * Time: 10:57 AM
 */


function openAndWriteALine($line,$filename)
{

    echo "openAndWriteALine";

    if (is_writable($filename)) {
        //open the file
        if (!$fh = fopen($filename, 'a')) {
            echo "Can't open" . $filename;
            exit;
        }
        // 写入内容
        if (fwrite($fh, $line."\n") === FALSE) {
            echo "Can't write" . $filename;
            exit;
        } else {
            echo 'Write ' . $line . ' successfully';
        }
        fclose($fh);
    } else {
        echo "File $filename not writtable";
    }
}

openAndWriteALine("test","../log/Log.txt");