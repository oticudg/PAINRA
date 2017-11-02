<?php
require_once 'Config/Autoload.php';
session_start();
Config\Autoload::run();
/*development*/
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// define('URL', 'http://localhost/painra/');
/*production*/
error_reporting(0);
ini_set('display_errors', 0);
define('URL', 'http://painra.sahum.gob.ve/');
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS);
if (isset($_SESSION['validar']) && !isset($_REQUEST['token'])) {
	$Template = new Views\Template();
	new Views\Modales\Modales();
}
Config\Enrutador::run(new Config\Request());
