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
<div class="thrive-ab-adv-settings">
	<div class="tvd-row">
		<div class="tvd-col tvd-s12 thrive-ab-no-padding">
			<?php echo __( 'Select one or more pages from your website, on which the user will land, and write the corresponding value of that conversion for your business. You can also create a new page and edit later.', Thrive_AB::T ) ?>
		</div>
	</div>
	<div id="item-forms" class="tvd-row tvd-collapse"></div>
	<div class="tvd-row tvd-collapse">
		<div class="tvd-col tvd-s12">
			<div class="tvd-card tvd-small tvd-card-new thrive-ab-add-new-goal tvd-valign-wrapper">
				<div class="tvd-card-content tvd-valign tvd-center-align">
					<i class="tvd-icon-plus tvd-icon-rounded tvd-icon-medium"></i>
					<h4>
						<?php echo __( 'Add new thank you page', Thrive_AB::T ) ?>
					</h4>
				</div>
			</div>
		</div>
	</div>
</div>
