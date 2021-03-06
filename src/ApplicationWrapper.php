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

		public $casClient;
		public $url;

		/**
		 * Constructor
		 */
		private function __construct() {
			//Load config
			$configDir = dirname( dirname( __FILE__ ) ) . '/config';
			Config::load(
				file_exists( $configDir . '/config.php' ) ? require $configDir . '/config.php' : array(),
				require $configDir . '/defaults.php'
			);

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
			else if ( false !== Config::get( 'redis.hostname', false ) ) {
				$casClient->setCallbackURL( $this->url->getURL() . '/callback.php' );

				$redis = new \Redis();
				$redis->connect( Config::get( 'redis.hostname' ), (int) Config::get( 'redis.port', 6379 ), 2 );
				$redis->setOption( \Redis::OPT_SERIALIZER, \Redis::SERIALIZER_PHP );
				$redis->setOption( \Redis::OPT_PREFIX, Config::get( 'application.project_name' ) . ':PHPCAS_TICKET_STORAGE:' );
				$redis->select( (int) Config::get( 'redis.db', 2 ) );
				$casClient->setPGTStorage( new RedisTicketStorage( $casClient, $redis ) );
			}
			else {
				$casClient->setCallbackURL( $this->url->resolve( 'callback.php' )->getURL() );
				$casClient->setPGTStorageFile( session_save_path() );
				// Handle logout requests but do not validate the server
				$casClient->handleLogoutRequests( false );
			}

			// Accept all proxy chains
			$casClient->getAllowedProxyChains()->allowProxyChain( new \CAS_ProxyChain_Any() );

			return $casClient;
		}

		public function getAPIServiceTicket() {
			return $this->casClient->retrievePT( Config::get( 'measurements.endpoint' ) . '/token', $code, $msg );
		}

		public function versionUrl( $url ) {
			$version = Config::get( 'version', false );
			if ( $version ) {
				$url = new \Net_URL2( $url );
				$url->setQueryVariable( 'ver', $version );
				return $url->getURL();
			}
			return $url;
		}

		public function authenticate() {
			$this->casClient->forceAuthentication();
		}

		public function logout() {
			$this->casClient->logout( array() );
		}

		public function appDir( $path = '' ) {
			$url = $this->url->resolve( 'app/' . Config::get( 'application.directory', 'dist' ) . '/' . ltrim( $path, '/' ) );
			$url->setQueryVariable( 'ver', Config::get( 'version', 'false' ) );
			return $url->getURL();
		}

		public function appConfig() {
			return json_encode( array(
				'version'                    => Config::get( 'version', '' ),
				'name'                       => stripos( \Net_URL2::getRequestedURL(), 'ishare' ) === false ?
					Config::get( 'name', 'GMA' ) : 'iShare',
				'ticket'                     => $this->getAPIServiceTicket(),
				'appUrl'                     => $this->url->resolve( 'app' )->getPath(),
				'mobileapps'                 => $this->mobileApps(),
				'api'                        => array(
					'measurements' => Config::get( 'measurements.endpoint' ),
					'refresh'      => $this->url->resolve( 'refresh.php' )->getPath(),
					'logout'       => Config::get( 'pgtservice.enabled' )
						? $this->url->resolve( 'logout.php' )->getPath()
						: $this->casClient->getServerLogoutURL(),
					'login'        => $this->casClient->getServerLoginURL(),
				),
				'namespace'                  => Config::get( 'measurements.namespace' ),
				'googlemaps'                 => $this->googleMapsUrl(),
				'googleanalytics'            => Config::get( 'googleanalytics.apiKey', false ),
				'tabs'                       => Config::get( 'tabs', array() ),
				'environment'                => Config::get( 'application.environment', 'production' ),
				'default_measurement_states' => stripos( \Net_URL2::getRequestedURL(), 'ishare' ) === false ?
					Config::get( 'default_measurement_states', array() ) : array(
						'gcm' => array( 'win_exposing' => 1 ),
						'llm' => array( 'win_exposing' => 1 ),
						'slm' => array( 'win_exposing' => 1 ),
						'ds'  => array( 'win_exposing' => 1 ),
					),
				'stories'                    => Config::get( 'stories', array() ),
				'area_codes'                 => Config::get( 'area_codes', array() ),
				'static_locales'             => Config::get( 'static_locales', array() ),
			), JSON_FORCE_OBJECT );
		}

		private function mobileApps() {
			$configuredApps = Config::get( 'mobileapps', array() );
			$apps           = array();
			foreach ( $configuredApps as $label => $link ) {
				$apps[] = array(
					'label' => $label,
					'link'  => $link,
				);
			}
			return $apps;
		}

		private function googleMapsUrl() {
			$url = new \Net_URL2( Config::get( 'googlemaps.endpoint' ) );
			if ( $key = Config::get( 'googlemaps.apiKey', false ) )
				$url->setQueryVariable( 'key', $key );
			return $url->getURL();
		}

		private function endswith( $string, $test ) {
			$strlen  = strlen( $string );
			$testlen = strlen( $test );
			if ( $testlen > $strlen ) return false;
			return substr_compare( $string, $test, $strlen - $testlen, $testlen ) === 0;
		}
	}

}
