<?php
$access = "yes";
require_once __DIR__.'/config.php';
require_once __DIR__.'/vendor/autoload.php';
session_start();
if (isset($_SESSION['logged_in'])) {
    header('Location: dashboard');
    exit();
}

$fb = new \Facebook\Facebook(
    [
                      'app_id' => FB_APP_ID,
                      'app_secret' => FB_APP_SECRET,
                      'default_graph_version' => FB_APP_VERSION
                ]
);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email','user_photos','public_profile','user_friends'];
$loginUrl = $helper->getLoginUrl(DIR.'authenticate', $permissions);
