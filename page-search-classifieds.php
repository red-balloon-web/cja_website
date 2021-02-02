<?php

// Output buffer because we may or may not be exporting a csv file
ob_start();

/**
 * SEARCH FOR CLASSIFIEDS PAGE
 * In order to sort by distance from the user a custom query is not enough as there is no way to sort the custom query by the result of the distance function. We have to query the database into an array with ID and distance, sort the array and then loop through.
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main"><?php

	// Only display results if user is logged in
	if (is_user_logged_in()) {
		
		$cja_current_user_obj = new CJA_User;
		
		$display_search = true; // do display the search results
		$search_type = 'classified'; // to trigger correct sections in includes

		// Load postcode functions
		include 'inc/searches/postcode-functions.php';

		// Display classified search form instead of results if $_GET['edit-search'] and set $display_search to false
		include 'inc/searches/display-search-form-classifieds.php';

		// only query and display search results if we're not editing form
		if ($display_search) {

			// Create search object $cja_search and update from POST or cookies if there are any
			include 'inc/searches/create_and_populate_search_object.php';

			// Page Title ?>
			<h1>Search Classifieds</h1><?php

			// Display the search criteria box
			include 'inc/searches/search_criteria_box.php';

			
			// Query database and return $cja_results_array of IDs and distances
			include 'inc/searches/query_return_array.php';
			
			// Slice and sort the array as required (nearest, newest, within certain distance etc)
			include 'inc/searches/slice_and_sort_array.php';

			// Display count of results within area
			include 'inc/searches/display_result_count.php';

			// Create the csv file for this search (todo: put this on admin_post hook separately to this page)
			include 'inc/searches/create_csv_array_classifieds.php';

			// Return just the bit of the array we want to look at (because of the pagination)
			include 'inc/searches/return_cja_results_array_paged.php';

			// Now we do what would normally be the WP loop but on our results array instead
			foreach ($cja_results_array_paged as $cja_result) {
				$cja_current_advert = new CJA_Classified_Advert($cja_result['id']);
				$cja_current_advertiser = new CJA_User($cja_current_advert->author); ?>

				<div class="cja_list_item">
					<a class="cja_button" href="<?php echo get_the_permalink($cja_current_advert->id); ?>">View Advert</a>
					<h4 class="item-title"><?php 
						echo ($cja_current_advert->title); 
						if ($cja_current_advert->is_new()) {
							echo ' <span class="new-item">NEW</span>';
						}?>
					</h4>
					<p class="item-meta"><?php echo ($cja_current_advert->author_human_name); 
						if ($cja_current_advert->postcode && $cja_current_user_obj->postcode && $cja_result['distance'] != -1) {
							echo (', ' . $cja_current_advert->postcode . ' (' . $cja_result['distance'] . ' miles away)');
						}?>
					</p>

					<p class="item-meta daysold"><em>Posted <?php 
						if ($cja_current_advert->days_old == 0) {
							echo ('today');
						} else if ($cja_current_advert->days_old == 1) {
							echo ('yesterday');
						} else {
							echo ($cja_current_advert->days_old) . ' days ago';
						} ?>
					</em></p>
				</div><?php 
			}

			wp_reset_postdata();
	
			// Display pagination
			include 'inc/searches/display_pagination.php';

		} // end of $display_search test

	} else { // end of is user logged in test ?>

	<h1>Search Classifieds</h1>
	<p><strong>It's FREE</strong> to search classified ads on Courses and Jobs Advertiser. Just create a <a href="<?php echo get_site_url(); ?>/my-account">free account</a> and you can start searching classifieds straight away.</p><?php
	} // end of user logged in else ?>	

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
	outputCsv('Classifiedsearch.csv', $csv_data_array);
}