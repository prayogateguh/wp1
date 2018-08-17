<?php

if (isset($_POST['dp-downloader-status'])) {
    update_option('dp-download-status', '1');
    update_option('dp-download-keywords', $_POST['dp-keywords']);
    update_option('dp-download-total', $_POST['dp-download-perkeyword']);
    echo '<meta http-equiv="refresh" content="0">'; // refresh browser
    if (! wp_next_scheduled ( 'dp_download_keywords' )) { // do the download process using wp cron
        wp_schedule_single_event( time(), 'dp_download_keywords' );
    }
}
