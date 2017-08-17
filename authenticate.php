<?php 
$access = "yes";
require_once __DIR__.'/config.php';
require_once __DIR__.'/vendor/autoload.php';
session_start();
$fb = new \Facebook\Facebook(
    [
              'app_id' => FB_APP_ID,
              'app_secret' => FB_APP_SECRET,
              'default_graph_version' => FB_APP_VERSION
    ]
);

$helper = $fb->getRedirectLoginHelper();
if (isset($_GET['state'])) {
    $helper->getPersistentDataHandler()->set('state', $_GET['state']);
}

try {
    $accessToken = $helper->getAccessToken();
} catch (Facebook\Exceptions\FacebookResponseException $e) {
    header('Location: login');
} catch (Facebook\Exceptions\FacebookSDKException $e) {
    header('Location: login');
    exit;
}

if (! isset($accessToken)) {
    if ($helper->getError()) {
        header('HTTP/1.0 401 Unauthorized');
        echo "Error: " . $helper->getError() . "\n";
        echo "Error Code: " . $helper->getErrorCode() . "\n";
        echo "Error Reason: " . $helper->getErrorReason() . "\n";
        echo "Error Description: " . $helper->getErrorDescription() . "\n";
    } else {
        header('HTTP/1.0 400 Bad Request');
        echo 'Bad request';
    }
    exit;
}

$oAuth2Client = $fb->getOAuth2Client();

if (! $accessToken->isLongLived()) {
    try {
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
        exit;
    }
}


try {
    $response = $fb->get('/me?fields=id,name,cover,email,picture{url}', $accessToken);
} catch (Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

$user = $response->getGraphUser();

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$sql = "SELECT id,g_token FROM user_master WHERE fb_id=".$user['id']."";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($result->num_rows == 1) {
    $_SESSION['user']['id'] = $row['id'];
    // print_r($row['g_token']);die;
    if ($row['g_token'] != NULL) {
        
        $root_fol_qr = "SELECT gdrive_id FROM gdrive_master WHERE user_id='".$row['id']."' AND type=1 ";
        $root_fol_res = $conn->query($root_fol_qr);
        $row_3 = $root_fol_res->fetch_assoc();
        $_SESSION['google_root_folder'] = $row_3['gdrive_id'];

        $_SESSION['google_token'] = json_decode($row['g_token']);
    }
    $sql_archive = "SELECT * FROM archive_master WHERE uid=".$row['id']."";

    $result2 = $conn->query($sql_archive);
    $i = 0;
    while ($row2 = $result2->fetch_assoc()) {
        $_SESSION['folders'][$i] = $row2["id"];
        $name = $row2['id'];
        $_SESSION[(string) $name]['downlaod_link'] = $row2["url"];
        $i++;
    }
} else {
    $sql1 = "INSERT INTO user_master (id,name, email, fb_id) VALUES ('".$user['id']."','".$user['name']."','".$user['email']."','".$user['id']."')";
    $_SESSION['user']['id'] = $user['id'];
    $conn->query($sql1);
    // $_SESSION['user']['id'] = mysql_insert_id();
}

$_SESSION['fb_access_token'] = (string) $accessToken;
$_SESSION['user']['fb_id'] = $user['id'];
$_SESSION['user']['name'] = $user['name'];
$_SESSION['user']['email'] = $user['email'];
$_SESSION['user']['picture'] = $user['picture']['url'];
$_SESSION['logged_in'] = 'true';

header('Location: dashboard');
