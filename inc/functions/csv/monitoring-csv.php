<?php
/**
 * Print Monitoring CSV
 * This function exports the monitoring table as a csv
 * 
 * Todo: remove CSV functions from monitoring page, this is just that page duplicated with the screen bits stripped out
 */

add_action( 'admin_post_print-monitoring.csv', 'print_monitoring_csv' );
function print_monitoring_csv() {

    $data_array = array();

    // Get start and end dates sent to page
    if($_POST['start_date']) {
        $first_date = $_POST['start_date'];
        $last_date = $_POST['end_date'];
    }

    // If we have a start date let's make a csv
    if ($_POST['start_date']) {

        // Convert to DateTime objects and echo table header
        $real_first_date = new DateTime($first_date);
        $real_last_date = new DateTime($last_date);
        $title = $real_first_date->format('D jS F Y') . ' - ' . $real_last_date->format('D jS F Y');
        $interval = new DateInterval('P1D'); 
        $real_last_date->add($interval); // add one day to end because DatePeriod will not include the final date
        
        // Initialise CSV data
        $csv_title = $title . '.csv';
        $csv_data_array = array();

        // Create date array for period
        $dates = array();
        $period = new DatePeriod($real_first_date, $interval, $real_last_date);
        foreach ($period as $key => $value) {
            $single_date = $value->format('Y-m-d');
            $dates[] = $single_date;      
        }

        // CSV Header Line
        $csv_data_array[] = array('Date', 'New Jobs', 'New Courses', 'New Classifieds', 'Job Applications', 'Course Applications', 'New Advertisers', 'New Course/Job Seekers', 'Course Seekers', 'Job Seekers');

        // go through dates one at a time and display
        foreach ($dates as $date) {

            // initialise CSV line
            $csv_data_line = array();

            $date_time = new DateTime($date);
            $year = $date_time->format('Y');
            $month = $date_time->format('m');
            $day = $date_time->format('d');
            $csv_data_line[] = $date_time->format('D d M');
            
            // job ads
            $args = array(
                'post_type' => 'job_ad',
                'date_query' => array(
                    'year' => $year,
                    'month' => $month,
                    'day' => $day
                )
            );
            $query = new WP_Query($args);
            $csv_data_line[] = $query->found_posts;

            // course ads
            $args['post_type'] = 'course_ad';
            $query = new WP_Query($args);
            $csv_data_line[] = $query->found_posts;

            // classified ads
            $args['post_type'] = 'classified_ad';
            $query = new WP_Query($args);
            $csv_data_line[] = $query->found_posts;

            // job applications
            $args['post_type'] = 'application';
            $query = new WP_Query($args);
            $csv_data_line[] = $query->found_posts;

            // course applications
            $args['post_type'] = 'course_application';
            $query = new WP_Query($args);
            $csv_data_line[] = $query->found_posts;

            // advertisers
            $args = array(
                'role' => 'advertiser',
                'date_query' => array(
                    'year' => $year,
                    'month' => $month,
                    'day' => $day
                )
            );
            $query = new WP_User_Query($args);
            $csv_data_line[] = $query->get_total();

            // jobseekers
            $args['role'] = 'jobseeker';
            $query = new WP_User_Query($args);
            $csv_data_line[] = $query->get_total();

            
            // get totals of is_jobseeker and is_student
            $this_day_jobseekers = 0;
            $this_day_courseseekers = 0;
            if ( ! empty( $query->get_results() ) ) {
                foreach ( $query->get_results() as $user ) {
                    $cja_user = new CJA_User ($user->id);
                    if ($cja_user->is_jobseeker) {
                        $this_day_jobseekers++;
                    }
                    if ($cja_user->is_student) {
                        $this_day_courseseekers++;
                    }
                }
            }

            $csv_data_line[] = $this_day_courseseekers;
            $csv_data_line[] = $this_day_jobseekers;

            $csv_data_array[] = $csv_data_line;
        }
        
        if ($_POST['export']) {
            outputCsv($csv_title, $csv_data_array);
        }
    }
}