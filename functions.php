<?php 
/**
 * @Packge 	   : Colorlib
 * @Version    : 1.0
 * @Author 	   : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 */
 
	// Block direct access
	if( !defined( 'ABSPATH' ) ){
		exit( 'Direct script access denied.' );
	}

	/**
	 *
	 * Define constant
	 *
	 */
	
	 
	// Base URI
	if( !defined( 'MEDICO_DIR_URI' ) )
		define( 'MEDICO_DIR_URI', get_template_directory_uri().'/' );
	
	// assets URI
	if( !defined( 'MEDICO_DIR_ASSETS_URI' ) )
		define( 'MEDICO_DIR_ASSETS_URI', MEDICO_DIR_URI.'assets/' );
	
	// Css File URI
	if( !defined( 'MEDICO_DIR_CSS_URI' ) )
		define( 'MEDICO_DIR_CSS_URI', MEDICO_DIR_ASSETS_URI .'css/' );
	
	// Js File URI
	if( !defined( 'MEDICO_DIR_JS_URI' ) )
		define( 'MEDICO_DIR_JS_URI', MEDICO_DIR_ASSETS_URI .'js/' );
	
	// Icon Images
	if( !defined('MEDICO_DIR_ICON_IMG_URI') )
		define( 'MEDICO_DIR_ICON_IMG_URI', MEDICO_DIR_ASSETS_URI.'img/icon/' );
	
	//DIR inc
	if( !defined( 'MEDICO_DIR_INC' ) )
		define( 'MEDICO_DIR_INC', MEDICO_DIR_URI.'inc/' );

	//Elementor Widgets Folder Directory
	if( !defined( 'MEDICO_DIR_ELEMENTOR' ) )
		define( 'MEDICO_DIR_ELEMENTOR', MEDICO_DIR_INC.'elementor-widgets/' );

	// Base Directory
	if( !defined( 'MEDICO_DIR_PATH' ) )
		define( 'MEDICO_DIR_PATH', get_parent_theme_file_path().'/' );
	
	//Inc Folder Directory
	if( !defined( 'MEDICO_DIR_PATH_INC' ) )
		define( 'MEDICO_DIR_PATH_INC', MEDICO_DIR_PATH.'inc/' );
	
	//Colorlib framework Folder Directory
	if( !defined( 'MEDICO_DIR_PATH_LIB' ) )
		define( 'MEDICO_DIR_PATH_LIB', MEDICO_DIR_PATH_INC.'libraries/' );
	
	//Classes Folder Directory
	if( !defined( 'MEDICO_DIR_PATH_CLASSES' ) )
		define( 'MEDICO_DIR_PATH_CLASSES', MEDICO_DIR_PATH_INC.'classes/' );

	
	//Widgets Folder Directory
	if( !defined( 'MEDICO_DIR_PATH_WIDGET' ) )
		define( 'MEDICO_DIR_PATH_WIDGET', MEDICO_DIR_PATH_INC.'widgets/' );
		
	//Elementor Widgets Folder Directory
	if( !defined( 'MEDICO_DIR_PATH_ELEMENTOR_WIDGETS' ) )
		define( 'MEDICO_DIR_PATH_ELEMENTOR_WIDGETS', MEDICO_DIR_PATH_INC.'elementor-widgets/' );
	

		
	/**
	 * Include File
	 *
	 */
	
	// Breadcrumbs file include
	require_once( MEDICO_DIR_PATH_INC . 'medico-breadcrumbs.php' );
	// Sidebar register file include
	require_once( MEDICO_DIR_PATH_INC . 'widgets/medico-widgets-reg.php' );
	// Post widget file include
	require_once( MEDICO_DIR_PATH_INC . 'widgets/medico-recent-post-thumb.php' );
	// News letter widget file include
	require_once( MEDICO_DIR_PATH_INC . 'widgets/medico-newsletter-widget.php' );
	//Social Links
	require_once( MEDICO_DIR_PATH_INC . 'widgets/medico-social-links.php' );
	// Instagram Widget
	require_once( MEDICO_DIR_PATH_INC . 'widgets/medico-instagram.php' );
	// Nav walker file include
	require_once( MEDICO_DIR_PATH_INC . 'wp_bootstrap_navwalker.php' );
	// Theme function file include
	require_once( MEDICO_DIR_PATH_INC . 'medico-functions.php' );

	// Theme Demo file include
	require_once( MEDICO_DIR_PATH_INC . 'demo/demo-import.php' );

	// Post Like
	require_once( MEDICO_DIR_PATH_INC . 'post-like.php' );
	// Theme support function file include
	require_once( MEDICO_DIR_PATH_INC . 'support-functions.php' );
	// Html helper file include
	require_once( MEDICO_DIR_PATH_INC . 'wp-html-helper.php' );
	// Pagination file include
	require_once( MEDICO_DIR_PATH_INC . 'wp_bootstrap_pagination.php' );
	// Elementor Widgets
	require_once( MEDICO_DIR_PATH_ELEMENTOR_WIDGETS . 'elementor-widget.php' );
	//
	require_once( MEDICO_DIR_PATH_CLASSES . 'Class-Enqueue.php' );
	
	require_once( MEDICO_DIR_PATH_CLASSES . 'Class-Config.php' );
	// Customizer
	require_once( MEDICO_DIR_PATH_INC . 'customizer/customizer.php' );
	// Class autoloader
	// Class medico dashboard
	// Common css
	require_once( MEDICO_DIR_PATH_INC . 'medico-commoncss.php' );

	// Admin Enqueue Script
	function medico_admin_script(){
		wp_enqueue_style( 'medico-admin', get_template_directory_uri().'/assets/css/medico_admin.css', false, '1.0.0' );
		wp_enqueue_script( 'medico_admin', get_template_directory_uri().'/assets/js/medico_admin.js', false, '1.0.0' );
	}
	add_action( 'admin_enqueue_scripts', 'medico_admin_script' );

	 
	// WooCommerce style desable
	add_filter( 'woocommerce_enqueue_styles', '__return_false' );


	/**
	 * Instantiate Medico object
	 *
	 * Inside this object:
	 * Enqueue scripts, Google font, Theme support features, Medico Dashboard .
	 *
	 */
	
	$Medico = new Medico();
	


/**
 * A page by title, without get_page_by_title().
 *
 * WordPress deprecated get_page_by_title() in 6.2; this keeps the same
 * signature and return shape so existing calls behave identically.
 *
 * @param string $title     Page title.
 * @param string $output    OBJECT, ARRAY_A or ARRAY_N.
 * @param string $post_type Post type to search.
 * @return WP_Post|array|null
 */
if ( ! function_exists( 'medico_get_page_by_title' ) ) {
	function medico_get_page_by_title( $title, $output = OBJECT, $post_type = 'page' ) {
		$query = new WP_Query(
			array(
				'post_type'              => $post_type,
				'title'                  => $title,
				'post_status'            => 'all',
				'posts_per_page'         => 1,
				'no_found_rows'          => true,
				'ignore_sticky_posts'    => true,
				'update_post_term_cache' => false,
				'update_post_meta_cache' => false,
				'orderby'                => 'post_date ID',
				'order'                  => 'ASC',
			)
		);

		$page = ! empty( $query->posts ) ? $query->posts[0] : null;

		if ( ! $page ) {
			return null;
		}

		if ( ARRAY_A === $output ) {
			return get_object_vars( $page );
		}

		if ( ARRAY_N === $output ) {
			return array_values( get_object_vars( $page ) );
		}

		return $page;
	}
}


/**
 * Editor and markup support this theme predates.
 */
if ( ! function_exists( 'medico_modern_supports' ) ) {
	function medico_modern_supports() {
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-styles' );
	}
	add_action( 'after_setup_theme', 'medico_modern_supports', 20 );
}

/**
 * The theme's Customizer controls.
 *
 * Replaces the Epsilon framework: same fields and stored values,
 * built on core's Customizer API.
 */
require_once get_template_directory() . '/inc/customizer/colorlib-customizer/colorlib-customizer.php';
