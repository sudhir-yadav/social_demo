<?php 
$access = "yes";
require_once __DIR__.'/config.php';
require_once __DIR__.'/vendor/autoload.php';
session_start();
$redirectUri = DIR.'google_drive_auth.php';
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$client = new Google_Client();
$client->setApplicationName("Social demo");
$client->setClientId(G_CLIENT_ID);
$client->setClientSecret(G_CLIENT_SECRET);
$client->setRedirectUri($redirectUri);
$client->setScopes(array('https://www.googleapis.com/auth/drive.file'));
$client->setAccessType("offline");
$client->setApprovalPrompt('force');

$user_name = str_replace(' ', '_', $_SESSION['user']['name']);

if (isset($_GET['code'])) 
{
    $client->authenticate($_GET['code']);
    $_SESSION['google_token'] = $client->getAccessToken();
    $sql = "UPDATE user_master SET g_token='".json_encode($_SESSION['google_token'])."' WHERE fb_id='".$_SESSION['user']['fb_id']."'";
    $conn->query($sql);
    $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}else{
    if (isset($_SESSION['google_token'])) 
    { 
            $client->setAccessToken($_SESSION['google_token']);
            $driveService = new Google_Service_Drive($client);
            $fileMetadata = new Google_Service_Drive_DriveFile(array('name' => 'facebook_'.strtolower($user_name).'_albums','mimeType' => 'application/vnd.google-apps.folder'));
            $file = $driveService->files->create($fileMetadata, array('fields' => 'id'));
            $sql1 = "INSERT INTO gdrive_master (gdrive_id,user_id,type) VALUES ('".$file->id."','".$_SESSION['user']['id']."',1)";       
            $conn->query($sql1);
            $_SESSION['google_root_folder'] = $file->id;
            header('Location: dashboard'); 
    }
    else
    {
       $authUrl = $client->createAuthUrl();
       header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL)); 
    }
}



?>

