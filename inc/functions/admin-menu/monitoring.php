<?php

/**
 * CJA Monitoring Content
 * Content for monitoring screen showing how many ads/users created on any given day
 */

function cja_monitoring_content() {

    $data_array = array();

    // Get start and end dates sent to page
    if($_POST['start_date']) {
        $first_date = $_POST['start_date'];
        $last_date = $_POST['end_date'];
    }
    
    // Start and end dates form ?>
    <form action="<?php echo get_site_url(); ?>/wp-admin/admin.php?page=cja_monitoring" method="post">
        <table style="margin-bottom: 30px; margin-top: 12px;">
            <tr>
                <td style="padding-right: 20px">
                    <p style="margin-bottom: 0;">Start Date</p>
                    <input type="date" name="start_date" <?php if ($first_date) {
                        echo('value="' . $first_date . '" ');
                    } ?>>
                </td>
                <td style="padding-right: 20px">
                    <p style="margin-bottom: 0;">End Date</p>
                    <input type="date" name="end_date" <?php if ($last_date) {
                        echo('value="' . $last_date . '" '); 
                    } ?>>
                </td>
                <td style="vertical-align: bottom; padding-right: 20px">
                    <input type="submit" name="display" value="Display" style="padding: 4px 10px;">  
                </td>
                <td style="vertical-align: bottom">
                <input type="submit" name="export" formaction="<?php echo get_site_url(); ?>/wp-admin/admin-post.php?action=print-monitoring.csv" value="Export CSV" style="padding: 4px 10px;">
                </td>
            </tr>
        </table>
    </form><?php 

    if ($_POST['start_date']) {

        
        // Convert to DateTime objects and echo table header
        $real_first_date = new DateTime($first_date);
        $real_last_date = new DateTime($last_date);
        $title = $real_first_date->format('D jS F Y') . ' - ' . $real_last_date->format('D jS F Y');
        echo ('<p style="font-size: 17px; margin-bottom: 4px;">' . $title . '</p>');
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

        // Initialise Table ?>
        <style>
            table#monitoringtable {
                border-collapse: collapse;
                border: 1px solid #333;
            }

            table#monitoringtable thead td {
                font-weight: 700;
            }

            table#monitoringtable tr.totals td {
                font-weight: 700;
            }

            table#monitoringtable tr td {
                padding: 5px 15px;
                text-align: center;
                border-bottom: 1px solid #333;
            }
        </style>

        <table id="monitoringtable">
            <thead>
                <tr>
                    <td>Date</td>
                    <td>New Jobs</td>
                    <td>New Courses</td>
                    <td>New Classifieds</td>
                    <td>Job Applications</td>
                    <td>Course Applications</td>
                    <td>New Advertisers</td>
                    <td>New Course/Job Seekers</td>
                    <td>Course Seekers</td>
                    <td>Job Seekers</td>
                </tr>
            </thead>
            <tbody><?php

        // CSV Header Line
        $csv_data_array[] = array('Date', 'New Jobs', 'New Courses', 'New Classifieds', 'Job Applications', 'Course Applications', 'New Advertisers', 'New Course/Job Seekers', 'Course Seekers', 'Job Seekers');

        // Initialise Running Totals Array
        $running_totals = array(
            'jobs' => 0,
            'courses' => 0,
            'classifieds' => 0,
            'job_applications' => 0,
            'course_applications' => 0,
            'advertisers' => 0,
            'seekers' => 0,
            'courseseekers' => 0,
            'jobseekers' => 0
        );

        // go through dates one at a time and display
        foreach ($dates as $date) {

            // initialise CSV line
            $csv_data_line = array();

            //echo '<tr><td>' . $date . '</td>';
            $date_time = new DateTime($date);
            $year = $date_time->format('Y');
            $month = $date_time->format('m');
            $day = $date_time->format('d');
            $csv_data_line[] = $date_time->format('D d M');
            echo '<tr><td>' . $date_time->format('D d M') . '</td>';
            
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
            echo '<td>' . $query->found_posts . '</td>';
            $csv_data_line[] = $query->found_posts;
            $running_totals['jobs'] += $query->found_posts;

            // course ads
            $args['post_type'] = 'course_ad';
            $query = new WP_Query($args);
            echo '<td>' . $query->found_posts . '</td>';
            $csv_data_line[] = $query->found_posts;
            $running_totals['courses'] += $query->found_posts;

            // classified ads
            $args['post_type'] = 'classified_ad';
            $query = new WP_Query($args);
            echo '<td>' . $query->found_posts . '</td>';
            $csv_data_line[] = $query->found_posts;
            $running_totals['classifieds'] += $query->found_posts;

            // job applications
            $args['post_type'] = 'application';
            $query = new WP_Query($args);
            echo '<td>' . $query->found_posts . '</td>';
            $csv_data_line[] = $query->found_posts;
            $running_totals['job_applications'] += $query->found_posts;

            // course applications
            $args['post_type'] = 'course_application';
            $query = new WP_Query($args);
            echo '<td>' . $query->found_posts . '</td>';
            $csv_data_line[] = $query->found_posts;
            $running_totals['course_applications'] += $query->found_posts;

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
            echo '<td>' . $query->get_total() . '</td>';
            $csv_data_line[] = $query->get_total();
            $running_totals['advertisers'] += $query->get_total();

            // jobseekers
            $args['role'] = 'jobseeker';
            $query = new WP_User_Query($args);
            echo '<td>' . $query->get_total() . '</td>';
            $csv_data_line[] = $query->get_total();
            $running_totals['seekers'] += $query->get_total();

            
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
            echo '<td>' . $this_day_courseseekers . '</td>';
            echo '<td>' . $this_day_jobseekers . '</td></tr>';
            $csv_data_line[] = $this_day_courseseekers;
            $csv_data_line[] = $this_day_jobseekers;
            $running_totals['jobseekers'] += $this_day_jobseekers;
            $running_totals['courseseekers'] += $this_day_courseseekers;

            $csv_data_array[] = $csv_data_line;
        }

        // End table ?>
        <tr class="totals">
            <td></td>
            <td>Total Jobs</td>
            <td>Total Courses</td>
            <td>Total Classifieds</td>
            <td>Total Job Applications</td>
            <td>Total Course Applications</td>
            <td>Total Advertisers</td>
            <td>Total C/J Seekers</td>
            <td>Course Seekers</td>
            <td>Job Seekers</td>
        </tr>
        <tr class="totals">
            <td></td>
            <td><?php echo $running_totals['jobs']; ?></td>
            <td><?php echo $running_totals['courses']; ?></td>
            <td><?php echo $running_totals['classifieds']; ?></td>
            <td><?php echo $running_totals['job_applications']; ?></td>
            <td><?php echo $running_totals['course_applications']; ?></td>
            <td><?php echo $running_totals['advertisers']; ?></td>
            <td><?php echo $running_totals['seekers']; ?></td>
            <td><?php echo $running_totals['courseseekers']; ?></td>
            <td><?php echo $running_totals['jobseekers']; ?></td>
        </tr>
        </tbody>
        </table><?php
        
        if ($_POST['export']) {
            outputCsv($csv_title, $csv_data_array);
        }
    }
}