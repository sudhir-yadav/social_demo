<?php 

 require_once __DIR__.'/vendor/autoload.php';

$fb = new \Facebook\Facebook([
      'app_id' => '1869850579937672',
      'app_secret' => '9a89e0233508584a71bbb3341d2c8ee4',
      'default_graph_version' => 'v2.8'
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email','user_photos','public_profile','user_friends']; // Optional permissions
$loginUrl = $helper->getLoginUrl('http://localhost/social_demo/trial2.php', $permissions);
echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
?>