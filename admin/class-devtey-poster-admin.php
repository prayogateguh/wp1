<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://devtey.com/
 * @since      1.0.0
 *
 * @package    Devtey_Poster
 * @subpackage Devtey_Poster/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Devtey_Poster
 * @subpackage Devtey_Poster/admin
 * @author     Devtey Inc. <devtey@gmail.com>
 */
class Devtey_Poster_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/devtey-poster-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/devtey-poster-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the Devtey Poster menu on the sidebar
	 * 
	 * @since	1.0.0
	 */
	public function display_admin_page() {
		add_menu_page('Devtey Poster', 'Devtey Poster', 'manage_options', 'devtey-poster', array($this, 'devtey_poster'), 'dashicons-awards', '3.0' );
		add_submenu_page('devtey-poster', 'Active', 'Active', 'manage_options', 'devtey-poster' );
		add_submenu_page('devtey-poster', 'Post Creator', 'Post Creator', 'manage_options', 'dp-post-creator', array($this, 'dp_post_creator') );
		add_submenu_page('devtey-poster', 'Post Scheduler', 'Post Scheduler', 'manage_options', 'dp-post-scheduler', array($this, 'dp_post_scheduler') );
		add_submenu_page('devtey-poster', 'About', 'About', 'manage_options', 'dp-about', array($this, 'dp_about') );
	}

	/**
	 * Retrieve the devtey poster options.
	 *
	 * @since     1.0.0
	 */
	public function dp_poster_settings() {
		// post creator options
		register_setting( 'dp-poster-settings', 'dp-kategori' );
  		register_setting( 'dp-poster-settings', 'dp-post-title' );
		register_setting( 'dp-poster-settings', 'dp-auto-tag' );
		register_setting( 'dp-poster-settings', 'dp-hapus-exif' );
		register_setting( 'dp-poster-settings', 'dp-cap-judul' );
		register_setting( 'dp-poster-settings', 'dp-auto-desc' );
	}
	public function dp_scheduler_settings() {
		// post scheduler options
		register_setting( 'dp-scheduler-settings', 'dp-aktif' );
		register_setting( 'dp-scheduler-settings', 'dp-jml-post' );
		register_setting( 'dp-scheduler-settings', 'dp-rtg-post' );
		register_setting( 'dp-scheduler-settings', 'dp-ack-post' );
	}

	/**
	 * Register the layout for the Devtey Poster admin
	 * 
	 * @since	1.0.0
	 */
	
	public function devtey_poster() {
		include_once 'partials/dp-activator-display.php';
	}

	/**
	 * Register the layout for the Devtey Poster admin
	 * 
	 * @since	1.0.0
	 */
	
	public function dp_post_creator() {
		include_once 'partials/dp-poster-display.php';
	}

	/**
	 * Display callback for the submenu page.
	 */
	function dp_post_scheduler() { 
		include_once 'partials/dp-scheduler-display.php';
	}

	/**
	 * Display callback for the submenu page.
	 */
	function dp_about() { 
		include_once 'partials/dp-about-display.php';
	}

}
