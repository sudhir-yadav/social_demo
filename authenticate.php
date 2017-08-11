<?php 
$access = "yes";
require_once __DIR__.'/config.php';
require_once __DIR__.'/vendor/autoload.php';

$fb = new \Facebook\Facebook([
              'app_id' => FB_APP_ID,
              'app_secret' => FB_APP_SECRET,
              'default_graph_version' => FB_APP_VERSION
        ]);

$helper = $fb->getRedirectLoginHelper();
if (isset($_GET['state'])) {
    $helper->getPersistentDataHandler()->set('state', $_GET['state']);
}
echo "<pre>";
try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
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

// Logged in
/*echo '<h3>Access Token</h3>';
var_dump($accessToken->getValue());*/
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
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->get('/me?fields=id,name,cover,email,picture{url}', $accessToken);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$user = $response->getGraphUser();

print_r($user);

echo 'Name: ' . $user['name'];
session_start();
$_SESSION['fb_access_token'] = (string) $accessToken;
$_SESSION['user']['fb_id'] = $user['id'];
$_SESSION['user']['name'] = $user['name'];
$_SESSION['user']['email'] = $user['email'];
$_SESSION['user']['picture'] = $user['picture']['url'];
$_SESSION['logged_in'] = 'true';

echo "<pre>";
print_r($_SESSION);
header('Location: dashboard');
//exit();

?>