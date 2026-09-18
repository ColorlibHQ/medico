<?php
/**
 * Loads the Colorlib Customizer.
 *
 * Include this once from the theme's functions.php. It registers the control
 * classes, captures the Customizer manager before the theme registers its
 * fields, and loads the scripts the controls need.
 *
 * @package Colorlib
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'COLORLIB_CUSTOMIZER_DIR' ) ) {
	define( 'COLORLIB_CUSTOMIZER_DIR', trailingslashit( __DIR__ ) );
}

if ( ! defined( 'COLORLIB_CUSTOMIZER_VERSION' ) ) {
	define( 'COLORLIB_CUSTOMIZER_VERSION', '1.0.0' );
}

require_once COLORLIB_CUSTOMIZER_DIR . 'class-colorlib-customizer.php';

if ( ! function_exists( 'colorlib_customizer_load_controls' ) ) {
	/**
	 * Control classes extend WP_Customize_Control, which only exists once the
	 * Customizer has loaded, so they are required on the hook rather than at
	 * file scope.
	 */
	function colorlib_customizer_load_controls() {
		require_once COLORLIB_CUSTOMIZER_DIR . 'class-colorlib-setting-repeater.php';
		require_once COLORLIB_CUSTOMIZER_DIR . 'controls/class-colorlib-simple-controls.php';
		require_once COLORLIB_CUSTOMIZER_DIR . 'controls/class-colorlib-control-icon-picker.php';
		require_once COLORLIB_CUSTOMIZER_DIR . 'controls/class-colorlib-control-repeater.php';
	}
	add_action( 'customize_register', 'colorlib_customizer_load_controls', 1 );
}

if ( ! function_exists( 'colorlib_customizer_capture_manager' ) ) {
	/**
	 * Hand the manager to the API before the themes' own callbacks run at 10.
	 *
	 * @param WP_Customize_Manager $manager Manager.
	 */
	function colorlib_customizer_capture_manager( $manager ) {
		Colorlib_Customizer::set_manager( $manager );
	}
	add_action( 'customize_register', 'colorlib_customizer_capture_manager', 5 );
}

if ( ! function_exists( 'colorlib_customizer_assets' ) ) {
	/**
	 * Scripts and styles for the control panel.
	 */
	function colorlib_customizer_assets() {
		$base = get_template_directory_uri() . '/inc/customizer/colorlib-customizer/assets/';

		wp_enqueue_style(
			'colorlib-customizer',
			$base . 'customizer.css',
			array( 'wp-color-picker' ),
			COLORLIB_CUSTOMIZER_VERSION
		);

		wp_enqueue_script(
			'colorlib-customizer',
			$base . 'customizer.js',
			array( 'jquery', 'wp-color-picker', 'customize-controls' ),
			COLORLIB_CUSTOMIZER_VERSION,
			true
		);

		// The repeater can pick images.
		wp_enqueue_media();

		// The icon previews need the theme's icon font. Themes ship Font
		// Awesome under a few different names, so take the first that exists
		// rather than guessing one.
		$candidates = array(
			'assets/css/font-awesome.min.css',
			'assets/css/font-awesome.css',
			'assets/css/fontawesome.min.css',
			'assets/fonts/font-awesome/css/font-awesome.min.css',
			'css/font-awesome.min.css',
			'assets/css/all.min.css',
		);

		foreach ( $candidates as $relative ) {
			if ( file_exists( get_template_directory() . '/' . $relative ) ) {
				wp_enqueue_style(
					'colorlib-customizer-icons',
					get_template_directory_uri() . '/' . $relative,
					array(),
					COLORLIB_CUSTOMIZER_VERSION
				);
				break;
			}
		}
	}
	add_action( 'customize_controls_enqueue_scripts', 'colorlib_customizer_assets', 20 );
}
