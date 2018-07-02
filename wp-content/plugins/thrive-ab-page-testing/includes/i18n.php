<?php
/**
 * Thrive Themes - https://thrivethemes.com
 *
 * @package thrive-ab-page-testing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden
}

return array(
	'control'                          => __( 'Control', Thrive_AB::T ),
	'variation_added'                  => __( 'Variation Added', Thrive_AB::T ),
	'delete_title'                     => __( 'Yes, delete', Thrive_AB::T ),
	'archive_title'                    => __( 'Yes, archive', Thrive_AB::T ),
	'cancel'                           => __( 'Cancel', Thrive_AB::T ),
	'stop'                             => __( 'Stop', Thrive_AB::T ),
	'keep_it_running'                  => __( 'Keep It Running', Thrive_AB::T ),
	'add_variation_error'              => __( 'Error adding new variation', Thrive_AB::T ),
	'variation_no'                     => __( 'Variation %s', Thrive_AB::T ),
	'about_to_delete'                  => __( 'You are about to delete %s. Do you want to continue?', Thrive_AB::T ),
	'about_to_archive'                 => __( 'You are about to archive %s. Do you want to continue?', Thrive_AB::T ),
	'about_to_stop_variation'          => __( 'Are you sure you want to stop showing the variation: "%s"', Thrive_AB::T ),
	'invalid_test_title'               => __( 'Invalid test title', Thrive_AB::T ),
	'invalid_min_win_conversions'      => __( 'Invalid minimum conversions', Thrive_AB::T ),
	'not_number_min_win_conversions'   => __( 'Minimum conversions is not number', Thrive_AB::T ),
	'greater_zero_min_win_conversions' => __( 'Minimum conversions must be greater than zero', Thrive_AB::T ),
	'invalid_auto_win_min_duration'    => __( 'Minimum duration invalid', Thrive_AB::T ),
	'invalid_auto_win_chance_original' => __( 'Chance to beat original invalid', Thrive_AB::T ),
	'variation_status_not_changed'     => __( 'Variation status could not be changed', Thrive_AB::T ),
	'variation_winner'                 => __( '<b>%s</b> was declared as being the winner for the current test.', Thrive_AB::T ),
	'choose_winner'                    => __( 'Choose winner variation', Thrive_AB::T ),
	'automatic_winner_settings'        => __( 'Automatic winner settings', Thrive_AB::T ),
	'auto_win_enabled'                 => __( 'Automatic winner settings enabled.', Thrive_AB::T ),
	'auto_win_disabled'                => __( 'Automatic winner settings disabled.', Thrive_AB::T ),
	'delete_variation'                 => __( 'Delete variation', Thrive_AB::T ),
	'archive_variation'                => __( 'Archive variation', Thrive_AB::T ),
);
