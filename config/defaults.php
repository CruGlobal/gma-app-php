<?php return array(
	/**
	 * Wrapper version
	 */
	'version'                    => '2.0.0',

	/**
	 * Application Name
	 */
	'name'                       => 'GMA',

	/**
	 * Application Settings
	 */
	'application'                => array(
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
	'pgtservice'                 => array(
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
	'cas'                        => array(
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
	'measurements'               => array(
		/** @var string API endpoint, no training slash */
		'endpoint'  => 'https://measurements.global-registry.org/v5',
		/** @var string Namespace of application specific measurements */
		'namespace' => 'gma-app',
	),

	/**
	 * Mobile Applications
	 * label => link
	 */
	'mobileapps'                 => array(
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
	'googlemaps'                 => array(
		'endpoint' => '//maps.googleapis.com/maps/api/js?libraries=places',
		'apiKey'   => false,
	),

	'googleanalytics'            => array(
		'apiKey' => false,
	),

	/**
	 * Enabled tabs
	 * reports tab is hidden for now
	 */
	'tabs'                       => array( 'news', 'map', 'measurements', 'admin' ),

	/**
	 * 'prem_link_stub' => 1
	 * 1 = Collapsed
	 * 0 = Expanded
	 */
	'default_measurement_states' => array(
		'gcm' => array(),
		'llm' => array(),
		'slm' => array(),
		'ds'  => array(),

	),

	/**
	 * Set the max values for stories section
	 * Image size in pixels
	 */
	'stories'                    => array(
		'content_length'   => 1000,
		'image_height'     => 256,
		'image_width'      => 256,
		'stories_per_page' => 5,
		'feeds_count'      => 12,
	),

	'area_codes'                 => array(
		'AAOP' => 'East Asia Opportunities',
		'AAOR' => 'East Asia Orient',
		'AASE' => 'Southeast Asia',
		'AASO' => 'South Asia',
		'AFFR' => 'Francophone Africa',
		'AFSE' => 'Southern & Eastern Africa',
		'AFWE' => 'West Africa',
		'EUER' => 'Eastern Europe and Russia',
		'EUWE' => 'Western Europe',
		'LAAM' => 'Latin America',
		'NAME' => 'North Africa & Middle East',
		'NAOC' => 'North America and Oceania',
		'PACT' => 'Persia, Central Asia & Turkey',
	),

	/**
	 * Following ISO 3166-1
	 * @source https://en.wikipedia.org/wiki/ISO_3166-1
	 */
	'static_locales'             => array(
		'en-US' => 'English (United States)',
		'en-GB' => 'English (United Kingdom)',
		'ro-RO' => 'Romanian',
		'sq-AL' => 'Albanian',
		'ru-RU' => 'Russian',
		'uk-UA' => 'Ukrainian',
		'pl-PL' => 'Polish',
		'bg-BG' => 'Bulgarian',
		'sr-BA' => 'Serbian',
		'sk-SK' => 'Slovak',
		'ka-GE' => 'Georgian',
		'he-IL' => 'Hebrew',
		'hu-HU' => 'Hungarian',
		'cs-CZ' => 'Czech',
		'hr-HR' => 'Croatian',
		'am-AM' => 'Amharic',
		'sw-KE' => 'Swahili',
		'pt-PT' => 'Portuguese (Portugal)',
		'pt-BR' => 'Portuguese (Brazil)',
		'fr-FR' => 'French',
		'ha-NG' => 'Hausa',
		'es-AR' => 'Spanish',
		'zh-CN' => 'Chinese Simplified',
		'zh-TW' => 'Chinese Traditional',
		'th-TH' => 'Thai',
		'vi-VN' => 'Vietnamese',
		'de-DE' => 'German',
		'ar-EG' => 'Arabic',
		'hi-IN' => 'Hindi (India)',
		'id-ID' => 'Indonesian',
	),
);
