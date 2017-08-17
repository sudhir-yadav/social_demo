<?php 
require_once 'vendor/autoload.php'; 
$clientId = '829552633759-s42vfsvmf430ovaumuj69masjel6fmhn.apps.googleusercontent.com';
$clientSecret = 'ryPQHYfsXl92oXZyHgxheDxd';
$redirectUri = 'http://localhost/social_demo/google_drive_upload.php';

session_start();

$client = new Google_Client();
$client->setApplicationName("Social demo");
$client->setClientId($clientId);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->setScopes(array('https://www.googleapis.com/auth/drive.file'));
$client->setAccessType("offline");
$client->setApprovalPrompt('force');


if (isset($_GET['code'])) 
{
    $client->authenticate($_GET['code']);
    $_SESSION['google_token'] = $client->getAccessToken();
    $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}else{
    if (isset($_SESSION['google_token'])) 
    { 
            $client->setAccessToken($_SESSION['google_token']);
            $driveService = new Google_Service_Drive($client);
            $fileMetadata = new Google_Service_Drive_DriveFile(array('name' => 'facebook_username_albums','mimeType' => 'application/vnd.google-apps.folder'));
            $file = $driveService->files->create($fileMetadata, array('fields' => 'id'));
            $file->id; 
            header('Location: dashboard'); 
    }
    else
    {
       $authUrl = $client->createAuthUrl();
       header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL)); 
    }
}



?>

