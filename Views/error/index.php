<div class="container" style="text-align: center; margin-top: 10%;">
	<h1>ERROR</h1>
	<h2>ERROR</h2>
	<h3>ERROR</h3>
	<h4>ERROR</h4>
	<h5>ERROR</h5>
	<h6>ERROR</h6>
	<a href="<?php echo(URL) ?>" class="btn btn-success">Ir atras.</a>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
	$("a#enlace").click(function (e) {
		e.preventDefault();
		window.location = $("meta[url]").attr("url");
	});
</script>