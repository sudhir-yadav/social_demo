<?php
$access = "yes";
require_once __DIR__.'/config.php';
require_once __DIR__.'/vendor/autoload.php';
session_start();
ini_set('MAX_EXECUTION_TIME', -1);
$zip = new ZipArchive;
if($_SESSION['logged_in'] != 'true'){header('Location:login');exit();}

 $fb = new \Facebook\Facebook([
              'app_id' => FB_APP_ID,
              'app_secret' => FB_APP_SECRET,
              'default_graph_version' => FB_APP_VERSION
        ]);

  $folder = $_POST['info'];
  $zipname = substr(md5(mt_rand()), 0, 5);
  $dt_time = date('d-m-Y__H_i_s_a');
  $zipname = "bkp_".$zipname."_".$dt_time;

  if ($zip->open("./usr_zip/".$zipname.'.zip', ZipArchive::CREATE) === TRUE)
  {
        for($i=0;$i<count($folder);$i++)
        {
            $response = $fb->get('/'.$folder[$i].'/?fields=name,count,photos.limit(100){source}', $_SESSION['fb_access_token']);
            $user_album = $response->getGraphObject();
            $user_album = $user_album->asArray();
            $foldr_nm = $user_album['name'];
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

            $sym = array("*","/","%","(",")",".");
            $foldr_nm = str_replace($sym, '_', $foldr_nm);
             for($j=0;$j<count($user_album['photos']);$j++)
             {
                 $file = $user_album['photos'][$j]['source'];
                 $content = file_get_contents($file);
                 $m = $zip->addFromString($foldr_nm."/".($j+1).".jpg", $content);
             }
        }
       $zip->close();
       echo '{"status":"success"}';
       exit();
   } 
   else {
    echo '{"status":"failed"}';
    exit();
   }
 ?>