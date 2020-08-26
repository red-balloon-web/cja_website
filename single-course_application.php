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
			
			
			$cja_current_application = new CJA_Course_Application(get_the_ID());
			$cja_current_ad = new CJA_Course_Advert($cja_current_application->advert_ID);
			$cja_current_advertiser = new CJA_User($cja_current_application->advertiser_ID);
			$cja_current_applicant = new CJA_User($cja_current_application->applicant_ID);

			
			/*include('inc/single-application/display-options.php');*/

			?>
			<!--<hr>-->
			<h1>View Course Application</h1>
			
			<?php include('inc/templates/course-application-details.php'); ?>
			<hr>
			<?php include('inc/templates/applicant-details.php'); ?>
			<hr>
			<?php include('inc/templates/course-details.php'); ?>
			<hr>
			<?php include('inc/templates/company-details.php'); ?>
			<hr>
			<?php /**
			 * DISPLAY OPTIONS
			 * 
			 *  - Archive (jobseeker)
			 *  - Archive (advertiser)
			 */
			include('inc/single-course-application/display-options.php');

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//do_action( 'storefront_sidebar' );
get_footer();
