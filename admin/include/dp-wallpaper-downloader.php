<?php

require __DIR__.'/vendor/autoload.php';
include_once "GoogleImageGrabber.php";
$dpKeywords = nl2br($_POST['dp-keywords']);
$dpKeywords = explode(PHP_EOL, $dpKeywords);
// var_dump($ids);
$gid = new GoogleImageGrabber();

// $idx = 1;
$uploadDir = wp_upload_dir()['basedir'];
$milliseconds = round(microtime(true) * 1000);

if (isset($_POST['dp-downloader-status'])) {
    $myfile = fopen("$uploadDir/wallpapers-$milliseconds.txt", "w") or die("Unable to open file!"); // buat file text untuk nampung data wallpaper
    foreach ($dpKeywords as $keyword) {
        $images = $gid->grab($keyword);

        //var_dump($images);

        foreach ($images as $image) {
            // echo "$idx - ";
            $namafile = $image['title'];
            $filetype = $image['filetype'];
            $lokasi = $image['url'];
            // $idx ++;

            // rename it
            $namafile = preg_replace("/[^ \w]+/", "", $namafile);
            $namafile = str_replace(" ", "_", $namafile);
            $namafile = strtolower($namafile);

            // download image
            //$image = file_get_contents($lokasi);
            //file_put_contents("$uploadDir/$namafile.$filetype", $image);
            $txt = "$namafile.$filetype>$lokasi\n";
            fwrite($myfile, $txt);
        }
    }
}
fclose($myfile); // tutup file penampung data wallpaper

