<?php
/**
 * An icon class picker.
 *
 * The stored value is the icon's CSS class, exactly as the themes print it
 * ("fa-brands fa-twitter", "ti-home"). A text input holds that value, so any class
 * keeps working — including icon sets this picker does not list. The grid
 * below it is a shortcut, not a constraint.
 *
 * @package Colorlib
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Colorlib_Control_Icon_Picker' ) ) {

	/**
	 * Class Colorlib_Control_Icon_Picker
	 */
	class Colorlib_Control_Icon_Picker extends WP_Customize_Control {

		/**
		 * @var string
		 */
		public $type = 'colorlib-icon-picker';

		/**
		 * Icon classes to offer. Defaults to the set below when the theme
		 * does not pass its own.
		 *
		 * @var array
		 */
		public $icons = array();

		/**
		 * The icons offered by default.
		 *
		 * Font Awesome 4 classes, which is what these themes load. Kept to the
		 * ones a site actually picks — social, contact and common UI — rather
		 * than the full set, which would be thousands of DOM nodes per control.
		 *
		 * @return array
		 */
		public static function default_icons() {
			$icons = array(
				// Social.
				'facebook', 'facebook-f', 'facebook-square', 'twitter', 'twitter-square',
				'instagram', 'linkedin', 'linkedin-square', 'youtube', 'youtube-play',
				'pinterest', 'pinterest-p', 'dribbble', 'behance', 'tumblr', 'vimeo',
				'skype', 'whatsapp', 'telegram', 'snapchat', 'reddit', 'github',
				'google-plus', 'flickr', 'vk', 'rss', '500px', 'medium',
				// Contact.
				'envelope', 'envelope-o', 'phone', 'mobile', 'fax', 'map-marker',
				'location-arrow', 'globe', 'clock-o', 'calendar', 'paper-plane',
				// Commerce.
				'shopping-cart', 'shopping-bag', 'shopping-basket', 'credit-card',
				'tag', 'tags', 'gift', 'truck', 'percent',
				// Common UI.
				'home', 'user', 'users', 'star', 'star-o', 'heart', 'heart-o',
				'check', 'check-circle', 'times', 'search', 'cog', 'cogs',
				'lock', 'unlock', 'camera', 'image', 'play', 'play-circle',
				'download', 'upload', 'print', 'share-alt', 'comment', 'comments',
				'quote-left', 'quote-right', 'thumbs-up', 'trophy', 'bolt',
				'lightbulb-o', 'leaf', 'book', 'graduation-cap', 'briefcase',
				'building', 'wrench', 'paint-brush', 'pencil', 'pencil-square-o',
				'line-chart', 'bar-chart', 'pie-chart', 'desktop', 'laptop',
				'tablet', 'code', 'database', 'cloud', 'shield', 'life-ring',
				'child', 'male', 'female', 'car', 'plane', 'bicycle', 'coffee',
				'cutlery', 'music', 'headphones', 'film', 'trash', 'folder',
				'file', 'files-o', 'link', 'external-link', 'info-circle',
				'question-circle', 'exclamation-triangle', 'bell', 'flag',
			);

			$classes = array();
			foreach ( $icons as $icon ) {
				$classes[] = 'fa fa-' . $icon;
			}

			return $classes;
		}

		/**
		 * Render.
		 */
		public function render_content() {
			$icons = ! empty( $this->icons ) ? $this->icons : self::default_icons();
			$value = (string) $this->value();
			?>
			<div class="colorlib-icon-picker">
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
				<?php endif; ?>

				<div class="colorlib-icon-picker__current">
					<i class="colorlib-icon-picker__preview <?php echo esc_attr( $value ); ?>" aria-hidden="true"></i>
					<input
						type="text"
						class="colorlib-icon-picker__input widefat"
						value="<?php echo esc_attr( $value ); ?>"
						placeholder="fa-brands fa-twitter"
						<?php $this->link(); ?>
					/>
				</div>

				<input
					type="search"
					class="colorlib-icon-picker__search widefat"
					placeholder="<?php esc_attr_e( 'Search icons', 'colorlib' ); ?>"
					aria-label="<?php esc_attr_e( 'Search icons', 'colorlib' ); ?>"
				/>

				<div class="colorlib-icon-picker__grid">
					<?php foreach ( $icons as $icon ) : ?>
						<button
							type="button"
							class="colorlib-icon-picker__icon<?php echo ( $icon === $value ) ? ' is-selected' : ''; ?>"
							data-icon="<?php echo esc_attr( $icon ); ?>"
							title="<?php echo esc_attr( $icon ); ?>"
						>
							<i class="<?php echo esc_attr( $icon ); ?>" aria-hidden="true"></i>
						</button>
					<?php endforeach; ?>
				</div>
			</div>
			<?php
		}
	}
}
