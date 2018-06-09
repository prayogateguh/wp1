<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://devtey.com/
 * @since      1.0.0
 *
 * @package    Devtey_Poster
 * @subpackage Devtey_Poster/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="dp-container">
    <h2 class="devtey-title">Tentang Devtey</h2>
    <hr>
    <p>Devtey berada di Internet, namun kantornya di Yogyakarta, homepage di <a href="https://devtey.com/" target="_blank">Devtey.com</a>,<br> Untuk tutorial cara penggunaan Plugin Devtey Poster, silakan kunjungi dokumentasinya di <a href="https://devtey.com/plugins/poster/" target="_blank">sini</a>.
    </p>
    <p>
        Jika ada error pada saat Hapus Exif, silakan klik di <a href="<?php echo plugin_dir_url( __FILE__ ) . '../include/info.php'; ?>" target="_blank">sini</a>. Kemudian, CTRL+F (sarch) ketikkan "gd" dan pastikan GD support telah "enabled". Perhatikan gambar di bawah.
        <img src="<?php echo plugin_dir_url( __FILE__ ) . '../../images/admin/gd.PNG'; ?>"> 
    </p>
    <p>Salam</p><hr>
    <ol>
        <li>Prayoga Teguh</li>
        <li>Yupi Firdaus</li>
    </ol>
</div>