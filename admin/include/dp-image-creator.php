<?php

require_once('dp-functions.php');

$attachment = get_post( $attach_ID );
// 1 - kategori
$kategori = get_option('dp-kategori');
// 2 - format judul
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
// 3 - auto tag
if (get_option('dp-auto-tag') == 1) {
    $tags = explode(' ', $_file_name);
} else {
    $tags = array(0);
}
// 4 - hapus exif data from the image
// 5 - capitalize title
if (get_option('dp-cap-judul') == 1) {
    $title = ucwords($title);
}
// 6 - auto descripsi
// 7 - multiple images into one post
$_id = strtok($_file_name, '-'); // ambil string sebelum tanda strip (-) pertama
if (!isset($_SESSION['post_id'])) { // jika belum ada post, berarti ini upload pertama => bikin post
    $_SESSION['_id'] = $_id;
    $_SESSION['attch_id'] = $attachment->ID;
    $_SESSION['attch_loc'] = $attachment->guid;
    $my_post_data = array(
        'post_category' => array($kategori),
        'post_title' => $title,
        'tags_input' => $tags
    );
    
    $post_id = wp_insert_post( $my_post_data );
    $_SESSION['post_id'] = $post_id;
}
if ($_id != $_SESSION['_id']) { // jika _id (nomer unik gambar untuk pembeda id post) berbeda dengan sessi, bikin post lagi
    $_SESSION['_id'] = $_id;
    $_SESSION['attch_id'] = $attachment->ID;
    $_SESSION['attch_loc'] = $attachment->guid;
    $my_post_data = array(
        'post_category' => array($kategori),
        'post_title' => $title,
        'tags_input' => $tags
    );
    
    $post_id = wp_insert_post( $my_post_data );
    $_SESSION['post_id'] = $post_id;
}

// attach media to post
wp_update_post( array(
    'ID' => $attach_ID,
    'post_parent' => $_SESSION['post_id'],
    
) );
// update post
$_kontent = '<a href="%s" rel="attachment wp-att-%s"><img class="alignnone size-full wp-image-%s" src="%s" alt="" /></a>';
$_kontent = sprintf($_kontent, get_attachment_link(($_SESSION['attch_id'])), $_SESSION['attch_id'], $_SESSION['attch_id'], $_SESSION['attch_loc']);    
wp_update_post( array(
    'ID' => $_SESSION['post_id'],
    'post_content' => $_kontent
) );

return $attach_ID;