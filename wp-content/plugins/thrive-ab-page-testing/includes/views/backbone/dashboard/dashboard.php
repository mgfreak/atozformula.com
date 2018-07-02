<?php
/**
 * Created by PhpStorm.
 * User: Ovidiu
 * Date: 11/27/2017
 * Time: 9:46 AM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden
}
global $post;
?>
<div id="thrive-ab-top-bar" class="tvd-row">
	<div class="tvd-col tvd-s2 thrive-ab-logo">
		<a href="<?php echo tcb_get_editor_url( $post ) ?>"><span><?php echo __( 'Thrive', Thrive_AB::T ) ?></span> <?php echo __( 'Architect', Thrive_AB::T ) ?>
			<div class="tvd-icon-chevron-left"></div>
		</a>
	</div>
	<div class="tvd-col tvd-s10 thrive-ab-settings">
		<a href="<?php echo get_edit_post_link( $post->ID, '' ) ?>">
			<div class="tvd-icon-cog"></div>
			<span><?php echo __( 'Page Settings', Thrive_AB::T ) ?></span>
		</a>
		<a href="javascript:void(0)" id="thrive-ab-start-test" class="click" data-fn="start_test">
			<div class="tvd-icon-eye"></div>
			<span><?php echo $post->post_status === 'publish' ? __( 'Set Up & Start A/B Test', Thrive_AB::T ) : __( 'Set Up & Start A/B Test', Thrive_AB::T ) ?></span>
		</a>
	</div>
</div>
<div class="clearfix">
	<div class="thrive-ab-heading">
		<h1><?php echo __( 'Variations', Thrive_AB::T ) ?></h1>
		<button class="tvd-waves-effect tvd-waves-light tvd-btn tvd-btn-blue click" data-fn="add_new_variation"><?php echo __( 'Add new', Thrive_AB::T ) ?></button>
		<p><?php echo __( 'You can duplicate an existing variation or create a new one from scratch. You can later edit the created variations, even though the test is running.', Thrive_AB::T ) ?></p>
		<a id="thrive-ab-eq-traffic" class="tvd-btn-flat tvd-btn-flat-primary tvd-btn-flat-dark click" data-fn="equalize_traffic" href="javascript:void(0)">
			<span><?php echo __( 'Distribute traffic evenly', Thrive_AB::T ) ?></span>
		</a>
	</div>
	<div class="tvd-row thrive-ab-card-list" id="thrive-ab-card-list">
		<div class="tvd-col tvd-l3 tvd-m6 click" data-fn="add_new_variation">
			<div class="tvd-card tvd-small tvd-card-new tvd-valign-wrapper">
				<div class="tvd-card-content tvd-valign tvd-center-align">
					<i class="tvd-icon-plus tvd-icon-rounded tvd-icon-medium"></i>
					<h4>
						<?php echo __( 'Add new variation', Thrive_AB::T ) ?>
					</h4>
				</div>
			</div>
		</div>
	</div>
	<div class="thrive-ab-heading thrive-ab-display-archived-container">
		<a class="click thrive-ab-display-archived" data-fn="display_archived" href="javascript:void(0)">
			<span><?php echo __( 'Archived Variations', Thrive_AB::T ) ?></span>
			<span class="tar-arrow"></span>
		</a>
		<p>
			<?php echo __( 'You can un archive a variation in order to reuse it in your test.', Thrive_AB::T ) ?>
		</p>
	</div>
	<div class="tvd-row thrive-ab-card-list" id="thrive-ab-card-list-archived" style="display:none;">
	</div>
</div>
