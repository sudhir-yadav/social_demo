<?php
    
    if(empty($access)) {header('Location:login'); die();}
    error_reporting(0);   
    date_default_timezone_set('Asia/Calcutta');

    /* system config */
    define('DIR','http://localhost/twitter_rt/');
    define('DOCROOT', dirname(__FILE__));
    define('APP_NAME','social_demo');
    define('SESSION_PREFIX','scl_dmo_');

    /* database config */
    define('DB_TYPE','mysql');
    define('DB_HOST','localhost');
    define('DB_NAME','cloveredge');
    define('DB_USER','root');
    define('DB_PASS','');

    /* facebook config */
    define('FB_APP_ID','');
    define('FB_APP_SECRET','');
    define('FB_APP_VERSION','V2.10');
?>