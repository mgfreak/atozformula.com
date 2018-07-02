<?php
/**
 * Created by PhpStorm.
 * User: Ovidiu
 * Date: 12/21/2017
 * Time: 2:24 PM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden
}

/**
 * Class Thrive_AB_Product
 */
class Thrive_AB_Product extends TVE_Dash_Product_Abstract {

	/**
	 * Tag of the product
	 *
	 * @var string tag.
	 */
	protected $tag = 'tab';

	/**
	 * Name of the product displayed in Dashboard
	 *
	 * @var string title
	 */
	protected $title = 'Thrive Optimize';

	/**
	 * Type of product
	 *
	 * @var string type of the product
	 */
	protected $type = 'plugin';

	/**
	 * Thrive_AB_Product constructor.
	 *
	 * @param array $data info used in dashboard.
	 */
	public function __construct( $data = array() ) {
		parent::__construct( $data );

		$this->logoUrl      = thrive_ab()->url( 'assets/images/tab-logo.png' );
		$this->logoUrlWhite = thrive_ab()->url( 'assets/images/tab-logo-white.png' );
		$this->productIds   = array();

		$this->description = __( 'Boost Conversion Rates by testing two or more variations of a page.', Thrive_AB::T );

		$this->button = array(
			'active' => true,
			'url'    => admin_url( 'admin.php?page=tab_admin_dashboard' ),
			'label'  => __( 'Thrive Optimize', Thrive_AB::T ),
		);

		$this->moreLinks = array(
			'support'   => array(
				'class'      => '',
				'icon_class' => 'tvd-icon-life-bouy',
				'href'       => 'https://thrivethemes.com/forums/forum/plugins/thrive-optimize/',
				'target'     => '_blank',
				'text'       => __( 'Support', Thrive_AB::T ),
			),
			'tutorials' => array(
				'class'      => '',
				'icon_class' => 'tvd-icon-graduation-cap',
				'href'       => 'https://thrivethemes.com/thrive-knowledge-base/thrive-optimize/',
				'target'     => '_blank',
				'text'       => __( 'Tutorials', Thrive_AB::T ),
			),
		);
	}
}
