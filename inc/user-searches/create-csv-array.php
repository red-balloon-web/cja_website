<?php

/**
 * Create CSV Array 
 * 
 * Builds $csv_data_array from search data which can then be turned into CSV
 * 
 * Included in:
 * page-search-cvs.php 
 * page-search-students.php 
 * 
 */ 

// Initialise array 
$csv_data_array = [];
$distance_header = 'Distance in miles from ' . $cja_current_user_obj->postcode;

// Set header row
$array_row = array(
    'ID', 
    'First Name',
    'Last Name', 
    'Town/City',
    $distance_header,
    'Age Category',
    'GCSE Maths',
    'GCSE English',
    'Functional Skills Maths',
    'Functional Skills English',
    'Highest Qualification',
    'Opportunities Required',
    'Courses FT/PT',
    'Jobs FT/PT',
    'Job Role(s)',
    'Cover Work',
    'Weekends Availability',
    'Specialism Area(s)',
    'Current Status',
    'Unemployed',
    'Receiving Benefits',
    'Contact Preference',
    'Profile'
);
$csv_data_array[] = $array_row;

// Loop through and add records to CSV
foreach($cja_results_array as $cja_result) {
    $current_user = new CJA_User($cja_result['id']);
    $array_row = [];
    $array_row[] = get_cja_user_code($current_user->id);
    $array_row[] = $current_user->first_name;
    $array_row[] = $current_user->last_name;
    $array_row[] = $current_user->town_city;
    if ($cja_result['distance'] != -1) {
        $array_row[] = $cja_result['distance'];
    } else {
        $array_row[] = '';
    }
    $array_row[] = $current_user->age_category;
    $array_row[] = $current_user->return_field('gcse_maths');
    $array_row[] = $current_user->return_field('gcse_english');
    $array_row[] = $current_user->return_field('functional_maths');
    $array_row[] = $current_user->return_field('functional_english');
    $array_row[] = $current_user->return_field('highest_qualification');
    $array_row[] = $current_user->return_field('opportunity_required');
    $array_row[] = $current_user->return_field('course_time');
    $array_row[] = $current_user->return_field('job_time');
    $array_row[] = $current_user->return_field('job_role');
    $array_row[] = $current_user->return_field('cover_work');
    $array_row[] = $current_user->return_field('weekends_availability');
    $array_row[] = $current_user->return_field('specialism_area');
    $array_row[] = $current_user->return_field('current_status');
    $array_row[] = $current_user->return_field('unemployed');
    $array_row[] = $current_user->return_field('receiving_benefits');
    $array_row[] = $current_user->return_field('contact_preference');
    $array_row[]= $current_user->return_field('company_description');
    $csv_data_array[] = $array_row;
}