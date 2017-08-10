<?php

require_once __DIR__.'/vendor/autoload.php';


//if($_SESSION['logged_in'] != 'true'){header('Location:login');exit();}

 $fb = new \Facebook\Facebook([
      'app_id' => '1869850579937672',
      'app_secret' => '9a89e0233508584a71bbb3341d2c8ee4',
      'default_graph_version' => 'v2.8'
]);

$folder =  Array(
                    0 => '765557443467420',
                    1 => '1178274008862426',
                    2 => '149349815088189'
                );

print_r($folder);

   $zip = new ZipArchive;
   if ($zip->open("./usr_zip/".$zipname.'.zip', ZipArchive::CREATE) === TRUE) {
    $file = $_POST['info']['file'];
     $content = file_get_contents($file);
    $m = $zip->addFromString(pathinfo ( $filenm.".jpg", PATHINFO_BASENAME), $content);
    $zip->close();
    exit();
   } else {
    echo '{"status":"failed"}';
    exit();
   }

die;

/*for($i;$i<count($folder);$i++)
{

}*/


$response = $fb->get('/372475649442270/?fields=name,count,photos.limit(100){source}', $_SESSION['fb_access_token']);
$user_album = $response->getGraphObject();
$user_album = $user_album->asArray();

 if($user_album['count'] > 100 )
 {
    $len = floor(($user_album['count']/count($user_album['photos'])));
    $offset = 0;
    for($j=0;$j<$len;$j++)
    {
      $offset+=100;
      $off_response = $fb->get('/'.$user_album['id'].'/photos?pretty=0&fields=source&offset='.$offset.'&limit=100', $_SESSION['fb_access_token']);
      $m = $off_response->getGraphEdge();
      $user_album['photos'] = array_merge($user_album['photos'], $m->asArray());
    }
 }

print_r($user_album);



// echo $_POST['info'];
 //  session_start();
 //  print_r($_SESSION['user']);

  //print_r($_POST['info']);

 /* for($i=0;$i<count($_POST['info']);$i++)
  {

  }*/
  

   /*$filenm = $_POST['info']['index'];
   $zipname = $_POST['info']['folder_name']."_".$_POST['info']['folder_id'];
   $zipname = str_replace('.', '', $zipname);
   $zipname = str_replace('*', '', $zipname);
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
   }*/

 ?>