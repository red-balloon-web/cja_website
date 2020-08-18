<?php

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		
		$display_search = true; // do display the search results

		/**
		 * Job Search Form
		 * Display job search form if $GET['edit-search']
		 */
		include('inc/browse-jobs/job-search-form.php');

		?>

		
		<?php 
		// only display search results if we're not editing form
		if ($display_search) {

			// create search object
			$cja_jobsearch = new CJA_Advert;

			// If there is postdata then update object from POST
			if ($_POST['update_job_search']) {
				$cja_jobsearch->update_from_form();
			// Otherwise populate from cookies
			} else {
			$cja_jobsearch->update_from_cookies(); // search criteria in $_POST are already stored as cookies on the init hook
			}

			//print_r($cja_jobsearch->build_wp_query());

			?>

			<h1>Postcode Test</h1>

			<div class="cja_search_criteria_box">
				<p><strong>Search Terms:</strong></p>

				<?php
				// Display the search criteria
				include('inc/browse-jobs/display_search_criteria.php');
				?>
				
				<p class="button-wrap"><a href="<?php echo get_the_permalink(); ?>?edit-search=true" class="cja_button cja_button--2">Edit Search Terms</a></p>

			</div>

            <h2>This is the postcode test bit</h2>

            <?php

                require 'inc/fmn/FindMyNearest.php';
                $fmn_file_address = get_stylesheet_directory_uri() . '/inc/fmn/data/postcodes.txt';
                $fmn = FindMyNearest::factory('textfile', array('datafile' => $fmn_file_address));
                if (! $fmn->loaddata()) {
                    echo "Error loading data: " . $fmn->lasterror() . "\n";
                    exit;
                  }
                $goodcode = $fmn->validcode('Se18lX');
                echo nl2br($goodcode . "\r\n");

                $distance = $fmn->calc_distance('NW55TT', 'LS21 1HF'); // calculate distance

                if ($distance === false) {
                echo "There was an error " . $fmn->lasterror();
                } else {
                    echo $distance . "\n";
                }

            ?>

			
			<?php

			$cja_current_user_obj = new CJA_User;
			
			$args = array(  
                    'post_type' => 'job_ad',
                    'author' => get_current_user_id(),
                    'posts_per_page' => -1,
					'meta_query' => array(
						array(
							'key' => 'cja_ad_status',
							'value' => 'active'
						),
						'order-clause' => array(
							'key' => 'cja_ad_activation_date',
							'type' => 'NUMERIC'
						)
					),
					'orderby' => 'order-clause', 
					'order' => 'DSC', 
				);
				
				$the_query = new WP_Query( $args );
                // print_r($cja_jobsearch->build_wp_query());
                
                $cja_results_array = array();

				if ( $the_query->have_posts() ) {

                    //$the_query->posts[0]->yourmum = 'hello';

                    //print_r($the_query->posts[0]);

                    while ( $the_query->have_posts() ) : $the_query->the_post();
                    
                    $cja_current_advert = new CJA_Advert(get_the_ID());
                    $the_query->reset_postdata();
					$cja_current_advertiser = new CJA_User($cja_current_advert->author);

                    // print_r($cja_current_advertiser);

                    if ($cja_current_advert->postcode) {
                        $cja_distance = $fmn->calc_distance('SE1 8LX', $cja_current_advert->postcode);
                    } else {
                        $cja_distance = 0;
                    }

                    ?>
                        <p>Post ID: <?php echo get_the_ID(); ?> Postcode: <?php echo $cja_current_advert->postcode; ?> Distance: <?php echo $cja_distance; ?></p>
                    
                    <?php

                        $cja_results_array[] = array(
                            'id' => get_the_ID(),
                            'distance' => $cja_distance
                        );


                    /*
					$cja_current_advert = new CJA_Advert(get_the_ID());
					$cja_current_advertiser = new CJA_User($cja_current_advert->author);

					?>
					<div class="cja_list_item">
						<?php 
						if ($cja_current_advert->applied_to_by_current_user) {
								$cja_user_application = new CJA_Application($cja_current_advert->applied_to_by_current_user);
								?><a class="cja_button" href="<?php echo get_the_permalink($cja_current_advert->applied_to_by_current_user); ?>">View Job</a><?php	
						} else {
							?><a class="cja_button" href="<?php echo get_the_permalink($cja_current_advert->id); ?>">View Job<?php if ($cja_current_user_obj->role == 'jobseeker') { echo (' and Apply'); } ?></a><?php
						}
						?>
						
						<h4 class="item-title"><?php echo ($cja_current_advert->title); ?></h4>
						<p class="item-meta"><?php echo ($cja_current_advert->author_human_name); 
							if ($cja_current_advertiser->postcode) {
								echo (', ' . $cja_current_advertiser->postcode);
							}
						?></p>
						<?php if ($cja_current_advert->applied_to_by_current_user) {
							$cja_user_application = new CJA_Application($cja_current_advert->applied_to_by_current_user);
							?><p class="green"><strong>You applied on <?php echo $cja_user_application->human_application_date; ?>.</strong></p>
							<?php
						} else { ?>
							<p class="item-meta"><em>Posted <?php 
								if ($cja_current_advert->days_old == 0) {
									echo ('today');
								} else if ($cja_current_advert->days_old == 1) {
									echo ('yesterday');
								} else {
									echo ($cja_current_advert->days_old) . ' days ago';
								} ?>
							</em></p>
						<?php } ?>
					</div>
					<?php

                    */

                    endwhile;

                    print_r($cja_results_array);

                    foreach($cja_results_array as $cja_result => $sub_array) {
                        if($sub_array['distance'] == 0){
                            unset($cja_results_array[$cja_result]);
                       }
                    }

                    $cja_distance = array_column($cja_results_array, 'distance');

                    echo nl2br("\r\n");

                    array_multisort($cja_distance, SORT_ASC, $cja_results_array);
                    print_r($cja_results_array);
                    
/*
					?>
					<div class="cja_pagination">
					<?php 
						echo paginate_links( array(
							'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
							'total'        => $the_query->max_num_pages,
							'current'      => max( 1, get_query_var( 'paged' ) ),
							'format'       => '?paged=%#%',
							'show_all'     => false,
							'type'         => 'plain',
							'end_size'     => 2,
							'mid_size'     => 1,
							'prev_next'    => true,
							'prev_text'    => '<<<',
							'next_text'    => '>>>',
							'add_args'     => false,
							'add_fragment' => '',
						) );
					?>
				</div>
                <?php
                */

				} else {

					echo("There are no jobs to view");
				}

			wp_reset_postdata();
			?>
		<?php } // end of $display_search test ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//do_action( 'storefront_sidebar' );
get_footer();
