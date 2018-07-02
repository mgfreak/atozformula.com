<?php
/**
 * Thrive Themes - https://thrivethemes.com
 *
 * @package thrive-comments
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden.
}

/**
 * Class Thrive_Comments_Front
 */
class Thrive_Comments_Front {

	/**
	 * Constructor for Thrive_Comments_Front
	 * Add all frontend hooks
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'init' ) );

		add_action( 'wp_head', array( $this, 'add_twitter_cards' ) );

		add_action( 'wp_head', array( $this, 'add_facebook_cards' ) );

		add_action( 'wp_head', array( $this, 'accent_color_css' ) );

		add_action( 'wp_login', array( $this, 'tcm_after_login' ) );

		add_filter( 'tcb_landing_head', array( $this, 'accent_color_css' ) );

		add_action( 'wp_footer', array( $this, 'add_frontend_svg_file' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 100 );

		add_action( 'rest_api_init', array( $this, 'tcm_create_frontend_rest_routes' ) );

		add_action( 'tve_dash_main_ajax_tcm_dash_data', 'tve_dash_generate_secret', 10, 2 );

		add_action( 'wp_loaded', array( $this, 'tcm_default_labels' ) );

		add_action( 'login_footer', array( $this, 'after_ajax_login' ) );

		add_action( 'wp_ajax_refresh_nonce', array( $this, 'refresh_nonce' ), 10, 2 );

		// Allow Thrive Leads ajax load for Thrive Comments.
		add_filter( 'tve_leads_ajax_load', '__return_true' );

		add_filter( 'tva_term_extra_content', array( $this, 'add_tcm_triggers' ) );

	}

	/**
	 * Hide date also from the comments list ( the comments shown for SEO )
	 */
	public function hide_date() {

		if ( ! tcms()->tcm_get_setting_by_name( 'comment_date' ) ) {
			add_filter( 'get_comment_date', '__return_false', 10, 3 );

			add_filter( 'get_comment_time', '__return_false', 10, 3 );
		}

	}

	/**
	 * Add twitter cards to post
	 */
	public function add_twitter_cards() {
		tcmc()->add_twitter_cards();
	}

	/**
	 * Add facebook cards to post
	 */
	public function add_facebook_cards() {
		tcmc()->add_facebook_cards();
	}


	/**
	 * Init frontend and include files
	 */
	public function init() {

		if ( tcm()->license_activated() && tcms()->tcm_get_setting_by_name( 'activate_comments' ) ) {

			add_filter( 'comments_template', array( $this, 'render_comments' ), 50 );

			add_filter( 'the_content', array( $this, 'add_tcm_triggers' ) );

			add_filter( 'get_comment_link', array( $this, 'tcm_change_comments_link' ) );

			add_action( 'wp_footer', array( $this, 'tcm_front_backbone_templates' ), 5 );

			// Enqueue the dash frontend script.
			add_filter( 'tve_dash_enqueue_frontend', '__return_true' );

			/*
			 * "dra_allow_rest_api" is a hook provided by Disable REST API (DRA) for whitelisting visitor request availability
			 * filter added to prevent the DRA plugin from blocking TCM requests
			 */
			add_filter( 'dra_allow_rest_api', array( $this, 'allow_rest_api_overwrite' ), 50, 1 );

			add_action( 'wp_print_footer_scripts', array( $this, 'add_leads_shortcode_to_content' ), 11 );

			// We are adding this because conversion thrive boxes need to work on landing pages also.
			add_action( 'tve_landing_page_content', array( $this, 'add_tcm_triggers' ), 11 );

			add_filter( 'tve_leads_ajax_load_forms', array( $this, 'add_thrivebox_flat_css' ) );

			add_filter( 'tva_term_extra_content', array( $this, 'add_tcm_triggers' ) );

			$this->hide_date();

			//compatibility with w3 total cache inline js minification option
			if ( defined( 'W3TC' ) ) {
				add_filter( 'w3tc_minify_enable', '__return_false' );
			}
		}
	}

	/**
	 * Add triggers for the ThriveBoxes set in conversion options.
	 *
	 * @param string $content The content.
	 *
	 * @return string
	 */
	public function add_tcm_triggers( $content ) {
		$conversion_settings = tcms()->tcm_get_setting_by_name( 'tcm_conversion' );

		$first_trigger  = sprintf( '<span class="tve-leads-two-step-trigger tl-2step-trigger-%d"></span>', $conversion_settings['tcm_thrivebox']['first_time']['thrivebox_id'] );
		$second_trigger = sprintf( '<span class="tve-leads-two-step-trigger tl-2step-trigger-%d"></span>', $conversion_settings['tcm_thrivebox']['second_time']['thrivebox_id'] );

		return $content . $first_trigger . $second_trigger;
	}

	/**
	 * Include thrive_flat css for ThriveBoxes.
	 *
	 * @param WP_Ajax_Response $response response.
	 *
	 * @return WP_Ajax_Response $response response.
	 */
	public function add_thrivebox_flat_css( $response ) {
		if ( ! function_exists( 'tve_get_style_families' ) ) {
			/**
			 * If this function does not exist, we can return safely the response cause Thrive Flat is not necessary since this function is called during Leads Lazy Load
			 */
			return $response;
		}

		/* flat is the default style for Thrive Leads */
		$tve_style_families = tve_get_style_families();
		$style_family       = 'Flat';

		if ( empty( $response['tve_flat_included'] ) ) {
			$response['res']['css']['tve_leads_flat'] = $tve_style_families[ $style_family ];
		}

		return $response;
	}

	/* overwrites the Disable REST API plugin's request handling so it lets through TCM requests */
	public function allow_rest_api_overwrite( $is_user_logged_in ) {
		if ( strpos( $GLOBALS['wp']->query_vars['rest_route'], 'tcm/' ) ) {
			return true;
		}

		return $is_user_logged_in;
	}

	/**
	 * Enqueue scripts and styles
	 */
	public function enqueue_scripts() {
		$js_suffix     = defined( 'TVE_DEBUG' ) && TVE_DEBUG ? '.js' : '.min.js';
		$show_comments = $this->tcm_show_comments();

		/**
		 * Allow to display comments on other pages beside posts
		 *
		 * @param bool $show_comments default value from thrive comments logic
		 */
		$show_comments = apply_filters( 'tcm_show_comments', $show_comments );

		if ( $show_comments ) {
			tcm()->tcm_enqueue_style( 'tcm-front-styles-css', tcm()->plugin_url( '/assets/css/styles.css' ) );

			tcm()->tcm_enqueue_script( 'tcm-frontend-js', tcm()->plugin_url( '/assets/js/frontend.min.js' ), array(
				'jquery',
				'backbone',
			), false, true );

			tcm()->tcm_enqueue_script( 'libs-frontend', tcm()->plugin_url( 'assets/js/libs-frontend.min.js' ), array( 'jquery' ) );

			wp_localize_script( 'tcm-frontend-js', 'ThriveComments', $this->tcm_get_localization_parameters() );

			// Enqueue all scripts and styles needed for ThriveBoxes.
			if ( defined( 'TVE_LEADS_URL' ) ) {
				if ( ! wp_script_is( 'tve_frontend' ) ) {
					tcm()->tcm_enqueue_script( 'tve_frontend', tve_editor_js() . '/frontend' . $js_suffix, array( 'jquery' ), false, true );
					$frontend_options = array(
						'is_editor_page' => is_editor_page(),
						'ajaxurl'        => admin_url( 'admin-ajax.php' ),
					);
					wp_localize_script( 'tve_frontend', 'tve_frontend_options', $frontend_options );
				}

				if ( ! wp_script_is( 'tve_leads_frontend' ) ) {
					tcm()->tcm_enqueue_script( 'tve_leads_frontend', TVE_LEADS_URL . 'js/frontend' . $js_suffix, array( 'jquery' ), false, true );
				}
			}

			if ( ! is_user_logged_in() ) {
				add_action( 'wp_footer', 'wp_auth_check_html', 5 );
				wp_enqueue_style( 'wp-auth-check' );
			}
		}
	}


	/**
	 * Check if we can show the comments on the post or page
	 *
	 * @return bool
	 */
	public function tcm_show_comments() {

		// If we have a tc element on a landing page than show comments only if the settings from TC allow that.
		if ( function_exists( 'tve_post_is_landing_page' ) && $is_landing_page = tve_post_is_landing_page( get_the_ID() ) ) {
			$post                  = tcmc()->tc_get_post();
			$tc_comments_closed    = tcms()->tcm_get_setting_by_name( 'activate_comments' );
			$post_content          = get_post_meta( $post->ID, 'tve_updated_post_' . $is_landing_page, true );
			$has_comment_container = strpos( $post_content, 'thrive-comments' );

			return is_editor_page() || ( $tc_comments_closed && $has_comment_container !== false && ! tcms()->close_comments( $post->ID ) );
		}

		$comment_count = get_comment_count( get_the_ID() );
		// If comments are closed, display the comments but show that they are closed.
		$show_comments = is_singular() && ( comments_open() || $comment_count['all'] );

		/**
		 * Filter if the comments needs to show on some other pages
		 *
		 * @param bool $show_comments - if the comments are shown based on the thrive comments criteria
		 */
		return apply_filters( 'tcm_show_comments', $show_comments );
	}

	/**
	 * Add frontend comments placeholder
	 *
	 * @return string
	 */
	public function render_comments() {
		return tcm()->plugin_path( 'includes/frontend/views/comments.php' );
	}

	/**
	 *  Create and register frontend rest routes
	 */
	public function tcm_create_frontend_rest_routes() {
		$endpoints = array(
			'TCM_REST_Comments_Controller',
		);

		foreach ( $endpoints as $e ) {
			$controller = new $e();
			$controller->register_routes();
		}
	}

	/**
	 * Get params to be used in javascript
	 *
	 * @return array
	 */
	public function tcm_get_localization_parameters() {
		$post = tcmc()->tc_get_post();

		$localization = array(
			'current_user'         => tcmh()->tcm_get_current_user(),
			'translations'         => include tcm()->plugin_path( 'includes/i18n.php' ),
			'nonce'                => wp_create_nonce( 'wp_rest' ),
			'routes'               => array(
				'comments'               => tcm()->tcm_get_route_url( 'comments' ),
				'gravatar'               => tcm()->tcm_get_route_url( 'comments' ) . '/gravatar',
				'live_update'            => tcm()->tcm_get_route_url( 'comments' ) . '/live_update',
				'update_post_subscriber' => tcm()->tcm_get_route_url( 'comments' ) . '/update_post_subscriber',
				'generate_nonce'         => admin_url( 'admin-ajax.php' ),
			),
			'post'                 => $post,
			'related_posts'        => tcmc()->get_related_posts( $post, Thrive_Comments_Constants::TCM_NO_RELATED_POSTS, $args = array() ),
			'const'                => array(
				'toast_timeout' => Thrive_Comments_Constants::TCM_TOAST_TIMEOUT, // Not sure if we really need this.
				'wp_content'    => rtrim( WP_CONTENT_URL, '/' ) . '/',
				'ajax_dash'     => array( Thrive_Comments_Constants::TCM_AJAX_DASH ),
				'site_url'      => get_site_url(),
				'moderation'    => array(
					'approve'              => Thrive_Comments_Constants::TCM_APPROVE,
					'unapprove'            => Thrive_Comments_Constants::TCM_UNAPPROVE,
					'spam'                 => Thrive_Comments_Constants::TCM_SPAM,
					'unspam'               => Thrive_Comments_Constants::TCM_UNSPAM,
					'trash'                => Thrive_Comments_Constants::TCM_TRASH,
					'untrash'              => Thrive_Comments_Constants::TCM_UNTRASH,
					'unreplied'            => Thrive_Comments_Constants::TCM_UNREPLIED,
					'tcm_delegate'         => Thrive_Comments_Constants::TCM_DELEGATE,
					'tcm_featured'         => Thrive_Comments_Constants::TCM_FEATURED,
					'tcm_keyboard_tooltip' => Thrive_Comments_Constants::TCM_KEYBOARD_TOOLTIP,
					'featured'             => Thrive_Comments_Constants::TCM_FEATURE_VALUE,
					'not_featured'         => Thrive_Comments_Constants::TCM_NOT_FEATURE_VALUE,
				),
			),
			'settings'             => tcms()->tcm_get_settings(),
			'close_comments'       => tcms()->close_comments( $post->ID ) || ! $this->tcm_show_comments(),
			'sorting'              => tcms()->get_comment_sorting(),
			'tcm_customize_labels' => tcms()->tcm_get_setting_by_name( Thrive_Comments_Constants::TCM_LABELS_KEY ),
			'tcm_social_apis'      => array(
				'facebook' => Thrive_Dash_List_Manager::credentials( 'facebook' ),
				'google'   => Thrive_Dash_List_Manager::credentials( 'google' ),
			),
			'email_services'       => tcamh()->get_email_services(),
			'tcm_accent_color'     => tcms()->tcm_get_setting_by_name( Thrive_Comments_Constants::TCM_ACCENT_COLOR ),
		);

		/**
		 * Filter for adding extra params for comments localization in fronted
		 *
		 * @param array $localization the already built localization by TC
		 */
		return apply_filters( 'tcm_comments_localization', $localization );
	}

	/**
	 * Load all backbone templates for frontend
	 */
	public function tcm_front_backbone_templates() {
		if ( $this->tcm_show_comments() ) {
			$templates = tve_dash_get_backbone_templates( tcm()->plugin_path( 'includes/frontend/views/templates' ), 'templates' );
			tve_dash_output_backbone_templates( $templates );
		}

	}

	/**
	 * Initialize default labels if the options does not exists already in the db.
	 *
	 * @return bool
	 */
	public function tcm_default_labels() {

		$default_labels = Thrive_Comments_Constants::$tcm_default_labels;
		$saved_labels   = get_option( Thrive_Comments_Constants::TCM_LABELS_KEY );
		$update         = 0;

		foreach ( $default_labels as $key => $value ) {
			if ( ! isset( $saved_labels[ $key ] ) || empty( $saved_labels[ $key ]['text'] ) ) {
				$saved_labels[ $key ] = array(
					'default' => __( $value ),
					'text'    => __( $value ),
				);
				$update               = 1;
			}
		}
		if ( count( $saved_labels ) !== count( $default_labels ) ) {
			$saved_labels = array_intersect_key( $default_labels, $saved_labels );
			$update       = 1;
		}

		if ( $update ) {
			update_option( Thrive_Comments_Constants::TCM_LABELS_KEY, $saved_labels );
		}

		return true;
	}

	/**
	 * Call used to change the nonce when the user logs in with ajax from frontend.
	 */
	public function refresh_nonce() {
		$nonce        = wp_create_nonce( 'wp_rest' );
		$current_user = tcmh()->tcm_get_current_user();

		echo json_encode( array( 'nonce' => $nonce, 'current_user' => $current_user ) );
		die();
	}

	/**
	 * Actions taken after the user logs in with ajax.
	 *
	 * @param $id
	 */
	public function after_ajax_login( $id ) {
		global $interim_login;
		if ( $interim_login ) {
			tcm()->tcm_enqueue_script( 'tcm-login-js', tcm()->plugin_url( '/assets/js/after-ajax-login.js' ), array(
				'jquery',
			), false, true );
		}
	}

	/**
	 * Insert shortcode for thrive boxes
	 *
	 * @return string
	 */
	public function add_leads_shortcode_to_content() {
		if ( ! defined( 'TVE_LEADS_URL' ) ) {
			return '';
		}
		$thrive_boxes_content = tcmc()->get_thrive_boxes_shortcodes();//take in consideration the case when the comments are on a landing page
		$leads_content        = ( function_exists( 'tve_post_is_landing_page' ) && tve_post_is_landing_page( get_the_ID() ) ) ? do_shortcode( $thrive_boxes_content ) : $thrive_boxes_content;

		echo $leads_content;
	}

	/* adds css for comment colors inside the header */
	public function accent_color_css( $landing_page_id ) {
		include tcm()->plugin_path( 'includes/frontend/views/accent-color-styles.php' );

		return $landing_page_id;
	}

	/* adds the hidden svg file with the icons from the frontend pages to the header */
	public function add_frontend_svg_file() {
		tcmh()->include_svg_file( 'frontend-page-icons.svg' );
	}

	/**
	 * Change comments link in widget
	 *
	 * @param string $link Comment link.
	 *
	 * @return string $link
	 */
	public function tcm_change_comments_link( $link ) {
		$link                          = preg_replace( '/(\/comment-page-)([0-9]+)/', '', $link );
		$link                          = str_replace( '#comment', '#comments', $link );
		$link[ strrpos( $link, '-' ) ] = '/';

		return $link;
	}

	/**
	 * If the user logs in with an admin account and he is logged in already with a social account, we log him out automatically from his social account
	 */
	public function tcm_after_login() {

		if ( isset( $_COOKIE['social-login'] ) ) {

			unset( $_COOKIE['social-login'] );
			setcookie( 'social-login', '', time() - 3600 );
		}
	}
}

return new Thrive_Comments_Front();
