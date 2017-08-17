<?php
session_start();
/*print_r($_SESSION['google_token']);

*/
	require_once 'vendor/autoload.php'; 
   $clientId = '829552633759-s42vfsvmf430ovaumuj69masjel6fmhn.apps.googleusercontent.com';
   $clientSecret = 'ryPQHYfsXl92oXZyHgxheDxd';


if (!isset($_SESSION['google_token']))
{ 
	header('Content-Type: application/json');
    echo '{"status":"failed","status":0}';
    exit();
	//$client->setAccessToken($_SESSION['token']);
}
else{
    $client = new Google_Client();
	$client->setApplicationName("Social demo");
	$client->setClientId($clientId);
	$client->setClientSecret($clientSecret);
	$client->setScopes(array('https://www.googleapis.com/auth/drive.file'));
	$client->setAccessType("offline");
	$client->setApprovalPrompt('force');

	$client->setAccessToken($_SESSION['google_token']);

	$driveService = new Google_Service_Drive($client);

   $fileMetadata = new Google_Service_Drive_DriveFile(array('name' => $_POST['info'][0],'mimeType' => 'application/vnd.google-apps.folder'));
   $file = $driveService->files->create($fileMetadata, array('fields' => 'id'));
   echo $file->id; 

	/*header('Content-Type: application/json');
	echo '{"status":"success","status":1}';*/
    exit();
}

?>