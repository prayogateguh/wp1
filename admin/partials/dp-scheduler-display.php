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
    <div class="devtey-label-title">Status: <span class="dp-scheduler-status">Tidak Aktif</span></div>
    <hr>

    <form>

        <label for="post-title" class="devtey-label-title">Jumlah Post Perpublish</label>
        <input name="post-title" type="text" id="post-title" placeholder="Jumlah post per-publish | Contoh: 3 (akan mem-publish 3 posting persatu waktu)" class="devtey-form">

        <label for="post-title" class="devtey-label-title">Rentang Posting</label>
        <input name="post-title" type="text" id="post-title" placeholder="Rentang waktu setiap publish, format = HH:MM:SS | Contoh: 01:00:00 (akan mempublish satu jam sekali)" class="devtey-form">

        <div class="devtey-toggle">
            <label class="switch">
                <input type="checkbox">
                <span class="slider"></span>
            </label>
            <label class="desc">
                <span class="title devtey-label-title">Acak Posting?</span>
                <span class="desc">(Jika aktif, maka posting akan diacak sebelum dipublish.)</span>
            </label>
        </div>

        <div><input type="submit" value="Aktifkan" class="devtey-submit"></div>

    </form>
</div>