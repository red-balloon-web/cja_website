<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
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

			/**
			 * ADVERTISER FUNCTIONS
			 * 
			 *  $_GET
			 *  - Extend ad
			 *  - Activate ad
			 *  - Display edit ad form
			 * 
			 *  $_POST
			 *  - Update advert if submitted
			 */
			include ('inc/single-ad/advertiser-get-post-functions.php');

			?>

			<?php
			if ($display_advert) {
			
				// Display user messages
				if ($cja_current_ad->created_by_current_user) {
					if ($cja_current_ad->status == 'active') {
						?><p class="cja_alert_success">You Placed this Advert on <?php echo $cja_current_ad->human_activation_date; ?> (<?php echo $cja_current_ad->days_left; ?> days left)</p><?php
					}
					if ($cja_current_ad->status == 'inactive') {
						?><p class="cja_alert cja_alert--amber">This Advert Is a Draft</p><?php
					}
					if ($cja_current_ad->status == 'deleted') {
						?><p class="cja_alert cja_alert--red">This Advert Has Been Deleted</p><?php
					}
				}
				?>

				<!--<hr>-->
				<?php $cja_current_advertiser = new CJA_User($cja_current_ad->author); ?>
				<?php // print_r($cja_current_ad); ?>
				<h1 class="with-subtitle"><?php echo $cja_current_ad->title; ?></h1>
				<?php if ($cja_current_ad->status == 'deleted') {
					?><p class="red"><strong>This advert has been deleted</strong></p>
				<?php } ?>
				<p class="cja_center header_subtitle">Posted by <?php echo ($cja_current_ad->author_human_name); 
					if ($cja_current_ad->status == 'active') {
						echo ' on ' . ($cja_current_ad->human_activation_date); 
					}
				?></p>
				
				<?php include('inc/templates/job-details.php'); ?>

				<hr>

				<?php include('inc/templates/company-details.php'); ?>

				<hr>

				<?php

				if ($cja_current_user_obj->is_logged_in == false) {
					?><a href="<?php echo get_site_url(); ?>/my-account" class="cja_button cja_button--2">Log In or Create Account to Apply</a><?php
				}

				// show apply button if user is jobseeker and if we are not on the application page already
				if ($cja_current_user_obj->role == 'jobseeker' && $_GET['action'] != 'apply') {
					if ($cja_current_ad->applied_to_by_current_user) {
						$cja_user_application = new CJA_Application($cja_current_ad->applied_to_by_current_user);

						?><p><strong>You applied to this job on <?php echo $cja_user_application->human_application_date; ?></strong></p><?php
					} else {
						?><a class="cja_button" href="<?php echo get_the_permalink(); ?>?action=apply">Apply for this Job</a><?php
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

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//do_action( 'storefront_sidebar' );
get_footer();
