<?php return array(
	/**
	 * Wrapper version
	 */
	'version'         => '1.0.4',

	/**
	 * Application Settings
	 */
	'application'     => array(
		/**
		 * Application directory
		 *
		 * Location where where index.html, javascript, styles should be loaded from.
		 * Valid values (dist, src)
		 */
		'directory'   => 'dist',

		/**
		 * Application Environment
		 *
		 * Valid values (production, stage, development)
		 */
		'environment' => 'production',
	),

	/**
	 * Proxy Granting Ticket Service
	 *
	 * Enable this to use the php wrapper on localhost.
	 */
	'pgtservice'      => array(
		/** @var bool Enable PGT Service */
		'enabled'  => false,
		/** @var string PGT Service proxy callback URL */
		'callback' => 'https://agapeconnect.me/casLogin.aspx',
		/** @var string PGT Service endpoint URL */
		'endpoint' => 'https://agapeconnect.me/DesktopModules/AgapeConnect/casauth/pgtcallback.asmx/RetrievePGTCallback',
		/** @var string PGT Service Username */
		'username' => '',
		/** @var string PGT Service Password */
		'password' => '',
	),

	/**
	 * CAS Settings
	 */
	'cas'             => array(
		/** @var string CAS hostname */
		'hostname' => 'thekey.me',
		/** @var int CAS port */
		'port'     => 443,
		/** @var string CAS context */
		'context'  => 'cas',
	),

	/**
	 * Measurements API
	 */
	'measurements'    => array(
		/** @var string API endpoint, no training slash */
		'endpoint'  => 'https://measurements.global-registry.org/v4',
		/** @var string Namespace of application specific measurements */
		'namespace' => 'gma-app',
	),

	/**
	 * Mobile Applications
	 * label => link
	 */
	'mobileapps'      => array(
		// -- Production --
		'iOS'     => 'itms-services://?action=download-manifest&url=https://downloads.global-registry.org/prod/ios/gma.plist',
		'Android' => 'https://play.google.com/store/apps/details?id=com.expidevapps.android.measurements',
		// -- Stage --
		//'iOS'     => 'itms-services://?action=download-manifest&url=https://downloads.global-registry.org/stage/ios/gma.plist',
		//'Android' => 'https://play.google.com/store/apps/details?id=com.expidevapps.android.measurements.demo',
	),

	/**
	 * Google Maps Configuration
	 */
	'googlemaps'      => array(
		'endpoint' => '//maps.googleapis.com/maps/api/js?libraries=places',
		'apiKey'   => false,
	),

	'googleanalytics' => array(
		'apiKey' => false,
	),

	/**
	 * Enabled tabs
	 */
	'tabs'            => array( 'map', 'measurements', 'reports', 'admin','news' ),

    /**
     * 'prem_link_stub' => 1
     * 1 = Collapsed
     * 0 = Expanded
     */
	'default_measurement_states' => array(
		'gcm'=>array(),
		'llm'=>array(),
		'slm'=>array(),
		'ds'=>array(),

	),

    /**
     * Set the max values for stories section
     * Image size in pixels
     */
    'stories' => array(
        'content_length' => 1000,
        'image_height' => 128,
        'image_width' => 128,
        'stories_per_page' => 5,
        'feeds_count' => 10,
    ),

    'area_codes' => array(
        ['code' => 'AAOP', 'name' => 'East Asia Opportunities'],
        ['code' => 'AAOR', 'name' => 'East Asia Orient'],
        ['code' => 'AASE', 'name' => 'Southeast Asia'],
        ['code' => 'AASO', 'name' => 'South Asia'],
        ['code' => 'AFFR', 'name' => 'Francophone Africa'],
        ['code' => 'AFSE', 'name' => 'Southern & Eastern Africa'],
        ['code' => 'AFWE', 'name' => 'West Africa'],
        ['code' => 'EUER', 'name' => 'Eastern Europe and Russia'],
        ['code' => 'EUWE', 'name' => 'Western Europe'],
        ['code' => 'LAAM', 'name' => 'Latin America'],
        ['code' => 'NAME', 'name' => 'North Africa & Middle East'],
        ['code' => 'NAOC', 'name' => 'North America and Oceania'],
        ['code' => 'PACT', 'name' => 'Persia], Central Asia & Turkey'],
    ),
);
