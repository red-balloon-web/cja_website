<?php

// Remove any jobs already applied to if required
if (!$cja_search->show_applied && $search_type != 'classified') {
    foreach($cja_results_array as $cja_result => $sub_array) {
        if ($search_type == 'job') {
            $cja_check_applied = new CJA_Advert($sub_array['id']);
        }
        if ($cja_check_applied->applied_to_by_current_user) {
            unset($cja_results_array[$cja_result]);
        }
    }
}

// Remove any blank distances from array if required
if ($cja_search->order_by == 'distance' || $cja_search->max_distance) {
    foreach($cja_results_array as $cja_result => $sub_array) {
        if($sub_array['distance'] == -1 || $sub_array['distance'] === FALSE) {
            unset($cja_results_array[$cja_result]);
        }
    }
}

// Remove any entries over the maximum distance, if set
if ($cja_search->max_distance) {
    foreach($cja_results_array as $cja_result => $sub_array) {
        if($sub_array['distance'] > $cja_search->max_distance) {
            unset($cja_results_array[$cja_result]);
        }
    }
}

// Sort the array by distance if required
if ($cja_search->order_by == 'distance') {
    $cja_distance = array_column($cja_results_array, 'distance');
    array_multisort($cja_distance, SORT_ASC, $cja_results_array);
}