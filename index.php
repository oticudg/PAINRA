<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
session_start();
require_once 'Config/Autoload.php';
Config\Autoload::run();
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS);
// define('URL', 'http://localhost/PAINRA/');
define('URL', 'http://painra.sahum.gob.ve/');
if (isset($_SESSION['validar']) && !isset($_REQUEST['token'])) {
	$Template = new Views\Template();
	new Views\Modales\Modales();
}
Config\Enrutador::run(new Config\Request());
