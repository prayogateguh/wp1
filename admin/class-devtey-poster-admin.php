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
		register_setting( 'dp-poster-settings', 'dp-multi-wallpapers' );
		register_setting( 'dp-poster-settings', 'dp-auto-tag' );
		register_setting( 'dp-poster-settings', 'dp-hapus-exif' );
		register_setting( 'dp-poster-settings', 'dp-cap-judul' );
		register_setting( 'dp-poster-settings', 'dp-auto-desc' );
		register_setting( 'dp-poster-settings', 'dp-desc-text' );
	}
	public function dp_scheduler_settings() {
		// post scheduler options
		register_setting( 'dp-scheduler-settings', 'dp-scheduler-status' );
		register_setting( 'dp-scheduler-settings', 'dp-jml-post' );
		register_setting( 'dp-scheduler-settings', 'dp-rtg-post' );
		register_setting( 'dp-scheduler-settings', 'dp-ack-post' );
	}
	public function dp_poster() {
		// dp poster aktif
		register_setting( 'dp-aktif', 'dp-info' );
		register_setting( 'dp-aktif', 'dp-key' );
	}

	/**
	 * Register the layout for the Devtey Poster admin
	 * 
	 * @since	1.0.0
	 */
	
	public function devtey_poster() {
		include_once 'dp-hurungken.php';
		include_once 'dp-pareman.php';
		include_once 'partials/dp-activator-display.php';
	}

	/**
	 * Register the layout for the Devtey Poster admin
	 * 
	 * @since	1.0.0
	 */
	
	public function dp_post_creator() {
		include_once 'include/dp-image-post.php';
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

	/**
	 * Image uploader actions
	 */
	function post_creator( $attach_ID ) {
		if (get_option('dp-multi-wallpapers') == 1) {
			include_once 'include/dp-image-multi.php';
		} else {
			include_once 'include/dp-image-single.php';
		}
	}

	/**
	 * Remove image exif & metadata when uploading
	 */
	function set_extension($array)
	{
		if ( empty($array['file']))
			return false;

		$fileInfo = pathinfo($array['file']);
		$filePath = $fileInfo['dirname'] . '/'.$fileInfo['basename'];
		switch ($fileInfo['extension']) {
			case 'jpg':
				$array['file'] = $this->remove_exif($filePath, 'jpg');
				break;
			case 'png':
				$array['file'] = $this->remove_exif($filePath, 'png');
				break;
		}

		return $array;
	}
	// the function for remove the exif & metadata
	function remove_exif($imagePath, $type)
	{
		
		if (empty($imagePath) || !is_admin())
			return false;

		if ($type == 'jpg')
			$clearExif = imagecreatefromjpeg($imagePath);
		elseif ($type == 'png')
			$clearExif = imagecreatefrompng($imagePath);
		else
			return $imagePath;

		imagejpeg($clearExif, $imagePath, 80);
		imagedestroy($clearExif);
		return $imagePath;
	}

	/**
	 * dp cron scheduler
	 */
	public function dp_rentang($rentang) {
		if (substr_count($rentang,":") == 2) {
			$waktu = explode(":", $rentang);
		} else {
			update_option('dp-rtg-post', '01:00:00');
			$waktu = explode(":", $rentang);
		}
		
		$jam = $waktu[0] * 3600;
		$menit = $waktu[1] * 60;
		$detik = $waktu[2];
		$waktu = (int)($jam + $menit + $detik);
		
        return $waktu;
    }
	function dp_next_schedule($schedules) {    // add custom time when to check for next auto post
        if (get_option('dp-scheduler-status') == 0) return $schedules;
        $timesecs = $this->dp_rentang(get_option('dp-rtg-post'));
        $schedules['dp_schedule'] = array(
            'interval' => $timesecs, 'display' => 'DP Scheduler'
        );
        return $schedules;
	}
	function dp_scheduler() {
		$aps_enabled = get_option('dp-scheduler-status');
        if ($aps_enabled == 0) return;

        $aps_batch = get_option('dp-jml-post');
        $aps_random = get_option('dp-ack-post');
    
        // set up the basic post query
        $args = array(
            'numberposts' => $aps_batch
        );
    
        $args['post_status'] = "draft";
        $args['order'] = "ASC";
		
		if ($aps_random == 1) $args['orderby'] = "rand";
        $results = get_posts($args);
    
        if (!empty($results)) {
            // cycle through results and update
            foreach ($results as $thepost) {
                $update = array();
                $update['ID'] = $thepost->ID;
                $update['post_status'] = 'publish';
                $thetime = date("Y-m-d H:i:s");
                $update['post_date'] = $thetime;
                wp_update_post($update);
            }
        }
        else {
            update_option('dp-scheduler-status', 0);
        }
	}

	/**
	 * session for create-posts-from-image-upload
	 */
	function start_session() {
		if(!session_id()) {
			session_start();
		}
	}
	function end_session() {
		session_destroy();
	}

	public function display_poster_page() {
		add_submenu_page('devtey-poster', 'Active', 'Active', 'manage_options', 'devtey-poster' );
		add_submenu_page('devtey-poster', 'Post Creator', 'Post Creator', 'manage_options', 'dp-post-creator', array($this, 'dp_post_creator') );
		add_submenu_page('devtey-poster', 'Post Scheduler', 'Post Scheduler', 'manage_options', 'dp-post-scheduler', array($this, 'dp_post_scheduler') );
		add_submenu_page('devtey-poster', 'About', 'About', 'manage_options', 'dp-about', array($this, 'dp_about') );
	}

}
