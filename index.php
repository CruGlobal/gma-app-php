<?php namespace GlobalTechnology\GlobalMeasurements {
	require_once( dirname( __FILE__ ) . '/vendor/autoload.php' );
	$wrapper = ApplicationWrapper::singleton();
	$wrapper->authenticate();
	?>
	<!doctype html>
	<html>
	<head>
		<title>Next-Gen Measurements</title>
		<link rel="icon" type="image/png" href="<?php echo $wrapper->versionUrl( "app/img/gma-logo.png" ); ?>">
		<script type="application/javascript">
			var gma = window.gma = window.gma || {};
			gma.config = <?php echo $wrapper->appConfig(); ?>;
		</script>
		<script type="application/javascript" src="app/dist/iframeResizer.min.js"></script>
	</head>
	<body style="margin: 0;">
	<iframe id="GlobalMeasurementsApplication" src="app/dist/gma.html" style="width: 100%; border-width: 0;" scrolling="no"></iframe>
	<script type="application/javascript">iFrameResize( {}, document.getElementById( 'GlobalMeasurementsApplication' ) );</script>
	</body>
	</html>
<?php }
