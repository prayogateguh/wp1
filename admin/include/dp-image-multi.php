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
$_attch_id = strtok($attachment->post_title, '-'); // ambil string sebelum tanda strip (-) pertama

if (!isset($_SESSION['post_id'])) { // jika belum ada post, berarti ini upload pertama => bikin post
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
}
if ($_attch_id != $_SESSION['_id']) { // jika _id (nomer unik gambar untuk pembeda id post) berbeda dengan sessi, bikin post lagi
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
}

// attach media to post
$_post_title = str_replace("_"," ", $attachment->post_title);
$_file_name = @end((explode('-', $_post_title, 3)));
$_post_title = str_replace("_","-", $attachment->post_title);
$_post_name = @end((explode('-', $_post_title, 3)));
wp_update_post( array(
    'ID' => $attach_ID,
    'post_parent' => $_SESSION['post_id'],
    'post_title' => ucwords($_file_name),
    'post_name' => $attach_ID .'-'. $_post_name
) );
// update post
$post_data = get_post($_SESSION['post_id']);
$attch_data = get_post($_SESSION['attch_id']);
if (get_option('dp-auto-desc') == 1) { // jika auto deskripsi diaktifkan
    include_once 'dp-deskripsi.php';
    $_kontent = desc_format(get_option('dp-desc-text'), $post_data, $attch_data);

    wp_update_post( array(
        'ID' => $_SESSION['post_id'],
        'post_content' => $_kontent
    ) );

    if (get_option('dp-auto-desc') == 1) { // jika auto deskripsi pada attachment diaktifkan
        wp_update_post( array(
            'ID' => $attach_ID,
            'post_parent' => $_SESSION['post_id'],
            'post_title' => ucwords($_file_name),
            'post_name' => $attach_ID .'-'. $_post_name,
            'post_content' => $_kontent
        ) );
    }

} else {
    $_kontent = "<a href=\"{$attch_data->post_name}\"><img src=\"{$attch_data->guid}\" alt=\"{$attch_data->post_title}\"></a>";

    wp_update_post( array(
        'ID' => $_SESSION['post_id'],
        'post_content' => $_kontent
    ) );
}

return $attach_ID;