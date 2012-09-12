<?php
namespace Hiptest;
session_set_cookie_params(18000);
session_start();

define("_INCLUDE_PATH_", "C:\\\\xampp\htdocs\hiptest\classes\\");
define("_SITE_URL_", "http://home.jjhosting.org/hiptest");

$db = mysqli_connect('127.0.0.1', 'hiptest', 'office', 'hiptest');

class Loader {
    static public function load($name) {
        $count = 1;
        $goodName = str_replace(__NAMESPACE__. "\\", "", $name, $count);
        $goodName = mb_strtolower($goodName);
        $file = _INCLUDE_PATH_. $goodName. ".php";
        include_once($file);
    }
}

spl_autoload_register(__NAMESPACE__ .'\Loader::load');
?>
