<?php

require ABSPATH . '/wp-content/themes/courses-and-jobs/inc/fmn/FindMyNearest.php';
$fmn_file_address = get_stylesheet_directory_uri() . '/inc/fmn/data/postcodes.txt';
$fmn = FindMyNearest::factory('textfile', array('datafile' => $fmn_file_address));
if (! $fmn->loaddata()) {
    echo "Error loading data: " . $fmn->lasterror() . "\n";
    exit;
}

// Set up user object
if (!$cja_current_user_obj->postcode) {
    ?><p class="cja_alert cja_alert--amber"><a href="<?php echo get_site_url() . $cja_config['user-details-page-slug']; ?>">Set your postcode</a> to search and order jobs by distance</p><?php
}