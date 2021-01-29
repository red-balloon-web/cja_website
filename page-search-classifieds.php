<?php

// Output buffer because we may or may not be exporting a csv file
ob_start();

/**
 * SEARCH FOR CLASSIFIEDS PAGE
 * 
 * 1. Classified Search Form
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

	// Only display results if user is logged in
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

		// Check whether user has set their postcode
		$cja_user = new CJA_User; 
		if (!$cja_user->postcode) {
			?><p class="cja_alert cja_alert--amber"><a href="<?php echo get_site_url() . $cja_config['user-details-page-slug']; ?>">Set your postcode</a> to search and order courses by distance</p><?php
		}


		/**
		 * 1. Course Search Form
		 * Display course search form if $GET['edit-search']
		 */
		include('inc/browse-classifieds/classified-search-form.php'); 


		/**
		 * 2. Build WP Query from search options 
		 */

		// only query and display search results if we're not editing form
		if ($display_search) {

			// create search object
			$cja_classifiedsearch = new CJA_Classified_Advert;
			// If there is postdata then update object from POST
			if ($_POST['update_classified_search']) {
				$cja_classifiedsearch->update_from_form();
			// Otherwise populate from cookies
			} else {
				// $cja_classifiedsearch->update_from_cookies(); // search criteria in $_POST are already stored as cookies on the init hook // disabled by client
			} ?>

			<h1>Search Classifieds</h1>

			<!-- display the search criteria box -->
			<div class="cja_search_criteria_box">
				<p><strong>Search Options:</strong></p><?php 
				
				// Display the search criteria
				include('inc/browse-classifieds/display_search_criteria.php');?>
				<p class="button-wrap"><a href="<?php echo get_the_permalink(); ?>?edit-search=true" class="cja_button cja_button--2">Edit Search Options</a></p>
			</div><?php
			

			/**
			 * 3. Turn WP Query into array with IDs and distances
			 */

			// Do the query
			$the_query = new WP_Query( $cja_classifiedsearch->build_wp_query() );
		
			if ( $the_query->have_posts() ) {
				$cja_results_array = array(); // set up the blank results array
				while ( $the_query->have_posts() ) : $the_query->the_post();

					// calculate the distance to the advert
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

				// Remove any blank distances from array if required
				if ($cja_classifiedsearch->order_by == 'distance' || $cja_classifiedsearch->max_distance) {
					foreach($cja_results_array as $cja_result => $sub_array) {
						if($sub_array['distance'] == -1 || $sub_array['distance'] === FALSE) {
							unset($cja_results_array[$cja_result]);
						}
					}
				}

				// Remove any entries over the maximum distance, if set
				if ($cja_classifiedsearch->max_distance) {
					foreach($cja_results_array as $cja_result => $sub_array) {
						if($sub_array['distance'] > $cja_classifiedsearch->max_distance) {
							unset($cja_results_array[$cja_result]);
						}
					}
				}
				
				// Sort the array by distance if required
				if ($cja_classifiedsearch->order_by == 'distance') {
					$cja_distance = array_column($cja_results_array, 'distance');
					array_multisort($cja_distance, SORT_ASC, $cja_results_array);
				}

				// Display count of results within area
				$cja_total_results = count($cja_results_array); ?>
				<p><?php echo $cja_total_results; ?> result<?php if ($cja_total_results != 1) { echo 's'; } ?> found<?php
					if ($cja_classifiedsearch->max_distance) {
						echo ' within a ' . $cja_classifiedsearch->max_distance . ' mile radius';
					}
				?></p><?php

				/**
				 * 4a Create the csv file for this search (this section can come before or after section 4 depending whether we want the raw array or the tailored one)
				 */ ?>
					
					<form action="<?php echo get_site_url(); ?>/search-classifieds?output_csv=true" method="post"> <?php
					foreach($_POST as $key => $value) { ?>
						<input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>"><?php
					} ?>
					<input type="submit" class="cja_button" value="Export Results as CSV File">
					</form>
					<?php

				// Initialise array
				$csv_data_array = [];

				// Set header row
				$array_row = array(
					'Advert Code', 
					'Advert Title', 
					'Advertiser Code',
					'Advertiser',
					'Category',
					'Postcode',
					'Phone Number',
					'Email'
				);
				$csv_data_array[] = $array_row;

				// Loop through and add records to CSV
				foreach($cja_results_array as $cja_result) {
					$current_advert = new CJA_Classified_Advert($cja_result['id']);
					$array_row = [];
					$array_row[] = get_cja_code($current_advert->id);
					$array_row[] = $current_advert->title;
					$array_row[] = get_cja_user_code($current_advert->author);
					$array_row[] = $current_advert->author_human_name;
					$array_row[] = $current_advert->return_human('category');
					$array_row[] = $current_advert->postcode;
					$array_row[] = $current_advert->phone;
					$array_row[] = $current_advert->email;
					$csv_data_array[] = $array_row;
				}
					

				/**
				 * 5. Pagination to return just the bit of the array we need
				 */

				// Now return just the page of the array that we want to look at
				$cja_total_results = count($cja_results_array);
				$cja_results_per_page = get_option( 'posts_per_page' );
				$cja_pages = ceil($cja_total_results / $cja_results_per_page);
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

				// And now we do the pagination
				if ($cja_pages > 1) { // don't display if only one page ?>
				
					<div class="cja_pagination"><?php

						if ($cja_page > 1) {
							?><a class="page-numbers" href="<?php echo get_page_link(); ?>?cjapage=<?php echo $cja_page - 1; ?>"><<<</a><?php
						} 

						for ($i=0; $i < $cja_pages; $i++) { ?>
							<a class="page-numbers<?php if ($cja_page == $i + 1) {echo ' current'; } ?> " href="<?php echo get_page_link(); ?>?cjapage=<?php echo $i + 1; ?>"><?php echo $i + 1; ?></a><?php
						}

						if ($cja_page < $cja_pages) {
							?><a class="page-numbers" href="<?php echo get_page_link(); ?>?cjapage=<?php echo $cja_page + 1; ?>">>>></a><?php
						} ?>

					</div><?php 
				}

			} else {
				echo("There are no adverts to view");
			}
			wp_reset_postdata();

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