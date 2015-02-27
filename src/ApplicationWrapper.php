<?php namespace GlobalTechnology\GlobalMeasurements {

	// Require phpCAS, composer does not autoload it.
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
		public $url;

		/**
		 * Constructor
		 */
		private function __construct() {
			//Load config
			Config::load( dirname( dirname( __FILE__ ) ) . '/config.php' );

			//Generate Current URL taking into account forwarded proto
			$url = \Net_URL2::getRequested();
			$url->setQuery( false );
			if ( $this->endswith( $url->getPath(), '.php' ) )
				$url->setPath( dirname( $url->getPath() ) );
			if ( isset( $_SERVER[ 'HTTP_X_FORWARDED_PROTO' ] ) )
				$url->setScheme( $_SERVER[ 'HTTP_X_FORWARDED_PROTO' ] );
			$this->url = $url;

			// Initialize phpCAS proxy client
			$this->casClient = $this->initializeCAS();
		}

		private function initializeCAS() {
			$casClient = new \CAS_Client(
				CAS_VERSION_2_0,
				true,
				Config::get( 'cas.hostname' ),
				Config::get( 'cas.port' ),
				Config::get( 'cas.context' )
			);
			$casClient->setNoCasServerValidation();

			if ( true === Config::get( 'pgtservice.enabled', false ) ) {
				$casClient->setCallbackURL( Config::get( 'pgtservice.callback' ) );
				$casClient->setPGTStorage( new ProxyTicketServiceStorage( $casClient ) );
			}
			else {
				$casClient->setCallbackURL( $this->url->resolve( 'callback.php' )->getURL() );
				$casClient->setPGTStorageFile( session_save_path() );
				// Handle logout requests but do not validate the server
				$casClient->handleLogoutRequests( false );
			}

			return $casClient;
		}

		public function getAPIServiceTicket() {
			return $this->casClient->retrievePT( Config::get( 'measurements.endpoint' ) . '/token', $code, $msg );
		}

		public function authenticate() {
			$this->casClient->forceAuthentication();
		}

		public function logout() {
			$this->casClient->logout( array() );
		}

		public function appConfig() {
			return json_encode( array(
				'ticket'     => $this->getAPIServiceTicket(),
				'appUrl'     => $this->url->resolve( 'app' )->getPath(),
				'mobileapps' => $this->mobileApps(),
				'api'        => array(
					'measurements' => Config::get( 'measurements.endpoint' ),
					'refresh'      => $this->url->resolve( 'refresh.php' )->getPath(),
					'logout'       => Config::get( 'pgtservice.enabled' )
						? $this->url->resolve( 'logout.php' )->getPath()
						: $this->casClient->getServerLogoutURL(),
				),
				'namespace'  => Config::get( 'measurements.namespace' ),
			) );
		}

		private function mobileApps() {
			$configuredApps = Config::get( 'mobileapps', array() );
			$apps           = array();
			foreach ( $configuredApps as $label => $link ) {
				$apps[ ] = array(
					'label' => $label,
					'link'  => $link,
				);
			}
			return $apps;
		}

		private function endswith( $string, $test ) {
			$strlen  = strlen( $string );
			$testlen = strlen( $test );
			if ( $testlen > $strlen ) return false;
			return substr_compare( $string, $test, $strlen - $testlen, $testlen ) === 0;
		}
	}

}
