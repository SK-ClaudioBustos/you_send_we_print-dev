<?php
// error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
error_reporting( E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 1);
$debug = true;

$app_folder = '/site'; 
session_save_path("D:/xampp/tmp");
require_once ($_SERVER['DOCUMENT_ROOT'] . $app_folder . '/CustomApp.class.php');
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
$app = new CustomApp($app_folder, $debug);
?>
