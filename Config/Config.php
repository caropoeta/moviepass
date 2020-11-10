<?php

namespace Config;

define("ROOT", dirname(__DIR__) . "/");

//Path to your project's root folder
define("FRONT_ROOT", "/personal/moviepass/");

define("VIEWS_PATH", "Views/");
define("CSS_PATH", FRONT_ROOT . VIEWS_PATH . "css/");
define("JS_PATH", FRONT_ROOT . VIEWS_PATH . "js/");
define("IMG_PATH", VIEWS_PATH . "img/");
define('DATA_PATH', 'Data/');

//Facebook login
define('APP_ID', '383668786136123');
define('APP_SECRET', '07cde429233190afc3f433c626dbfc0e');

//Facebook login & mailing
define('HOST_NAME', $_SERVER['HTTP_HOST']);

//The movie db
define('API_KEY', 'daaea3a3b1e2571ed4a7d51041531d32');

//Default timezone
date_default_timezone_set('America/Argentina/Buenos_Aires');

//Database
define('DB_HOST', "localhost");
define('DB_USER', "university");
define('DB_PASS', "");
define('DB_NAME', "moviepass");

//Role names
define('ADMIN_ROLE_NAME', "Admin");
define('CLIENT_ROLE_NAME', "Client");
define('GUEST_ROLE_NAME', "Guest");

//php ini file changes, for mailing purposes
define('APP_MAIL', "dev.groupthree@gmail.com");
define('APP_MAIL_PASSWORD', "carolina.3");

