<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
<style>
html, body {
	background-color: #fff;
	color: #636b6f;
	margin: 0;
}
.content {
	text-align:center;
}
.errores{
	font-family: 'Raleway', sans-serif;
	font-weight: 100;
	height: 100vh;
	font-size: 2em;
}
</style>
<div class="container" style="text-align: center; margin-top: 10%;">
	<div class="errores">
		<h1>ERROR</h1>
		<h2>ERROR</h2>
		<h3>ERROR</h3>
		<h4>ERROR</h4>
		<h5>ERROR</h5>
		<h6>ERROR</h6>
	<a href="<?php echo(URL) ?>" class="btn btn-success">Ir atras.</a>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
	$("a#enlace").click(function (e) {
		e.preventDefault();
		window.location = $("meta[url]").attr("url");
	});
</script>