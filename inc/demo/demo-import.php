<?php 
/**
 * @Packge     : Medico
 * @Version    : 1.0
 * @Author     : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 */

if( !defined( 'WPINC' ) ){
    die;
}

// demo import file
function medico_import_files() {
	
	$demoImg = '<img src="'. MEDICO_DIR_INC . 'demo/screen-image.png' .' " alt="'.esc_attr__( 'Demo Preview Imgae', 'medico' ).'" />';
	
  return array(
    array(
      'import_file_name'             => 'Medico Demo',
      'local_import_file'            => MEDICO_DIR_PATH_INC .'demo/medico-demo.xml',
      'local_import_widget_file'     => MEDICO_DIR_PATH_INC .'demo/medico-widgets.wie',
      'import_customizer_file_url'   => MEDICO_DIR_INC . 'demo/medico-customizer.dat',
      'import_notice' => $demoImg,
    ),
  );
}
add_filter( 'pt-ocdi/import_files', 'medico_import_files' );
	
// demo import setup
function medico_after_import_setup() {
	// Assign menus to their locations.
    $main_menu    	  = get_term_by( 'name', 'Main Menu', 'nav_menu' );
	$quick_links      = get_term_by( 'name', 'Quick Links', 'nav_menu' );
	$explore     	  = get_term_by( 'name', 'Explore', 'nav_menu' );
	$resources        = get_term_by( 'name', 'Resources', 'nav_menu' );
	
	set_theme_mod( 'nav_menu_locations', array(
            'primary-menu' => $main_menu->term_id,
            'quick-links'  => $quick_links->term_id,
            'explore'  => $explore->term_id,
            'resources'  => $resources->term_id,
		)
	);

	// Assign front page and posts page (blog page).
	$front_page_id = get_page_by_title( 'Homepage' );
	$blog_page_id  = get_page_by_title( 'Blog' );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );
	update_option( 'medico_demodata_import', 'yes' );

}
add_action( 'pt-ocdi/after_import', 'medico_after_import_setup' );

//disable the branding notice after successful demo import
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

//change the location, title and other parameters of the plugin page
function medico_import_plugin_page_setup( $default_settings ) {
	$default_settings['parent_slug'] = 'themes.php';
	$default_settings['page_title']  = esc_html__( 'One Click Demo Import' , 'medico' );
	$default_settings['menu_title']  = esc_html__( 'Import Demo Data' , 'medico' );
	$default_settings['capability']  = 'import';
	$default_settings['menu_slug']   = 'medico-demo-import';

	return $default_settings;
}
add_filter( 'pt-ocdi/plugin_page_setup', 'medico_import_plugin_page_setup' );

// Enqueue scripts
function medico_demo_import_custom_scripts(){
	
	
	if( isset( $_GET['page'] ) && $_GET['page'] == 'medico-demo-import' ){
		// style
		wp_enqueue_style( 'medico-demo-import', MEDICO_DIR_INC . 'demo/css/demo-import.css', array(), '1.0', false );
	}
	
	
}
add_action( 'admin_enqueue_scripts', 'medico_demo_import_custom_scripts' );



?>