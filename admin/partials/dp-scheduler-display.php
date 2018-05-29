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
    <h2 class="devtey-title">Post Scheduler</h2>
    <?php if ( get_option('dp-aktif') ) { ?>
    <div class="devtey-label-title">Status: <span class="dp-scheduler-status dp-aktif">Aktif</span></div>
    <?php } else { ?>
    <div class="devtey-label-title">Status: <span class="dp-scheduler-status dp-nonaktif">Tidak Aktif</span></div>
    <?php } ?>
    <hr>

    <form method="post" action="options.php" class="dp-form">
        <?php settings_fields( 'dp-scheduler-settings' ); ?>
        <?php do_settings_sections( 'dp-scheduler-settings' ); ?>
        <label for="post-title" class="devtey-label-title">Jumlah Post Perpublish</label>
        <input name="dp-jml-post" type="text" id="post-title" placeholder="Jumlah post per-publish | Contoh: 3 (akan mem-publish 3 posting persatu waktu)" class="devtey-form" value="<?php echo esc_attr( get_option('dp-jml-post') ); ?>">

        <label for="post-title" class="devtey-label-title">Rentang Posting</label>
        <input name="dp-rtg-post" type="text" id="post-title" placeholder="Rentang waktu setiap publish, format = HH:MM:SS | Contoh: 01:00:00 (akan mempublish satu jam sekali)" class="devtey-form" value="<?php echo esc_attr( get_option('dp-rtg-post') ); ?>">

        <div class="devtey-toggle">
            <label class="switch">
                <input type="checkbox" name="dp-ack-post" value="1" <?php checked( get_option('dp-ack-post') ); ?>>
                <span class="slider"></span>
            </label>
            <label class="desc">
                <span class="title devtey-label-title">Acak Posting?</span>
                <span class="desc">(Jika aktif, maka posting akan diacak sebelum dipublish.)</span>
            </label>
        </div>

        <div>
        <?php if ( get_option('dp-aktif') == 0 ) { ?>
            <input type="hidden" name="dp-aktif" value="1">
            <?php submit_button( 'Aktifkan', 'primary aktif' ); ?>
        <?php } else { ?>
            <input type="hidden" name="dp-aktif" value="0">
            <?php submit_button( 'Non Aktifkan', 'non-aktif' ); ?>
        <?php } ?>
        </div>

    </form>
</div>