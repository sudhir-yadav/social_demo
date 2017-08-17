<?php
session_start();
    require_once 'vendor/autoload.php'; 
   $clientId = '829552633759-s42vfsvmf430ovaumuj69masjel6fmhn.apps.googleusercontent.com';
   $clientSecret = 'ryPQHYfsXl92oXZyHgxheDxd';

   $_POST['info'][0] = "Instagram";

    $client = new Google_Client();
    $client->setApplicationName("Social demo");
    $client->setClientId($clientId);
    $client->setClientSecret($clientSecret);
    $client->setScopes(array('https://www.googleapis.com/auth/drive.file'));
    $client->setAccessType("offline");
    $client->setApprovalPrompt('force');

    $client->setAccessToken($_SESSION['google_token']);

    $driveService = new Google_Service_Drive($client);

   $fileMetadata = new Google_Service_Drive_DriveFile(
       array('name' => $_POST['info'][0],
                                                               'mimeType' => 'application/vnd.google-apps.folder',
                                                               'parents' => array('0ByyxubpRz5QvYkZNOWRxbnJPejQ'))
   );
   $file = $driveService->files->create($fileMetadata, array('fields' => 'id'));
   echo $file->id; 

   /*header('Content-Type: application/json');
   echo '{"status":"success","status":1}';*/
    exit();

   // 0ByyxubpRz5QvcmNhQlhYMjltZUU


?>
