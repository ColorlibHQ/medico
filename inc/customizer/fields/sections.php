<?php 
/**
 * @Packge     : Medico
 * @Version    : 1.0
 * @Author     : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 * Customizer panels and sections
 *
 */

/***********************************
 * Register customizer panels
 ***********************************/

$panels = array(
    /**
     * Theme Options Panel
     */
    array(
        'id'   => 'medico_theme_options_panel',
        'args' => array(
            'priority'       => 0,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
            'title'          => esc_html__( 'Theme Options', 'medico' ),
        ),
    )
);


/***********************************
 * Register customizer sections
 ***********************************/


$sections = array(

    /**
     * General Section
     */
    array(
        'id'   => 'medico_general_section',
        'args' => array(
            'title'    => esc_html__( 'General', 'medico' ),
            'panel'    => 'medico_theme_options_panel',
            'priority' => 1,
        ),
    ),
    
    /**
     * Header Section
     */
    array(
        'id'   => 'medico_header_section',
        'args' => array(
            'title'    => esc_html__( 'Header', 'medico' ),
            'panel'    => 'medico_theme_options_panel',
            'priority' => 2,
        ),
    ),

    /**
     * Blog Section
     */
    array(
        'id'   => 'medico_blog_section',
        'args' => array(
            'title'    => esc_html__( 'Blog', 'medico' ),
            'panel'    => 'medico_theme_options_panel',
            'priority' => 3,
        ),
    ),


    /**
     * 404 Page Section
     */
    array(
        'id'   => 'medico_fof_section',
        'args' => array(
            'title'    => esc_html__( '404 Page', 'medico' ),
            'panel'    => 'medico_theme_options_panel',
            'priority' => 6,
        ),
    ),

    /**
     * Footer Section
     */
    array(
        'id'   => 'medico_footer_section',
        'args' => array(
            'title'    => esc_html__( 'Footer Page', 'medico' ),
            'panel'    => 'medico_theme_options_panel',
            'priority' => 7,
        ),
    ),



);


/***********************************
 * Add customizer elements
 ***********************************/
$collection = array(
    'panel'   => $panels,
    'section' => $sections,
);

Epsilon_Customizer::add_multiple( $collection );

?>