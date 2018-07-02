<?php
/**
 * Thrive Themes - https://thrivethemes.com
 *
 * @package thrive-ab-page-testing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden
}

?>
<a id="thrive-ab-create-test" href="<?php echo $this->get_dashboard_url(); ?>" <?php if ( ! thrive_ab()->license_activated() ) : ?>class="tvd-tooltipped" data-tooltip="<?php echo __( 'Click here to activate Thrive Optimize before creating a new A/B test.', Thrive_AB::T ); ?>"<?php endif; ?>>
	<?php echo __( 'Create new a/b test', Thrive_AB::T ) ?>
	<span>
		<svg id="icon-add" viewBox="0 0 32 32">
		  <path d="M17.6 25.6v-8h8v-3.2h-8v-8h-3.2v8h-8v3.2h8v8h3.2z"></path>
		</svg>
	</span>
</a>
