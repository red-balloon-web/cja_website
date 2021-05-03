<?php
/**
 * FUNCTIONS TO EXPORT FILTERED/UNFILTERED LIST OF JOBS/COURSES/CLASSIFIEDS FROM ADMIN SCREENS FOR EACH POST TYPE
 */

// ADD EXPORT AS CSV FORM CONTAINING ALL GET DATA SENT TO THE PAGE
add_action( 'admin_notices', 'custom_post_type_csv_button' );
function custom_post_type_csv_button() {

    global $pagenow;
    if (is_admin() && 'edit.php' == $pagenow && ($_GET['post_type'] == 'job_ad' || $_GET['post_type'] == 'course_ad' || $_GET['post_type'] == 'classified_ad')) { ?>

        <form id="custom-post-type-csv-form" action="<?php echo get_site_url(); ?>/wp-admin/admin-post.php?action=custom-post-type-csv" target="_blank" method="post">

            <input type="hidden" name="post_type" value="<?php $_GET['post_type']; ?>">
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

// CREATE AND EXPORT THE CSV FILE
add_action( 'admin_post_custom-post-type-csv', 'custom_post_type_csv');
function custom_post_type_csv() {

    // JOB ADS
    if ($_POST['post_type'] == 'job_ad') {

        $csv_title = 'CJA-Jobs.csv';
        
        // Initialise array
        $csv_data_array = [];

        // Set header row
        $array_row = array(
            'Job Code', 
            'Job Title',
            'Job Description', 
            'Advertiser Code',
            'Advertiser',
            'Paid / Unpaid',
            'Salary',
            'Salary per',
            'Payment Frequency',
            'Posted',
            'Deadline',
            'Sector',
            'Job Type',
            'Career Level',
            'Experience Required',
            'Minimum Qualification',
            'DBS Required',
            'Shift Work',
            'Location Options',
            'Additional Information',
            'Employer Type',
            'Postcode',
            'Contact Person',
            'Contact Phone'
        );
        $csv_data_array[] = $array_row;

        // Custom Query
        $cja_jobsearch = new CJA_Advert();
        $cja_jobsearch->update_from_form();
        $args = $cja_jobsearch->build_wp_query();
        unset($args['meta_query'][0]); // remove active ads only
        print_r($args);
        $query = new WP_Query($args);
        while ($query->have_posts()) {
            $query->the_post();
            $current_post = new CJA_Advert(get_the_id());
            $array_row = [];
            $array_row[] = get_cja_code(get_the_id());
            $array_row[] = $current_post->title;
            $array_row[] = $current_post->content;
            $array_row[] = get_cja_code($current_post->author);
            $array_row[] = $current_post->author_human_name;
            $array_row[] = $current_post->return_human('salary_type');
            $array_row[] = $current_post->salary_numeric;
            $array_row[] = $current_post->salary_per;
            $array_row[] = $current_post->return_human('payment_frequency');
            $array_row[] = $current_post->human_activation_date;
            $array_row[] = $current_post->return_human('deadline');
            $array_row[] = $current_post->return_human('sector');
            $array_row[] = $current_post->return_human('job_type');
            $array_row[] = $current_post->return_human('career_level');
            $array_row[] = $current_post->return_human('experience_required');
            $array_row[] = $current_post->return_human('minimum_qualification');
            $array_row[] = $current_post->return_human('dbs_required');
            $array_row[] = $current_post->return_human('shift_work');
            $array_row[] = $current_post->return_human('location_options');
            $array_row[] = $current_post->more_information;
            $array_row[] = $current_post->return_human('employer_type');
            $array_row[] = $current_post->postcode;
            $array_row[] = $current_post->contact_person;
            $array_row[] = $current_post->contact_phone_number;
            $csv_data_array[] = $array_row;
        }
    }

    // COURSE ADS
    if ($_POST['post_type'] == 'course_ad') {

        $csv_title = 'CJA-Courses.csv';
        
        // Initialise array
        $csv_data_array = [];

        // Set header row
        $array_row = array(
            'Course Code', 
            'Course Title', 
            'Course Description',
            'Advertiser Code',
            'Advertiser',
            'Posted',
            'Deadline',
            'Offer Type',
            'Category',
            'Sector',
            'Qualification Level',
            'Total Units',
            'Awarding Body',
            'Duration',
            'Delivery Route',
            'Career Level',
            'Available to Start',
            'Price for Students not Eligible for Funding',
            'Deposit Required',
            'Experience Required',
            'Previous Qualification Required',
            'Course Pathway',
            'Course Funding Options',
            'Payment Plan',
            'DBS Required',
            'Allowance Available',
            'Social Services - Service Users',
            'Suitable for those on Benefits',
            'Additional Information'
        );
        $csv_data_array[] = $array_row;

        // Custom Query
        $cja_jobsearch = new CJA_Course_Advert();
        $cja_jobsearch->update_from_form();
        $args = $cja_jobsearch->build_wp_query();
        unset($args['meta_query'][0]); // remove active ads only
        print_r($args);
        $query = new WP_Query($args);
        while ($query->have_posts()) {
            $query->the_post();
            $current_course = new CJA_Course_Advert(get_the_id());
            $array_row = [];
            $array_row[] = get_cja_code($current_course->id);
            $array_row[] = $current_course->title;
            $array_row[] = $current_course->description;
            $array_row[] = get_cja_user_code($current_course->author);
            $array_row[] = $current_course->author_human_name;
            $array_row[] = $current_course->human_activation_date;
            $array_row[] = $current_course->return_human('deadline');
            $array_row[] = $current_course->return_human('offer_type');
            $array_row[] = $current_course->return_human('category');
            $array_row[] = $current_course->return_human('sector');
            $array_row[] = $current_course->return_human('qualification_level');
            $array_row[] = $current_course->return_human('total_units');
            $array_row[] = $current_course->return_human('awarding_body');
            $array_row[] = $current_course->return_human('duration');
            $array_row[] = $current_course->return_human('delivery_route');
            $array_row[] = $current_course->return_human('career_level');
            $array_row[] = $current_course->return_human('available_start');
            $array_row[] = $current_course->price;
            $array_row[] = $current_course->return_human('deposit_required');
            $array_row[] = $current_course->return_human('experience_required');
            $array_row[] = $current_course->return_human('previous_qualification');
            $array_row[] = $current_course->return_human('course_pathway');
            $array_row[] = $current_course->return_human('funding_options');
            $array_row[] = $current_course->return_human('payment_plan');
            $array_row[] = $current_course->return_human('dbs_required');
            $array_row[] = $current_course->return_human('allowance_available');
            $array_row[] = $current_course->return_human('social_services');
            $array_row[] = $current_course->return_human('suitable_benefits');
            $array_row[] = $current_course->more_information;
            $csv_data_array[] = $array_row;
        }
    }

    // CLASSIFIED ADS
    if ($_POST['post_type'] == 'classified_ad') {

        $csv_title = 'CJA-Classifieds.csv';
        
        // Initialise array
        $csv_data_array = [];

        // Set header row
        $array_row = array(
            'Advert Code', 
            'Posted',
            'Advert Title', 
            'Advertiser Code',
            'Advertiser',
            'Category',
            'Postcode',
            'Phone Number',
            'Email'
        );
        $csv_data_array[] = $array_row;

        // Custom Query
        $cja_classifiedsearch = new CJA_Classified_Advert();
        $cja_classifiedsearch->update_from_form();
        $args = $cja_classifiedsearch->build_wp_query();
        unset($args['meta_query'][0]); // remove active ads only
        print_r($args);
        $query = new WP_Query($args);
        while ($query->have_posts()) {
            $query->the_post();
            $current_advert = new CJA_Classified_Advert(get_the_id());
            $array_row = [];
            $array_row[] = get_cja_code($current_advert->id);
            $array_row[] = $current_advert->human_activation_date;
            $array_row[] = $current_advert->title;
            $array_row[] = get_cja_user_code($current_advert->author);
            $array_row[] = $current_advert->author_human_name;
            $array_row[] = $current_advert->return_human('category');
            $array_row[] = $current_advert->postcode;
            $array_row[] = $current_advert->phone;
            $array_row[] = $current_advert->email;
            $csv_data_array[] = $array_row;
        }
    }

    outputCsv($csv_title, $csv_data_array);
}