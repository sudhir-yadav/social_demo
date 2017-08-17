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
if (empty($access)) {
    header('Location:login');
    die();
}
//error_reporting(0);
date_default_timezone_set('Asia/Calcutta');

/** system config */
define('DIR', 'http://fbdemo.rto-utility.in/');
define('DOCROOT', dirname(__FILE__));
define('APP_NAME', 'social_demo');
define('SESSION_PREFIX', 'scl_dmo_');

/** database config */
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'sudhirin_social_demo');
define('DB_USER', 'sudhirin_scld');
define('DB_PASS', 'sudhir123#');

/** facebook config */
define('FB_APP_ID', '2036712353228138');
define('FB_APP_SECRET', '5060189a367d277e11ac53a6ebed470d');
define('FB_APP_VERSION', 'v2.10');


/** google config */
define('G_CLIENT_ID', '829552633759-s42vfsvmf430ovaumuj69masjel6fmhn.apps.googleusercontent.com');
define('G_CLIENT_SECRET', 'ryPQHYfsXl92oXZyHgxheDxd');
