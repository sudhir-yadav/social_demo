<?php
$access = "yes";
require_once '../config.php';

  $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

   $filenm = $_POST['info']['index'];
   $total = $_POST['info']['total'];
   $zipname = $_POST['info']['folder_name']."_".$_POST['info']['folder_id'];
   $zipname = str_replace(' ', '_', $zipname);
   $sym = array("*","/","%","(",")",".");
   $zipname = str_replace($sym, '_', $zipname);
   $zip = new ZipArchive;
   if ($zip->open("../usr_zip/".$zipname.'.zip', ZipArchive::CREATE) === TRUE) 
   {
    	  $file = $_POST['info']['file'];
         $content = file_get_contents($file);
         $m = $zip->addFromString(pathinfo ( $filenm.".jpg", PATHINFO_BASENAME), $content);

        if($m == 1)
        {
            if($filenm == $total)
            {
               session_start();
               
               header('Content-Type: application/json');
               $date = date("Y-m-d H:i:s");
               if(in_array($_POST['info']['folder_id'],$_SESSION['folders']))
               {
                  $sql = "UPDATE archive_master SET udate='".$date."' WHERE id='".$_POST['info']['folder_id']."'";
                    if ($conn->query($sql)  === TRUE) 
                    {
                         echo '{"status":"ok","link":"usr_zip/'.$zipname.'.zip"}'; 
                        $_SESSION[$_POST['info']['folder_id']]['downlaod_link'] = "usr_zip/".$zipname.".zip";
                    }
                  
               }else
               {
                  $sql1 = "INSERT INTO archive_master (id,title,uid,url,udate) VALUES (".$_POST['info']['folder_id'].",'".$_POST['info']['folder_name']."','".$_SESSION['user']['id']."','usr_zip/".$zipname.".zip','".$date."')";
                  
                   if($conn->query($sql1) === TRUE)
                   {
                       echo '{"status":"ok","link":"usr_zip/'.$zipname.'.zip"}'; 
                       $_SESSION['folders'][count($_SESSION['folders'])] = $_POST['info']['folder_id'];
                       $_SESSION[$_POST['info']['folder_id']]['downlaod_link'] = "usr_zip/".$zipname.".zip";
                   }
               }
               
            }else{
               header('Content-Type: application/json');
               echo '{"status":"ok"}';  
            }
        }
        $zip->close();
        exit();
   } 
   else { echo '{"status":"failed"}'; exit(); }

 ?>