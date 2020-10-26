<?php namespace Config;

define("ROOT", dirname(__DIR__) . "/");
//Path to your project's root folder

define("FRONT_ROOT", "/moviepass-main2/");

define("VIEWS_PATH", "Views/");
define("CSS_PATH", FRONT_ROOT.VIEWS_PATH . "css/");
define("JS_PATH", FRONT_ROOT.VIEWS_PATH . "js/");
define("IMG_PATH", VIEWS_PATH . "img/");
define('DATA_PATH', 'Data/');

define('APP_ID', '383668786136123');
define('APP_SECRET', '07cde429233190afc3f433c626dbfc0e');

define('API_KEY', '69b28faa719e69ade504cc5f24994250');

date_default_timezone_set('America/Argentina/Buenos_Aires');

//Database
define('DB_HOST',"localhost");
define('DB_USER',"university");
define('DB_PASS',"");
define('DB_NAME',"moviepass");