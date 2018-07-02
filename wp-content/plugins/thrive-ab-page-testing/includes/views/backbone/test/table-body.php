<?php
/**
 * Created by PhpStorm.
 * User: Ovidiu
 * Date: 12/14/2017
 * Time: 12:56 PM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden
}
?>
<div class="thrive-ab-test-items"></div>
<div class="thrive-ab-test-footer">
	<p><span></span><?php echo __( 'Changes occurred while a test is running can sometimes invalidate the test results.', Thrive_AB::T ); ?></p>
	<span id="thrive-ab-auto-win-text"></span>
	<button class="tvd-btn-flat tvd-btn-flat-primary tvd-btn-flat-blue tvd-waves-effect tvd-blue-text click" data-fn="change_automatic_winner_settings"><?php echo __( 'Change', Thrive_AB::T ) ?></button>
</div>
<div class="thrive-ab-test-stopped-items"></div>
