<?php namespace GlobalTechnology\GlobalMeasurements {
	require_once( dirname( __FILE__ ) . '/vendor/autoload.php' );
	$wrapper = ApplicationWrapper::singleton();
	$wrapper->authenticate();
	$min = Config::get( 'application.directory', 'dist' ) === 'dist' ? '.min' : '';
	?>
	<!doctype html>
	<html>
	<head>
		<title><?php echo Config::get( 'name', 'GMA' ); ?></title>
		<meta charset="utf-8">
		<link rel="icon" type="image/png" href="<?php echo $wrapper->appDir( 'img/logo/favicon.png' ); ?>">
		<script type="application/javascript">
			var gma = window.gma = window.gma || {};
			gma.config = <?php echo $wrapper->appConfig(); ?>;
		</script>
		<style>
			body, html {
				margin: 0; padding: 0; height: 100%; overflow: hidden;
			}

			#GlobalMeasurementsApplication {
				position:absolute; left: 0; right: 0; bottom: 0; top: 0; height: 100%;
			}
		</style>

		<!--<script type="application/javascript" src="<?php echo $wrapper->appDir( "js/wrapper{$min}.js" ); ?>"></script>-->
	</head>
	<body>
	<iframe id="GlobalMeasurementsApplication" src="<?php echo $wrapper->appDir( 'index.html' ); ?>" style="width: 100%; border-width: 0;"></iframe>
	<!--<script type="application/javascript">iFrameResize( {minHeight: 500}, document.getElementById( 'GlobalMeasurementsApplication' ) );</script>-->
	</body>
	</html>
<?php }
