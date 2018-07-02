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
		<div class="tvd-col tvd-s2"><?php echo __( 'Name', Thrive_AB::T ) ?></div>
		<div class="tvd-col tvd-s1"><?php echo __( 'Visitors', Thrive_AB::T ) ?></div>
		<div class="tvd-col tvd-s1"><?php echo __( 'Unique Visitors', Thrive_AB::T ) ?></div>
		<div class="tvd-col tvd-s1"><?php echo __( 'Conversions', Thrive_AB::T ) ?></div>
		<div class="tvd-col tvd-s1"><?php echo __( 'Conversion Rate', Thrive_AB::T ) ?></div>
		<div class="tvd-col tvd-s2"><?php echo __( 'Improvement', Thrive_AB::T ) ?></div>
		<div class="tvd-col tvd-s2"><?php echo __( 'Chance to beat Original', Thrive_AB::T ) ?></div>
		<div class="tvd-col tvd-s2">&nbsp;</div>
	</div>
</div>
<div class="thrive-ab-test-items"></div>
