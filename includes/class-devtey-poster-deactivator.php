<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://devtey.com/
 * @since      1.0.0
 *
 * @package    Devtey_Poster
 * @subpackage Devtey_Poster/includes
 */
use function delete_option as dposter;
/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Devtey_Poster
 * @subpackage Devtey_Poster/includes
 * @author     Devtey Inc. <devtey@gmail.com>
 */
class Devtey_Poster_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		dposter('dp-kategori');
		dposter('dp-post-title');
		dposter('dp-multi-wallpapers');
		dposter('dp-auto-tag');
		dposter('dp-hapus-exif');
		dposter('dp-cap-judul');
		dposter('dp-auto-desc');
		dposter('dp-desc-text');
		dposter('dp-scheduler-status');
		dposter('dp-jml-post');
		dposter('dp-rtg-post');
		dposter('dp-ack-post');
		dposter('dp-info');
		dposter('dp-key');
		dposter('dp_info');
		dposter('dp_key');
		dposter('dp_poster');
	}

}
