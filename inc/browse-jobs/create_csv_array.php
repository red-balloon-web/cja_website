<?php

/**
 * Create CSV Array 
 * 
 * Displays export CSV button on user search pages
 * Builds $csv_data_array from search data which can then be turned into CSV
 * 
 * Included in:
 * page-search-jobs.php
 * 
 */ ?>

<form action="<?php echo get_site_url(); ?>/search-jobs?output_csv=true" method="post"> <?php
    foreach($_POST as $key => $value) {
        if (!is_array($value)) { ?>
            <input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>"><?php
        } else {
            foreach($value as $single_value) {
                ?><input type="hidden" name="<?php echo $key; ?>[]" value="<?php echo $single_value; ?>"><?php
            }
        }
    } ?>
    <input type="submit" class="cja_button" value="Export Results as CSV File">
    </form>
    <?php

// Initialise array
$csv_data_array = [];
$distance_header = 'Distance in miles from ' . $cja_current_user_obj->postcode;

// Set header row
$array_row = array(
    'Job Code', 
    'Job Title',
    'Job Description', 
    'Advertiser Code',
    'Advertiser',
    $distance_header,
    'Salary',
    'Salary per',
    'Payment Frequency',
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

// Loop through and add records to CSV
foreach($cja_results_array as $cja_result) {
    $current_job = new CJA_Advert($cja_result['id']);
    $array_row = [];
    $array_row[] = get_cja_code($current_job->id);
    $array_row[] = $current_job->title;
    $array_row[] = $current_job->content;
    $array_row[] = get_cja_user_code($current_job->author);
    $array_row[] = $current_job->author_human_name;
    if ($cja_result['distance'] != -1) {
        $array_row[] = $cja_result['distance'];
    } else {
        $array_row[] = '';
    }
    $array_row[] = $current_job->salary_numeric;
    $array_row[] = $current_job->salary_per;
    $array_row[] = $current_job->payment_frequency;
    $array_row[] = $current_job->return_human('deadline');
    $array_row[] = $current_job->return_human('sector');
    $array_row[] = $current_job->return_human('job_type');
    $array_row[] = $current_job->return_human('career_level');
    $array_row[] = $current_job->return_human('experience_required');
    $array_row[] = $current_job->return_human('minimum_qualification');
    $array_row[] = $current_job->return_human('dbs_required');
    $array_row[] = $current_job->return_human('shift_work');
    $array_row[] = $current_job->return_human('location_options');
    $array_row[] = $current_job->more_information;
    $array_row[] = $current_job->return_human('employer_type');
    $array_row[] = $current_job->postcde;
    $array_row[] = $current_job->contact_person;
    $array_row[] = $current_job->contact_phone_number;
    $csv_data_array[] = $array_row;
}