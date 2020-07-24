<?php get_header(); ?>

	<?php			
	// Set up current user object
	$cja_current_user_obj = new CJA_User;
	?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">


		<?php
		while ( have_posts() ) :
			the_post();
			
			
			$cja_current_application = new CJA_Application(get_the_ID());
			$cja_current_application_advert = new CJA_Advert($cja_current_application->advert_ID);
			$cja_current_advertiser = new CJA_User($cja_current_application->advertiser_ID);
			$cja_current_applicant = new CJA_User($cja_current_application->applicant_ID);

			/**
			 * DISPLAY OPTIONS
			 * 
			 *  - Archive (jobseeker)
			 *  - Archive (advertiser)
			 */
			include('inc/single-application/display-options.php');

			?>
			<hr>
			<h1>View Application</h1>
			<p>Name of Applicant: <?php echo $cja_current_applicant->full_name; ?></p>
			<p>Date of Application: <?php echo $cja_current_application->human_application_date; ?></p>
			<p>Covering Letter: <?php echo $cja_current_application->applicant_letter; ?></p>
			<p><a target="_blank" href="<?php echo $cja_current_application->cv_url; ?>" class="cja_button">Download CV</a></p>
			<h2>Job Information</h2>
			<p>Job Title: <?php echo $cja_current_application_advert->title; ?></p>
			<p>Posted on: <?php echo $cja_current_application_advert->human_activation_date; ?></p>
			<p>Company Name: <?php echo $cja_current_advertiser->company_name; ?></p>

			<hr>
		
			<?php
			include('inc/single-application/display-options.php');

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//do_action( 'storefront_sidebar' );
get_footer();
