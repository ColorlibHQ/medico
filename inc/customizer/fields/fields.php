<?php 
/**
 * @Packge     : Medico
 * @Version    : 1.0
 * @Author     : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 * Customizer section fields
 *
 */

/***********************************
 * General Section Fields
 ***********************************/

 // Theme color field
Epsilon_Customizer::add_field(
    'medico_theme_color',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( 'Theme Color', 'medico' ),
        'description' => esc_html__( 'Select the theme color.', 'medico' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'medico_general_section',
        'default'     => '#0065e1',
    )
);
 
// Header background color field
Epsilon_Customizer::add_field(
    'medico_header_bg_color',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( 'Sticky Header BG Color', 'medico' ),
        'description' => esc_html__( 'Select the header background color.', 'medico' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'medico_header_section',
        'default'     => '#fff',
    )
);

// Header nav menu color field
Epsilon_Customizer::add_field(
    'medico_header_menu_color',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( 'Header menu color', 'medico' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'medico_header_section',
        'default'     => '#242429',
    )
);

// Header nav menu hover color field
Epsilon_Customizer::add_field(
    'medico_header_menu_hover_color',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( 'Header menu hover color', 'medico' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'medico_header_section',
        'default'     => '#0065e1',
    )
);

// Header dropdown menu bg color field
Epsilon_Customizer::add_field(
    'medico_header_drop_menu_bg_color',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( 'Dropdown menu BG color', 'medico' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'medico_header_section',
        'default'     => '#fafafa',
    )
);

// Header dropdown menu color field
Epsilon_Customizer::add_field(
    'medico_header_drop_menu_color',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( 'Dropdown menu color', 'medico' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'medico_header_section',
        'default'     => '#000',
    )
);

// Header dropdown menu hover color field
Epsilon_Customizer::add_field(
    'medico_header_drop_menu_hover_color',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( 'Dropdown menu hover color', 'medico' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'medico_header_section',
        'default'     => '#0065e1',
    )
);


// Header right button toggle section
Epsilon_Customizer::add_field(
    'medico_header_button_section_separator',
    array(
        'type'        => 'epsilon-separator',
        'label'       => esc_html__( 'Header right button toggle Section', 'medico' ),
        'section'     => 'medico_header_section',

    )
);


// Header right button toggle
Epsilon_Customizer::add_field(
	'medico_header_right_button',
	array(
		'type'        => 'epsilon-toggle',
		'label'       => esc_html__( 'Header right button show/hide', 'medico' ),
		'section'     => 'medico_header_section',
		'default'     => true
	)
);

// Header right button toggle
Epsilon_Customizer::add_field(
	'medico_header_right_button_lbl',
	array(
		'type'              => 'text',
		'label'             => esc_html__( 'Header right button label', 'medico' ),
		'section'           => 'medico_header_section',
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__( 'HOT LINE- 09856', 'medico' ),
	)
);

// Header right button toggle
Epsilon_Customizer::add_field(
	'medico_header_right_button_url',
	array(
		'type'              => 'url',
		'label'             => esc_html__( 'Header right button URL', 'medico' ),
		'section'           => 'medico_header_section',
        'sanitize_callback' => 'esc_url_raw'
	)
);

// Header right button text color field
Epsilon_Customizer::add_field(
    'medico_header_right_btn_color',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( 'Header right button text color', 'medico' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'medico_header_section',
        'default'     => '#fff'
    )
);

// Header right button hover bg color field
Epsilon_Customizer::add_field(
    'medico_header_right_btn_bg_color',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( 'Header right button bg color', 'medico' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'medico_header_section',
        'default'     => '#0065e1'
    )
);


/***********************************
 * Blog Section Fields
 ***********************************/
 
// Post excerpt length field
Epsilon_Customizer::add_field(
    'medico_excerpt_length',
    array(
        'type'        => 'text',
        'label'       => esc_html__( 'Set post excerpt length', 'medico' ),
        'description' => esc_html__( 'Set post excerpt length.', 'medico' ),
        'section'     => 'medico_blog_section',
        'sanitize_callback' => 'sanitize_text_field',
        'default'     => '30',
    )
);

// Blog single page social share icon
Epsilon_Customizer::add_field(
    'medico_blog_meta',
    array(
        'type'        => 'epsilon-toggle',
        'label'       => esc_html__( 'Blog page post meta show/hide', 'medico' ),
        'section'     => 'medico_blog_section',
        'default'     => true
    )
);
Epsilon_Customizer::add_field(
    'medico_like_btn',
    array(
        'type'        => 'epsilon-toggle',
        'label'       => esc_html__( 'Blog Single Page Like Button show/hide', 'medico' ),
        'section'     => 'medico_blog_section',
        'default'     => true
    )
);
Epsilon_Customizer::add_field(
    'medico_blog_share',
    array(
        'type'        => 'epsilon-toggle',
        'label'       => esc_html__( 'Blog Single Page Share show/hide', 'medico' ),
        'section'     => 'medico_blog_section',
        'default'     => true
    )
);

/***********************************
 * 404 Page Section Fields
 ***********************************/

// 404 text #1 field
Epsilon_Customizer::add_field(
    'medico_fof_titleone',
    array(
        'type'              => 'text',
        'label'             => esc_html__( '404 Text #1', 'medico' ),
        'section'           => 'medico_fof_section',
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 'Say Hello.'
    )
);
// 404 text #2 field
Epsilon_Customizer::add_field(
    'medico_fof_titletwo',
    array(
        'type'              => 'text',
        'label'             => esc_html__( '404 Text #2', 'medico' ),
        'section'           => 'medico_fof_section',
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 'Say Hello.'
    )
);
// 404 text #1 color field
Epsilon_Customizer::add_field(
    'medico_fof_textone_color',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( '404 Text #1 Color', 'medico' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'medico_fof_section',
        'default'     => '#000000',
    )
);
// 404 text #2 color field
Epsilon_Customizer::add_field(
    'medico_fof_texttwo_color',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( '404 Text #2 Color', 'medico' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'medico_fof_section',
        'default'     => '#656565',
    )
);
// 404 background color field
Epsilon_Customizer::add_field(
    'medico_fof_bg_color',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( '404 Page Background Color', 'medico' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'medico_fof_section',
        'default'     => '#fff',
    )
);

/***********************************
 * Footer Section Fields
 ***********************************/

// Footer Widget section
Epsilon_Customizer::add_field(
    'footer_widget_separator',
    array(
        'type'        => 'epsilon-separator',
        'label'       => esc_html__( 'Footer Widget Section', 'medico' ),
        'section'     => 'medico_footer_section',

    )
);

// Footer widget toggle field
Epsilon_Customizer::add_field(
    'medico_footer_widget_toggle',
    array(
        'type'        => 'epsilon-toggle',
        'label'       => esc_html__( 'Footer widget show/hide', 'medico' ),
        'description' => esc_html__( 'Toggle to display footer widgets.', 'medico' ),
        'section'     => 'medico_footer_section',
        'default'     => true,
    )
);

// Footer Copyright section
Epsilon_Customizer::add_field(
    'medico_footer_copyright_separator',
    array(
        'type'        => 'epsilon-separator',
        'label'       => esc_html__( 'Footer Copyright Section', 'medico' ),
        'section'     => 'medico_footer_section',
        'default'     => true,

    )
);

// Footer copyright text field
// Copy right text
$url = 'https://colorlib.com/';
$copyText = sprintf( __( 'Theme by %s colorlib %s Copyright &copy; %s  |  All rights reserved.', 'medico' ), '<a target="_blank" href="' . esc_url( $url ) . '">', '</a>', date( 'Y' ) );
Epsilon_Customizer::add_field(
    'medico_footer_copyright_text',
    array(
        'type'        => 'epsilon-text-editor',
        'label'       => esc_html__( 'Footer copyright text', 'medico' ),
        'section'     => 'medico_footer_section',
        'default'     => wp_kses_post( $copyText ),
    )
);

// Footer widget background color field
Epsilon_Customizer::add_field(
    'medico_footer_bg_color',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( 'Footer Background Color', 'medico' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'medico_footer_section',
        'default'     => '#f3f6f7',
    )
);

// Footer widget background color field
Epsilon_Customizer::add_field(
    'medico_footer_bottom_bg_color',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( 'Footer Bottom Background Color', 'medico' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'medico_footer_section',
        'default'     => '#0d1820',
    )
);

// Footer widget text color field
Epsilon_Customizer::add_field(
    'medico_footer_widget_text_color',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( 'Footer Text Color', 'medico' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'medico_footer_section',
        'default'     => '#7f7f7f',
    )
);

// Footer widget title color field
Epsilon_Customizer::add_field(
    'medico_footer_widget_title_color',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( 'Footer Widget Title Color', 'medico' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'medico_footer_section',
        'default'     => '#242429',
    )
);

// Footer widget anchor color field
Epsilon_Customizer::add_field(
    'medico_footer_widget_anchor_color',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( 'Footer Anchor Color', 'medico' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'medico_footer_section',
        'default'     => '#7f7f7f',
    )
);

// Footer widget anchor hover color field
Epsilon_Customizer::add_field(
    'medico_footer_widget_anchor_hover_color',
    array(
        'type'        => 'epsilon-color-picker',
        'label'       => esc_html__( 'Footer Anchor Hover Color', 'medico' ),
        'sanitize_callback' => 'sanitize_text_field',
        'section'     => 'medico_footer_section',
        'default'     => '#0065e1',
    )
);


Epsilon_Customizer::add_field(
    'social_pro_separator',
    array(
        'type'        => 'epsilon-separator',
        'label'       => esc_html__( 'Social Profile', 'medico' ),
        'section'     => 'medico_footer_section',

    )
);

// Social Profile Show/Hide
Epsilon_Customizer::add_field(
    'medico_social_profile_toggle',
    array(
        'type'        => 'epsilon-toggle',
        'label'       => esc_html__( 'Social Profile Show/Hide', 'medico' ),
        'section'     => 'medico_footer_section',
        'default'     => true,
    )
);

//Social Profile links
Epsilon_Customizer::add_field(
	'medico_footer_social',
	array(
		'type'         => 'epsilon-repeater',
		'section'      => 'medico_footer_section',
		'label'        => esc_html__( 'Social Profile Links', 'medico' ),
		'button_label' => esc_html__( 'Add new social link', 'medico' ),
		'row_label'    => array(
			'type'  => 'field',
			'field' => 'social_link_title',
		),
		'fields'       => array(
			'social_link_title'       => array(
				'label'             => esc_html__( 'Title', 'medico' ),
				'type'              => 'text',
				'sanitize_callback' => 'wp_kses_post',
				'default'           => 'Twitter',
			),
			'social_url' => array(
				'label'             => esc_html__( 'Social URL', 'medico' ),
				'type'              => 'text',
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => 'https://twitter.com',
			),
			'social_icon'        => array(
				'label'   => esc_html__( 'Icon', 'medico' ),
				'type'    => 'epsilon-icon-picker',
				'default' => 'fa fa-twitter',
			),
			
		),
	)
);


