<?php namespace GlobalTechnology\GlobalMeasurements {
	require_once( dirname( __FILE__ ) . '/vendor/autoload.php' );
	$wrapper = ApplicationWrapper::singleton();
	$wrapper->authenticate();
	$min = Config::get( 'application.directory', 'dist' ) === 'dist' ? '.min' : '';
	?>
	<!doctype html>
	<html>
	<head>
		<title>Next-Gen Measurements</title>
		<link rel="icon" type="image/png" href="<?php echo $wrapper->appDir( 'img/logo/favicon.png' ); ?>">
		<script type="application/javascript">
			var gma = window.gma = window.gma || {};
			gma.config = <?php echo $wrapper->appConfig(); ?>;
		</script>
		<script type="application/javascript" src="<?php echo $wrapper->appDir( "js/wrapper{$min}.js" ); ?>"></script>
	</head>
	<body style="margin: 0;">
	<iframe id="GlobalMeasurementsApplication" src="<?php echo $wrapper->appDir( 'index.html' ); ?>" style="width: 100%; border-width: 0;" scrolling="no"></iframe>
	<script type="application/javascript">iFrameResize( { minHeight: 500}, document.getElementById( 'GlobalMeasurementsApplication' ) );</script>
	</body>
	</html>
<?php }
