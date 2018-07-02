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
		<div class="tvd-col tvd-s2"><?php echo __( 'Traffic', Thrive_AB::T ) ?></div>
		<div class="tvd-col tvd-s1"><?php echo __( 'Visitors', Thrive_AB::T ) ?></div>
		<div class="tvd-col tvd-s1"><?php echo __( 'Unique Visitors', Thrive_AB::T ) ?></div>
		<div class="tvd-col tvd-s1"><?php echo __( 'Sales', Thrive_AB::T ) ?></div>
		<div class="tvd-col tvd-s1"><?php echo __( 'Revenue', Thrive_AB::T ) ?></div>
		<div class="tvd-col tvd-s1"><?php echo __( 'Revenue per Visitor', Thrive_AB::T ) ?></div>
		<div class="tvd-col tvd-s1"><?php echo __( 'Conversion Rate', Thrive_AB::T ) ?></div>
		<div class="tvd-col tvd-s1"><?php echo __( 'Improvement', Thrive_AB::T ) ?></div>
		<div class="tvd-col tvd-s1"><?php echo __( 'Chance to beat Original', Thrive_AB::T ) ?></div>
	</div>
</div>
<?php include dirname( __FILE__ ) . '/table-body.php'; ?>
