<?
//error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
ini_set('display_errors', 0);

$app_folder = '/site'; $debug = false;
require_once ($_SERVER['DOCUMENT_ROOT'] . $app_folder . '/CustomApp.class.php');
$app = new CustomApp($app_folder, $debug);
?>
