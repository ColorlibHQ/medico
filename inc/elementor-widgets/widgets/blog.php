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
 * Medico elementor few words section widget.
 *
 * @since 1.0
 */

class Medico_Blog extends Widget_Base {

	public function get_name() {
		return 'medico-blog';
	}

	public function get_title() {
		return __( 'Our Blog', 'medico' );
	}

	public function get_icon() {
		return 'eicon-post-list';
	}

	public function get_categories() {
		return [ 'medico-elements' ];
	}

	protected function _register_controls() {

        // Section Heading
        $this->start_controls_section(
            'section_heading',
            [
                'label' => __( 'Section Heading', 'medico' ),
            ]
        );

        $this->add_control(
            'sec_heading',
            [
                'label'         => esc_html__( 'Heading Text', 'medico' ),
                'type'          => Controls_Manager::TEXTAREA,
                'default'       => __( 'Our Blog', 'medico' )
            ]
        );
        $this->end_controls_section(); 


        // Blog post settings
        $this->start_controls_section(
            'blog_post_sec',
            [
                'label' => __( 'Blog Post Settings', 'medico' ),
            ]
        );
		$this->add_control(
			'post_num',
			[
				'label'         => esc_html__( 'Post Item', 'medico' ),
				'type'          => Controls_Manager::NUMBER,
				'label_block'   => false,
                'default'       => absint(2),
                'min'           => 2,
                'step'          => 2,
                'max'           => 4,
			]
		);
		$this->add_control(
			'post_order',
			[
				'label'         => esc_html__( 'Post Order', 'medico' ),
				'type'          => Controls_Manager::SWITCHER,
				'label_block'   => false,
				'label_on'      => 'ASC',
				'label_off'     => 'DESC',
                'default'       => 'yes',
                'options'       => [
                    'no'        => 'ASC',
                    'yes'       => 'DESC'
                ]
			]
		);

        $this->end_controls_section(); // End few words content

        //------------------------------ Style Section ------------------------------
        $this->start_controls_section(
            'style_section', [
                'label' => __( 'Style Section Heading', 'medico' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'color_secttitle', [
                'label'     => __( 'Section Title Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blog_part .section_tittle h2' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'blog_style_sep', [
                'label'     => __( 'Blog Styles', 'medico' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'after'
            ]
        );
        $this->add_control(
            'blog_title_color', [
                'label'     => __( 'Blog Title Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blog_part .single-home-blog .card h5' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'blog_meta_color', [
                'label'     => __( 'Blog Meta Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blog_part .single-home-blog .card ul li' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'blog_hvr_style_sep', [
                'label'     => __( 'Blog Hover Styles', 'medico' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'after'
            ]
        );

        $this->add_control(
            'blog_title_hvr_color', [
                'label'     => __( 'Blog Title Hover Color', 'medico' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blog_part .single-home-blog .card h5:hover' => 'color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .blog_part',
            ]
        );

        $this->end_controls_section();
	}

	protected function render() {

    $settings  = $this->get_settings();
    $sec_heading = !empty( $settings['sec_heading'] ) ? $settings['sec_heading'] : '';
    $post_num   = !empty( $settings['post_num'] ) ? $settings['post_num'] : '';
    $post_order = !empty( $settings['post_order'] ) ? $settings['post_order'] : '';
    $post_order = $post_order == 'yes' ? 'DESC' : 'ASC';
    ?>

    <!--::blog_part start::-->
    <section class="blog_part section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="section_tittle text-center">
                        <h2><?php echo esc_html( $sec_heading )?></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                    if( function_exists( 'medico_latest_blog' ) ) {
                        medico_latest_blog( $post_num, $post_order );
                    }
                ?>
            </div>
        </div>
    </section>
    <!--::blog_part end::-->
    <?php
	}
}
