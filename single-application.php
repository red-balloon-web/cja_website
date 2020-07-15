<?php get_header(); ?>

	<?php			
	// Set up current user object
	$cja_current_user_obj = new Cja_current_user;
	$cja_current_user_obj->populate(); 
	?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">


		<?php
		while ( have_posts() ) :
			the_post();
			
			$currentApplication = new Application;
			$currentApplication->populate(get_the_ID());

			?><!--<p>Application</p>--><?php
			//print_r($currentApplication);

			?><!--<p>Advert / Job</p>--><?php
			$currentAd = new Advert;
			$currentAd->populate($currentApplication->advertID);
			//print_r($currentAd);

			?><!--<p>Advertiser</p>--><?php
			$currentAdvertiser = new Cja_current_user;
			$currentAdvertiser->populate($currentApplication->advertiserID);
			//print_r($currentAdvertiser);

			?><!--<p>Applicant</p>--><?php
			$currentApplicant = new Cja_current_user;
			$currentApplicant->populate($currentApplication->applicantID);
			//print_r($currentApplicant);

			?>
			<h1>View Application</h1>
			<h2>Job Information</h2>
			<p>Job Title: <?php echo $currentAd->title; ?></p>
			<p>Posted on: <?php echo $currentAd->humanActivationDate; ?></p>
			<p>Company Name: <?php echo $currentAdvertiser->companyname; ?></p>
			<h2>Application Information</h2>
			<p>Name of Applicant: <?php echo $currentApplicant->fullname; ?></p>
			<p>Date of Application: <?php echo $currentApplication->applicationHumanDate; ?></p>
			<p>Covering Letter: <?php echo $currentApplication->applicantLetter; ?></p>
			<p>CV: <?php echo $currentApplication->cvurl; ?></p>
			<?php


		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//do_action( 'storefront_sidebar' );
get_footer();
