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
    <?php if ( get_option('dp-scheduler-status') ) { ?>
    <div class="devtey-label-title">Scheduler status: <span class="dp-scheduler-status dp-aktif" style="padding:2px;">on</span></div>
    <?php } else { ?>
    <div class="devtey-label-title">Scheduler status: <span class="dp-scheduler-status dp-nonaktif" style="padding:2px;">off</span></div>
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

        <div class="submit">
            <?php if ( get_option('dp-scheduler-status') == 0 ) { ?>
                <input type="hidden" name="dp-scheduler-status" value="1">
                <input type="submit" value="Hidupkan" class="button button-primary aktif">
            <?php } else { ?>
                <input type="hidden" name="dp-scheduler-status" value="0">
                <input type="submit" value="Matikan" class="button non-aktif">
            <?php } ?>
        </div>
        <?php
            if (get_option('dp-scheduler-status') == 1) { // start the scheduler
                wp_clear_scheduled_hook('dp_scheduler_hook');
                $timesecs = $this->dp_rentang(get_option('dp-rtg-post'));
                wp_schedule_event( time() + $timesecs, 'dp_schedule', 'dp_scheduler_hook' );
            } else {
                wp_clear_scheduled_hook('dp_scheduler_hook');
            }
        ?>

    </form>
</div>