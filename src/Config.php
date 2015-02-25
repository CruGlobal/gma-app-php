<?php namespace GlobalTechnology\GlobalMeasurements {

	class Config {
		private static $config = array();

		/**
		 * @param      $option
		 * @param null $default
		 *
		 * @return mixed
		 */
		public static function get( $option, $default = null ) {
			$parts = explode( '.', $option );
			$value = static::$config;
			foreach ( $parts as $part ) {
				if ( array_key_exists( $part, $value ) )
					$value = $value[ $part ];
				else
					return $default;
			}
			return $value;
		}

		public static function load( $file ) {
			static::$config = require $file;
		}
	}

}
