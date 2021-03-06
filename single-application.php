<?php 

get_header();

// Set up current user object
$cja_current_user_obj = new CJA_User; ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main"><?php

		while ( have_posts() ) :
			the_post();
			
			$cja_current_application = new CJA_Application(get_the_ID());
			$cja_current_ad = new CJA_Advert($cja_current_application->advert_ID);
			$cja_current_advertiser = new CJA_User($cja_current_application->advertiser_ID);
			$cja_current_applicant = new CJA_User($cja_current_application->applicant_ID); ?>

			<h1 class="with-subtitle">View Job Application</h1>
			<p class="cja_center cja_code"><?php echo get_cja_code($cja_current_application->id); ?></p><?php

			if ($cja_current_user_obj->role == 'advertiser' || $cja_current_user_obj->role == 'administrator') { ?>
			
				<p>&nbsp;</p>
				<p><a href="<?php echo get_site_url(); ?>/applications-jobs?advert_id=<?php echo $cja_current_ad->id; ?>"><< Back to <?php echo $cja_current_ad->title; ?> applications</a></p> <?php
			
			}
			
			include('inc/templates/application-details.php');
			$candidate_template = 'jobseeker';
			include('inc/templates/candidate-details.php');
			include('inc/templates/job-details.php');
			include('inc/templates/company-details.php'); ?>

			<?php 
			
			/**
			 * DISPLAY OPTIONS
			 * 
			 *  - Archive (jobseeker)
			 *  - Archive (advertiser)
			 */
			include('inc/single-application/display-options.php');

		endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//do_action( 'storefront_sidebar' );
get_footer();
