<?php 
get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main"><?php

		while ( have_posts() ) :
			the_post();

			$cja_current_user_obj = new CJA_User();
			$cja_current_ad = new CJA_Advert(get_the_ID());
			$display_advert = true;

			/**
			 * JOBSEEKER FUNCTIONS
			 * 
			 *  - Display application form
			 *  - Create new application from POST
			 *  - Display message if already applied
			 */
			include ('inc/single-ad/jobseeker-get-post-functions.php');

			// Display advert if we're displaying it
			if ($display_advert) {
			
				// Display user messages
				if ($cja_current_ad->created_by_current_user) {
					/*
					if ($cja_current_ad->status == 'active') {
						?><p class="cja_alert_success">You Placed this Advert on <?php echo $cja_current_ad->human_activation_date; ?> (<?php echo $cja_current_ad->days_left; ?> days left)</p><?php
					}
					*/
					if ($cja_current_ad->status == 'inactive') {
						?><p class="cja_alert cja_alert--amber">This Advert Is a Draft</p><?php
					}
					
					if ($cja_current_ad->status == 'deleted') {
						?><p class="cja_alert cja_alert--red">This Advert Has Been Deleted</p><?php
					}
				}

				$cja_current_advertiser = new CJA_User($cja_current_ad->author); ?>
				<h1 class="with-subtitle"><?php echo $cja_current_ad->title; ?></h1><?php 
				if ($cja_current_ad->status == 'deleted') { ?>
					<p class="red"><strong>This advert has been deleted</strong></p><?php 
				} ?>
				<p class="cja_center header_subtitle">Posted by <?php echo ($cja_current_ad->author_human_name); 
					if ($cja_current_ad->status == 'active') {
						echo ' on ' . ($cja_current_ad->human_activation_date); 
					} ?>
				</p><?php 
				
				// Display job details
				include('inc/templates/job-details.php');
				include('inc/templates/company-details.php'); ?>

				<hr><?php

				// Not logged in message
				if ($cja_current_user_obj->is_logged_in == false) {
					?><a href="<?php echo get_site_url(); ?>/my-account" class="cja_button cja_button--2">Log In or Create Account to Apply</a><?php
				}

				// show apply button if user is jobseeker and if we are not on the application page already and online applications are enabled
				if ($cja_current_user_obj->role == 'jobseeker' && $_GET['action'] != 'apply') {

					// If already applied
					if ($cja_current_ad->applied_to_by_current_user) {
						$cja_user_application = new CJA_Application($cja_current_ad->applied_to_by_current_user);

						?><p><strong>You applied to this job on <?php echo $cja_user_application->human_application_date; ?></strong></p><?php
					} else {

						// If online applications enabled for this job
						if ($cja_current_ad->can_apply_online) { ?>
						<p>
							<a class="cja_button cja_button--mar-right" href="<?php echo get_the_permalink(); ?>?action=apply">Apply for this Job</a>
							<a class="cja_button cja_button--mar-right" href="<?php echo get_site_url(); ?>/browse-jobs">Search Jobs</a>
						</p><?php

						} else { ?>
							<p><strong>Please contact the advertiser directly to apply for this job</strong></p>
							<p><a class="cja_button cja_button--mar-right" href="<?php echo get_site_url(); ?>/browse-jobs">Search Jobs</a></p><?php
						}
					}
				}

				/**
				 * DISPLAY USER OPTIONS
				 * 
				 * ADVERTISER
				 *  - Activate
				 *  - Edit
				 *  - Extend
				 *  - Delete
				 */
				include('inc/single-ad/display-user-options.php');

			}

		endwhile; // End of the loop.?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
//do_action( 'storefront_sidebar' );
get_footer();
