<?php

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main"><?php
			$cja_current_page_url = get_the_permalink();
			$cja_current_user_obj = new CJA_User;
			
			/**
			 * JOBSEEKER SECTION
			 * Display the section for applicants
			 */
			if ($cja_current_user_obj->role == 'jobseeker') {

				// Archive a given application if user has just selected to archive it
				if ($_GET['applicant_archive']) {
					$cja_archive_application = new CJA_Course_Application($_GET['applicant_archive']);
					$cja_archive_application_advert = new CJA_Course_Advert($cja_archive_application->advert_ID);
					$cja_archive_application->applicant_archive();
					$cja_archive_application->save(); ?>
					<p class="cja_alert cja_alert--success">You archived your application to '<?php echo $cja_archive_application_advert->title; ?>' with <?php echo $cja_archive_application_advert->author_human_name; ?>.</p><?php
				} ?>

				<h1>Course Applications I Have Made</h1>
				
				<!-- filter to show archived or current applications -->
				<div class="application-filter-options">
					<form action="<?php echo get_site_url() ?>/course-applications" method="get">
						<p>Show: 
							<select name="show-archived" id="">
								<option value="false">Unarchived</option>
								<option value="true" <?php if ($_GET['show-archived'] == 'true') { echo 'selected'; } ?>>Archived</option>
							</select>
							<input type="submit" class="cja_button cja_button--2" value="Go">
						</p>
					</form>
				</div><?php

				// Query to get either archived or non-archived applications
				$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
				$args = array(  
					'post_type' => 'course_application',
					'author' => get_current_user_id(),
					'order' => 'ASC', 
					'meta_query' => array(
						array(
							'key' => 'applicant_archived',
							'value' => '0'
						)
					),
					'paged' => $paged
				);
				if ($_GET['show-archived'] == 'true') {
					$args['meta_query'][0]['compare'] = '!=';
				}
				$the_query = new WP_Query( $args );

				// The Loop
				if ( $the_query->have_posts() ) {

					while ( $the_query->have_posts() ) : $the_query->the_post(); 

						// Set up objects
						$cja_current_application = new CJA_Course_Application(get_the_ID());
						$cja_current_advert = new CJA_Course_Advert($cja_current_application->advert_ID);
						$the_query->reset_postdata();
						$cja_current_advertiser = new CJA_User($cja_current_application->advertiser_ID);
						$cja_current_applicant = new CJA_User($cja_current_application->applicant_ID);
						
						// display items in table ?>
						<div class="cja_list_item"><?php 
							if ($_GET['show-archived'] != 'true') { ?> 
								<a href="<?php echo $cja_current_page_url; ?>?applicant_archive=<?php echo $cja_current_application->id; ?>" class="cja_icon"><i class="fa fa-trash cja_tooltip"><div class="tooltiptext">archive</div></i></a><?php 
							} ?>
							<a href="<?php echo get_the_permalink($cja_current_application->id); ?>" class="cja_icon"><i class="fas fa-eye cja_tooltip"><div class="tooltiptext">view</div></i></a>
							<h4 class="item-title"><?php echo $cja_current_advert->title; ?></h4>
							<p class="item-meta"><?php echo $cja_current_advertiser->company_name; ?></p>
							<p class="item-meta"><em>You applied on <?php echo $cja_current_application->human_application_date; ?></em></p>
						</div><?php

					endwhile; ?>

					<!-- pagination -->
					<div class="cja_pagination"><?php 
						echo paginate_links( 
							array(
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
							) 
						); ?>
					</div><?php
				} else {
						echo ("You have not yet made any applications");
				}
				// End Loop
				wp_reset_postdata();
			}


			/**
			 * ADVERTISER SECTION
			 * Else if the user is an advertiser or admin show the advertiser section
			 */
			else if ($cja_current_user_obj->role == 'advertiser' || $cja_current_user_obj->role == 'administrator') {

				// archive application if user has just selected that
				if ($_GET['advertiser_archive']) {
					$cja_archive_application = new CJA_Course_Application($_GET['advertiser_archive']);
					if (!$cja_archive_application->advertiser_archived) {
						$cja_archive_application_advert = new CJA_Course_Advert($cja_archive_application->advert_ID);
						$cja_archive_application->advertiser_archive();
						$cja_archive_application->save();
						?><p class="cja_alert cja_alert--success">You archived <?php echo $cja_archive_application->applicant_name; ?>'s application for '<?php echo $cja_archive_application_advert->title; ?>'.</p><?php
					}
				} ?>
            
				<h1>Applications to My Courses</h1>

				<!-- show archived or unarchived -->
				<div class="application-filter-options">
					<form action="<?php echo get_site_url() ?>/course-applications" method="get">
						<p>Show: 
							<select name="show-archived" id="">
								<option value="false">Unarchived</option>
								<option value="true" <?php if ($_GET['show-archived'] == 'true') { echo 'selected'; } ?>>Archived</option>
							</select>
							<input type="submit" class="cja_button cja_button--2" value="Go">
						</p>
					</form>
				</div><?php

				// Query
				$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
				$args = array(  
					'post_type' => 'course_application',
					'meta_query' => array(
						array(
							'key' => 'advertiserID',
							'value' => $cja_current_user_obj->id
						),
						array(
							'key' => 'advertiser_archived',
							'value' => '0'
						)
					),
					'order' => 'ASC', 
					'paged' => $paged
				);
				if ($_GET['show-archived'] == 'true') {
					$args['meta_query'][1]['compare'] = '!=';
				}
				$the_query = new WP_Query( $args );

				// Loop
				if ( $the_query->have_posts() ) {
					while ( $the_query->have_posts() ) : $the_query->the_post(); 

						// Set up objects
						$cja_current_application = new CJA_Application(get_the_ID());
						$cja_current_advert = new CJA_Advert($cja_current_application->advert_ID);
						$the_query->reset_postdata();
						$cja_current_advertiser = new CJA_User($cja_current_application->advertiser_ID);
						$cja_current_applicant = new CJA_User($cja_current_application->applicant_ID);
						
						// Display items in table ?>
						<div class="cja_list_item"><?php 
							if ($_GET['show-archived'] != 'true') { ?>
								<a href="<?php echo $cja_current_page_url; ?>?advertiser_archive=<?php echo $cja_current_application->id; ?>" class="cja_icon"><i class="fa fa-trash cja_tooltip"><div class="tooltiptext">archive</div></i></a><?php 
							} ?>
							<a href="<?php echo get_the_permalink($cja_current_application->id); ?>" class="cja_icon"><i class="fas fa-eye cja_tooltip"><div class="tooltiptext">view</div></i></a>
							<h4 class="item-title"><?php echo $cja_current_advert->title; ?></h4>
							<p class="item-meta"><em><?php echo $cja_current_applicant->full_name; ?> :: <?php echo $cja_current_application->human_application_date; ?></em></p>
						</div><?php

					endwhile;

					// Pagination ?>
					<div class="cja_pagination"><?php 
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
						) ); ?>
					</div><?php

				} else {
						echo ("You have not yet received any applications");
				}
				// End Loop
				wp_reset_postdata();

			} // end if (role == advertiser) ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//do_action( 'storefront_sidebar' );
get_footer();