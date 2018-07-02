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
<div class="thrive-ab-test-header">
	<div class="tvd-row">
		<div class="tvd-col tvd-s2"><?php echo __( 'Variation Name', Thrive_AB::T ) ?></div>
		<div class="tvd-col tvd-s1"><?php echo __( 'Content Views', Thrive_AB::T ) ?></div>
		<div class="tvd-col tvd-s1"><?php echo __( 'Engagements', Thrive_AB::T ) ?></div>
		<div class="tvd-col tvd-s2"><?php echo __( 'Engagement Rate', Thrive_AB::T ) ?></div>
		<div class="tvd-col tvd-s2"><?php echo __( 'Percentage Improvement', Thrive_AB::T ) ?></div>
		<div class="tvd-col tvd-s2"><?php echo __( 'Chance to beat Original', Thrive_AB::T ) ?></div>
		<div class="tvd-col tvd-s2">&nbsp;</div>
	</div>
</div>
<div class="thrive-ab-test-items"></div>
