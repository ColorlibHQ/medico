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
class Medico_Departments extends Widget_Base {

	public function get_name() {
		return 'medico-departments';
	}

	public function get_title() {
		return __( 'Departments', 'medico' );
	}

	public function get_icon() {
		return 'eicon-posts-group';
	}

	public function get_categories() {
		return [ 'medico-elements' ];
	}

	protected function _register_controls() {

        
		// ----------------------------------------  Departments content ------------------------------
		$this->start_controls_section(
			'departments_content',
			[
				'label' => __( 'Departments Settings', 'medico' ),
			]
		);
        $this->add_control(
            'sec_title',
            [
                'label'         => esc_html__( 'Section Title', 'medico' ),
                'type'          => Controls_Manager::TEXTAREA,
                'default'       => __( 'Our Department', 'medico' )
            ]
        );

        $this->add_control(
            'all_departments', [
                'label' => __( 'Create New', 'medico' ),
                'type'  => Controls_Manager::REPEATER,
                'title_field' => '{{{ dep_title }}}',
                'fields' => [
                    [
                        'name'  => 'dep_icon',
                        'label' => __( 'Select Icon', 'medico' ),
                        'type'  => Controls_Manager::ICON,
                        'default' => 'fa fa-500px',
                        'label_block' => true,
                        'options' => medico_themify_icon()
                    ],
                    [
                        'name'  => 'dep_title',
                        'label' => __( 'Item Title', 'medico' ),
                        'type'  => Controls_Manager::TEXT,
                        'label_block' => true,
                        'default' => __( 'Better Future', 'medico' )
                    ],
                    [
                        'name'  => 'dep_txt',
                        'label' => __( 'Department Text', 'medico' ),
                        'type'  => Controls_Manager::TEXTAREA,
                        'label_block' => true,
                        'default' => __( 'Darkness multiply rule Which from without life creature blessed give moveth moveth seas make day which divided our have.', 'medico' )
                    ],
                ],
            ]
        );
        
        $this->end_controls_section(); // End department content
        

        // Color Settings ==============================
        $this->start_controls_section(
            'color_sect', [
                'label' => __( 'Color Settings', 'medico' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
			'sec_title_color', [
				'label'     => __( 'Section Title Color', 'medico' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .our_depertment .depertment_content h2' => 'color: {{VALUE}};',
				],
			]
		);
        $this->end_controls_section();


        // Single Department Color Settings ==============================
        $this->start_controls_section(
            'single_dep_color_sett', [
                'label' => __( 'Single Department Color Settings', 'medico' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'sing_dep_border_color', [
                'label'     => __( 'Singel Item Border Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .our_depertment .single_our_depertment' => 'border-color: {{VALUE}};',
                ],
            ]
        );   

        $this->add_control(
            'icon_bg_color', [
                'label'     => __( 'Icon BG Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .our_depertment .single_our_depertment .our_depertment_icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );   

        $this->add_control(
            'icon_item_color', [
                'label'     => __( 'Icon Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .our_depertment .single_our_depertment .our_depertment_icon i' => 'color: {{VALUE}};',
                ],
            ]
        );   

        $this->add_control(
            'inner_styles_sep',
            [
                'label'     => __( 'Inner Color Settings', 'medico' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'item_title_color', [
                'label'     => __( 'Title Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .our_depertment .single_our_depertment h4' => 'color: {{VALUE}};',
                ],
            ]
        );   

        $this->add_control(
            'item_text_color', [
                'label'     => __( 'Text Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .our_depertment .single_our_depertment p' => 'color: {{VALUE}};',
                ],
            ]
        );   

        $this->add_control(
            'item_hov_style_sep',
            [
                'label'     => __( 'Hover Color Settings', 'medico' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'item_hvr_bg_color', [
                'label'     => __( 'Item Hover BG Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .our_depertment .single_our_depertment:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );   

        $this->add_control(
            'item_hov_title_color', [
                'label'     => __( 'Item Hover Title Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .our_depertment .single_our_depertment:hover h4' => 'color: {{VALUE}};',
                ],
            ]
        );   

        $this->add_control(
            'item_hov_txt_color', [
                'label'     => __( 'Item Hover Text Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .our_depertment .single_our_depertment:hover p' => 'color: {{VALUE}};',
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
                'separator' => 'after',
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'sectionbg',
                'label' => __( 'Background', 'medico' ),
                'types' => [ 'classic' ],
                'selector' => '{{WRAPPER}} .our_depertment',
            ]
        );

        $this->add_control(
            'overlay_color_sett_sep',
            [
                'label'     => __( 'Overlay Color Settings', 'medico' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'overlay_color_sett', [
                'label'     => __( 'Overlay Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .our_depertment:after' => 'background-color: {{VALUE}};',
                ],
            ]
        ); 

        $this->end_controls_section();


	}

	protected function render() {
        $settings        = $this->get_settings();
        $sec_title   = !empty( $settings['sec_title'] ) ? $settings['sec_title'] : '';
        $all_departments    = !empty( $settings['all_departments'] ) ? $settings['all_departments'] : '';
        $dynamic_class = is_front_page() || is_page( 'about-us' ) ? 'our_depertment section_padding' : 'our_depertment section_padding single_pepertment_page';
        ?>

        <!-- our depertment part start-->
        <section class="<?php echo esc_attr( $dynamic_class )?>">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-xl-12">
                        <div class="depertment_content">
                            <div class="row justify-content-center">
                                <div class="col-xl-8">
                                    <h2><?php echo esc_html( $sec_title );?></h2>
                                    <div class="row">
                                        <?php
                                        if( is_array( $all_departments ) && count( $all_departments ) > 0 ){
                                            foreach ( $all_departments as $item ) {
                                                $icon       = !empty( $item['dep_icon'] ) ? $item['dep_icon'] : '';
                                                $dep_title  = !empty( $item['dep_title'] ) ? $item['dep_title'] : '';
                                                $dep_txt    = !empty( $item['dep_txt'] ) ? $item['dep_txt'] : '';
                                            ?>
                                            <div class="col-lg-6 col-sm-6">
                                                <div class="single_our_depertment">
                                                    <span class="our_depertment_icon"><?php echo '<i class="'. $icon .'"></i>'; ?></span>        
                                                    <h4><?php echo esc_html( $dep_title );?></h4>
                                                    <p><?php echo esc_html( $dep_txt );?></p>
                                                </div>
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
                </div>
            </div>
        </section>
        <!-- our depertment part end-->
    <?php

    }

}
