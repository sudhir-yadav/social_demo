<?php

   $filenm = $_POST['info']['index'];
   $zipname = $_POST['info']['folder_name']."_".$_POST['info']['folder_id'];
   $zipname = str_replace(' ', '_', $zipname);
   
   $zip = new ZipArchive;
if ($zip->open("./usr_zip/".$zipname.'.zip', ZipArchive::CREATE) === TRUE) {
	$file = $_POST['info']['file'];
     $content = file_get_contents($file);
    $m = $zip->addFromString(pathinfo ( $filenm.".jpg", PATHINFO_BASENAME), $content);
    if($m == 1)
    {
       header('Content-Type: application/json');
       echo '{"status":"ok"}';	
    }
    $zip->close();
    exit();
   } else {
    echo '{"status":"failed"}';
    exit();
   }

 ?>