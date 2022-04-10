<?php
// For ZIP file
function forZip($dir,$folder_name){

    $zip = new ZipArchive();
    $filename = $dir."/".$folder_name.".zip";

    if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
        exit("cannot open <$filename>\n");
    }

    // Create zip
    createZip($zip,$dir."/".$folder_name."/");

    $zip->close();
}

// Create zip
function createZip($zip,$dir){

    if (is_dir($dir)){

        if ($dh = opendir($dir)){
            while (($file = readdir($dh)) !== false){

                // If file
                if (is_file($dir.$file)) {
                    if($file != '' && $file != '.' && $file != '..'){

                        $zip->addFile($dir.$file);
                    }
                }else{
                    // If directory
                    if(is_dir($dir.$file) ){

                        if($file != '' && $file != '.' && $file != '..'){

                            // Add empty directory
                            $zip->addEmptyDir($dir.$file);

                            $folder = $dir.$file.'/';

                            // Read data of the folder
                            createZip($zip,$folder);
                        }
                    }

                }

            }
            closedir($dh);
        }
    }
}


// Download Created Zip file
function downloadZip($zip_file_name){


    $filename = $zip_file_name;

    if (file_exists($filename)) {
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="'.basename($filename).'"');
        header('Content-Length: ' . filesize($filename));

        flush();
        readfile($filename);
        // delete file
        unlink($filename);

    }

}

?>
