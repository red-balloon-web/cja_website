<?php
/**
 * Daily Admin Actions
 * Fires once a day on the first load of the website
 * 
 * - Filter ads and update ads which have expired to 'expired' if it hasn't been done already today.
 * - Send emails warning that ads are about to expire or have expired
 * 
 */

add_action('init', 'daily_admin_functions');
function daily_admin_functions() {

   // Do this if it hasn't been done already today
    if (get_option('cja_expired_check') != strtotime(date('j F Y'))) {
    //if (true) { // testing

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

       // Update option to mark that this has been done today
       update_option('cja_expired_check', strtotime(date('j F Y')));

       wp_reset_postdata();
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

