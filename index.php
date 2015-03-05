<?php namespace GlobalTechnology\GlobalMeasurements {
	require_once( dirname( __FILE__ ) . '/vendor/autoload.php' );
	$wrapper = ApplicationWrapper::singleton();
	$wrapper->authenticate();
	?>
	<!doctype html>
	<html>
	<head>
		<title>Next-Gen Measurements</title>
		<link rel="icon" type="image/png" href="app/img/gma-logo.png">

		<link href="app/vendor/bootstrap/dist/css/bootstrap.css" rel="stylesheet" />
		<link href="app/vendor/bootstrap/dist/css/bootstrap-theme.css" rel="stylesheet" />
		<link href="app/css/spinner.css" rel="stylesheet" />
		<link href="app/css/gcm.css" rel="stylesheet" />

		<script type="application/javascript" src="app/vendor/jquery/dist/jquery.js"></script>
		<script type="application/javascript">
			var gma = window.gma = window.gma || {};
			gma.config = <?php echo $wrapper->appConfig(); ?>;
		</script>
	</head>
	<body>
	<div ng-include="'app/template/app.html'"></div>
	<script type="application/javascript" data-main="app/js/main.js" src="app/vendor/requirejs/require.js"></script>
	</body>
	</html>
<?php }
