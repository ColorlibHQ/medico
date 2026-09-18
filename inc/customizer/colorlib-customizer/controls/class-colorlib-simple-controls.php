<?php
/**
 * The Customizer controls WordPress has no equivalent for, minus the two
 * complicated ones (icon picker and repeater), which live in their own files.
 *
 * Each renders with render_content() rather than a JS template: none of them
 * needs to re-render on the client, and PHP rendering keeps the markup where
 * it can be read.
 *
 * @package Colorlib
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Colorlib_Control_Separator' ) ) {

	/**
	 * A labelled rule, used to group fields inside a section.
	 *
	 * Stores nothing anyone reads; it exists to break up long sections.
	 */
	class Colorlib_Control_Separator extends WP_Customize_Control {

		/**
		 * @var string
		 */
		public $type = 'colorlib-separator';

		/**
		 * Render.
		 */
		public function render_content() {
			?>
			<div class="colorlib-separator">
				<?php if ( ! empty( $this->label ) ) : ?>
					<span class="colorlib-separator__label"><?php echo esc_html( $this->label ); ?></span>
				<?php endif; ?>
				<?php if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
				<?php endif; ?>
				<hr />
			</div>
			<?php
		}
	}
}

if ( ! class_exists( 'Colorlib_Control_Toggle' ) ) {

	/**
	 * An on/off switch.
	 *
	 * It is a checkbox underneath, so it stays keyboard accessible and the
	 * stored value is the boolean the themes already test.
	 */
	class Colorlib_Control_Toggle extends WP_Customize_Control {

		/**
		 * @var string
		 */
		public $type = 'colorlib-toggle';

		/**
		 * Render.
		 */
		public function render_content() {
			$id = '_customize-input-' . $this->id;
			?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
			<?php endif; ?>
			<label class="colorlib-toggle" for="<?php echo esc_attr( $id ); ?>">
				<input
					type="checkbox"
					id="<?php echo esc_attr( $id ); ?>"
					class="colorlib-toggle__input"
					value="1"
					<?php $this->link(); ?>
					<?php checked( (bool) $this->value() ); ?>
				/>
				<span class="colorlib-toggle__track" aria-hidden="true"></span>
			</label>
			<?php
		}
	}
}

if ( ! class_exists( 'Colorlib_Control_Text_Editor' ) ) {

	/**
	 * A multi-line HTML field.
	 *
	 * Epsilon rendered a bare textarea here too, so this is parity rather than
	 * a downgrade; the value is filtered with wp_kses_post.
	 */
	class Colorlib_Control_Text_Editor extends WP_Customize_Control {

		/**
		 * @var string
		 */
		public $type = 'colorlib-text-editor';

		/**
		 * Render.
		 */
		public function render_content() {
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
				<?php endif; ?>
				<textarea rows="6" class="widefat colorlib-text-editor" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			</label>
			<?php
		}
	}
}

if ( ! class_exists( 'Colorlib_Control_Slider' ) ) {

	/**
	 * A number with a range slider beside it.
	 *
	 * Both inputs drive the same setting; the number field is what carries the
	 * value, so the control still works if the range input is unsupported.
	 */
	class Colorlib_Control_Slider extends WP_Customize_Control {

		/**
		 * @var string
		 */
		public $type = 'colorlib-slider';

		/**
		 * Min, max and step, overridable per field via input_attrs.
		 *
		 * @var array
		 */
		public $choices = array();

		/**
		 * Render.
		 */
		public function render_content() {
			$attrs = wp_parse_args(
				$this->input_attrs,
				array(
					'min'  => isset( $this->choices['min'] ) ? $this->choices['min'] : 0,
					'max'  => isset( $this->choices['max'] ) ? $this->choices['max'] : 100,
					'step' => isset( $this->choices['step'] ) ? $this->choices['step'] : 1,
				)
			);
			?>
			<label class="colorlib-slider">
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
				<?php endif; ?>
				<span class="colorlib-slider__row">
					<input
						type="range"
						class="colorlib-slider__range"
						min="<?php echo esc_attr( $attrs['min'] ); ?>"
						max="<?php echo esc_attr( $attrs['max'] ); ?>"
						step="<?php echo esc_attr( $attrs['step'] ); ?>"
						value="<?php echo esc_attr( $this->value() ); ?>"
					/>
					<input
						type="number"
						class="colorlib-slider__number"
						min="<?php echo esc_attr( $attrs['min'] ); ?>"
						max="<?php echo esc_attr( $attrs['max'] ); ?>"
						step="<?php echo esc_attr( $attrs['step'] ); ?>"
						value="<?php echo esc_attr( $this->value() ); ?>"
						<?php $this->link(); ?>
					/>
				</span>
			</label>
			<?php
		}
	}
}

if ( ! class_exists( 'Colorlib_Control_Layouts' ) ) {

	/**
	 * Pick how many columns a region has, by picture.
	 *
	 * The stored value keeps the shape the themes read:
	 * array( 'columnsCount' => n, 'columns' => array( i => array( 'index', 'span' ) ) )
	 * Footers read columnsCount; Bonkers also reads each column's bootstrap span.
	 */
	class Colorlib_Control_Layouts extends WP_Customize_Control {

		/**
		 * @var string
		 */
		public $type = 'colorlib-layouts';

		/**
		 * Column count => preview image URL.
		 *
		 * @var array
		 */
		public $layouts = array();

		/**
		 * The currently stored column count.
		 *
		 * @return int
		 */
		private function current_count() {
			$value = $this->value();

			if ( ! is_array( $value ) ) {
				$decoded = json_decode( $value, true );
				$value   = is_array( $decoded ) ? $decoded : array();
			}

			return isset( $value['columnsCount'] ) ? (int) $value['columnsCount'] : 0;
		}

		/**
		 * Render.
		 */
		public function render_content() {
			if ( empty( $this->layouts ) ) {
				return;
			}

			$current = $this->current_count();
			$name    = '_customize-layouts-' . $this->id;
			?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
			<?php endif; ?>

			<input type="hidden" class="colorlib-layouts__value" <?php $this->link(); ?> />

			<div class="colorlib-layouts">
				<?php foreach ( $this->layouts as $count => $image ) : ?>
					<label class="colorlib-layouts__choice<?php echo ( (int) $count === $current ) ? ' is-selected' : ''; ?>">
						<input
							type="radio"
							name="<?php echo esc_attr( $name ); ?>"
							class="colorlib-layouts__radio"
							value="<?php echo esc_attr( $count ); ?>"
							<?php checked( (int) $count, $current ); ?>
						/>
						<img src="<?php echo esc_url( $image ); ?>" alt="<?php
							/* translators: %s: number of columns. */
							echo esc_attr( sprintf( _n( '%s column', '%s columns', (int) $count, 'colorlib' ), number_format_i18n( (int) $count ) ) );
						?>" />
					</label>
				<?php endforeach; ?>
			</div>
			<?php
		}
	}
}
