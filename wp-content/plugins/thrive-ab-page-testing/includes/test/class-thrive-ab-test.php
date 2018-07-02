<?php
/**
 * Thrive Themes - https://thrivethemes.com
 *
 * @package thrive-ab-page-testing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden
}

/**
 * Class Thrive_AB_Test
 *
 * - id                             int primary key
 * - type                           string: monetary, visits, optins
 * - page_id                        int
 * - thank_you_id                   int
 * - date_started                   datetime
 * - date_completed                 datetime
 * - title                          string
 * - notes                          string
 * - auto_win_enabled               bool
 * - auto_win_min_conversions       int
 * - auto_win_min_duration          int days
 * - auto_win_chance_original       float
 * - status                         string: running, completed, archived
 *
 * Dynamic properties
 * - items                          array of test_items instances
 *
 * array associative which has indexes columns from DB
 */
class Thrive_AB_Test extends Thrive_AB_Model {

	protected function _get_default_data() {

		$_items_count = ! empty( $this->items ) && is_array( $this->items ) ? count( $this->items ) : 0;

		$defaults = array(
			'date_added'               => date( 'Y-m-d H:i:s' ),
			'date_started'             => date( 'Y-m-d H:i:s' ),
			'auto_win_enabled'         => true,
			'auto_win_min_conversions' => $this->_get_default_win_conversions( $_items_count ),
			'auto_win_min_duration'    => 14,
			'auto_win_chance_original' => 95,
			'status'                   => 'running',
			'items'                    => array(),
		);

		return $defaults;
	}


	public function get_data() {
		$data = array(
			'id'                       => $this->id,
			'goal_pages'               => $this->goal_pages,
			'page_id'                  => $this->page_id,
			'title'                    => $this->title,
			'notes'                    => $this->notes,
			'type'                     => $this->type,
			'auto_win_enabled'         => $this->auto_win_enabled,
			'auto_win_min_conversions' => $this->auto_win_min_conversions,
			'auto_win_min_duration'    => $this->auto_win_min_duration,
			'auto_win_chance_original' => $this->auto_win_chance_original,
			'date_started'             => $this->date_started,
			'date_completed'           => $this->date_completed,
			'status'                   => $this->status,
			'items'                    => $this->items,
		);

		$items = array();
		/** @var Thrive_AB_Test_Item $item */
		foreach ( $this->items as $item ) {
			$items[] = $item->get_data();
		}
		$data['items'] = $items;


		return $data;
	}

	/**
	 * @inheritdoc
	 *
	 * @return bool
	 */
	protected function is_valid() {

		$is_valid = true;

		if ( ! ( $this->page_id ) ) {
			$is_valid = false;
		} elseif ( ! ( $this->title ) ) {
			$is_valid = false;
		} elseif ( ! ( $this->type ) ) {
			$is_valid = false;
		}

		return $is_valid;
	}

	/**
	 * @inheritdoc
	 *
	 * @return array
	 */
	protected function _prepare_data() {

		$data = $this->_data;

		if ( isset( $data['items'] ) ) {
			unset( $data['items'] );
		}

		return $data;
	}

	/**
	 * Calc default winning conversions based on how many items current test has
	 *
	 * @param $test_items_count int
	 *
	 * @return int
	 */
	protected function _get_default_win_conversions( $test_items_count ) {

		return abs( ( $test_items_count - 1 ) * 100 );
	}

	/**
	 * @inheritdoc
	 */
	protected function _table_name() {

		return thrive_ab()->table_name( 'tests' );
	}

	/**
	 * Save the model into db and push it into _data[items]
	 *
	 * @param $model
	 *
	 * @return Thrive_AB_Test_Item
	 */
	public function save_item( $model ) {

		$item = new Thrive_AB_Test_Item( $model );
		$item->save();

		if ( ! $this->items || ! is_array( $this->items ) ) {
			$this->items = array();
		}

		$this->_data['items'][] = $item;

		return $item;
	}

	public function delete() {

		delete_transient( Thrive_AB_Report_Manager::$_transient_stats_name );

		parent::delete();

		$this->delete_test_items();

		/**
		 * Delete also log entries
		 */
		Thrive_AB_Event_Manager::bulk_delete_log( array( 'test_id' => $this->id ) );
	}

	public function get_items() {

		if ( empty( $this->items ) ) {
			$sql   = $this->wpdb->prepare( 'SELECT * FROM ' . thrive_ab()->table_name( 'test_items' ) . ' WHERE test_id = %s ORDER BY is_control DESC', array(
				$this->id
			) );
			$items = $this->wpdb->get_results( $sql, ARRAY_A );

			if ( count( $items ) ) {
				$control = new Thrive_AB_Test_Item( $items[0] );
				foreach ( $items as $key => $item ) {
					$item['control']   = $control;
					$item['variation'] = new Thrive_AB_Page_Variation( (int) $item['variation_id'] );
					$items[ $key ]     = new Thrive_AB_Test_Item( $item );
				}

				$this->items = $items;
			}
		}

		return $this->items;
	}

	public function start() {

		$this->status       = 'running';
		$this->date_started = date( 'Y-m-d H:i:s' );

		if ( $this->page_id && $this->id ) {
			$page = new Thrive_AB_Page( (int) $this->page_id );
			$page->get_meta()->update( 'running_test_id', $this->id );
		}

		thrive_ab()->flush_post_cache( $this->page_id );

		/**
		 * purge cache for goal pages
		 */
		$goal_pages = is_array( $this->goal_pages ) ? $this->goal_pages : maybe_unserialize( $this->goal_pages );
		$goal_pages = is_array( $goal_pages ) ? array_keys( $goal_pages ) : array();
		foreach ( $goal_pages as $page_id ) {
			thrive_ab()->flush_post_cache( $page_id );
		}

		return $this;
	}

	public function stop() {

		$this->status         = 'completed';
		$this->date_completed = date( 'Y-m-d H:i:s' );

		if ( $this->page_id && $this->id ) {
			$page = new Thrive_AB_Page( (int) $this->page_id );
			$page->get_meta()->update( 'running_test_id', false );
		}

		return $this;
	}

	protected function delete_test_items() {

		try {
			//try to delete test post variations
			$items = $this->get_items();

			/** @var Thrive_AB_Test_Item $item */
			foreach ( $items as $key => $item ) {
				if ( $item->variation && $item->variation instanceof Thrive_AB_Page_Variation ) {
					$item->variation->delete();
				}
			}
		} catch ( Exception $e ) {
		}

		$this->wpdb->delete( thrive_ab()->table_name( 'test_items' ), array( 'test_id' => $this->id ) );
	}
}
