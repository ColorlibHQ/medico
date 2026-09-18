<?php
/**
 * A small Customizer API, replacing the Epsilon framework.
 *
 * The themes call Colorlib_Customizer::add_field( $id, $args ) once per
 * option. This registers the setting and the control in one step, picking a
 * sanitiser from the field type when the theme does not name one.
 *
 * Everything WordPress already does well uses a core control; only the seven
 * controls core has no equivalent for are our own. Setting IDs, stored value
 * shapes and sanitiser behaviour match what Epsilon wrote, so options saved
 * before the switch keep working and the front end needs no changes.
 *
 * @package Colorlib
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Colorlib_Customizer' ) ) {

	/**
	 * Class Colorlib_Customizer
	 */
	class Colorlib_Customizer {

		/**
		 * The Customizer manager, captured on customize_register.
		 *
		 * @var WP_Customize_Manager|null
		 */
		public static $manager = null;

		/**
		 * Field type => control class.
		 *
		 * Anything not listed is handed to WP_Customize_Control, which renders
		 * text, textarea, checkbox, radio, select, number, url, email, range
		 * and dropdown-pages natively.
		 *
		 * @return array
		 */
		public static function controls() {
			return array(
				'colorlib-color-picker' => 'WP_Customize_Color_Control',
				'colorlib-image'        => 'WP_Customize_Image_Control',
				'colorlib-upload'       => 'WP_Customize_Upload_Control',
				'colorlib-separator'    => 'Colorlib_Control_Separator',
				'colorlib-toggle'       => 'Colorlib_Control_Toggle',
				'colorlib-text-editor'  => 'Colorlib_Control_Text_Editor',
				'colorlib-slider'       => 'Colorlib_Control_Slider',
				'colorlib-layouts'      => 'Colorlib_Control_Layouts',
				'colorlib-icon-picker'  => 'Colorlib_Control_Icon_Picker',
				'colorlib-repeater'     => 'Colorlib_Control_Repeater',
				'image'                 => 'WP_Customize_Image_Control',
				'upload'                => 'WP_Customize_Upload_Control',
				'cropped_image'         => 'WP_Customize_Cropped_Image_Control',
			);
		}

		/**
		 * Normalise a field type.
		 *
		 * The themes were written against Epsilon, and child themes in the wild
		 * still pass the old names, so epsilon-* is accepted as an alias for
		 * colorlib-*.
		 *
		 * @param string $type Field type.
		 * @return string
		 */
		public static function normalize_type( $type ) {
			$type = (string) $type;

			if ( 0 === strpos( $type, 'epsilon-' ) ) {
				$type = 'colorlib-' . substr( $type, 8 );
			}

			// Epsilon's section repeater was the page-builder variant of the
			// same control; the themes we ship only need the plain one.
			if ( 'colorlib-section-repeater' === $type ) {
				$type = 'colorlib-repeater';
			}

			return $type;
		}

		/**
		 * The sanitiser for a field type, when the theme does not name one.
		 *
		 * @param string $type Field type.
		 * @return string|array|null
		 */
		public static function sanitizer( $type ) {
			switch ( $type ) {
				case 'url':
					return 'esc_url_raw';
				case 'email':
					return 'sanitize_email';
				case 'textarea':
					return 'sanitize_textarea_field';
				case 'colorlib-text-editor':
					return 'wp_kses_post';
				case 'checkbox':
				case 'colorlib-toggle':
					return array( __CLASS__, 'sanitize_checkbox' );
				case 'number':
				case 'range':
				case 'colorlib-slider':
					return array( __CLASS__, 'sanitize_number' );
				case 'colorlib-color-picker':
					return array( __CLASS__, 'sanitize_color' );
				case 'colorlib-layouts':
					return array( __CLASS__, 'sanitize_layouts' );
				case 'image':
				case 'colorlib-image':
				case 'upload':
				case 'colorlib-upload':
					return 'esc_url_raw';
				case 'colorlib-separator':
					// Renders nothing and stores nothing meaningful.
					return array( __CLASS__, 'sanitize_checkbox' );
				default:
					return 'sanitize_text_field';
			}
		}

		/**
		 * Capture the manager. Hooked early so the themes' own
		 * customize_register callbacks can call add_field() straight away.
		 *
		 * @param WP_Customize_Manager $manager Manager.
		 */
		public static function set_manager( $manager ) {
			if ( is_a( $manager, 'WP_Customize_Manager' ) ) {
				self::$manager = $manager;
			}
		}

		/**
		 * Kept because two themes call it; the manager is captured on the hook.
		 *
		 * @param WP_Customize_Manager|array $manager Manager.
		 * @return Colorlib_Customizer|null
		 */
		public static function get_instance( $manager = array() ) {
			self::set_manager( $manager );

			return null;
		}

		/**
		 * The manager, falling back to the global if the hook has not run.
		 *
		 * @return WP_Customize_Manager|null
		 */
		private static function manager() {
			if ( is_a( self::$manager, 'WP_Customize_Manager' ) ) {
				return self::$manager;
			}

			global $wp_customize;

			return is_a( $wp_customize, 'WP_Customize_Manager' ) ? $wp_customize : null;
		}

		/**
		 * Register a setting and its control.
		 *
		 * @param string $id   Setting ID. Kept verbatim: stored options depend on it.
		 * @param array  $args Field arguments.
		 */
		public static function add_field( $id, array $args = array() ) {
			$manager = self::manager();
			if ( null === $manager ) {
				return;
			}

			$type          = self::normalize_type( isset( $args['type'] ) ? $args['type'] : 'text' );
			$args['type']  = $type;
			$controls      = self::controls();
			$control_class = isset( $controls[ $type ] ) ? $controls[ $type ] : 'WP_Customize_Control';

			/**
			 * Setting.
			 */
			$setting_args = array(
				'default'           => isset( $args['default'] ) ? $args['default'] : '',
				'type'              => isset( $args['setting_type'] ) ? $args['setting_type'] : 'theme_mod',
				'capability'        => isset( $args['capability'] ) ? $args['capability'] : 'edit_theme_options',
				'transport'         => isset( $args['transport'] ) ? $args['transport'] : 'refresh',
				'sanitize_callback' => isset( $args['sanitize_callback'] ) ? $args['sanitize_callback'] : self::sanitizer( $type ),
			);

			if ( 'colorlib-repeater' === $type ) {
				// The repeater sanitises itself: its value is a list of rows,
				// not a scalar, and the decode has to happen before saving.
				unset( $setting_args['sanitize_callback'] );
				$manager->add_setting( new Colorlib_Setting_Repeater( $manager, $id, $setting_args ) );
			} else {
				$manager->add_setting( $id, $setting_args );
			}

			/**
			 * Control. Core's controls do not understand our type names, so the
			 * ones backed by a core class get a type core recognises.
			 */
			if ( 'WP_Customize_Color_Control' === $control_class ) {
				unset( $args['type'] );
			} elseif ( 'WP_Customize_Image_Control' === $control_class || 'WP_Customize_Upload_Control' === $control_class ) {
				unset( $args['type'] );
			} elseif ( 'WP_Customize_Cropped_Image_Control' === $control_class ) {
				unset( $args['type'] );
			}

			$args['settings'] = isset( $args['settings'] ) ? $args['settings'] : $id;

			$manager->add_control( new $control_class( $manager, $id, $args ) );
		}

		/**
		 * Register a section.
		 *
		 * @param string $id   Section ID.
		 * @param array  $args Section arguments.
		 */
		public static function add_section( $id, array $args = array() ) {
			$manager = self::manager();
			if ( null === $manager ) {
				return;
			}

			// Epsilon shipped decorative section types; core renders a plain one.
			unset( $args['type'] );

			$manager->add_section( $id, $args );
		}

		/**
		 * Register a panel.
		 *
		 * @param string $id   Panel ID.
		 * @param array  $args Panel arguments.
		 */
		public static function add_panel( $id, array $args = array() ) {
			$manager = self::manager();
			if ( null === $manager ) {
				return;
			}

			unset( $args['type'] );

			$manager->add_panel( $id, $args );
		}

		/**
		 * Register panels, sections and fields from one array.
		 *
		 * @param array $collection Keyed by element type: panel, section, field.
		 */
		public static function add_multiple( array $collection = array() ) {
			foreach ( $collection as $type => $items ) {
				$method = 'add_' . $type;

				if ( ! is_array( $items ) || ! method_exists( __CLASS__, $method ) ) {
					continue;
				}

				foreach ( $items as $item ) {
					if ( ! isset( $item['id'] ) ) {
						continue;
					}

					$args = isset( $item['args'] ) && is_array( $item['args'] ) ? $item['args'] : array();

					call_user_func( array( __CLASS__, $method ), $item['id'], $args );
				}
			}
		}

		/**
		 * Sanitisers.
		 *
		 * checkbox() matches what Epsilon stored: a real boolean, so themes
		 * testing the value with a bare if() behave as they did.
		 *
		 * @param mixed $value Raw value.
		 * @return bool
		 */
		public static function sanitize_checkbox( $value ) {
			return ( true === $value || 'true' === $value || 1 === $value || '1' === $value || 'on' === $value );
		}

		/**
		 * @param mixed $value Raw value.
		 * @return int|float
		 */
		public static function sanitize_number( $value ) {
			return is_numeric( $value ) ? $value + 0 : 0;
		}

		/**
		 * A column layout, as array( 'columnsCount' => n, 'columns' => … ).
		 *
		 * Epsilon stored this as a JSON string and the themes decode whatever
		 * they find, so both a string and an array are accepted; an array is
		 * returned because that is the branch every theme tries first.
		 *
		 * @param mixed $value Raw value.
		 * @return array
		 */
		public static function sanitize_layouts( $value ) {
			if ( ! is_array( $value ) ) {
				$decoded = json_decode( (string) $value, true );
				$value   = is_array( $decoded ) ? $decoded : array();
			}

			if ( empty( $value['columnsCount'] ) ) {
				return array();
			}

			$count   = max( 1, (int) $value['columnsCount'] );
			$columns = array();

			for ( $i = 1; $i <= $count; $i++ ) {
				$span = isset( $value['columns'][ $i ]['span'] ) ? (int) $value['columns'][ $i ]['span'] : (int) floor( 12 / $count );

				$columns[ $i ] = array(
					'index' => $i,
					'span'  => max( 1, $span ),
				);
			}

			return array(
				'columnsCount' => $count,
				'columns'      => $columns,
			);
		}

		/**
		 * Accepts hex and rgba, since the themes store both.
		 *
		 * @param mixed $value Raw value.
		 * @return string
		 */
		public static function sanitize_color( $value ) {
			$value = is_string( $value ) ? trim( $value ) : '';

			if ( '' === $value ) {
				return '';
			}

			if ( 0 === strpos( $value, 'rgba' ) || 0 === strpos( $value, 'rgb' ) ) {
				return preg_replace( '/[^rgba0-9,.\(\)% ]/', '', $value );
			}

			$hex = sanitize_hex_color( $value );

			return null === $hex ? '' : $hex;
		}
	}
}
