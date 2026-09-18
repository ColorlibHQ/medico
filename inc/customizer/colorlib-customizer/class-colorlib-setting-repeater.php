<?php
/**
 * The setting behind a repeater control.
 *
 * A repeater's value is a list of rows, each an associative array of field
 * key => value. The Customizer posts it as a URL-encoded JSON string, so it
 * has to be decoded before it is saved and always read back as an array.
 *
 * This is deliberately the same contract Epsilon used, because themes store
 * live content here (social links, services, team members) and the front end
 * reads it with get_theme_mod(). Changing the shape would empty those
 * sections.
 *
 * @package Colorlib
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Colorlib_Setting_Repeater' ) ) {

	/**
	 * Class Colorlib_Setting_Repeater
	 */
	class Colorlib_Setting_Repeater extends WP_Customize_Setting {

		/**
		 * Constructor.
		 *
		 * @param WP_Customize_Manager $manager Manager.
		 * @param string               $id      Setting ID.
		 * @param array                $args    Setting arguments.
		 */
		public function __construct( $manager, $id, $args = array() ) {
			parent::__construct( $manager, $id, $args );

			// Has to run before the value is saved, hence the filter rather
			// than a sanitize_callback.
			add_filter( "customize_sanitize_{$this->id}", array( $this, 'sanitize_rows' ), 10, 1 );
		}

		/**
		 * Always an array, so callers can foreach() without checking.
		 *
		 * @return array
		 */
		public function value() {
			$value = parent::value();

			return is_array( $value ) ? $value : array();
		}

		/**
		 * Decode the posted rows into a clean, reindexed list of arrays.
		 *
		 * @param mixed $value URL-encoded JSON, or an array when set in code.
		 * @return array
		 */
		public function sanitize_rows( $value ) {
			if ( ! is_array( $value ) ) {
				$value = json_decode( urldecode( $value ) );
			}

			if ( empty( $value ) || ! is_array( $value ) ) {
				return array();
			}

			$rows = array();

			foreach ( $value as $row ) {
				if ( empty( $row ) ) {
					continue;
				}

				$rows[] = (array) $row;
			}

			// Reindex, so a removed row does not leave a gap.
			return array_values( $rows );
		}
	}
}
