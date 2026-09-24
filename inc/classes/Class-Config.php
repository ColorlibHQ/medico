<?php 
/**
 * @Packge 	   : Medico
 * @Version    : 1.0
 * @Author 	   : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 */
 
	// Block direct access
	if( !defined( 'ABSPATH' ) ){
		exit( 'Direct script access denied.' );
	}

	// Final Class
	final class Medico{

		
		// Theme Version
		private $medico_version = '1.0';

		// Minimum WordPress Version required
		private $min_wp = '4.0';

		// Minimum PHP version required 
		private $min_php = '5.6.25';

		function __construct(){
			// Theme Support
			add_action( 'after_setup_theme', array( $this, 'support' ) );
			// 
			$this->init();
		}

		// Theme init
		public function init(){
			//
			$this->setup();

			// customizer init Instantiate
			$this->customizer_init();
			
		}

		// Theme setup
		private function setup(){
			
			// Create enqueue class instance
			$enqueu = new medico_Enqueue();
			$enqueu->scripts = $this->enqueue() ;
			$enqueu->medico_scripts_enqueue_init() ;

		}
		// Theme Support
		public function support(){
			// content width
	        $GLOBALS['content_width'] = apply_filters( 'medico_content_width', 751 );

	        
	        // text domain for translation.
	        load_theme_textdomain( 'medico', MEDICO_DIR_PATH . '/languages' );
	        
	        // support title tage
	        add_theme_support( 'title-tag' );
	        
	        // support logo
			add_theme_support( 'custom-logo', array(
				'height'      => 28,
				'width'       => 119,
				'flex-height' => true,
				'flex-width'  => true,
				'header-text' => array( 'site-title', 'site-description' ),
			) );

			//Custom Hreader
			add_theme_support( 'custom-header', array(
				'flex-width'    => true,
				'width'         => 1920,
				'flex-height'   => true,
				'height'        => 275,
				'default-image' => get_template_directory_uri() . '/assets/img/banner.png'
			) );

			//Custom background
			add_theme_support( 'custom-background', array(
				'default-color' => 'ffffff'
			) );

	        //  support post format
	        add_theme_support( 'post-formats', array( 'video','audio' ) );
	        
	        // support post-thumbnails
	        add_theme_support( 'post-thumbnails', array( 'post' ) );
			
			// Site logo size
			add_image_size( 'medico_logo_119x28', 119, 28, true );
					
			// Banner image size
			add_image_size( 'medico_banner_section_652x502', 652, 502, true );
					
			// About image size
			add_image_size( 'medico_about_section_533x531', 533, 531, true );
					
			// Services image size
			add_image_size( 'medico_services_section_425x425', 425, 425, true );
					
			// Doctors image size
			add_image_size( 'medico_doctors_section_263x339', 263, 339, true );
					
			// Appointment image size
			add_image_size( 'medico_appointment_section_390x683', 390, 683, true );
			
			// Home blog post image size
			add_image_size( 'medico_home_blog_555x572', 555, 572, true );

			// Latest post thumbnail Widget thumbnail size
			add_image_size( 'medico_widget_post_thumb', 80, 80, true );

			// Single blog post image size
			add_image_size( 'medico_single_blog_750x375', 750, 375, true );
			add_image_size( 'medico_np_thumb', 60, 60, true );
	        	        
	        // support automatic feed links
	        add_theme_support( 'automatic-feed-links' );
	        
	        // support html5
	        add_theme_support( 'html5' );
			
			// Add theme support for selective refresh for widgets.
			add_theme_support( 'customize-selective-refresh-widgets' );
						    
	        // register nav menu
	        register_nav_menus( array(
	            'primary-menu'   => esc_html__( 'Primary Menu', 'medico' ),
				'quick-links'     => esc_html__( 'Quick Links', 'medico' ),
				'explore'    	 => esc_html__( 'Explore', 'medico' ),
				'resources'    	 => esc_html__( 'Resources', 'medico' ),
	        ) );

	        // editor style
	        add_editor_style('assets/css/editor-style.css');

		} // end support method

		// enqueue theme style and script
		private function enqueue(){

			$cssPath = MEDICO_DIR_CSS_URI;
			$jsPath  = MEDICO_DIR_JS_URI;

			$scripts = array(
				'style' => array(
					array(
						'handler'		=> 'medico-google-font',
						'file' 			=> $this->google_font(),
					),
					array(
						'handler'		=> 'medico-bootstrap',
						'file' 			=> $cssPath.'bootstrap.min.css',
						'dependency' 	=> array(),
						'version' 		=> '5.3.8-5',
					),
					array(
						'handler'		=> 'medico-animate',
						'file' 			=> $cssPath.'animate.css',
						'dependency' 	=> array(),
						'version' 		=> '1.0',
					),
					array(
						'handler'		=> 'medico-owl-carousel',
						'file' 			=> $cssPath.'owl.carousel.min.css',
						'dependency' 	=> array(),
						'version' 		=> '1.0',
					),
					array(
						'handler'		=> 'medico-font-awesome',
						'file' 			=> $cssPath.'font-awesome.min.css',
						'dependency' 	=> array(),
						'version' 		=> '7.3.1-1',
					),
					array(
						'handler'		=> 'medico-themify',
						'file' 			=> $cssPath.'themify-icons.css',
						'dependency' 	=> array(),
						'version' 		=> '1.0',
					),
					array(
						'handler'		=> 'medico-flaticon',
						'file' 			=> $cssPath.'flaticon.css',
						'dependency' 	=> array(),
						'version' 		=> '1.0',
					),
					array(
						'handler'		=> 'medico-magnific-popup-css',
						'file' 			=> $cssPath.'magnific-popup.css',
						'dependency' 	=> array(),
						'version' 		=> '1.0',
					),
					array(
						'handler'		=> 'medico-slick-css',
						'file' 			=> $cssPath.'slick.css',
						'dependency' 	=> array(),
						'version' 		=> '1.0',
					),
					array(
						'handler'		=> 'medico-nice-select-css',
						'file' 			=> $cssPath.'nice-select.css',
						'dependency' 	=> array(),
						'version' 		=> '1.0',
					),
					array(
						'handler'		=> 'medico-default-css',
						'file' 			=> $cssPath.'default.css',
						'dependency' 	=> array(),
						'version' 		=> '1.0',
					),
					array(
						'handler'		=> 'medico-style-css',
						'file' 			=> $cssPath.'style.css',
						'dependency' 	=> array(),
						'version' 		=> '1.0',
					),
					
					array(
						'handler'		=> 'medico-style',
						'file' 			=> get_stylesheet_uri(),
					),
				),
				
				'scripts' => array(
					array(
						'handler'		=> 'medico-bootstrap',
						'file' 			=> $jsPath.'bootstrap.min.js',
						'dependency' 	=> array( 'jquery' ),
						'version' 		=> '5.3.8-4',
						'in_footer' 	=> true
					),
					array(
						'handler'		=> 'medico-owl-carousel-js',
						'file' 			=> $jsPath.'owl.carousel.min.js',
						'dependency' 	=> array( 'jquery' ),
						'version' 		=> '1.0',
						'in_footer' 	=> true
					),
					array(
						'handler'		=> 'medico-ajaxchimp-min-js',
						'file' 			=> $jsPath.'jquery.ajaxchimp.min.js',
						'dependency' 	=> array( 'jquery' ),
						'version' 		=> '1.0',
						'in_footer' 	=> true
					),
					
					array(
						'handler'		=> 'medico-ui-js',
						'file' 			=> $jsPath.'colorlib-ui.js',
						'dependency' 	=> array(),
						'version' 		=> '2.1.1',
						'in_footer' 	=> true
					),
					array(
						'handler'		=> 'medico-custom',
						'file' 			=> $jsPath.'custom.js',
						'dependency' 	=> array( 'jquery', 'medico-ui-js' ),
						'version' 		=> $this->medico_version . '-s1',
						'in_footer' 	=> true
					),

				)
			);

			return $scripts;

		} // end enqueu method 

		// Google Font  
		private function google_font(){
			$font_url = '';

			/*
			 * The families this theme uses are bundled under
			 * assets/fonts/google, so nothing is fetched from Google and
			 * no request leaves the visitor's browser for a third party.
			 *
			 * Translators can still turn the fonts off for scripts these
			 * families do not cover.
			 */
			if ( 'off' !== _x( 'on', 'Google font: on or off', 'medico' ) ) {
				$font_url = get_template_directory_uri() . '/assets/css/google-fonts.css';
			}

			return esc_url_raw( $font_url );
		} //End google_font method

		private function customizer_init(){

		
			

			
			// Instantiate medico theme customizer
			$medico_theme_customizer = new medico_theme_customizer();
		}
	} // End Medico Class

?>