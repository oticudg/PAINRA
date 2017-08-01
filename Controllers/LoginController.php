<?php namespace Controllers;
/**
* Metodos de controladores de Login
*/
class LoginController
{
	public function index()
	{
		if (isset($_SESSION['validar']) && $_SESSION['validar'] == TRUE) {
			header('Location: '.URL.'inicio');
			exit();
		}
	}
} /*Fin de la clase LoginController*/
