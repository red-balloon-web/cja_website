<?php

// Output buffer because we may or may not be exporting a csv file
ob_start();

/**
 * SEARCH FOR COURSES PAGE
 * 
 * 1. Course Search Form
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
 * 
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php

	if (is_user_logged_in()) {
		
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

		// Check whether user has set their postcode
		if (!$cja_user->postcode) {
			?><p class="cja_alert cja_alert--amber"><a href="<?php echo get_site_url() . $cja_config['user-details-page-slug']; ?>">Set your postcode</a> to search and order courses by distance</p><?php
		}


		/**
		 * 1. Course Search Form
		 * Display course search form if $GET['edit-search']
		 */
		include('inc/browse-courses/course-search-form.php');


		/**
		 * 2. Build WP Query from search options 
		 */

		// only query and display search results if we're not editing form
		if ($display_search) {

			// create search object
			$cja_coursesearch = new CJA_Course_Advert;
			// If there is postdata then update object from POST
			if ($_POST['update_course_search']) {
				$cja_coursesearch->update_from_form();
			// Otherwise populate from cookies
			} else {
				// $cja_coursesearch->update_from_cookies(); // search criteria in $_POST are already stored as cookies on the init hook
			} ?>

			<h1>Search Courses</h1>

			<?php // Display the search criteria box ?>
			<div class="cja_search_criteria_box">
				<p><strong>Search Options:</strong></p>

				<?php // Display the search criteria
				include('inc/browse-courses/display_search_criteria.php');?>
				<p class="button-wrap"><a href="<?php echo get_the_permalink(); ?>?edit-search=true" class="cja_button cja_button--2">Edit Search Options</a></p>
			</div><?php
			

			/**
			 * 3. Turn WP Query into array with IDs and distances
			 */

			// Do the query
			$the_query = new WP_Query( $cja_coursesearch->build_wp_query() );
			// print_r($cja_coursesearch->build_wp_query());
		
			if ( $the_query->have_posts() ) {
				$cja_results_array = array(); // set up the blank results array
				while ( $the_query->have_posts() ) : $the_query->the_post();

					// calculate the distance to the course
					$cja_current_advert = new CJA_Advert(get_the_ID());
					$the_query->reset_postdata();
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

				/**
				 * 4. Slice and sort array if required
				 */

				// Remove any courses already applied to if required
				if (!$cja_coursesearch->show_applied) {
					foreach($cja_results_array as $cja_result => $sub_array) {
						$cja_check_applied = new CJA_Course_Advert($sub_array['id']);
						if ($cja_check_applied->applied_to_by_current_user) {
							unset($cja_results_array[$cja_result]);
						}
					}
				}

				// Remove any blank distances from array if required
				if ($cja_coursesearch->order_by == 'distance' || $cja_coursesearch->max_distance) {
					foreach($cja_results_array as $cja_result => $sub_array) {
						if($sub_array['distance'] == -1 || $sub_array['distance'] === FALSE) {
							unset($cja_results_array[$cja_result]);
						}
					}
				}

				// Remove any entries over the maximum distance, if set
				if ($cja_coursesearch->max_distance) {
					foreach($cja_results_array as $cja_result => $sub_array) {
						if($sub_array['distance'] > $cja_coursesearch->max_distance) {
							unset($cja_results_array[$cja_result]);
						}
					}
				}
				
				// Sort the array by distance if required
				if ($cja_coursesearch->order_by == 'distance') {
					$cja_distance = array_column($cja_results_array, 'distance');
					array_multisort($cja_distance, SORT_ASC, $cja_results_array);
				}

				// Display count of results within area
				$cja_total_results = count($cja_results_array); ?>
				<p><?php echo $cja_total_results; ?> result<?php if ($cja_total_results != 1) { echo 's'; } ?> found<?php
					if ($cja_coursesearch->max_distance) {
						echo ' within a ' . $cja_coursesearch->max_distance . ' mile radius';
					}
				?></p><?php

				/**
				 * 4a Create the csv file for this search (this section can come before or after section 4 depending whether we want the raw array or the tailored one)
				 */

				include('inc/browse-courses/create_csv_array.php');
					

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
					$cja_current_advert = new CJA_Course_Advert($cja_result['id']);
					$cja_current_advertiser = new CJA_User($cja_current_advert->author); ?>

					<div class="cja_list_item"><?php 
						if ($cja_current_advert->applied_to_by_current_user) {
								$cja_user_application = new CJA_Course_Application($cja_current_advert->applied_to_by_current_user);
								?><a class="cja_button" href="<?php echo get_the_permalink($cja_current_advert->applied_to_by_current_user); ?>">View Application</a><?php	
						} else {
							?><a class="cja_button" href="<?php echo get_the_permalink($cja_current_advert->id); ?>">View Course<?php if ($cja_current_user_obj->role == 'jobseeker') { echo (' and Apply'); } ?></a><?php
						} ?>

						<h4 class="item-title"><?php 
							echo ($cja_current_advert->title); 
							if ($cja_current_advert->is_new()) {
								echo ' <span class="new-item">NEW</span>';
							}?>
						</h4>
						<p class="item-meta"><?php echo ($cja_current_advert->author_human_name); 
							if ($cja_current_advert->postcode && $cja_current_user_obj->postcode && $cja_result['distance'] != -1) {
								echo (', ' . $cja_current_advert->postcode . ' (' . $cja_result['distance'] . ' miles away)');
							} ?>
						</p><?php 
						if ($cja_current_advert->applied_to_by_current_user) {
							$cja_user_application = new CJA_Course_Application($cja_current_advert->applied_to_by_current_user); ?>
							<p class="green"><strong>You applied on <?php echo $cja_user_application->human_application_date; ?>.</strong></p><?php

						} else { ?>

							<p class="item-meta daysold"><em>Posted <?php 
								if ($cja_current_advert->days_old == 0) {
									echo ('today');
								} else if ($cja_current_advert->days_old == 1) {
									echo ('yesterday');
								} else {
									echo ($cja_current_advert->days_old) . ' days ago';
								} ?></em>
							</p><?php 
						} ?>
					</div><?php 
				}

				// And now we do the pagination
				if ($cja_pages > 1) { // don't display if only one page

					?><div class="cja_pagination"><?php
						if ($cja_page > 1) {
							?><a class="page-numbers" href="<?php echo get_page_link(); ?>?cjapage=<?php echo $cja_page - 1; ?>"><<<</a><?php
						} 
						for ($i=0; $i < $cja_pages; $i++) {?>
							<a class="page-numbers<?php if ($cja_page == $i + 1) {echo ' current'; } ?> " href="<?php echo get_page_link(); ?>?cjapage=<?php echo $i + 1; ?>"><?php echo $i + 1; ?></a><?php
						}
						if ($cja_page < $cja_pages) {
							?><a class="page-numbers" href="<?php echo get_page_link(); ?>?cjapage=<?php echo $cja_page + 1; ?>">>>></a><?php
						} ?>
					</div><?php 
				}

			} else {
				echo("There are no jobs to view");
			}

			wp_reset_postdata();

		} // end of $display_search test

	} else { // end of is user logged in test ?>

		<h1>Search Jobs</h1>
		<h3>Jobseekers</h3>
		<p><strong>It's FREE</strong> to search courses on Courses and Jobs Advertiser. Just create a <a href="<?php echo get_site_url(); ?>/my-account">free jobseeker account</a> and you can start searching and applying to jobs straight away.</p>
		<p><strong>Upload your details</strong> and apply for courses directly online!</p>
		<p>Allow potential employers to search for you, view your CV and contact you directly for jobs that may interest you.</p>
		<h3>Employers</h3>
		<p>It's currently <strong>free</strong> to advertise your courses on Courses and Jobs Advertiser. Just create a <a href="<?php echo get_site_url(); ?>/my-account">free account</a> and start listing your jobs today.</p>

		<p>You can also use our <strong>Student Search</strong> to find the candidates that are right for you, also free for a limited time!</p>

		<p class="free_account_link"><a href="">Get started with a free account today!</a></p><?php
		
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
	outputCsv('Coursesearch.csv', $csv_data_array);
}