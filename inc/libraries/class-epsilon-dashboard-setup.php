<?php
/**
 * Medico Dashboard
 *
 * @package Medico
 * @since   1.0
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

class Epsilon_Dashboard_Setup {

	/**
	 * Theme array
	 *
	 * @var array
	 */
	public $theme = array();
	/**
	 * Notice layout
	 *
	 * @var string
	 */
	private $notice = '';

	/**
	 * Epsilon_Dashboard_Setup constructor.
	 *
	 * @param array $theme
	 */
	public function __construct( $theme = array() ) {

		$this->theme = $theme;

		$theme = wp_get_theme();
		$arr   = array(
			'theme-name'    => $theme->get( 'Name' ),
			'theme-slug'    => $theme->get( 'TextDomain' ),
			'theme-version' => $theme->get( 'Version' ),
		);

		$this->theme = wp_parse_args( $this->theme, $arr );
	}

	/**
	 * @param array $theme
	 *
	 * @return Epsilon_Dashboard_Setup
	 */
	public static function get_instance( $theme = array() ) {
		static $inst;
		if ( ! $inst ) {
			$inst = new Epsilon_Dashboard_Setup( $theme );
		}

		return $inst;
	}

	/**
	 * Adds an admin notice in the backend
	 *
	 * If the Epsilon Notification class does not exist, we stop
	 */
	public function add_admin_notice() {
		if ( ! class_exists( 'Epsilon_Notifications' ) ) {
			return;
		}

		if ( ! empty( $_GET ) && isset( $_GET['page'] ) && 'epsilon-onboarding' === $_GET['page'] ) {
			return;
		}

		$used_onboarding = get_theme_mod( $this->theme['theme-slug'] . '_used_onboarding', false );
		if ( $used_onboarding ) {
			return;
		}

		$imported_demo = Epsilon_Init_Notify_System::check_installed_data();
		if ( $imported_demo ) {
			return;
		}

		if ( empty( $this->notice ) ) {
			$this->notice .= '<img src="' . esc_url( get_template_directory_uri() ) . '/inc/libraries/epsilon-theme-dashboard/assets/images/colorlib-logo-dark.png" class="epsilon-author-logo" />';


			/* Translators: Notice Title */
			$this->notice .= '<h1>' . sprintf( esc_html__( 'Welcome to %1$s', 'medico' ), $this->theme['theme-name'] ) . '</h1>';
			$this->notice .= '<p>';
			$this->notice .= sprintf( /* Translators: Notice */
				esc_html__( 'Welcome! Thank you for choosing %3$s! To fully take advantage of the best our theme can offer please make sure you visit our %1$swelcome page%2$s.', 'medico' ), '<a href="' . esc_url( admin_url( 'themes.php?page=' . $this->theme['theme-slug'] . '-dashboard' ) ) . '">', '</a>', $this->theme['theme-name'] );
			$this->notice .= '</p>';
			/* Translators: Notice URL */
			$this->notice .= '<p><a href="' . esc_url( admin_url( '?page=epsilon-onboarding' ) ) . '" class="button button-primary button-hero" style="text-decoration: none;"> ' . sprintf( esc_html__( 'Get started with %1$s', 'medico' ), $this->theme['theme-name'] ) . '</a></p>';
		}
		$notifications = Epsilon_Notifications::get_instance();
		$notifications->add_notice( array(
			'id'      => 'notification_testing',
			'type'    => 'notice epsilon-big',
			'message' => $this->notice,
		) );
	}

	/**
	 * Edd params
	 *
	 * @return array
	 */
	public function get_edd( $setup = array() ) {
		$options = get_option( $setup['theme']['theme-slug'] . '_license_object', array() );
		$options = wp_parse_args( $options, array(
			'expires'       => false,
			'licenseStatus' => false,
		) );

		return array(
			'license'       => trim( get_option( $setup['theme']['theme-slug'] . '_license_key', false ) ),
			'licenseOption' => $setup['theme']['theme-slug'] . '_license_key',
			'downloadId'    => '221300',
			'expires'       => $options['expires'],
			'status'        => $options['licenseStatus'],
		);
	}

	/**
	 * Onboarding steps
	 *
	 * @return array
	 */
	public function get_steps() {
		$url = 'https://colorlib.com/';
		$txt = sprintf( __( 'Your new theme has been all set up. Enjoy your new theme by %s Colorlib %s.', 'medico' ), '<a href="'.esc_url( $url ).'">', '</a>' );
		return array(
			array(
				'id'       => 'landing',
				'title'    => __( 'Welcome to Medico', 'medico' ),
				'content'  => array(
					'paragraphs' => array(
						__( ' This wizard will set up your theme, install plugins and import demo content. It is optional & should take less than a minute.', 'medico' ),
					),
				),
				'progress' => __( 'Getting Started', 'medico' ),
				'buttons'  => array(
					'next' => array(
						'action' => 'next',
						'label'  => __( 'Let\'s get started <span class="dashicons dashicons-arrow-right-alt2"></span>', 'medico' ),
					),
				),
			),
			array(
				'id'       => 'plugins',
				'title'    => __( 'Install Recommended Plugins', 'medico' ),
				'content'  => array(
					'paragraphs' => array(
						__( 'Medico integrates tightly with a few plugins that we recommend installing to get the full theme experience, as we\'ve intended it to be. This is an optional step, but we recommend installing them as we think these hand-picked plugins work really nice with Medico and help enhance the overall experience.', 'medico' ),
					),
				),
				'progress' => __( 'Plugins', 'medico' ),
				'buttons'  => array(
					'next' => array(
						'action' => 'next',
						'label'  => __( 'Next <span class="dashicons dashicons-arrow-right-alt2"></span>', 'medico' ),
					),
				),
			),
			array(
				'id'       => 'enjoy',
				'title'    => __( 'Almost ready', 'medico' ),
				'content'  => array(
					'paragraphs' => array(
						$txt

					),
				),
				'progress' => __( 'Finished', 'medico' ),
				'buttons'  => array(
					'next' => array(
						'action' => 'customizer',
						'label'  => __( 'Allow & Finish', 'medico' ),
					),
				),
			),
		);
	}

	/**
	 * Returns a html string
	 *
	 * @return string
	 */
	public function get_permission_content() {
		$html = '<div class="permission-request">';
		$html .= '<a href="#hidden-permissions" id="hidden-permissions-toggle"> ' . __( 'What permissions are being granted', 'medico' ) . ' <span class="dashicons dashicons-arrow-down"></span></a>';
		$html .= '<div id="hidden-permissions" >
			<ul>
				<li>
					<span class="dashicons dashicons-admin-users"></span>
					<span class="content">
						<strong>' . __( 'YOUR PROFILE OVERVIEW', 'medico' ) . '</strong>
						<small>' . __( 'Name and email address', 'medico' ) . '</small>		
					</span>
				</li>
				<li>
					<span class="dashicons dashicons-admin-settings"></span>
					<span class="content">
						<strong>' . __( 'YOUR SITE OVERVIEW', 'medico' ) . '</strong>
						<small>' . __( 'Site URL, WP Version, PHP Version, plugins and themes', 'medico' ) . '</small>		
					</span>
				</li>
				<li>
					<span class="dashicons dashicons-admin-plugins"></span>
					<span class="content">
						<strong>' . __( 'CURRENT PLUGIN EVENTS', 'medico' ) . '</strong>
						<small>' . __( 'Activation, deactivation and uninstall', 'medico' ) . '</small>		
					</span>
				</li>
			</ul>
			</div>
		</div>';

		return $html;
	}

	/**
	 * @param bool $integrated
	 *
	 * @return array
	 */
	public function get_plugins( $integrated = false ) {
		$arr = array(
			'contact-form-7' => array(
				'integration' => true,
				'recommended' => false,
			),
			'elementor' => array(
				'integration' => true,
				'recommended' => false,
			),
			'custom-icons-for-elementor' => array(
				'integration' => true,
				'recommended' => false,
			),
			'one-click-demo-import' => array(
				'integration' => true,
				'recommended' => false,
			),

		);

		if ( ! $integrated ) {
			unset( $arr['contact-form-7'] );
			unset( $arr['elementor'] );
			unset( $arr['custom-icons-for-elementor'] );
			unset( $arr['one-click-demo-import'] );
		}

		return $arr;
	}

	/**
	 * Dashboard actions
	 */
	public function get_actions() {
		if ( is_customize_preview() ) {
			return $this->_customizer_actions();
		}

		return array(
			array(
				'id'          => 'medico-check-cf7',
				'title'       => Epsilon_Init_Notify_System::plugin_verifier( 'contact-form-7', 'title', 'Contact Form 7', 'verify_cf7' ),
				'description' => Epsilon_Init_Notify_System::plugin_verifier( 'contact-form-7', 'description', 'Contact Form 7', 'verify_cf7' ),
				'plugin_slug' => 'contact-form-7',
				'state'       => false,
				'check'       => defined( 'WPCF7_VERSION' ),
				'actions'     => array(
					array(
						'label'   => Epsilon_Init_Notify_System::plugin_verifier( 'contact-form-7', 'installed', 'Contact Form 7', 'verify_cf7' ) ? __( 'Activate Plugin', 'medico' ) : __( 'Install Plugin', 'medico' ),
						'type'    => 'handle-plugin',
						'handler' => Epsilon_Init_Notify_System::plugin_verifier( 'contact-form-7', 'installed', 'Contact Form 7', 'verify_cf7' ),
					),
				),
			),
			array(
				'id'          => 'medico-check-elementor',
				'title'       => Epsilon_Init_Notify_System::plugin_verifier( 'elementor', 'title', 'Elementor' ),
				'description' => Epsilon_Init_Notify_System::plugin_verifier( 'elementor', 'description', 'Elementor' ),
				'plugin_slug' => 'elementor',
				'state'       => false,
				'check'       => defined( 'ELEMENTOR_VERSION' ),
				'actions'     => array(
					array(
						'label'   => Epsilon_Init_Notify_System::plugin_verifier( 'elementor', 'installed', 'Elementor' ) ? __( 'Activate Plugin', 'medico' ) : __( 'Install Plugin', 'medico' ),
						'type'    => 'handle-plugin',
						'handler' => Epsilon_Init_Notify_System::plugin_verifier( 'elementor', 'installed', 'Elementor' ),
					),
				),
			),
			array(
				'id'          => 'medico-check-custom-icons-for-elementor',
				'title'       => Epsilon_Init_Notify_System::plugin_verifier( 'custom-icons-for-elementor', 'title', 'Custom Icons for Elementor' ),
				'description' => Epsilon_Init_Notify_System::plugin_verifier( 'custom-icons-for-elementor', 'description', 'Custom Icons for Elementor' ),
				'plugin_slug' => 'custom-icons-for-elementor',
				'state'       => false,
				'check'       => defined( 'META_BOX_VERSION' ),
				'actions'     => array(
					array(
						'label'   => Epsilon_Init_Notify_System::plugin_verifier( 'custom-icons-for-elementor', 'installed', 'Custom Icons for Elementor' ) ? __( 'Activate Plugin', 'medico' ) : __( 'Install Plugin', 'medico' ),
						'type'    => 'handle-plugin',
						'handler' => Epsilon_Init_Notify_System::plugin_verifier( 'custom-icons-for-elementor', 'installed', 'Custom Icons for Elementor' ),
					),
				),
			),
			array(
				'id'          => 'medico-check-ocdi',
				'title'       => Epsilon_Init_Notify_System::plugin_verifier( 'one-click-demo-import', 'title', 'One Click Demo Import' ),
				'description' => Epsilon_Init_Notify_System::plugin_verifier( 'one-click-demo-import', 'description', 'One Click Demo Import' ),
				'plugin_slug' => 'one-click-demo-import',
				'state'       => false,
				'check'       => defined( 'PT_OCDI_VERSION' ),
				'actions'     => array(
					array(
						'label'   => Epsilon_Init_Notify_System::plugin_verifier( 'one-click-demo-import', 'installed', 'One Click Demo Import' ) ? __( 'Activate Plugin', 'medico' ) : __( 'Install Plugin', 'medico' ),
						'type'    => 'handle-plugin',
						'handler' => Epsilon_Init_Notify_System::plugin_verifier( 'one-click-demo-import', 'installed', 'One Click Demo Import' ),
					),
				),
			),
		);
	}

	/**
	 * Render customizer actions
	 */
	private function _customizer_actions() {
		return array(
			array(
				'id'          => 'medico-check-cf7',
				'title'       => Epsilon_Init_Notify_System::plugin_verifier( 'contact-form-7', 'title', 'Contact Form 7', 'verify_cf7' ),
				'description' => Epsilon_Init_Notify_System::plugin_verifier( 'contact-form-7', 'description', 'Contact Form 7', 'verify_cf7' ),
				'plugin_slug' => 'contact-form-7',
				'check'       => defined( 'WPCF7_VERSION' ),
			),
			array(
				'id'          => 'medico-check-elementor',
				'title'       => Epsilon_Init_Notify_System::plugin_verifier( 'elementor', 'title', 'Elementor' ),
				'description' => Epsilon_Init_Notify_System::plugin_verifier( 'elementor', 'description', 'Elementor' ),
				'plugin_slug' => 'elementor',
				'check'       => defined( 'ELEMENTOR_VERSION' ),
			),
			array(
				'id'          => 'medico-check-custom-icons-for-elementor',
				'title'       => Epsilon_Init_Notify_System::plugin_verifier( 'custom-icons-for-elementor', 'title', 'Custom Icons for Elementor' ),
				'description' => Epsilon_Init_Notify_System::plugin_verifier( 'custom-icons-for-elementor', 'description', 'Custom Icons for Elementor' ),
				'plugin_slug' => 'custom-icons-for-elementor',
				'check'       => defined( 'META_BOX_VERSION' ),
			),
			array(
				'id'          => 'medico-check-ocdi',
				'title'       => Epsilon_Init_Notify_System::plugin_verifier( 'one-click-demo-import', 'title', 'One Click Demo Import' ),
				'description' => Epsilon_Init_Notify_System::plugin_verifier( 'one-click-demo-import', 'description', 'One Click Demo Import' ),
				'plugin_slug' => 'one-click-demo-import',
				'check'       => defined( 'PT_OCDI_VERSION' ),
			),
		);
	}

	/**
	 * Welcome Screen tabs
	 *
	 * @param $setup array
	 *
	 * @return array
	 */
	public function get_tabs( $setup = array() ) {
		$theme = wp_get_theme();

		return array(
			array(
				'id'      => 'epsilon-getting-started',
				'title'   => esc_html__( 'Getting Started', 'medico' ),
				'hidden'  => false,
				'type'    => 'info',
				'content' => array(
					array(
						'title'     => esc_html__( 'Step 1 - Implement recommended actions', 'medico' ),
						'paragraph' => esc_html__( 'We compiled a list of steps for you, to take make sure the experience you will have using one of our products is very easy to follow.', 'medico' ),
						'action'    => '<a href="' . esc_url( admin_url() . '?page=epsilon-onboarding' ) . '" class="button button-primary">' . __( 'Launch wizard', 'medico' ) . '</a>',
					),
					array(
						'title'     => esc_html__( 'Step 2 - Check our documentation', 'medico' ),
						'paragraph' => esc_html__( 'Even if you are a long-time WordPress user, we still believe you should give our documentation a very quick Read.', 'medico' ),
						'action'    => '<a target="_blank" href="https://colorlib.com/">' . __( 'Full documentation', 'medico' ) . '</a>',
					),
					array(
						'title'     => esc_html__( 'Step 3 - Customize everything', 'medico' ),
						'paragraph' => esc_html__( 'Using the WordPress Customizer you can easily customize every aspect of the theme.', 'medico' ),
						'action'    => '<a target="_blank" href="' . esc_url( admin_url() . 'customize.php' ) . '" class="button button-primary">' . esc_html__( 'Go to Customizer', 'medico' ) . '</a>',
					),
				),
			),
			array(
				'id'      => 'epsilon-actions',
				'title'   => esc_html__( 'Actions', 'medico' ),
				'type'    => 'actions',
				'hidden'  => $this->theme['theme-slug'] . '_recommended_actions',
				'content' => $this->get_actions(),
			),
			array(
				'id'      => 'epsilon-privacy',
				'title'   => esc_html__( 'Privacy', 'medico' ),
				'type'    => 'option-page',
				'hidden'  => false,
				'content' => array(
					'title'      => esc_html__( 'We believe in a better and streamlined user experiences', 'medico' ),
					'paragraphs' => array(
						esc_html__( 'And as such, we\'ve made it easy for you - our user, to disable all of our theme upsells & recommendations.', 'medico' ),
						esc_html__( 'Mind you that we use these as a way to facilitate compatible product discovery - as in: plugins that enhance the
		user experience with any of our products. But, in the end, the user should always have a say in it.', 'medico' ),
						wp_kses_post( __( 'By turning any or all of the toggles below to the <span style="color: green;">ON</span> position you\'ll be able
		to hide all upsells & recommended plugin discovery sections & actions.', 'medico' ) ),
						wp_kses_post( __( '<u>We really hope</u> you\'ll enjoy using our products as much as we\'ve enjoyed building them.', 'medico' ) ),
					),
				),
				'fields'  => array(
					array(
						'id'      => $this->theme['theme-slug'] . '_recommended_actions',
						'type'    => 'epsilon-toggle',
						'value'   => true,
						'label'   => esc_html__( 'Hide Customizer Recommended Actions', 'medico' ),
						'checked' => get_option( $this->theme['theme-slug'] . '_recommended_actions', false ),
					),
				),
			),
		);
	}

	/**
	 * Return privacy options
	 *
	 * @return array
	 */
	public function get_privacy_options() {
		$arr = array(
			$this->theme['theme-slug'] . '_recommended_actions' => get_option( $this->theme['theme-slug'] . '_recommended_actions', false ),
			$this->theme['theme-slug'] . '_recommended_plugins' => get_option( $this->theme['theme-slug'] . '_recommended_plugins', false ),
			$this->theme['theme-slug'] . '_lite_vs_pro'         => get_option( $this->theme['theme-slug'] . '_lite_vs_pro', 'NA' ),
			$this->theme['theme-slug'] . '_theme_upsells'       => get_option( $this->theme['theme-slug'] . '_theme_upsells', 'NA' ),

		);

		foreach ( $arr as $id => $val ) {
			$arr[ $id ] = empty( $val ) ? false : true;
		}

		return $arr;
	}
}