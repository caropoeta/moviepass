<?php namespace Config;

define("ROOT", dirname(__DIR__) . "/");
//Path to your project's root folder
define("FRONT_ROOT", "/personal/moviepass/");
define("VIEWS_PATH", "Views/");
define("CSS_PATH", FRONT_ROOT.VIEWS_PATH . "css/");
define("JS_PATH", FRONT_ROOT.VIEWS_PATH . "js/");
define("IMG_PATH", VIEWS_PATH . "img/");


define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'moviepass_user');
define('DB_PASSWORD', 'moviepass@localhost');
define('DB_NAME', 'moviepass');

date_default_timezone_set('America/Argentina/Buenos_Aires');
?>




