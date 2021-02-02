<?php

// Now return just the page of the array that we want to look at
$cja_total_results = count($cja_results_array);
$cja_results_per_page = get_option( 'posts_per_page' );
$cja_pages = ceil($cja_total_results / $cja_results_per_page);
if ($_GET['cjapage']) {
    $cja_page = $_GET['cjapage'];
} else {
    $cja_page = 1;
}
$cja_first_result = ($cja_page - 1) * $cja_results_per_page; 
$cja_results_array_paged = array_slice($cja_results_array, $cja_first_result, $cja_results_per_page);