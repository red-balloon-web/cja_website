<?php
/**
 * Update Expired Ads
 * Filter ads and update ads which have expired to 'expired' if it hasn't been done already today.
 */

add_action('init', 'update_expired_ads');
function update_expired_ads() {

   // Do this if it hasn't been done already today
    if (get_option('cja_expired_check') != strtotime(date('j F Y'))) {

       // Query job ads
       $args = array(
           'post_type' => 'job_ad',
           'posts_per_page' => -1,
           'meta_query' => array(
               array(
                   'key' => 'cja_ad_status',
                   'value' => 'active'
               )
           )
       );
       $cja_update_expired = new WP_Query($args);

       // Loop through and mark as expired
       if ($cja_update_expired->have_posts()) {
           while ( $cja_update_expired->have_posts() ) {
               $cja_update_expired->the_post();
               if (get_post_meta(get_the_ID(), 'cja_ad_expiry_date', true) <= strtotime(date('j F Y'))) {
                   update_post_meta(get_the_ID(), 'cja_ad_status', 'expired');
               }
           }
       }
       wp_reset_postdata();

       // Query course ads
       $args = array(
           'post_type' => 'course_ad',
           'posts_per_page' => -1,
           'meta_query' => array(
               array(
                   'key' => 'cja_ad_status',
                   'value' => 'active'
               )
           )
       );

       // Loop through and mark as expired
       $cja_update_expired = new WP_Query($args);
       if ($cja_update_expired->have_posts()) {
           while ( $cja_update_expired->have_posts() ) {
               $cja_update_expired->the_post();
               if (get_post_meta(get_the_ID(), 'cja_ad_expiry_date', true) <= strtotime(date('j F Y'))) {
                   update_post_meta(get_the_ID(), 'cja_ad_status', 'expired');
               }
           }
       }
       wp_reset_postdata();

       // Query classified ads
       $args = array(
           'post_type' => 'classified_ad',
           'posts_per_page' => -1,
           'meta_query' => array(
               array(
                   'key' => 'cja_ad_status',
                   'value' => 'active'
               )
           )
       );
       $cja_update_expired = new WP_Query($args);

       // Loop through and mark as expired
       if ($cja_update_expired->have_posts()) {
           while ( $cja_update_expired->have_posts() ) {
               $cja_update_expired->the_post();
               if (get_post_meta(get_the_ID(), 'cja_ad_expiry_date', true) <= strtotime(date('j F Y'))) {
                   update_post_meta(get_the_ID(), 'cja_ad_status', 'expired');
               }
           }
       }
       wp_reset_postdata();

       // Update option to mark that this has been done today
       update_option('cja_expired_check', strtotime(date('j F Y')));
    }
}

