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
			
			
			?><!--<p>Application</p><?php
			$cja_current_application = new CJA_Application(get_the_ID());
			print_r($cja_current_application);

			?><p>Advert / Job</p><?php
			$cja_current_application_advert = new CJA_Advert($cja_current_application->advert_ID);
			print_r($cja_current_application_advert);

			?><p>Advertiser</p><?php
			$cja_current_advertiser = new CJA_User($cja_current_application->advertiser_ID);
			print_r($cja_current_advertiser);

			?><p>Applicant</p><?php
			$cja_current_applicant = new CJA_User($cja_current_application->applicant_ID);
			print_r($cja_current_applicant);

			?>
			-->
			
			<h1>View Application</h1>
			<h2>Job Information</h2>
			<p>Job Title: <?php echo $cja_current_application_advert->title; ?></p>
			<p>Posted on: <?php echo $cja_current_application_advert->human_activation_date; ?></p>
			<p>Company Name: <?php echo $cja_current_advertiser->company_name; ?></p>
			<h2>Application Information</h2>
			<p>Name of Applicant: <?php echo $cja_current_applicant->full_name; ?></p>
			<p>Date of Application: <?php echo $cja_current_application->human_application_date; ?></p>
			<p>Covering Letter: <?php echo $cja_current_application->applicant_letter; ?></p>
			<p>CV: <?php echo $cja_current_application->cv_url; ?></p>
		
			<?php


		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//do_action( 'storefront_sidebar' );
get_footer();
