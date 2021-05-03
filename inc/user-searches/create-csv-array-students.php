<?php

/**
 * Create CSV Array 
 * 
 * Builds $csv_data_array from search data which can then be turned into CSV
 * 
 * Included in:
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
    'Phone Number',
    'Email Address',
    'Town/City',
    'Profile Status',
    'Pre-Trained',
    'Date Registered',
    $distance_header,
    'GCSE Maths',
    'GCSE English',
    'Functional Skills Maths',
    'Functional Skills English',
    'Highest Qualification',
    'Upskilling and CPD Status',
    'Opportunities Sought',
    'Courses FT/PT',
    'Course Sought',
    'Student or advanced learner loan',
    'Looking for a course to progress to university',
    'Looking for a course to enter employment',
    'Specialism Area(s)',
    'Weekends Availability',
    'Age Category',
    'Current Status',
    'Unemployed',
    'Receiving Benefits',
    'DBS Yes/No',
    'Current Availability',
    'How far can you travel',
    'Prevent or Safeguarding training',
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
    $array_row[] = $current_user->phone;
    $array_row[] = $current_user->email;
    $array_row[] = $current_user->town_city;
    $array_row[] = $current_user->return_field('profile_status');
    $array_row[] = $current_user->return_field('pre_trained');
    $array_row[] = $current_user->date_registered;
    if ($cja_result['distance'] != -1) {
        $array_row[] = $cja_result['distance'];
    } else {
        $array_row[] = '';
    }
    $array_row[] = $current_user->return_field('gcse_maths');
    $array_row[] = $current_user->return_field('gcse_english');
    $array_row[] = $current_user->return_field('functional_maths');
    $array_row[] = $current_user->return_field('functional_english');
    $array_row[] = $current_user->return_field('highest_qualification');
    $array_row[] = $current_user->return_field('upskill_status');
    $array_row[] = $current_user->return_field('opportunity_required');
    $array_row[] = $current_user->return_field('course_time');
    $array_row[] = $current_user->return_field('what_course');
    $array_row[] = $current_user->return_field('looking_for_loan');
    $array_row[] = $current_user->return_field('progress_to_university');
    $array_row[] = $current_user->return_field('progress_to_employment');
    $array_row[] = $current_user->return_field('specialism_area');
    $array_row[] = $current_user->return_field('weekends_availability');
    $array_row[] = $current_user->age_category;
    $array_row[] = $current_user->return_field('current_status');
    $array_row[] = $current_user->return_field('unemployed');
    $array_row[] = $current_user->return_field('receiving_benefits');
    $array_row[] = $current_user->return_field('dbs');
    $array_row[] = $current_user->return_field('current_availability');
    $array_row[] = $current_user->return_field('how_far_travel');
    $array_row[] = $current_user->return_field('prevent_safeguarding');
    $array_row[] = $current_user->return_field('contact_preference');
    $array_row[] = $current_user->return_field('company_description');
    $csv_data_array[] = $array_row;
}