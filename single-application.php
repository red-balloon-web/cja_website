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
			/*include('inc/single-application/display-options.php');*/

			?>
			<!--<hr>-->
			<h1>View Application</h1>
			<div class="basic_details application_box">
				<h2>Basic Details</h2>
				<h4>Applicant: <strong><?php echo $cja_current_applicant->full_name; ?></strong></h4>
				<h4>Job Title: <strong><?php echo $cja_current_application_advert->title; ?></strong></h4>
				<h4>Company: <strong><?php echo $cja_current_advertiser->company_name; ?></strong></h4>
				<h4>Date: <strong><?php echo $cja_current_application->human_application_date; ?></strong></h4>
				<!--<h4>Application by <strong><?php echo $cja_current_applicant->full_name; ?></strong> for <strong><?php echo $cja_current_application_advert->title; ?></strong> at <strong><?php echo $cja_current_advertiser->company_name; ?></strong> on <strong><?php echo $cja_current_application->human_application_date; ?></strong></h4>-->
				<h4>Covering Letter:</h4> 
				<p><?php echo $cja_current_application->applicant_letter; ?></p>
			</div>
			
			<div class="applicant_details application_box">
				<h2>Applicant Details</h2>
				<h4>Name: <strong><?php echo $cja_current_applicant->full_name; ?></strong></h4>
				<h4>Phone Number: <strong><?php echo $cja_current_applicant->phone; ?></strong></h4>
				<h4>Postcode: <strong><?php echo $cja_current_applicant->postcode; ?></strong></h4>
				<h4>Age Category: <strong><?php echo $cja_current_applicant->age_category; ?></strong></h4>
				<h4>GCSE Maths: <strong><?php echo $cja_current_applicant->return_human('gcse_maths'); ?></strong></h4>
				<h4>Weekends Availability: <strong><?php echo $cja_current_applicant->return_human('weekends_availability'); ?></strong></h4>
				<p><a target="_blank" href="<?php echo $cja_current_application->cv_url; ?>" class="cja_button">Download CV</a></p>
			</div>
			<div class="job_details application_box">
				<h2>Job Information</h2>
				<h4>Job Title: <strong><?php echo $cja_current_application_advert->title; ?></strong></h4>
				<h4>Posted on: <strong><?php echo $cja_current_application_advert->human_activation_date; ?></strong></h4>
				<h4>Company Name: <strong><?php echo $cja_current_advertiser->company_name; ?></strong></h4>
				<h4>Salary: <strong><?php echo $cja_current_application_advert->salary; ?></strong></h4>
				<h4>Contact person: <strong><?php echo $cja_current_application_advert->contact_person; ?></strong></h4>
				<h4>Contact phone number: <strong><?php echo $cja_current_application_advert->phone; ?></strong></h4>
				<h4>Deadline: <strong><?php echo $cja_current_application_advert->deadline; ?></strong></h4>
				<h4>Job Type: <strong><?php echo $cja_current_application_advert->return_human('job_type'); ?></strong></h4>
				<h4>Sector: <strong><?php echo $cja_current_application_advert->return_human('sectors'); ?></strong></h4>
			</div>
			

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
