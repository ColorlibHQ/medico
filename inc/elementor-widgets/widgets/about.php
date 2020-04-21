<?php
namespace Medicoelementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;



// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 * Medico elementor section widget.
 *
 * @since 1.0
 */
class Medico_About extends Widget_Base {

	public function get_name() {
		return 'medico-about';
	}

	public function get_title() {
		return __( 'About', 'medico' );
	}

	public function get_icon() {
		return 'eicon-thumbnails-half';
	}

	public function get_categories() {
		return [ 'medico-elements' ];
	}

	protected function _register_controls() {

        
		// ----------------------------------------  About content ------------------------------
		$this->start_controls_section(
			'about_content',
			[
				'label' => __( 'About Section', 'medico' ),
			]
        );
        $this->add_control(
			'img_left',
			[
				'label'         => esc_html__( 'Image Left', 'medico' ),
                'type'          => Controls_Manager::MEDIA,
                'default'       => [
                    'url'       => Utils::get_placeholder_image_src(),
                ]
			]
		);
        $this->add_control(
            'sec_title',
            [
                'label'         => esc_html__( 'Section Title', 'medico' ),
                'description'   => esc_html__('Use <br> tag for line break', 'medico'),
                'type'          => Controls_Manager::WYSIWYG,
                'label_block'   => true,
                'default'       => __( '<h2>About us</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua Quis ipsum suspendisse ultrices gravida. Risus cmodo viverra maecenas accumsan lacus vel</p>', 'medico' )
            ]
        );

        $this->add_control(
            'abt_btn_label',
            [
                'label'         => esc_html__( 'Button Label', 'medico' ),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => true,
                'default'       => esc_html__( 'learn more', 'medico' )
            ]
        );
        $this->add_control(
            'abt_btn_url',
            [
                'label'         => esc_html__( 'Button Url', 'medico' ),
                'type'          => Controls_Manager::URL,
                'show_external' => false
            ]
        );
        
        $this->end_controls_section(); // End about content
        
        // ----------------------------------------   Icons ------------------------------
        $this->start_controls_section(
            'rep_icons_block',
            [
                'label' => __( 'Icons', 'medico' ),
            ]
        );
        $this->add_control(
            'all_icons', [
                'label' => __( 'Create New', 'medico' ),
                'type'  => Controls_Manager::REPEATER,
                'title_field' => '{{{ icon_title }}}',
                'fields' => [
                    [
                        'name'  => 'icon',
                        'label' => __( 'Select Icon', 'medico' ),
                        'type'  => Controls_Manager::ICON,
                        'default' => 'fa fa-500px',
                        'label_block' => true,
                        'options' => medico_themify_icon()
                    ],
                    [
                        'name'  => 'icon_title',
                        'label' => __( 'Feature Title', 'medico' ),
                        'type'  => Controls_Manager::TEXT,
                        'label_block' => true,
                        'default' => __( 'Emergency', 'medico' )
                    ],
                ],
            ]
        );

        $this->end_controls_section(); // Icon section content

        // Color Settings ==============================
        $this->start_controls_section(
            'color_sect', [
                'label' => __( 'Color Settings', 'medico' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
			'title_color', [
				'label'     => __( 'Title Color', 'medico' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .about_us .about_us_text h2' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'sec_txt_color', [
				'label'     => __( 'Text Color', 'medico' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .about_us .about_us_text p' => 'color: {{VALUE}};',
				],
			]
		);
        $this->end_controls_section();


        // Button Style ==============================
        $this->start_controls_section(
            'btn_styles', [
                'label' => __( 'Button Styles', 'medico' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'btnn_bg', [
                'label'     => __( 'Button Background', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .about_us .about_us_text .btn_2' => 'background: {{VALUE}};',
                ],
            ]
        );  
        $this->add_control(
            'btnn_txt_color', [
                'label' => __( 'Button Text Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .about_us .about_us_text .btn_2' => 'color: {{VALUE}};',
                ],
            ]
        ); 

        $this->add_control(
            'btn_hvr_separator',
            [
                'label'     => __( 'Hover Styles', 'medico' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        ); 

        $this->add_control(
            'btnn_hover_bg', [
                'label'     => __( 'Button Hover Background', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .about_us .about_us_text .btn_2:hover' => 'background: {{VALUE}};',
                ],
            ]
        );  
        $this->add_control(
            'btnn_hover_txt_color', [
                'label' => __( 'Button Hover Text Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .about_us .about_us_text .btn_2:hover' => 'color: {{VALUE}};',
                ],
            ]
        ); 
        $this->end_controls_section();


        // Icon Style ==============================
        $this->start_controls_section(
            'icon_styles_sec', [
                'label' => __( 'Icon Styles', 'medico' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'icon_color', [
                'label'     => __( 'Icon Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .banner_item .single_item .eci' => 'color: {{VALUE}};',
                ],
            ]
        );  
        $this->add_control(
            'icon_txt_color', [
                'label'     => __( 'Icon Text Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .banner_item .single_item h5' => 'color: {{VALUE}};',
                ],
            ]
        );  
        $this->add_control(
            'icon_sec_sep_color', [
                'label'     => __( 'Icon Section Separator Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .banner_item .single_item:after' => 'background-color: {{VALUE}};',
                ],
            ]
        );  

        $this->end_controls_section();


        /**
         * Style Tab
         * ------------------------------ Background Style ------------------------------
         *
         */
        $this->start_controls_section(
            'section_bg', [
                'label' => __( 'Style Background', 'medico' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'section_bgheading',
            [
                'label'     => __( 'Background Settings', 'medico' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'sectionbg',
                'label' => __( 'Background', 'medico' ),
                'types' => [ 'classic' ],
                'selector' => '{{WRAPPER}} .about_us',
            ]
        );

        $this->end_controls_section();


	}

	protected function render() {
        $settings     = $this->get_settings();
        $sec_title    = !empty( $settings['sec_title'] ) ? $settings['sec_title'] : '';
        $left_img  = !empty( $settings['img_left']['id'] ) ? wp_get_attachment_image( $settings['img_left']['id'], 'medico_about_section_533x531', false, array( 'alt' => 'about image left' ) ) : '';
        
        $abt_btn_label    = !empty( $settings['abt_btn_label'] ) ? $settings['abt_btn_label'] : '';		
        $abt_btn_url    = !empty( $settings['abt_btn_url']['url'] ) ? $settings['abt_btn_url']['url'] : '';	
        $all_icons    = !empty( $settings['all_icons'] ) ? $settings['all_icons'] : '';			
        $dynamic_class = is_front_page() ? 'about_us padding_top' : 'about_us single_about_padding';
        ?>

        <!-- about us part start-->
        <section class="<?php echo esc_attr( $dynamic_class )?>">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-6 col-lg-6">
                        <div class="about_us_img">
                            <?php
                                //Left image ==============
                                if( $left_img ){
                                    echo wp_kses_post( $left_img );
                                }
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-5">
                        <div class="about_us_text">
                            <?php
                                //Content ==============
                                if( $sec_title ){
                                    echo wp_kses_post( wpautop( $sec_title ) );
                                }

                                // Button =============
                                if( $abt_btn_label ){
                                    echo '<a class="btn_2" href="'. esc_url( $abt_btn_url ) .'">'. esc_html( $abt_btn_label ) .'</a>';
                                }
                            ?>
                            <div class="banner_item">
                                <?php
                                if( is_array( $all_icons ) && count( $all_icons ) > 0 ){
                                    foreach ( $all_icons as $item ) {
                                        $icon       = !empty( $item['icon'] ) ? $item['icon'] : '';
                                        $icon_title = !empty( $item['icon_title'] ) ? $item['icon_title'] : '';
                                        ?>
                                        <div class="single_item">
                                            <?php echo '<i class="'. $icon .'"></i>'; ?>
                                            <h5><?php echo esc_html( $icon_title )?></h5>
                                        </div>
                                        <?php
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- about us part end-->
        <?php
    }
}
