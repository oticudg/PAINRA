<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta url="<?php echo(URL) ?>">
	<title>P A I N R A</title>
	<link rel="shortcut icon" href="<?php echo(URL.'Views/Resource/imagenes/favicon-96x96.png') ?>"/>
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"> -->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
	<link rel="stylesheet" href="<?php Config\Route::css('bootstrap.min') ?>">
	<link rel="stylesheet" href="<?php Config\Route::css('bootstrap-theme.min') ?>">
	<link rel="stylesheet" href="<?php Config\Route::css('font-awesome.min') ?>">
	<link rel="stylesheet" href="Views/Resource/css/estilos.css">
</head>
<body class="bgbody">
	<nav class="navbar navbar-primary navbar-fixed-top" role="navigation">
		<div id="page-loader"> <span class="preloader-interior"></span> </div>
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><i class="fa fa-desktop" aria-hidden="true"></i> <strong>P A I N R A</strong></a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Ingresar</b> <span class="fa fa-user"></span> <span class="caret"></span></a>
						<ul id="login-dp" class="dropdown-menu">
							<li>
								<div class="row">
									<div class="col-md-12">
										<form class="form" role="form" method="post" action="" accept-charset="UTF-8" id="">
											<div class="form-group">
												<label class="sr-only" for="usuario">Usuario</label>
												<input type="text" class="form-control" id="usuario" name="usuario" pattern="[A-Za-z0-9@.-]{2,}" placeholder="Ingrese su usuario" required>
											</div>
											<div class="form-group">
												<label class="sr-only" for="clave">Contraseña</label>
												<input type="password" class="form-control" id="clave" name="clave" pattern=".{8,}" placeholder="Ingrese su contraseña" required>
											</div>
											<div class="form-group">
												<button type="submit" id="ingresar" class="btn btn-primary btn-block"><span class="fa fa-sign-in"></span> Iniciar Sesion <i class="fa fa-spinner fa-pulse fa-1x fa-fw" style="display: none;"></i></button>
											</div>
											<input type="hidden" name="token" value="1">
										</form>
									</div>
									<div class="bottom text-center">
										<span id="menssage"> Presione para ingresar!</span>
									</div>
								</div>
							</li>
						</ul>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
	<div class="container-fluid">
		<div class="row text-primary text-center">
			<h2>Bienvenido a PAINRA</h2>
			<h3>Su sistema de control de solicitud de servicios</h3>
		</div>
	</div>
	<footer class="navbar-fixed-bottom">
		<div class="container">
			<p class="text-center"> APLICACIÓN DESARROLLADA POR LA UNIDAD DE DESARROLLO Y PROGRAMACIÓN - OTIC <b><span class="fa fa-copyright"></span> Copyleft</b> </p>
		</div>
	</footer>
</body>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->
<script src="<?php Config\Route::js('jquery.min') ?>"></script>
<script src="<?php Config\Route::js('bootstrap.min') ?>"></script>
<script src="Views/Resource/js/login.js"></script>
</html>
