<?php namespace GlobalTechnology\GlobalMeasurements {
	require_once( dirname( __FILE__ ) . '/vendor/autoload.php' );
	$wrapper = ApplicationWrapper::singleton();
	$wrapper->authenticate();
	$min = Config::get( 'use_min', true ) ? '.min' : '';
	?>
	<!doctype html>
	<html>
	<head>
		<title>Next-Gen Measurements</title>
		<link rel="icon" type="image/png" href="<?php echo $wrapper->versionUrl( "app/img/gma-logo.png" ); ?>">

		<link href="<?php echo $wrapper->versionUrl( "app/vendor/bootstrap/dist/css/bootstrap{$min}.css" ); ?>" rel="stylesheet" />
		<link href="<?php echo $wrapper->versionUrl( "app/vendor/bootstrap/dist/css/bootstrap-theme{$min}.css" ); ?>" rel="stylesheet" />
		<link href="<?php echo $wrapper->versionUrl( 'app/css/spinner.css' ); ?>" rel="stylesheet" />
		<link href="<?php echo $wrapper->versionUrl( 'app/css/gcm.css' ); ?>" rel="stylesheet" />

		<script type="application/javascript" src="<?php echo $wrapper->versionUrl( "app/vendor/jquery/dist/jquery{$min}.js" ); ?>"></script>
		<script type="application/javascript">
			var gma = window.gma = window.gma || {};
			gma.config = <?php echo $wrapper->appConfig(); ?>;
		</script>
	</head>
	<body>
	<div ng-include="'app/template/app.html'"></div>
	<script type="application/javascript"
			data-main="<?php echo $wrapper->versionUrl( "app/js/main.js" ); ?>"
			src="<?php echo $wrapper->versionUrl( "app/vendor/requirejs/require.js" ); ?>"></script>
	</body>
	</html>
<?php }
