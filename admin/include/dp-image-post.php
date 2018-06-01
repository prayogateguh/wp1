<?php
/**
 * Outputs the legacy media upload form.
 *
 * @since 2.5.0
 *
 * @global string $type
 * @global string $tab
 * @global bool   $is_IE
 * @global bool   $is_opera
 *
 * @param array $errors
 */
function dp_uploader( $errors = null ) {
	global $type, $tab, $is_IE, $is_opera;

    $upload_action_url = admin_url('async-upload.php');
	$post_id = isset($_REQUEST['post_id']) ? intval($_REQUEST['post_id']) : 0;
	$_type = isset($type) ? $type : '';
	$_tab = isset($tab) ? $tab : '';

	$max_upload_size = wp_max_upload_size();
	if ( ! $max_upload_size ) {
		$max_upload_size = 0;
	}
?>

<div id="media-upload-notice"><?php

	if (isset($errors['upload_notice']) )
		echo $errors['upload_notice'];

?></div>
<div id="media-upload-error"><?php

	if (isset($errors['upload_error']) && is_wp_error($errors['upload_error']))
		echo $errors['upload_error']->get_error_message();

?></div>
<?php
if ( is_multisite() && !is_upload_space_available() ) {
	/**
	 * Fires when an upload will exceed the defined upload space quota for a network site.
	 *
	 * @since 3.5.0
	 */
	do_action( 'upload_ui_over_quota' );
	return;
}

/**
 * Fires just before the legacy (pre-3.5.0) upload interface is loaded.
 *
 * @since 2.6.0
 */
do_action( 'pre-upload-ui' );

$post_params = array(
	"post_id" => $post_id,
	"_wpnonce" => wp_create_nonce('media-form'),
	"type" => $_type,
	"tab" => $_tab,
	"short" => "1",
);

/**
 * Filters the media upload post parameters.
 *
 * @since 3.1.0 As 'swfupload_post_params'
 * @since 3.3.0
 *
 * @param array $post_params An array of media upload parameters used by Plupload.
 */
$post_params = apply_filters( 'upload_post_params', $post_params );

/*
 * Since 4.9 the `runtimes` setting is hardcoded in our version of Plupload to `html5,html4`,
 * and the `flash_swf_url` and `silverlight_xap_url` are not used.
 */
$plupload_init = array(
	'browse_button'       => 'plupload-browse-button',
	'container'           => 'plupload-upload-ui',
	'drop_element'        => 'drag-drop-area',
	'file_data_name'      => 'async-upload',
	'url'                 => $upload_action_url,
	'filters' => array(
		'max_file_size'   => $max_upload_size . 'b',
	),
	'multipart_params'    => $post_params,
);

/**
 * Filters the default Plupload settings.
 *
 * @since 3.3.0
 *
 * @param array $plupload_init An array of default settings used by Plupload.
 */
$plupload_init = apply_filters( 'plupload_init', $plupload_init );

?>

<script type="text/javascript">
<?php
// Verify size is an int. If not return default value.
$large_size_h = absint( get_option('large_size_h') );
if( !$large_size_h )
	$large_size_h = 1024;
$large_size_w = absint( get_option('large_size_w') );
if( !$large_size_w )
	$large_size_w = 1024;
?>
var resize_height = <?php echo $large_size_h; ?>, resize_width = <?php echo $large_size_w; ?>,
wpUploaderInit = <?php echo wp_json_encode( $plupload_init ); ?>;
</script>

<div id="plupload-upload-ui" class="hide-if-no-js">
<?php
/**
 * Fires before the upload interface loads.
 *
 * @since 2.6.0 As 'pre-flash-upload-ui'
 * @since 3.3.0
 */
do_action( 'pre-plupload-upload-ui' ); ?>
<div id="drag-drop-area">
	<div class="drag-drop-inside">
	<p class="drag-drop-info"><?php _e('Geser wallpaper ke sini'); ?></p>
	<p><?php _ex('or', 'Uploader: Drop files here - or - Select Files'); ?></p>
	<p class="drag-drop-buttons"><input name="dp_upload" id="plupload-browse-button" type="button" value="<?php esc_attr_e('Pilih Wallpaper'); ?>" class="button" /></p>
	</div>
</div>

<p class="max-upload-size"><?php printf( __( 'Maximum upload file size: %s.' ), esc_html( size_format( $max_upload_size ) ) ); ?></p>
<?php
}