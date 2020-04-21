<?php
// Block direct access
if( !defined( 'ABSPATH' ) ){
    exit( 'Direct script access denied.' );
}

/**
 * @Packge     : Medico
 * @Version    : 1.0
 * @Author     : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 */
 
 
function medico_widgets_init() {
    // sidebar widgets 
    
    register_sidebar(array(
        'name'          => esc_html__('Sidebar widgets', 'medico'),
        'description'   => esc_html__('Place widgets in sidebar widgets area.', 'medico'),
        'id'            => 'sidebar_widgets',
        'before_widget' => '<div id="%1$s" class="widget single_sidebar_widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget_title">',
        'after_title'   => '</h4>'
    ));

	// footer widgets register
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer One', 'medico' ),
			'id'            => 'footer-1',
			'before_widget' => '<div id="%1$s" class="single-footer-widget footer_1 %2$s">',
			'after_widget'  => '</div>',
			// 'before_title'  => '<h4>',
			// 'after_title'   => '</h4>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Two', 'medico' ),
			'id'            => 'footer-2',
			'before_widget' => '<div id="%1$s" class="col-xl-2 col-sm-6 col-md-4 single-footer-widget footer_2 %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4>',
			'after_title'   => '</h4>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Three', 'medico' ),
			'id'            => 'footer-3',
			'before_widget' => '<div id="%1$s" class="col-xl-2 col-sm-6 col-md-4 single-footer-widget footer_3 footer_icon %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4>',
			'after_title'   => '</h4>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Four', 'medico' ),
			'id'            => 'footer-4',
			'before_widget' => '<div id="%1$s" class="col-xl-2 col-sm-6 col-md-6 single-footer-widget footer_4 %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4>',
			'after_title'   => '</h4>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Five', 'medico' ),
			'id'            => 'footer-5',
			'before_widget' => '<div id="%1$s" class="col-xl-3 col-sm-6 col-md-6 single-footer-widget footer_5 %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4>',
			'after_title'   => '</h4>',
		)
	);
	

}
add_action( 'widgets_init', 'medico_widgets_init' );
