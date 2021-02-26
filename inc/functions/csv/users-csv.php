<?php

add_action( 'admin_notices', 'users_csv_button' );
function users_csv_button() {

    global $pagenow;
    if (is_admin() && 'users.php' == $pagenow) { ?>

        <form id="user-csv-form" action="<?php echo get_site_url(); ?>/wp-admin/admin-post.php?action=users-csv" target="_blank" method="post">
        <?php 

        foreach ($_GET as $key => $value) {
            if ($key != 'action' && !is_array($value)) { ?>
                <input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>"><?php   
            } else if ($key != 'action' && is_array($value)) {
                foreach($value as $val) { ?>
                <input type="hidden" name="<?php echo $key; ?>[]" value="<?php echo $val; ?>"><?php
                }
            }
        } ?>
        </form><?php 
    }
}


add_action( 'admin_post_users-csv', 'users_csv');
function users_csv() {

    $csv_data_array = [];
    // Set header row
    $array_row = array(
        'ID', 
        'First Name',
        'Last Name', 
        'Phone Number',
        'Email Address',
        'Town/City',
        'GCSE Maths',
        'GCSE English',
        'Functional Skills Maths',
        'Functional Skills English',
        'Highest Qualification',
        'Opportunities Sought',
        'Jobs FT/PT',
        'Preferred Job Role(s)',
        'Cover Work',
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

    $cja_user = new CJA_User();
    $cja_user->updateFromForm();
    //$args = $cja_user->build_wp_query();
    //print_r($args);
    $the_query = new WP_User_Query($cja_user->build_wp_query());
    $the_results_array = $the_query->get_results();
    foreach($the_results_array as $result) {
        $current_iteration_id = $result->data->ID;
        $current_user = new CJA_User($current_iteration_id);
        $array_row = [];
        $array_row[] = get_cja_user_code($current_user->id);
        $array_row[] = $current_user->first_name;
        $array_row[] = $current_user->last_name;
        $array_row[] = $current_user->phone;
        $array_row[] = $current_user->email;
        $array_row[] = $current_user->town_city;
        $array_row[] = $current_user->return_field('gcse_maths');
        $array_row[] = $current_user->return_field('gcse_english');
        $array_row[] = $current_user->return_field('functional_maths');
        $array_row[] = $current_user->return_field('functional_english');
        $array_row[] = $current_user->return_field('highest_qualification');
        $array_row[] = $current_user->return_field('opportunity_required');
        $array_row[] = $current_user->return_field('job_time');
        $array_row[] = $current_user->return_field('job_role');
        $array_row[] = $current_user->return_field('cover_work');
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
        $array_row[]= $current_user->return_field('company_description');
        $csv_data_array[] = $array_row;
    }

    outputCsv('CJA_Users.csv', $csv_data_array);
}