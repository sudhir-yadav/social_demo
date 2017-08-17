<?php
session_start();
$access = "yes";
require_once '../config.php';
require_once '../vendor/autoload.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
//$folder = array(0 => '765557443467420');
 $folder = $_POST['info'];
//echo $_SESSION['google_root_folder'];

if (!isset($_SESSION['google_token']))
{ 
	header('Content-Type: application/json');
    echo '{"status":"failed","status":0}';
    exit();
}
else{
    $client = new Google_Client();
	$client->setApplicationName("Social demo");
	$client->setClientId(G_CLIENT_ID);
	$client->setClientSecret(G_CLIENT_SECRET);
	$client->setScopes(array('https://www.googleapis.com/auth/drive.file'));
	$client->setAccessType("offline");
	$client->setApprovalPrompt('force');
	$client->setAccessToken(json_encode($_SESSION['google_token']));
   
    $driveService = new Google_Service_Drive($client);

	$fb = new \Facebook\Facebook([
              'app_id' => FB_APP_ID,
              'app_secret' => FB_APP_SECRET,
              'default_graph_version' => FB_APP_VERSION
        ]);

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
            
            $sql_archive = "SELECT gdrive_id FROM gdrive_master WHERE folder_id=".$folder[$i]."";
            $result2 = $conn->query($sql_archive);  
            if ($result2->num_rows > 0) 
            {
                 $row2 = $result2->fetch_assoc();
                 $driveService->files->delete($row2['gdrive_id']);
                 $fileMetadata = new Google_Service_Drive_DriveFile(array('name' => $foldr_nm,'mimeType' => 'application/vnd.google-apps.folder','parents' => array($_SESSION['google_root_folder'])));
	            $file = $driveService->files->create($fileMetadata, array('fields' => 'id'));
	            $temp_pr = $file->id;
	            $sql1 = "UPDATE gdrive_master SET gdrive_id='".$temp_pr."' WHERE folder_id='".$folder[$i]."'";
	            $conn->query($sql1) ;
            }else
            {
                $fileMetadata = new Google_Service_Drive_DriveFile(array('name' => $foldr_nm,'mimeType' => 'application/vnd.google-apps.folder','parents' => array($_SESSION['google_root_folder'])));
	            $file = $driveService->files->create($fileMetadata, array('fields' => 'id'));
	            $temp_pr = $file->id;
	            $sql1 = "INSERT INTO gdrive_master (gdrive_id,folder_id,user_id,type) VALUES ('".$temp_pr."','".$folder[$i]."','".$_SESSION['user']['id']."',2)";
	            $conn->query($sql1) ; 
            }

             for($j=0;$j<count($user_album['photos']);$j++)
             {
                 $file = $user_album['photos'][$j]['source'];
                 $content = file_get_contents($file);
                 $fileMetadata2 = new Google_Service_Drive_DriveFile(array('name' => ($j+1),'parents' => array($temp_pr)));
                 $driveService->files->create($fileMetadata2,  array('data' => $content,'mimeType' => 'image/jpeg','uploadType' => 'multipart','fields' => 'id'));
             }

             if($i == (count($folder)-1))
             {
             	header('Content-Type: application/json');
			    echo '{"status":"success","status":1}';
			    $conn->close();
			    exit();
             }
        }
	
    exit();
}

?>