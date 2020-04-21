<?php
namespace Medicoelementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Utils;
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
 * Medico elementor Team Member section widget.
 *
 * @since 1.0
 */
class Medico_Services extends Widget_Base {

	public function get_name() {
		return 'medico-services';
	}

	public function get_title() {
		return __( 'Services', 'medico' );
	}

	public function get_icon() {
		return 'eicon-info-box';
	}

	public function get_categories() {
		return [ 'medico-elements' ];
	}

	protected function _register_controls() {
        
		// ----------------------------------------   Services content ------------------------------
		$this->start_controls_section(
			'services_block',
			[
				'label' => __( 'Services', 'medico' ),
			]
        );
        
		$this->add_control(
            'sec_title', [
                'label' => __( 'Section Title', 'medico' ),
                'type'  => Controls_Manager::TEXT,
                'default' => __( 'Our services', 'medico' ),
            ]
        );
        
		$this->add_control(
			'circle_img',
			[
				'label'         => esc_html__( 'Circle Image', 'medico' ),
                'type'          => Controls_Manager::MEDIA,
                'default'       => [
                    'url'       => Utils::get_placeholder_image_src(),
                ]
			]
		);

		$this->add_control(
            'services_content', [
                'label' => __( 'Create Service', 'medico' ),
                'type'  => Controls_Manager::REPEATER,
                'title_field' => '{{{ label }}}',
                'fields' => [
                    [
                        'name'        => 'icon',
                        'label'       => __( 'Select Icon', 'medico' ),
                        'default'     => 'fa fa-500px',
                        'type'        => Controls_Manager::ICON,
                        'label_block' => true,
                        'options'     => medico_themify_icon(),
                    ],
                    [
                        'name'  => 'label',
                        'label' => __( 'Title', 'medico' ),
                        'type'  => Controls_Manager::TEXT,
                        'label_block' => true,
                        'default' => __( 'Better Future', 'medico' )
                    ],
                    [
                        'name'      => 'desc',
                        'label'     => __( 'Descriptions', 'medico' ),
                        'type'      => Controls_Manager::TEXTAREA,
                        'default'   => __( 'Darkness multiply rule Which from without life creature blessed give moveth moveth seas make day which divided our have.', 'medico' )
                    ],
                ],
            ]
        );

		$this->end_controls_section(); // End Services content

        /**
         * Style Tab
         * ------------------------------ Style Tab Content ------------------------------
         *
         */

        // Section title color
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
					'{{WRAPPER}} .feature_part .section_tittle h2' => 'color: {{VALUE}};',
				],
			]
		);
        $this->end_controls_section();

        // Single Service Color Settings ==============================
        $this->start_controls_section(
            'single_serv_color_sett', [
                'label' => __( 'Single Service Color Settings', 'medico' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
 
        $this->add_control(
            'icon_bg_color', [
                'label'     => __( 'Icon BG Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .feature_part .single_feature_part span' => 'background-color: {{VALUE}};',
                ],
            ]
        ); 
 
        $this->add_control(
            'icon_color', [
                'label'     => __( 'Icon Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .feature_part .single_feature_part span i' => 'color: {{VALUE}};',
                ],
            ]
        ); 

        $this->add_control(
            'item_title_color', [
                'label'     => __( 'Item Title Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .feature_part .single_feature_part h4' => 'color: {{VALUE}};',
                ],
            ]
        ); 

        $this->add_control(
            'item_text_color', [
                'label'     => __( 'Item Text Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .feature_part .single_feature_part p' => 'color: {{VALUE}};',
                ],
            ]
        ); 

        $this->end_controls_section();

    }

	protected function render() {

    $settings  = $this->get_settings();
    $sec_title = !empty( $settings['sec_title'] ) ? $settings['sec_title'] : '';
    $circle_img = !empty( $settings['circle_img']['id'] ) ? wp_get_attachment_image( $settings['circle_img']['id'], 'medico_services_section_425x425', false, ['alt' => 'Service circle image'] ) : '';
    $services  = !empty( $settings['services_content'] ) ? $settings['services_content'] : '';
    $dynamic_class = is_front_page() ? 'feature_part' : 'feature_part single_feature_page';

    function medico_single_service_function( $fontIcon, $service_title, $service_desc ){?>
        <div class="single_feature">
            <div class="single_feature_part">
                <?php echo '<span class="single_feature_icon"><i class="'. $fontIcon .'"></i></span>'; ?>
                <h4><?php echo esc_html( $service_title );?></h4>
                <p><?php echo esc_html( $service_desc );?></p>
            </div>
        </div>
        <?php
    }

    function medico_circle_img_function( $circle_img ){?>
        <div class="col-lg-4 col-sm-12">
            <div class="single_feature_img">
                <?php echo wp_kses_post( $circle_img )?>
            </div>
        </div>
        <?php
    }
    ?>

    <!-- feature_part start-->
    <section class="<?php echo esc_attr( $dynamic_class )?>">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="section_tittle text-center">
                        <h2><?php echo esc_html( $sec_title );?></h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between align-items-center">
                <?php
                if( is_array( $services ) && count( $services ) > 0 ){
                    $count = 0;
                    foreach ( $services as $service ) {
                        $fontIcon      = !empty( $service['icon'] ) ? $service['icon'] : '';
                        $service_title = !empty( $service['label'] ) ? $service['label'] : '';
                        $service_desc  = !empty( $service['desc'] ) ? $service['desc'] : '';
                        $count++;

                        if ( $count == 1 ) {
                            echo '<div class="col-lg-3 col-sm-12">';
                                medico_single_service_function( $fontIcon, $service_title, $service_desc );
                        } elseif ( $count == 2 ) {
                                medico_single_service_function( $fontIcon, $service_title, $service_desc );
                            echo '</div>';
                        } elseif ( $count == 3 ) {
                            medico_circle_img_function( $circle_img );
                            echo '<div class="col-lg-3 col-sm-12">';
                                medico_single_service_function( $fontIcon, $service_title, $service_desc );
                        } elseif ( $count == 4 ) {
                                medico_single_service_function( $fontIcon, $service_title, $service_desc );
                            echo '</div>';
                        }
                    }
                }
                ?>
            </div>
        </div>
    </section>
    <!-- feature_part start-->
    <?php
    }
}
