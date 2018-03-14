<?php
/**
 * WRA_Post class for manipulation with post content on frontend
 * 
 * @package    WPRelatedArticles
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WRA_Admin_Dashboard {
	public function __construct() {
		add_action('admin_init', array($this, 'wra_register_settings') );
		add_action('admin_menu', array($this, 'wra_menu') );
	}

	public function wra_menu() {
		add_menu_page('Related Articles', 'Related Articles', 'administrator', 'wra-settings', array( $this,'wra_settings' ), 'dashicons-admin-generic');
	}

	public function wra_settings() {
		$categories = get_terms(array(
			'taxonomy' => 'category',
			'hide_empty' => true
		));

		@include_once WRA_PLUGIN_DIR . 'views/admin/template-settings.php';
	}

	public function wra_register_settings() {
		register_setting( 'wra-settings-group', 'wra_category' );
		register_setting( 'wra-settings-group', 'wra_number_of_posts' );
	}

}
