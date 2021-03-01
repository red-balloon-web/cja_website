<?php
/**
 * Create CSV Array
 * 
 * Displays export CSV button on user search pages
 * Builds $csv_data_array from search data which can then be turned into CSV
 * 
 * Included in:
 * page-search-courses.php 
 */ ?>
 
<form action="<?php echo get_site_url(); ?>/search-courses?output_csv=true" method="post"> <?php
    foreach($_POST as $key => $value) {
        if (!is_array($value)) { ?>
            <input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>"><?php
        } else {
            foreach($value as $single_value) {
                ?><input type="hidden" name="<?php echo $key; ?>[]" value="<?php echo $single_value; ?>"><?php
            }
        }
    }?>
    <input type="submit" class="cja_button" value="Export Results as CSV File">
    </form>
    <?php

// Initialise array
$csv_data_array = [];
$distance_header = 'Distance in miles from ' . $cja_current_user_obj->postcode;

// Set header row
$array_row = array(
    'Course Code', 
    'Course Title', 
    'Course Description',
    'Advertiser Code',
    'Advertiser',
    $distance_header,
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

// Loop through and add records to CSV
foreach($cja_results_array as $cja_result) {
    $current_course = new CJA_Course_Advert($cja_result['id']);
    $array_row = [];
    $array_row[] = get_cja_code($current_course->id);
    $array_row[] = $current_course->title;
    $array_row[] = $current_course->description;
    $array_row[] = get_cja_user_code($current_course->author);
    $array_row[] = $current_course->author_human_name;
    if ($cja_result['distance'] != -1) {
        $array_row[] = $cja_result['distance'];
    } else {
        $array_row[] = '';
    }
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