<?php header('location:'.URL.'error') ?>

<div class="container" style="text-align: center; margin-top: 51px;">
	<h1>ERROR</h1>
	<h2>ERROR</h2>
	<h3>ERROR</h3>
	<h4>ERROR</h4>
	<h5>ERROR</h5>
	<h6>ERROR</h6>
<a href="<?php echo(URL) ?>" class="btn btn-success">Ir atras.</a>
</div>
<script>
	$("#enlace").click(function () {
		window.location = 'http://localhost:8080/PAINRA/error';
	});
</script>