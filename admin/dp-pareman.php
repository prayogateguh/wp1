<?php
if (isset($_REQUEST['dp_off'])) {
    $license_key = $_REQUEST['dp_key'];

    // API query parameters
    $api_params = array(
        'slm_action' => 'slm_deactivate',
        'secret_key' => DP_SK,
        'license_key' => $license_key,
        'registered_domain' => $_SERVER['SERVER_NAME'],
        'item_reference' => urlencode(DP_IR),
    );

    // Send query to the license manager server
    $query = esc_url_raw(add_query_arg($api_params, DP_SU));
    $response = wp_remote_get($query, array('timeout' => 20, 'sslverify' => true));

    // Check for error in the response
    if (is_wp_error($response)){
        echo "Unexpected Error! The query returned with an error.";
    }
    
    // License data.
    $license_data = json_decode(wp_remote_retrieve_body($response));
    //var_dump($license_data);
    if($license_data->result == get_option('dp_info')){//Success was returned for the license activation
        update_option('dp_poster', '0');
        update_option('dp_key', '');
        echo '<meta http-equiv="refresh" content="0">';
    }
    
}