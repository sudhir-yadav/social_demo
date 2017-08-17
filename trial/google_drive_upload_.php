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

if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['token'] = $client->getAccessToken();
    print_r($client->getAccessToken());
    //$client->getAccessToken(["refreshToken"]);
    $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    die;
    header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
    return;
}

if (isset($_SESSION['token'])) { $client->setAccessToken($_SESSION['token']);}
if (isset($_REQUEST['logout'])) {unset($_SESSION['token']);}

?>


<?php
if ($client->getAccessToken()) {

    $_SESSION['token'] = $client->getAccessToken();
    $token = $_SESSION['token'];
    echo "<pre>";
    print_r($token);

    echo "Access Token = " . $token['access_token'] . '<br/>';
    echo "Refresh Token = " . $token['refresh_token'] . '<br/>';
   
    $saveToken = file_put_contents("token.txt",$token['refresh_token']); // Saving the refresh token in a text file. 
    if ($saveToken){
        //echo 'Token saved successfully!<br/><br/>';
    }

   $driveService = new Google_Service_Drive($client);
   $fileMetadata = new Google_Service_Drive_DriveFile(array('name' => 'facebook_username_albums','mimeType' => 'application/vnd.google-apps.folder'));
    $file = $driveService->files->create($fileMetadata, array('fields' => 'id'));
    echo $file->id; 
     echo "<br/><a class='logout' href='?logout'>Logout</a>";
} else 
{
    $authUrl = $client->createAuthUrl();
    print "<a class='login' href='$authUrl'>Connect Me!</a>";
}
?>
