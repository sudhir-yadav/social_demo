<?php
session_start();
$access = "yes";
require_once '../config.php';
require_once '../vendor/autoload.php';


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

	$client->setAccessToken($_SESSION['google_token']);

	$driveService = new Google_Service_Drive($client);

   $fileMetadata = new Google_Service_Drive_DriveFile(array('name' => $_POST['info'][0],'mimeType' => 'application/vnd.google-apps.folder','parents' => array($_SESSION['google_root_folder'])));

   //$_SESSION['google_root_folder'];
   $file = $driveService->files->create($fileMetadata, array('fields' => 'id'));
   echo $file->id; 

	/*header('Content-Type: application/json');
	echo '{"status":"success","status":1}';*/
    exit();
}

?>