<?php

$filename = $_REQUEST["file"];

 $filename = "data/".$filename.".zip";
 $directory = "data/".$filename;

if (file_exists($filename)) {
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="'.basename($filename).'"');
    header('Content-Length: ' . filesize($filename));

    flush();
    readfile($filename);
    // delete file
   // unlink($filename);
    unlink($directory);
    unset($_COOKIE['download_file_src']);
    header("Location: index.php");

}
else
{
    echo "<br/><br/><h1 align='center'>No file exist</h1>";
}
