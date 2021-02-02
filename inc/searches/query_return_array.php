<?php

// Do the query
$the_query = new WP_Query( $cja_search->build_wp_query() );
$cja_results_array = array(); // set up the blank results array

// populate the array with posts if there are any
if ( $the_query->have_posts() ) {
    while ( $the_query->have_posts() ) : $the_query->the_post();

        // create object for current advert
        if ($search_type == 'job') {
            $cja_current_advert = new CJA_Advert(get_the_ID());
        } else if ($search_type == 'course') {
            $cja_current_advert = new CJA_Course_Advert(get_the_ID());
        } else if ($search_type == 'classified') {
            $cja_current_advert = new CJA_Classified_Advert(get_the_ID());
        }
        $the_query->reset_postdata(); // why?

        // Calculate distance to job if postcodes are set, else return -1 if no or malformed postcodes
        if ($cja_current_advert->postcode && $cja_current_user_obj->postcode) {
            $cja_distance = $fmn->calc_distance($cja_current_user_obj->postcode, $cja_current_advert->postcode);
            if ($cja_distance === false) {
                $cja_distance = -1;
            }
        } else {
            $cja_distance = -1;
        }
        
        // Put the result in the array
        $cja_results_array[] = array(
            'id' => get_the_ID(),
            'distance' => $cja_distance
        );

    endwhile;
}