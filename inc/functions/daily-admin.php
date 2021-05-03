<?php
/**
 * Daily Admin Actions
 * Fires once a day on the first load of the website
 * 
 */

add_action('init', 'daily_admin_functions');
function daily_admin_functions() {

    // Do this if it hasn't been done already today
    if (get_option('cja_expired_check') != strtotime(date('j F Y'))) {
        //if (true) { // testing

        // Initialise email body
        $email_body = '<style>
            h2 {
                font-size: 20px;
                text-align: left;
                text-decoration: underline;
                line-height: 1;
                font-weight: 700;
                margin-bottom: 12px;
                margin-top: 20px;
            }
            h3 {
                font-size: 16px;
                text-align: left;
                text-decoration: none;
                line-height: 1;
                font-weight: 700;
                margin-top: 0;
                margin-bottom: 8px;
            }
            h4 {
                font-size: 16px;
                text-align: left;
                text-decoration: none;
                line-height: 1;
                margin-bottom: 10px;
                font-weight: 700;
                margin-top: 8px;
            }
        </style>';

        //$email_body .= "<p>Test: </p>";

        // Get last week's job adverts to set $daily_jobs_content
        $daily_jobs_content = '';
        $args = array(
            'post_type' => 'job_ad',
            'date_query' => array(
                array(
                    'after'     => '-1 week',
                    'inclusive' => true,
                ),
            ),
            
            'meta_query' => array(
                array(
                    'key' => 'status',
                    'value' => 'active'
                )
            )
        );

        $query = new WP_Query($args);
        //print_r($query);
        if ($query->have_posts()) {
            while ( $query->have_posts() ) {
                $query->the_post();
                $job_ad = new CJA_Advert(get_the_id());

                // Add opportunity to daily jobs details
                $daily_jobs_content .= '<h2><a href="' . get_the_permalink() . '">' . $job_ad->title . '</a></h2>';
                $daily_jobs_content .= '<h3>Posted by ' . $job_ad->author_human_name . '</h3>';
                $daily_jobs_content .= '<h4>' . $job_ad->human_activation_date . '</h4>'; 
                $daily_jobs_content .= '<p>' . $job_ad->content . '</p>';
                $daily_jobs_content .= '<hr>';
            }

            wp_reset_postdata();
        }

        // Get last week's course adverts to set $daily_courses_content
        $daily_courses_content = '';
        $args = array(
            'post_type' => 'course_ad',
            'date_query' => array(
                array(
                    'after'     => '-1 week', 
                    'inclusive' => true,
                ),
            ),
            
            'meta_query' => array(
                array(
                    'key' => 'status',
                    'value' => 'active'
                )
            )
        );

        $query = new WP_Query($args);
        //print_r($query);
        if ($query->have_posts()) {
            while ( $query->have_posts() ) {
                $query->the_post();
                $course_ad = new CJA_Course_Advert(get_the_id());

                // Add opportunity to daily courses details
                $daily_courses_content .= '<h2><a href="' . get_the_permalink() . '">' . $course_ad->title . '</a></h2>';
                $daily_courses_content .= '<h3>Posted by ' . $course_ad->author_human_name . '</h3>';
                $daily_courses_content .= '<h4>' . $course_ad->human_activation_date . '</h4>'; 
                $daily_courses_content .= '<p>' . $course_ad->content . '</p>';
            }

            wp_reset_postdata();
        }



        // Query Jobseekers for daily updates
        $args = array(
            "role" => "jobseeker",
            "meta_key" => "receive_updates",
            "meta_value" => array(
                "daily",
            ),
            "compare" => "IN"
        );

        // If it is the appropriate day of the week then add the users who selected weekly updates
        if (date('w') == 4) {
            $args['meta_value'][] = "weekly";
        }

        // The Query
        $user_query = new WP_User_Query( $args );

        // User Loop
        if ( ! empty( $user_query->get_results() ) ) {
            foreach ( $user_query->get_results() as $user ) { 
                $send_email = false;

                $current_user = new CJA_User($user->ID);

                if ($current_user->is_jobseeker == 'true') {
                    $email_body .= $daily_jobs_content;
                    $send_email = true;
                }

                if ($current_user->is_student == 'true') {
                    $email_body .= $daily_courses_content;
                    $send_email = true;
                }

                $to = $current_user->email;
                $subject = 'Roundup of opportunities from Courses and Jobs Advertiser';
                $headers = array('Content-Type: text/html');

                // Send email to this user
                if ($send_email == true) {
                    wp_mail($to, $subject, $email_body, $headers);
                }

            }
        }

        /**
         * MARK ADVERTS AS EXPIRED IF THEY HAVE EXPIRED
         * SEND EMAILS ABOUT EXPIRING SOON AND EXPIRED ADS
         */

       // Get all active advert posts
       $args = array(
           'post_type' => array('job_ad', 'course_ad', 'classified_ad'),
           'posts_per_page' => -1,
           'meta_query' => array(
               array(
                   'key' => 'cja_ad_status',
                   'value' => 'active'
               )
           )
        );
        $query = new WP_Query($args);

        // The loop
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();

                // Set up $advert and $advertiser objects
                if (get_post_type() == 'job_ad') {
                    $advert = new CJA_Advert(get_the_ID());
                } else if (get_post_type() == 'course_ad') {
                    $advert = new CJA_Course_Advert(get_the_ID());
                } else if (get_post_type() == 'classified_ad') {
                    $advert = new CJA_Classified_Advert(get_the_ID());
                }

                $advertiser = new CJA_User($advert->author);

                // Send expires soon email if required
                if ($advert->days_left == get_option('advert_running_out_message_days')) {

                    $subject = cja_filter_message(stripslashes(get_option('advert_running_out_email_subject')), $advert);
                    $message = cja_filter_message(stripslashes(get_option('advert_running_out_email_message')), $advert);
                    wp_mail($advertiser->email, $subject, $message);
                }

                // Expire advert if it's expired
                if ($advert->days_left == 0) {

                    update_post_meta(get_the_ID(), 'cja_ad_status', 'expired');

                    $subject = cja_filter_message(stripslashes(get_option('advert_expired_email_subject')), $advert);
                    $message = cja_filter_message(stripslashes(get_option('advert_expired_email_message')), $advert);
                    wp_mail($advertiser->email, $subject, $message);
                }
            }
        }
        wp_reset_postdata();

        // Update option to mark that this has been done today
        update_option('cja_expired_check', strtotime(date('j F Y')));

    }
}

function cja_filter_message($message, $advert) {
    $message = preg_replace('/%ad-title%/', $advert->title, $message);
    $message = preg_replace('/%expiry-date%/', date("j F", $advert->expiry_date), $message);
    $login_link = get_site_url() . '/my-account';
    $message = preg_replace('/%login-link%/', $login_link, $message);

    return $message;
}

function cja_escape_double_quotes($text) {
    $text = preg_replace('/"/', '&quot;', $text);
    return $text;
}

