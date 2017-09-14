<?php namespace Views;

use Config\Route as Route;

class Template {
	public function __construct()
	{
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta url="<?php echo(URL) ?>">
	<title>P A I N R A</title>
	<!-- <link rel="shortcut icon" href="images/favicon.png"/> -->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"> -->
	<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/white/pace-theme-minimal.css" rel="stylesheet"> -->
	<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.min.css" rel="stylesheet"> -->
	<!-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"> -->
	<!-- <link href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css" rel="stylesheet"> -->
	<!-- <link rel="stylesheet" href="bower_components/sweetalert2/dist/sweetalert2.min.css"> -->

	<link rel="stylesheet" href="<?php Route::css('bootstrap.min') ?>">
	<link rel="stylesheet" href="<?php Route::css('bootstrap-theme.min') ?>">
	<link rel="stylesheet" href="<?php Route::css('pace-theme-minimal') ?>">
	<link rel="stylesheet" href="<?php Route::css('bootstrap-datepicker3.min') ?>">
	<link rel="stylesheet" href="<?php Route::css('font-awesome.min') ?>">
	<link rel="stylesheet" href="<?php Route::css('dataTables.bootstrap.min') ?>">
	<link rel="stylesheet" href="<?php Route::css('sweetalert2.min') ?>">
	<link href="Views/resource/css/estilos.css" rel="stylesheet">
</head>
<body>
	<nav class="navbar navbar-primary navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><span class="fa fa-support"></span> <strong> P A I N R A</strong></a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="inicio" id="enlace" class="text-"><span class="fa fa-home"></span> Inicio </a></li>
					<li><a href="tickets" id="enlace" class="text-"><span class="fa fa-ticket"></span> Tickets</a></li>
					<li class="dropdown text-center">
						<a href="#" class="dropdown-toggle btneffect" data-toggle="dropdown" data-hover="dropdown" role="button"><span class="fa fa-bar-chart"></span> Estadisticas
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu menup">
							<li><a href="departamentos" id="enlace"><span class="glyphicon glyphicon-calendar"></span> Departamentos </a></li>
							<li class="divider"><a href="#"></a></li>
							<li><a href="personales" id="enlace"><span class="fa fa-user-circle-o"></span> Personales </a></li>
							<li class="divider"><a href="#"></a></li>
							<li><a href="mensuales" id="enlace"><span class="fa fa-table" aria-hidden="true"></span> Mensuales</a></li>
						</ul>
					</li>
					<div class="col-sm- col-md-5 hidden-sm">
						<form id="ticket" class="navbar-form" role="search">
							<div class="input-group">
								<input type="number" id="numero" class="form-control" placeholder="Buscar ticket" name="ticket" placeholder="Ingresa el n° del ticket" min="1">
								<div class="input-group-btn">
									<button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
								</div>
								<input type="hidden" name="token" value="4">
							</div>
						</form>
					</div>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><b>Bienvenido, <?php echo $_SESSION['nombre']; ?> <span class="caret"></span></b></a>
						<ul class="dropdown-menu menup">
						<?php if ($_SESSION['rol'] < 3) { ?>
							<?php if ($_SESSION['rol'] == 1): ?>
							<li><a href="#" data-toggle="modal" data-target=".modal-departamentos"><span class="fa fa-cubes" aria-hidden="true"></span>Departamentos</a></li>
							<li role="separator" class="divider"></li>
							<?php endif ?>
							<li><a href="#" data-toggle="modal" data-target=".modal-servicios"><span class="glyphicon glyphicon-inbox" aria-hidden="true"></span> Servicios</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="#" data-toggle="modal" data-target=".modal-soportistas"><span class="fa fa-user-circle-o" aria-hidden="true"></span> Usuarios</a></li>
							<li role="separator" class="divider"></li>
						<?php } ?>
							<li><a href="#" data-toggle="modal" data-target=".modal-contraseña"><span class="glyphicon glyphicon-cog"></span> Cambiar Contraseña</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="#" id="logout"><span class="fa fa-sign-out"></span> Salir</a></li>
						</ul>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
<?php
	}
	public function __destruct()
	{
?>
	<div id="page-loader"><span class="preloader-interior"></span></div>
	<footer class="navbar-fixed-bottom">
		<div class="container">
			<p class="text-center"> Made with <span class="glyphicon glyphicon-heart"></span>. por la oficina de sistemas y tecnológias de información</p>
			<!-- <p class="text-center"> APLICACIÓN DESARROLLADA POR LA OFICINA DE SISTEMAS Y TECNOLÓGIAS DE INFORMACIÓN <b><span class="fa fa-copyright"></span> Copyleft</b> </p> -->
		</div>
	</footer>
</body>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->
<!-- <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/locales/bootstrap-datepicker.es.min.js"></script> -->
<!-- <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script> -->
<!-- <script src="http://code.highcharts.com/highcharts.js"></script> -->
<!-- <script src="http://code.highcharts.com/modules/exporting.js"></script> -->
<!-- <script src="bower_components/sweetalert2/dist/sweetalert2.min.js"></script> -->

<script src="<?php Route::js('jquery.min') ?>"></script>
<script src="<?php Route::js('bootstrap.min') ?>"></script>
<script src="<?php Route::js('jquery.dataTables.min') ?>"></script>
<script src="<?php Route::js('pace.min') ?>"></script>
<script src="<?php Route::js('bootstrap-datepicker.min') ?>"></script>
<script src="<?php Route::js('bootstrap-datepicker.es.min') ?>"></script>
<script src="<?php Route::js('dataTables.bootstrap.min') ?>"></script>
<script src="<?php Route::js('highcharts') ?>"></script>
<script src="<?php Route::js('exporting') ?>"></script>
<script src="<?php Route::js('sweetalert2.min') ?>"></script>
<script src="<?php Route::js('highcharts-more') ?>"></script>
<script src="Views/resource/js/main.js"></script>
</html>
<?php
	}
}
