<?php
/**
 * Custom heading for customizer.
 *
 * @package Greentech
 */

if ( class_exists( 'WP_Customize_Control' ) ) {
	/**
	 * Add custom heading for each part in section.
	 */
	class Greentech_Custom_Heading extends WP_Customize_Control {
		/**
		 * Control's type.
		 *
		 * @var string
		 */
		public $type = 'info';

		/**
		 * Label for the control.
		 *
		 * @var string
		 */
		public $label = '';

		/**
		 * Render the control's content.
		 */
		public function render_content() {
		?>
		<h3 style="margin-top: 3em; padding-bottom: .3em; border-bottom: 1px solid #ddd; text-transform: uppercase; color: #555d66;"><?php echo esc_html( $this->label ); ?></h3>
		<?php
		}
	}
}
