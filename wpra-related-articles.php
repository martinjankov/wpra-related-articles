<?php
/**
 * Plugin Name: WP Related Articles
 * Description: Show related articles based on category below the post
 * Author:      Martin Jankov
 * Author URI:  https://martincv.com
 * Version:     1.0.0
 * Text Domain: wra
 *
 * WP Related Articles is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * WP Related Articles is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Ads Management System. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    WPRARelatedArticles
 * @author     Martin Jankov
 * @since      1.0.0
 * @license    GPL-3.0+
 * @copyright  Copyright (c) 2018, Martin Jankov
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

final class WPRARelatedArticles {

	private static $_instance;

	private $_version = '1.0.0';

	public static function instance() {

		if ( ! isset( self::$_instance ) && ! ( self::$_instance instanceof WPRARelatedArticles ) ) {

			self::$_instance = new WPRARelatedArticles;
			self::$_instance->constants();
			self::$_instance->includes();

			add_action( 'plugins_loaded', array( self::$_instance, 'objects' ), 10 );
			//add_action( 'admin_enqueue_scripts', array( self::$_instance, 'load_global_admin_assets' ), 10 );
			add_action( 'wp_enqueue_scripts', array( self::$_instance, 'load_frontend_global_assets' ), 10 );
		}
		
		return self::$_instance;
	}

	private function includes() {

		// Global includes
		require_once WRA_PLUGIN_DIR . 'includes/functions.php';

		// Classes
		require_once WRA_PLUGIN_DIR . 'classes/WRA_Post.php';

		// Admin classes
		if( is_admin() ) {
			require_once WRA_PLUGIN_DIR . 'classes/admin/WRA_Admin_Dashboard.php';
		}
	}

	private function constants() {

		// Plugin version
		if ( ! defined( 'WRA_VERSION' ) ) {
			define( 'WRA_VERSION', $this->_version );
		}

		// Plugin Folder Path
		if ( ! defined( 'WRA_PLUGIN_DIR' ) ) {
			define( 'WRA_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		}

		// Plugin Folder URL
		if ( ! defined( 'WRA_PLUGIN_URL' ) ) {
			define( 'WRA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}

		// Plugin Root File
		if ( ! defined( 'WRA_PLUGIN_FILE' ) ) {
			define( 'WRA_PLUGIN_FILE', __FILE__ );
		}
	}

	public function objects() {
		// Global objects
		new WRA_Post;

		if ( is_admin() ) {
			new WRA_Admin_Dashboard;
		}
	}

	public function load_global_admin_assets($hook){
		global $post;

		if($hook != "toplevel_page_wra-settings") return;
			
		if(!isset($post)) return;
		
		wp_enqueue_style('wra-admin-style', WRA_PLUGIN_URL.'assets/css/admin/style.css', array(), WRA_VERSION);

		wp_enqueue_script('wplink');
		wp_enqueue_script('wra-admin-script', WRA_PLUGIN_URL.'assets/js/admin/script.js', array('jquery'), WRA_VERSION, true);
	}

	public function load_frontend_global_assets($hook){
		global $post;
			
		if(!isset($post)) return;
			
		wp_enqueue_style('wra-style', WRA_PLUGIN_URL.'assets/css/style.css', array(), WRA_VERSION);
		wp_enqueue_script('wra-script', WRA_PLUGIN_URL.'assets/js/script.js', array('jquery'), WRA_VERSION);
	}
}

/**
 * Use this function as global in all other classes and/or files. 
 */
function wra() {
	return WPRARelatedArticles::instance();
}
wra();