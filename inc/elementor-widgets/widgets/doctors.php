<?php
namespace Medicoelementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
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
 * Medico elementor Doctors section widget.
 *
 * @since 1.0
 */
class Medico_Doctors extends Widget_Base {

	public function get_name() {
		return 'medico-doctors';
	}

	public function get_title() {
		return __( 'Doctors', 'medico' );
	}

	public function get_icon() {
		return 'eicon-person';
	}

	public function get_categories() {
		return [ 'medico-elements' ];
	}

	protected function _register_controls() {

        // ----------------------------------------  Doctors Section ------------------------------
        $this->start_controls_section(
            'doc_heading',
            [
                'label' => __( 'Doctors Heading', 'medico' ),
            ]
        );
        $this->add_control(
            'doc_header',
            [
                'label'         => esc_html__( 'Section Header', 'medico' ),
                'description'   => esc_html__('Use <br> tag for line break', 'medico'),
                'type'          => Controls_Manager::WYSIWYG,
                'label_block'   => true,
                'default'       => __( '<h2>Experienced Doctors</h2><p>Face replenish sea good winged bearing years air divide wasHave night male also</p>', 'medico' )
            ]
        );

        $this->end_controls_section(); // End section top content
        
		// ----------------------------------------   Doctorss content ------------------------------
		$this->start_controls_section(
			'docs_block',
			[
				'label' => __( 'Doctors', 'medico' ),
			]
		);
		$this->add_control(
            'docs_content', [
                'label' => __( 'Create a Doctor', 'medico' ),
                'type'  => Controls_Manager::REPEATER,
                'title_field' => '{{{ doc_name }}}',
                'fields' => [
                    [
                        'name'  => 'image',
                        'label' => __( 'Doctor Image', 'medico' ),
                        'type'  => Controls_Manager::MEDIA,
                    ],
                    [
                        'name'  => 'doc_name',
                        'label' => __( 'Name', 'medico' ),
                        'type'  => Controls_Manager::TEXT,
                        'label_block' => true,
                        'default' => __( 'DR Adam Billiard', 'medico' )
                    ],
                    [
                        'name'      => 'desg',
                        'label'     => __( 'Designation', 'medico' ),
                        'type'      => Controls_Manager::TEXT,
                        'default'   => __( 'Heart specialist', 'medico' )
                    ],
                    [
                        'name'      => 'fb',
                        'label'     => __( 'Facebook URL', 'medico' ),
                        'type'      => Controls_Manager::URL,
                        'show_external' => false,
                        'default'   => [
                            'url'   => '#',
                        ]
                    ],
                    [
                        'name'      => 'tw',
                        'label'     => __( 'Twitter URL', 'medico' ),
                        'type'      => Controls_Manager::URL,
                        'show_external' => false,
                        'default'   => [
                            'url'   => '#',
                        ]
                    ],
                    [
                        'name'      => 'ins',
                        'label'     => __( 'Instagram URL', 'medico' ),
                        'type'      => Controls_Manager::URL,
                        'show_external' => false,
                        'default'   => [
                            'url'   => '#',
                        ]
                    ],
                    [
                        'name'      => 'skype',
                        'label'     => __( 'Skype URL', 'medico' ),
                        'type'      => Controls_Manager::URL,
                        'show_external' => false,
                        'default'   => [
                            'url'   => '#',
                        ]
                    ],
                ],
            ]
        );

		$this->end_controls_section(); // End Doctorss content

        /**
         * Style Tab
         * ------------------------------ Style Tab Content ------------------------------
         *
         */

        // Heading Style ==============================
        $this->start_controls_section(
            'color_sect', [
                'label' => __( 'Style Doctors Heading', 'medico' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'color_secttitle', [
                'label'     => __( 'Section Title Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .doctor_part .section_tittle h2' => 'color: {{VALUE}};',
                ],
            ]
        );    
        $this->add_control(
            'color_sec_sub_txt', [
                'label'     => __( 'Section Sub Title Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .doctor_part .section_tittle p' => 'color: {{VALUE}};',
                ],
            ]
        );    
        
        $this->end_controls_section();


        // Single Item Style ==============================
        $this->start_controls_section(
            'single_item_style', [
                'label' => __( 'Single Item Style', 'medico' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'doc_name_col', [
                'label'     => __( 'Doctor Name Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .doctor_part .single_blog_item h3' => 'color: {{VALUE}};',
                ],
            ]
        );   

        $this->add_control(
            'doc_des_col', [
                'label'     => __( 'Doctor Designation Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .doctor_part .single_blog_item p' => 'color: {{VALUE}};',
                ],
            ]
        );  

        $this->add_control(
            'doc_soc_col', [
                'label'     => __( 'Social Icon Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .doctor_part .single_blog_item .single_blog_img .social_icon a' => 'color: {{VALUE}};',
                ],
            ]
        );  

        $this->add_control(
            'section_separator',
            [
                'label'     => __( 'Hover styles', 'medico' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        ); 

        $this->add_control(
            'hov_doc_name_col', [
                'label'     => __( 'On Hover Doctor Name Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .doctor_part .single_blog_item:hover h3' => 'color: {{VALUE}}!important;',
                ],
            ]
        );   

        $this->add_control(
            'hov_doc_des_col', [
                'label'     => __( 'On Hover Doctor Designation Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .doctor_part .single_blog_item:hover p' => 'color: {{VALUE}};',
                ],
            ]
        );  

        $this->add_control(
            'soc_icon_hvr_color', [
                'label'     => __( 'Social Icon Hover Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .doctor_part .single_blog_item .single_blog_img .social_icon a:hover' => 'color: {{VALUE}}!important;',
                ],
            ]
        );  

        $this->add_control(
            'soc_icon_exp_bg', [
                'label'     => __( 'Social Icon Holder BG Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .doctor_part .single_blog_item .single_blog_img .social_icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );  

        $this->end_controls_section();


        // Background Style ==============================
        $this->start_controls_section(
            'section_bg', [
                'label' => __( 'Style Background', 'medico' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'sectionbg',
                'label' => __( 'Background', 'medico' ),
                'types' => [ 'classic' ],
                'selector' => '{{WRAPPER}} .doctor_part',
            ]
        );

        $this->end_controls_section();


	}

	protected function render() {

    $settings = $this->get_settings();
    $doc_header = !empty( $settings['doc_header'] ) ? $settings['doc_header'] : '';
    $doctors = !empty( $settings['docs_content'] ) ? $settings['docs_content'] : '';
    $dynamic_class = is_front_page() ? 'doctor_part section_padding' : 'doctor_part single_page_doctor_part';
    ?>

    <!--::doctor_part start::-->
    <section class="<?php echo esc_attr( $dynamic_class )?>">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="section_tittle text-center">
                        <?php
                            // Doctors Header =============
                            if( $doc_header ){
                                echo wp_kses_post( wpautop( $doc_header ) );
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                if( is_array( $doctors ) && count( $doctors ) > 0 ){
                    foreach ( $doctors as $doctor ) {
                        $doc_img   = !empty( $doctor['image']['id'] ) ? wp_get_attachment_image( $doctor['image']['id'], 'medico_doctors_section_263x339', false, array( 'alt' => $doctor['doc_name'] ) ) : '';
                        $name       = !empty( $doctor['doc_name'] ) ? $doctor['doc_name'] : '';
                        $desig      = !empty( $doctor['desg'] ) ? $doctor['desg'] : '';
                        $fb         = !empty( $doctor['fb']['url'] ) ? $doctor['fb']['url'] : '';
                        $tw         = !empty( $doctor['tw']['url'] ) ? $doctor['tw']['url'] : '';
                        $ins        = !empty( $doctor['ins']['url'] ) ? $doctor['ins']['url'] : '';
                        $skype      = !empty( $doctor['skype']['url'] ) ? $doctor['skype']['url'] : '';
                        ?>
                        <div class="col-sm-6 col-lg-3">
                            <div class="single_blog_item">
                                <div class="single_blog_img">
                                    <?php
                                        if( $doc_img ){
                                            echo wp_kses_post( $doc_img );
                                        }
                                    ?>
                                    <div class="social_icon">
                                        <ul>
                                            <li><a href="<?php echo esc_url( $fb );?>"> <i class="ti-facebook"></i> </a></li>
                                            <li><a href="<?php echo esc_url( $tw );?>"> <i class="ti-twitter-alt"></i> </a></li>
                                            <li><a href="<?php echo esc_url( $ins );?>"> <i class="ti-instagram"></i> </a></li>
                                            <li><a href="<?php echo esc_url( $skype );?>"> <i class="ti-skype"></i> </a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="single_text">
                                    <div class="single_blog_text">
                                        <h3><?php echo esc_html( $name );?></h3>
                                        <p><?php echo esc_html( $desig );?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </section>
    <!--::doctor_part end::-->
    <?php
    }
}
