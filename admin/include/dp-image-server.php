<?php
// hanya jalankan post creator jika diakses dari halaman plugin
$referr = $_SERVER['HTTP_REFERER'];
$sekarang = admin_url("upload.php?page=add-from-server");

if ($referr === $sekarang) {
require_once('dp-functions.php');

$attachment = get_post( $attach_ID );
// kategori
$kategori = get_option('dp-kategori');
// format judul
$_fmt_title = get_option('dp-post-title');
$_fmt = array($_fmt_title);

$_file_name = str_replace("_"," ", $attachment->post_title);
$_file_name = @end((explode('-', $_file_name, 3))); // hanya mengambil file name tanpa kode angka

if ($_fmt[0] != '') {
    $_format_title = get_string_between($_fmt_title, '{', '}');
    $format_title = explode("{{$_format_title}}", $_fmt_title);
    $title = $format_title[0] . $_file_name . $format_title[1];
} else {
    $title = $_file_name;
}
// auto tag
if (get_option('dp-auto-tag') == 1) {
    $tags = explode(' ', $_file_name);
} else {
    $tags = array(0);
}
// capitalize title
if (get_option('dp-cap-judul') == 1) {
    $title = ucwords($title);
}

// create post
$_attch_id = strtok($attachment->post_title, '-'); // ambil string sebelum tanda strip (-) pertama
$_SESSION['_id'] = $_attch_id;
$_SESSION['attch_id'] = $attachment->ID;
$_SESSION['attch_loc'] = $attachment->guid;
$my_post_data = array(
    'post_category' => array($kategori),
    'post_title' => $title,
    'tags_input' => $tags
);
    
$post_id = wp_insert_post( $my_post_data );
$_SESSION['post_id'] = $post_id;

// set featured
if (get_option('dp-featured-image') == 1) {
    set_post_thumbnail( $_SESSION['post_id'], $_SESSION['attch_id'] );
}

// attach wallpaper to the post
$_post_ = str_replace("_"," ", $attachment->post_title);
$_file_name = @end((explode('-', $_post_, 3)));
$_post_name = $attach_ID .'-'. str_replace("_","-", $attachment->post_title);
wp_update_post( array(
    'ID' => $attach_ID,
    'post_parent' => $post_id,
    'post_title' => ucwords($_file_name),
    'post_name' => $_post_name,
) );

// update post dengan auto deskripsi / tidak
$post_data = get_post($_SESSION['post_id']);
$attch_data = get_post($_SESSION['attch_id']);
if (get_option('dp-auto-desc') == 1) { // jika auto deskripsi diaktifkan
    include_once 'dp-deskripsi.php';
    $_kontent = desc_format(get_option('dp-desc-text'), $post_data, $attch_data, '');

    wp_update_post( array(
        'ID' => $_SESSION['post_id'],
        'post_content' => $_kontent
    ) );    
} else {
    $_kontent = "";

    wp_update_post( array(
        'ID' => $_SESSION['post_id'],
        'post_content' => $_kontent
    ) );
}

return $attach_ID;
} else {
    return;
}