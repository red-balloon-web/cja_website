<?php

// Output buffer because we may or may not be exporting a csv file
ob_start();

/**
 * SEARCH FOR JOBS PAGE
 * In order to sort by distance from the user a custom query is not enough as there is no way to sort the custom query by the result of the distance function. We have to query the database into an array with ID and distance, sort the array and then loop through.
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main"><?php

		if (is_user_logged_in()) { // Only display results if user is logged in

			$cja_current_user_obj = new CJA_User;

			$display_search = true; // do display the search results
			$search_type = 'job'; // to trigger correct sections in includes

			// Load postcode functions
			include 'inc/searches/postcode-functions.php';
			
			// Display job search form instead of results if $_GET['edit-search'] and set $display_search to false
			include 'inc/searches/display-search-form-jobs.php';

			// only query and display search results if we're not editing form
			if ($display_search) {

				// Create search object $cja_search and update from POST or cookies if there are any
				include 'inc/searches/create_and_populate_search_object.php';

				// Page Title ?>
				<h1>Search Jobs</h1><?php 
				
				// Display the search criteria box
				include 'inc/searches/search_criteria_box.php';
				
				// Query database and return $cja_results_array of IDs and distances
				include 'inc/searches/query_return_array.php';

				// Slice and sort the array as required (nearest, newest, within certain distance etc)
				include 'inc/searches/slice_and_sort_array.php';

				// Display count of results within area
				include 'inc/searches/display_result_count.php';

				// Create the csv file for this search (todo: put this on admin_post hook separately to this page)
				include 'inc/searches/create_csv_array_jobs.php';

				// Return just the bit of the array we want to look at (because of the pagination)
				include 'inc/searches/return_cja_results_array_paged.php';

				// Now we do what would normally be the WP loop but on our results array instead
				foreach ($cja_results_array_paged as $cja_result) {

					// Set up objects
					$cja_current_advert = new CJA_Advert($cja_result['id']);
					$cja_current_advertiser = new CJA_User($cja_current_advert->author); ?>

					<div class="cja_list_item"><?php 
						// display view job / view application button
						if ($cja_current_advert->applied_to_by_current_user) { ?>
							<a class="cja_button" href="<?php echo get_the_permalink($cja_current_advert->applied_to_by_current_user); ?>">View Application</a><?php	
						} else {?>
							<a class="cja_button" href="<?php echo get_the_permalink($cja_current_advert->id); ?>">View Job<?php if ($cja_current_user_obj->role == 'jobseeker') { echo (' and Apply'); } ?></a><?php
						}

						// display job title, company and distance ?>
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
						</p><?php

						// display you applied to this job text if appropriate
						if ($cja_current_advert->applied_to_by_current_user) {
							$cja_user_application = new CJA_Application($cja_current_advert->applied_to_by_current_user); ?>
							<p class="green"><strong>You applied on <?php echo $cja_user_application->human_application_date; ?>.</strong></p><?php
						
						// otherwise display how many days ago the job was posted
						} else { ?>
							<p class="item-meta daysold"><em>Posted <?php 
								if ($cja_current_advert->days_old == 0) {
									echo ('today');
								} else if ($cja_current_advert->days_old == 1) {
									echo ('yesterday');
								} else {
									echo ($cja_current_advert->days_old) . ' days ago';
								} ?>
							</em></p><?php 
						} ?>
					</div><?php 
				}

				// Display pagination
				include 'inc/searches/display_pagination.php';

				wp_reset_postdata();

			} // end of $display_search test 
		
		} else { // end of is user logged in test ?>

			<h1>Search Jobs</h1>
			<h3>Jobseekers</h3>
			<p><strong>It's FREE</strong> to search jobs on Courses and Jobs Advertiser. Just create a <a href="<?php echo get_site_url(); ?>/my-account">free jobseeker account</a> and you can start searching and applying to jobs straight away.</p>
			<p><strong>Upload your CV</strong> and apply for jobs directly online!</p>
			<p>Allow potential employers to search for you, view your CV and contact you directly for jobs that may interest you.</p>
			<h3>Employers</h3>
			<p>It's currently <strong>free</strong> to advertise your jobs on Courses and Jobs Advertiser. Just create a <a href="<?php echo get_site_url(); ?>/my-account">free employer account</a> and start listing your jobs today.</p>
			<p>You can also use our <strong>CV Search</strong> to find the candidates that are right for you, also free for a limited time!</p>

			<p class="free_account_link"><a href="">Get started with a free account today!</a></p>

			<?php
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
	outputCsv('Jobsearch.csv', $csv_data_array);
}