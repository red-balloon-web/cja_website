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

				// If we're not looking at a specific course then display all our courses
				
				if (!$_GET['advert_id']) { ?>

					<h1>Applications to My Courses</h1> <?php

					// Fetch non-deleted courses
					$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
					$args = array(
						'post_type' => 'course_ad',
						'author' => $cja_current_user_obj->id,
						'meta_query' => array(
							'activation_date' => array(
								'key' => 'cja_ad_activation_date'
							),
							'is_not_deleted' => array(
								'key' => 'cja_ad_status',
								'value' => 'deleted',
								'compare' => '!='
							)
						),
						'orderby' => 'activation_date',
						'order' => 'DESC',
						'paged' => $paged
					);
					$query = new WP_Query($args);

					
					// Loop through
					if ($query->have_posts()) {
						while ($query->have_posts()) {

							// For each course display the number of applications and a link to go to the page of applications for just that job
							$query->the_post();
							$cja_advert = new CJA_Course_Advert(get_the_id());

							// Display items in table ?>
							<div class="cja_list_item">
								<a href="<?php echo get_site_url(); ?>/course-applications?advert_id=<?php echo $cja_advert->id; ?>" class="cja_icon"><i class="fas fa-eye cja_tooltip"><div class="tooltiptext">view applications</div></i></a>
								<h4 class="item-title"><?php echo $cja_advert->title; ?></h4>
								<p class="item-meta">Placed on <?php echo $cja_advert->human_activation_date; ?></p>
								<p class="item-meta"><?php echo $cja_advert->display_application_count(); ?></p>
							</div><?php
						}?>

						<!-- pagination -->
						<div class="cja_pagination"> <?php 
							echo paginate_links( 
								array(
									'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
									'total'        => $query->max_num_pages,
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
					}
				} else { // if ($_GET['advert_id']) i.e. if we are looking at applications for an individual advert
					$cja_advert = new CJA_Course_Advert($_GET['advert_id']); ?>
					<h1>Applications for <?php echo $cja_advert->title; ?></h1>
					<p><a href="<?php echo get_site_url(); ?>/course-applications"><< Back to my course applications</a></p>
					<p style="margin-bottom: 0;">Advert placed on <?php echo $cja_advert->human_activation_date; ?></p>
					<p>CJA Code: <?php echo get_cja_code($cja_advert->id); ?></p>
					<p><a href="<?php echo get_site_url(); ?>/wp-admin/admin-post.php?action=create-course-applicants-csv&advert_id=<?php echo $cja_advert->id; ?>" class="cja_button">Export Applicants as CSV</a></p>
					<p>&nbsp;</p>


					<?php

					// Search for applications
					$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
					$args = array(
						'post_type' => 'course_application',
						'meta_key' => 'advertID',
						'meta_value' => $cja_advert->id,
						'orderby' => 'date',
						'paged' => $paged
					);
					$query = new WP_Query($args);
					//print_r($query);

					// Display applications table 
					if ($query->have_posts()) {
						while ($query->have_posts()) { 
							$query->the_post();
							$application = new CJA_Course_Application(get_the_ID());
							?>
							<div class="cja_list_item">
								<a href="<?php echo get_the_permalink($application->id); ?>" class="cja_icon"><i class="fas fa-eye cja_tooltip"><div class="tooltiptext">view application</div></i></a>
								<h4 class="item-title"><?php echo $application->applicant_name; ?></h4>
								<p class="item-meta"><?php echo $application->human_application_date; ?></p>
							</div><?php
						} ?>

						<!-- pagination -->
						<div class="cja_pagination"> <?php 
							echo paginate_links( 
								array(
									'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
									'total'        => $query->max_num_pages,
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
					}
				}

				/* OLD FORMAT FOR ADVERTISER APPLICATIONS SCREEN - DELETE AFTER A WHILE 21-1-21

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
				*/
			} // end if (role == advertiser) ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//do_action( 'storefront_sidebar' );
get_footer();