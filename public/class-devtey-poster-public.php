<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://devtey.com/
 * @since      1.0.0
 *
 * @package    Devtey_Poster
 * @subpackage Devtey_Poster/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Devtey_Poster
 * @subpackage Devtey_Poster/public
 * @author     Devtey Inc. <devtey@gmail.com>
 */
class Devtey_Poster_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Devtey_Poster_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Devtey_Poster_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/devtey-poster-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Devtey_Poster_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Devtey_Poster_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/devtey-poster-public.js', array( 'jquery' ), $this->version, false );

	}

	// register shortcode
	public function register_shortcodes() {
		add_shortcode( 'dpgallery', array( $this, 'dp_gallery') );
	}

	public function dp_gallery($atts) {
		$_attch_id = array();
		$args = array(
            'post_parent'    => $atts['id'],
            'post_type'      => 'attachment',
            'numberposts'    => -1, // show all
            'post_status'    => 'any',
            'post_mime_type' => 'image',
            'orderby'        => 'menu_order',
            'order'           => 'ASC'
       	);
		$images = get_posts($args);
		
		foreach ($images as $image) {
			array_push($_attch_id,$image->ID); // get all attachment id
		}

		if (count($_attch_id) > 1) {
			array_shift($_attch_id); // hapus element pertama, karena sudah ditampilkan
		} else {
			return "";
		}

		$dom = '';
		foreach ($_attch_id as $_aid) {
			$attc = get_post($_aid);
			$dom .= "<a class='dp-item' href='{$attc->post_name}/'><img class='mySlides' id='dp-attch-item-{$attc->ID}' src='{$attc->guid}' alt='{$attc->post_title}' style='width:100%;opacity:0.7;'></a>";
		}
		// $dom = "<div class='dp-gallery'>{$dom}</div>";
$dom = "
<div class='w3-content w3-display-container'>
{$dom}
<button class='w3-button w3-black w3-display-left' onclick='plusDivs(-1)'>&#10094;</button>
<button class='w3-button w3-black w3-display-right' onclick='plusDivs(1)'>&#10095;</button>
</div>
";
		$output = $dom;
		
		return $output;
		//$_attch_id = implode(',', $_attch_id);
		//return "[gallery columns=\"4\" ids=\"{$_attch_id}\"]";
	}

}
