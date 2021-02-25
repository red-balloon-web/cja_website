<?php

/*
$args = array(
    'role' => 'jobseeker',
    'orderby' => 'ID'
);

$the_query = new WP_User_Query($args);
$returned_users = $the_query->get_results();
if (!empty($the_query)) {
    foreach($returned_users as $returned_user) {
        $current_iteration_user_id = $returned_user->data->ID;
        update_user_meta($current_iteration_user_id, 'profile_status', 'available');
        echo "User ID: $current_iteration_user_id <br>"; 
    }
}

*/
