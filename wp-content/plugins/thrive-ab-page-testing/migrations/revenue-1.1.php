<?php
/**
 * Thrive Themes - https://thrivethemes.com
 *
 * @package thrive-ab-page-testing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden
}

$installer = new TD_DB_Migration( 'tab' );

$edit_event_log = "	ALTER TABLE {$installer->get_table_name( 'event_log' )}
	ADD `revenue` DECIMAL(10,2 ) NOT NULL DEFAULT '0' AFTER `event_type`,
	ADD `goal_page` BIGINT(20) NULL DEFAULT NULL AFTER `revenue`";

$edit_test = " ALTER TABLE {$installer->get_table_name( 'tests' )} ADD `goal_pages` LONGTEXT NULL DEFAULT NULL ";

$installer->add( $edit_event_log, false );
$installer->add( $edit_test, false );

return $installer;
