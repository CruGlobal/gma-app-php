<?php namespace GlobalTechnology\GlobalMeasurements {

	require_once( dirname( dirname( __FILE__ ) ) . '/config.php' );
	require_once( dirname( dirname( __FILE__ ) ) . '/vendor/jasig/phpcas/source/CAS.php' );

	class ApplicationWrapper {
		/**
		 * Singleton instance
		 * @var ApplicationWrapper
		 */
		private static $instance;

		/**
		 * Returns the Plugin singleton
		 * @return ApplicationWrapper
		 */
		public static function singleton() {
			if ( ! isset( self::$instance ) ) {
				$class          = __CLASS__;
				self::$instance = new $class();
			}
			return self::$instance;
		}

		/**
		 * Prevent cloning of the class
		 * @internal
		 */
		private function __clone() {
		}

		private $casClient;
		public $baseUrl;

		/**
		 * Constructor
		 */
		private function __construct() {
			$url = \Net_URL2::getRequested();
			$url->setQuery( false );
			if( $this->endswith( $url->getPath(), '.php' ) )
				$url->setPath( dirname( $url->getPath() ) );
			if( isset( $_SERVER[ 'HTTP_X_FORWARDED_PROTO' ] ) )
				$url->setScheme( $_SERVER[ 'HTTP_X_FORWARDED_PROTO' ] );
			$this->baseUrl = rtrim( $url->getURL(), '/' );

			$this->casClient = $this->initializeCAS();
		}

		private function initializeCAS() {
			$casClient = new \CAS_Client( CAS_VERSION_2_0, true, CASHostname, CASPort, CASContext );
			$casClient->setNoCasServerValidation();

			if ( true === UseProxyTicketService ) {
				$casClient->setCallbackURL( ProxyTicketServiceCallback );
				$casClient->setPGTStorage( new ProxyTicketServiceStorage( $casClient ) );
			}
			else {
				$casClient->setCallbackURL( $this->baseUrl . '/callback.php' );
				// Handle logout requests but do not validate the server
				$casClient->handleLogoutRequests( false );
			}

			return $casClient;
		}

		public function getAPIServiceTicket() {
			error_log( rtrim( MeasurementsAPI, '/' ) . '/token' );
			return $this->casClient->retrievePT( rtrim( MeasurementsAPI, '/' ) . '/token', $code, $msg );
		}

		public function authenticate() {
			$this->casClient->forceAuthentication();
		}

		public function logout() {
			$this->casClient->logout( array() );
		}

		public function appConfig() {
			return json_encode( array(
				'ticket'      => $this->getAPIServiceTicket(),
				'api_url'     => rtrim( MeasurementsAPI, '/' ),
				'app_url'     => $this->baseUrl . '/app',
				'refresh_url' => $this->baseUrl . '/refresh.php',
				'cas_logout'  => $this->casClient->getServerLogoutURL(),
			) );
		}

		private function endswith( $string, $test ) {
			$strlen  = strlen( $string );
			$testlen = strlen( $test );
			if ( $testlen > $strlen ) return false;
			return substr_compare( $string, $test, $strlen - $testlen, $testlen ) === 0;
		}
	}

}
