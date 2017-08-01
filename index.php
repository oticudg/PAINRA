<?php
session_start();
require_once 'Config/Autoload.php';
Config\Autoload::run();
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS);
define('URL', 'http://localhost/PAINRA/');
if (isset($_SESSION['validar']) && !isset($_REQUEST['token'])) {
	$template = new Views\Template();
}
Config\Enrutador::run(new Config\Request());
