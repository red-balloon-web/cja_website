<?php

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
			$cja_current_page_url = get_the_permalink();

            $cja_current_user_obj = new CJA_User;
			if ($cja_current_user_obj->role == 'jobseeker') {
				
				if ($_GET['applicant_archive']) {
					$cja_archive_application = new CJA_Application($_GET['applicant_archive']);
					$cja_archive_application_advert = new CJA_Advert($cja_archive_application->advert_ID);
					$cja_archive_application->applicant_archive();
					$cja_archive_application->save();
					?><p class="cja_alert">You archived your application to '<?php echo $cja_archive_application_advert->title; ?>' at <?php echo $cja_archive_application_advert->author_human_name; ?>.</p><?php
				}
				
				?>

				<h2>Applications I Have Made</h2>
				

				<?php

				// Query Arguments
				$args = array(  
					'post_type' => 'application',
					'author' => get_current_user_id(),
					'order' => 'ASC', 
					'meta_query' => array(
						array(
							'key' => 'applicant_archived',
							'value' => '0'
						)
					),
				);
				$the_query = new WP_Query( $args );

				// The Loop to list job ads
				if ( $the_query->have_posts() ) {

					while ( $the_query->have_posts() ) : $the_query->the_post(); 

					// create objects
					$cja_current_application = new CJA_Application(get_the_ID());
					$cja_current_advert = new CJA_Advert($cja_current_application->advert_ID);
					$cja_current_advertiser = new CJA_User($cja_current_application->advertiser_ID);
					$cja_current_applicant = new CJA_User($cja_current_application->applicant_ID);
					?>
							
						<div class="my-account-job-advert">
							<div class="maja_title_row">
								<div class="maja_title">
									<h3><?php echo $cja_current_advert->title; ?></h3>
									<p>At: <?php echo $cja_current_advertiser->company_name; ?></p>
									<p>Applied on: <?php echo $cja_current_application->human_application_date; ?></p>
									<?php if ($cja_current_application->applicant_archived) {
										?><p>This application is archived</p><?php
									} ?>
									<a href="<?php echo get_the_permalink($cja_current_application->id); ?>">VIEW</a>
									<a href="<?php echo $cja_current_page_url; ?>?applicant_archive=<?php echo $cja_current_application->id; ?>">ARCHIVE</a>
								</div>
							</div>
						</div>
					<?php

					endwhile;

				} else {
						echo ("You have not yet made any applications");
				}
				// End Loop

				wp_reset_postdata();

			} // End if (role == 'jobseeker')
			else if ($cja_current_user_obj->role == 'advertiser') {

				if ($_GET['advertiser_archive']) {
					$cja_archive_application = new CJA_Application($_GET['advertiser_archive']);
					$cja_archive_application_advert = new CJA_Advert($cja_archive_application->advert_ID);
					$cja_archive_application->advertiser_archive();
					$cja_archive_application->save();
					?><p class="cja_alert">You archived <?php echo $cja_archive_application->applicant_name; ?>'s application for '<?php echo $cja_archive_application_advert->title; ?>'.</p><?php
				}

				?>
            
				<h2>Applications to My Jobs</h2>

				<?php

				// Query Arguments
				$args = array(  
					'post_type' => 'application',
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
				);
				$the_query = new WP_Query( $args );

				// The Loop to list job ads
				if ( $the_query->have_posts() ) {

					while ( $the_query->have_posts() ) : $the_query->the_post(); 
						?>
						<!--
					<p>Application: <?php
					$cja_current_application = new CJA_Application(get_the_ID());
					print_r($cja_current_application); ?></p>

					<p>Advert: <?php
					$cja_current_advert = new CJA_Advert($cja_current_application->advert_ID);
					print_r($cja_current_advert); ?></p>

					<p>Advertiser: <?php
					$cja_current_advertiser = new CJA_User($cja_current_application->advertiser_ID);
					print_r($cja_current_advertiser); ?></p>
					
					<p>Applicant: <?php 
					$cja_current_applicant = new CJA_User($cja_current_application->applicant_ID);
					print_r($cja_current_applicant); ?></p>-->
							
							<div class="my-account-job-advert">
								<div class="maja_title_row">
									<div class="maja_title">
										<h3><?php echo $cja_current_advert->title; ?></h3>
										<p>Application by: <?php echo $cja_current_applicant->full_name; ?></p>
										<?php if ($cja_current_application->advertiser_archived) {
										?><p>This application is archived</p><?php
									} ?>
										<a href="<?php echo get_the_permalink($cja_current_application->id); ?>">VIEW</a>
										<a href="<?php echo $cja_current_page_url; ?>?advertiser_archive=<?php echo $cja_current_application->id; ?>">ARCHIVE</a>
									</div>
								</div>
							</div>
						<?php

					endwhile;

				} else {
						echo ("You have not yet received any applications");
				}
				// End Loop

				wp_reset_postdata();

			} // end if (role == advertiser)

            ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//do_action( 'storefront_sidebar' );
get_footer();
