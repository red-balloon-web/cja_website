<?php

// Output buffer because we may or may not be exporting a csv file
ob_start();

/**
 * SEARCH FOR STUDENTS PAGE
 * 
 * 1. Search Form
 * if $GET['edit-search'] then the search options are displayed instead of the results, which can then be POSTed back to this page.
 * 
 * 2. Build WP query from search options and query database
 * 
 * 3. Turn query result into array with distances
 * 
 * 4. IF we're ordering by distance then slice and sort array otherwise leave as is
 * 
 * 5. Select just the page we want from the array (pagination)
 * 
 * 6. Display loop 
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main"><?php 
    
    if (is_user_logged_in()) {

        // Check whether user has active search subscription
        if (!get_option('cja_charge_users') || has_woocommerce_subscription('', 343, 'active')) { 
            
            $display_search = true; // do display the search results
            $cja_current_user_obj = new CJA_User;

            // Load postcode functions
            require 'inc/fmn/FindMyNearest.php';
            $fmn_file_address = get_stylesheet_directory_uri() . '/inc/fmn/data/postcodes.txt';
            $fmn = FindMyNearest::factory('textfile', array('datafile' => $fmn_file_address));
            if (! $fmn->loaddata()) {
                echo "Error loading data: " . $fmn->lasterror() . "\n";
                exit;
            }

            $cja_user = new CJA_User;
            if (!$cja_user->postcode) {
                ?><p class="cja_alert cja_alert--amber"><a href="<?php echo get_site_url() . $cja_config['user-details-page-slug']; ?>">Set your postcode</a> to search within a set distance</p><?php
            }


            /**
             * 1. User Search Form
             * Display user search form if $GET['edit-search']
             */
            include('inc/user-searches/student-search-form.php');

            /**
             * 1a. Display User Profile
             * Display user profile if $GET['view-profile']
             */
            include('inc/user-searches/student-search-view-user.php');

            /**
             * 2. Build WP Query from search options 
             */

            // only query and display search results if we're not editing form
            if ($display_search) {

                // create search object
                $cja_usersearch = new CJA_User;

                // If there is postdata then update object from POST
                if ($_POST['update_student_search']) {
                    $cja_usersearch->updateFromForm();

                // Otherwise populate from cookies
                } else {
                    // $cja_usersearch->update_from_student_cookies(); // search criteria in $_POST are already stored as cookies on the init hook - disabled by client
                }

                // Only search for students
                $cja_usersearch->is_student = true; ?>

                <h1>Search Students</h1><?php 
                
                // Display the search criteria box ?>
                <div class="cja_search_criteria_box">
                    <p><strong>Search Options:</strong></p><?php 

                    // Display the search criteria
                    include('inc/user-searches/display_cv_search_criteria.php');?>
                    <p class="button-wrap"><a href="<?php echo get_the_permalink(); ?>?edit-search=true" class="cja_button cja_button--2">Edit Search Options</a></p>
                </div><?php
                

                /**
                 * 3. Turn WP Query into array with IDs and distances
                 */
                
                // Do the query
                $the_query = new WP_User_Query( $cja_usersearch->build_wp_query() );
                $the_returned_query_array = $the_query->get_results();
                if ( !empty($the_returned_query_array)) {

                    $cja_results_array = array(); // set up the blank results array
                    foreach ($the_returned_query_array as $the_returned_query) {

                        $current_loop_id = $the_returned_query->data->ID;
                        $current_loop_postcode = get_user_meta($the_returned_query->data->ID, 'postcode', true);

                        // calculate the distance to the user
                        $cja_current_user_result = new CJA_User($current_loop_id);
                        if ($current_loop_postcode && $cja_current_user_obj->postcode) {
                            $cja_distance = $fmn->calc_distance($cja_current_user_obj->postcode, $current_loop_postcode);
                            if ($cja_distance === false) {
                                $cja_distance = -1;
                            }
                        } else {
                            $cja_distance = -1;
                        }
                        
                        // Put the result in the array
                        $cja_results_array[] = array(
                            'id' => $current_loop_id,
                            'distance' => $cja_distance
                        );

                    }

                    /**
                     * 4. Slice and sort array if required
                     */
                    
                    // Remove any blank distances from array if required
                    if ($cja_usersearch->max_distance) {
                        foreach($cja_results_array as $cja_result => $sub_array) {
                            if($sub_array['distance'] == -1 || $sub_array['distance'] === FALSE) {
                                unset($cja_results_array[$cja_result]);
                            }
                        }
                    }

                    // Remove any entries over the maximum distance, if set
                    if ($cja_usersearch->max_distance) {
                        foreach($cja_results_array as $cja_result => $sub_array) {
                            if($sub_array['distance'] > $cja_usersearch->max_distance) {
                                unset($cja_results_array[$cja_result]);
                            }
                        }
                    }
                            
                    // Sort the array by distance
                        
                    $cja_distance = array_column($cja_results_array, 'distance');
                    array_multisort($cja_distance, SORT_ASC, $cja_results_array);


                    /**
                     * 4a Create the csv array for this search
                     * We do this at this point because the final results array has been set up in the previous step
                     */

                    // display the export to csv button with hidden form fields to resend POST data ?>
                    <form action="<?php echo get_site_url(); ?>/search-students?output_csv=true" method="post"> <?php
                        foreach($_POST as $key => $value) {
                            if (!is_array($value)) { ?>
                                <input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>"><?php
                            } else {
                                foreach($value as $single_value) {
                                    ?><input type="hidden" name="<?php echo $key; ?>[]" value="<?php echo $single_value; ?>"><?php
                                }
                            }
                        } 
                        // Display count of results within area
                        $cja_total_results = count($cja_results_array); ?>
                        <p><?php echo $cja_total_results; ?> result<?php if ($cja_total_results != 1) { echo 's'; } ?> found<?php
                            if ($cja_usersearch->max_distance) {
                                echo ' within a ' . $cja_usersearch->max_distance . ' mile radius';
                            }
                        ?></p>
                        <input type="submit" class="cja_button" value="Export Results as CSV File">
                    </form><?php

                    // Create the array
                    include('inc/user-searches/create-csv-array-students.php');

                    /**
                     * 5. Pagination to return just the bit of the array we need
                     */

                    // Now return just the page of the array that we want to look at
                    $cja_total_results = count($cja_results_array);
                    $cja_results_per_page = get_option( 'posts_per_page' );
                    $cja_pages = ceil($cja_total_results / $cja_results_per_page);
                    // echo ('there are ' . $cja_total_results . ' results and ' . $cja_pages . ' results pages');
                    if ($_GET['cjapage']) {
                        $cja_page = $_GET['cjapage'];
                    } else {
                        $cja_page = 1;
                    }
                    $cja_first_result = ($cja_page - 1) * $cja_results_per_page; 
                    $cja_results_array_paged = array_slice($cja_results_array, $cja_first_result, $cja_results_per_page);

                    /**
                     * 6. Display loop
                     */

                    // Now we do what would normally be the WP loop but on our results array instead
                    foreach ($cja_results_array_paged as $cja_result) {
                        $cja_current_result = new CJA_User($cja_result['id']); ?>
                        <div class="cja_list_item">

                            <a class="cja_button" href="<?php echo get_site_url() . '/search-students?view-profile=' . $cja_current_result->id; ?>">View Profile</a>


                            <p class="short_list_item"><?php 
                                if ($cja_current_result->full_name != ' ') {
                                    echo ($cja_current_result->full_name) . ' ';
                                    if ($cja_current_result->is_new()) {
                                        echo ' <span class="new-item">NEW</span>';
                                    }
                                } else {
                                    echo ('User #' . $cja_current_result->id);
                                } ?>
                            </p>

                        </div><?php 
                    }

                    // And now we do the pagination
                    if ($cja_pages > 1) { // don't display if only one page ?>
                        <div class="cja_pagination"><?php
                            if ($cja_page > 1) {
                                ?><a class="page-numbers" href="<?php echo get_page_link(); ?>?cjapage=<?php echo $cja_page - 1; ?>"><<<</a><?php
                            } 
                            for ($i=0; $i < $cja_pages; $i++) {
                                //echo ('link to page ' . $i . ' ');
                                ?><a class="page-numbers<?php if ($cja_page == $i + 1) {echo ' current'; } ?> " href="<?php echo get_page_link(); ?>?cjapage=<?php echo $i + 1; ?>"><?php echo $i + 1; ?></a>
                                <?php
                            }
                            if ($cja_page < $cja_pages) {
                                ?><a class="page-numbers" href="<?php echo get_page_link(); ?>?cjapage=<?php echo $cja_page + 1; ?>">>>></a><?php
                            } ?>
                        </div><?php 
                    }
                } else {
                    echo("There are no users to view");
                }
                wp_reset_postdata();

            } // end of $display_search test
        } else { // active subscription test ?>
            <p>You do not have an active Student Search subscription</p>
            <p><a href="<?php echo get_site_url() . '/my-account/purchase-subscriptions'; ?>">Purchase Subscription</a></p><?php 
        }

    } else { // is user logged in test ?>

        <h1>Search Students</h1>
        <p>Our Student Search functionality allows you to search the profiles of students and find the right students to fill your course.</p>
        <p>Student Search costs £150 per month and can be purchased as soon as you <a href="<?php echo get_site_url() ?>/my-account">log in or create an account</a></p><?php
    } ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
//do_action( 'storefront_sidebar' );
get_footer();

// Send data to page or export CSV
if (!$_GET['output_csv']) {
	ob_flush();
} else {
	ob_clean();
	outputCsv('Student-Search.csv', $csv_data_array);
}