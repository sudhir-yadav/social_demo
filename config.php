<?php
/**
 * This file is part of the Symfony2-coding-standard (phpcs standard)
 *
 * PHP version 5
 *
 * @category PHP
 * @package  social_demo
 * @author   Authors <sudhiry875@gmail.com>
 * @license  http://spdx.org/licenses/MIT MIT License
 * @link     https://github.com/djoos/Symfony2-coding-standard
 */

/** env setting */
if ( empty($access)) {
    header('Location:login'); die(); 
}
error_reporting(0);   
date_default_timezone_set('Asia/Calcutta');

/** system config */
define('DIR', 'http://localhost/twitter_rt/');
define('DOCROOT', dirname(__FILE__));
define('APP_NAME', 'social_demo');
define('SESSION_PREFIX', 'scl_dmo_');

/** database config */
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'social_demo');
define('DB_USER', 'root');
define('DB_PASS', '');

/** facebook config */
define('FB_APP_ID', '1869850579937672');
define('FB_APP_SECRET', '9a89e0233508584a71bbb3341d2c8ee4');
define('FB_APP_VERSION', 'v2.8');
?>