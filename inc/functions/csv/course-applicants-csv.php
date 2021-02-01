<?php
/**
 * Create course applicants CSV
 * Creates CSV of applicants for any given job
 */

add_action( 'admin_post_create-course-applicants-csv', 'create_course_applicants_csv');
function create_course_applicants_csv() {

    // Get the ID of the ad we're looking for
    $advert_id = $_GET['advert_id'];

    // Make sure that the ad belongs to the current user and they're not playing with the URL
    $advert = new CJA_Course_Advert($advert_id);
    if ($advert->author != get_current_user_id()) {
        exit;
    }

    // Initialise CSV array
    $csv_array = array(
        array(
            'Applicant Code',
            'First Name',
            'Last Name',
            'Application Date',
            'Town/City',
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
        )
    );


    // Retrieve all applications for this job
    $args = array(
        'post_type' => 'course_application',
        'meta_key' => 'advertID',
        'meta_value' => $advert_id,
        'orderby'=> 'date'
    );
    $query = new WP_Query($args);

    // Loop through applications
    if ($query->have_posts()) {
        while($query->have_posts()) {
            $query->the_post();

            // Populate new array row
            $current_application = new CJA_Course_Application(get_the_ID());
            $current_applicant = new CJA_User($current_application->applicant_ID);
            $current_advert = new CJA_Course_Advert($current_application->advert_ID);
            $csv_title = 'Applicants for ' . get_cja_code($current_advert->id) . ' ' . $current_advert->title . '.csv';
            $csv_row = [];
            
            $csv_row[] = get_cja_user_code($current_applicant->id); // code
            $csv_row[] = $current_applicant->first_name;
            $csv_row[] = $current_applicant->last_name;
            $csv_row[] = $current_application->human_application_date;
            $csv_row[] = $current_applicant->town_city;
            $csv_row[] = $current_applicant->age_category;
            $csv_row[] = $current_applicant->return_field('gcse_maths');
            $csv_row[] = $current_applicant->return_field('gcse_english');
            $csv_row[] = $current_applicant->return_field('functional_maths');
            $csv_row[] = $current_applicant->return_field('functional_english');
            $csv_row[] = $current_applicant->return_field('highest_qualification');
            $csv_row[] = $current_applicant->return_field('opportunity_required');
            $csv_row[] = $current_applicant->return_field('course_time');
            $csv_row[] = $current_applicant->return_field('job_time');
            $csv_row[] = $current_applicant->return_field('job_role');
            $csv_row[] = $current_applicant->return_field('cover_work');
            $csv_row[] = $current_applicant->return_field('weekends_availability');
            $csv_row[] = $current_applicant->return_field('specialism_area');
            $csv_row[] = $current_applicant->return_field('current_status');
            $csv_row[] = $current_applicant->return_field('unemployed');
            $csv_row[] = $current_applicant->return_field('receiving_benefits');
            $csv_row[] = $current_applicant->return_field('contact_preference');
            $csv_row[] = $current_applicant->return_field('company_description');

            // Push to master csv array
            $csv_array[] = $csv_row;
        }
    }
    
    outputCsv($csv_title, $csv_array);
    exit;
}