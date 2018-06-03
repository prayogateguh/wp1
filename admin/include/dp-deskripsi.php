<?php
error_reporting(E_PARSE);
function desc_format($content, $post, $attch, $gallery) {
    // var_dump($attch);
    preg_match_all('/({{.*?}})/', $content, $matches);

    $cat_name = get_cat_name($post->post_category[0]);
    $category_link = get_category_link($post->post_category[0]);
    $tags = get_the_tags($post->ID);
    $i = 0;
    foreach($tags as $tag) {
        if ($i == 0) {
            $_tags = '<a href="/tag/'.$tag->slug.'/">#'.ucwords($tag->name).'</a>';
        } else {
            $_tags = $_tags . ', ' . '<a href="/tag/'.$tag->slug.'/">#'.ucwords($tag->name).'</a>';
        }
        $i++; 
    }
    $attch_img = getimagesize($attch->guid);

    $_author = get_the_author_meta('display_name', $post->post_author);
    $_post_title = $post->post_title;
    $_post_date = date('l, d/F/Y', strtotime($post->post_date));
    $_post_cats = "<a href=\"{$category_link}\" title=\"{$cat_name}\">{$cat_name}</a>";
    $_post_tags = $_tags;
    $_post_attch_name = $attch->post_title;
    //$_post_attch_page = get_attachment_link($attch->ID);
    $_post_attch_page = $attch->post_name;
    $_post_attch_url = $attch->guid;
    $_post_attch_res = "{$attch_img[0]}x{$attch_img[1]}";
    $_post_attch_size = size_format(filesize( get_attached_file( $attch->ID ) ));

    $search = array(
        '{{post_author}}',
        '{{post_title}}',
        '{{post_date}}',
        '{{post_cats}}',
        '{{post_tags}}',
        '{{attch_img_name}}',
        '{{attch_img_page}}',
        '{{attch_img_loc}}',
        '{{attch_img_res}}',
        '{{attch_img_size}}',
    );
    $replace = array(
        ucwords($_author),
        $_post_title,
        $_post_date,
        $_post_cats,
        $_post_tags,
        $_post_attch_name,
        $_post_attch_page,
        $_post_attch_url,
        $_post_attch_res,
        $_post_attch_size
    );
    $deskripsi = str_replace($search, $replace, $content);
    return "$deskripsi {$gallery}";
}