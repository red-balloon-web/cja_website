<?php
/**
 * The template for displaying all single posts.
 *
 * @package storefront
 */

get_header(); ?>

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

			
			$currentAd = new Advert;
			$currentAd->populate(get_the_ID());
						
			if ($_GET['action'] == 'apply') {
				?>

				<h2>Apply for Job: <?php echo $currentAd->title; ?></h2>
				<form action="<?php echo get_the_permalink(); ?>" method="post">
					<input type="hidden" name="doapplication" value="true">
					<p>Covering letter:</p>
					<textarea name="letter" id="" cols="30" rows="10"></textarea>
					<p></p>
					<p><input type="submit" value="Send Application"></p>
				</form>

				<?php
			}

			if ($_POST['doapplication'] == 'true') {
				$newApplication = new Application;
				$newApplication->advertID = $currentAd->id;
				$newApplication->applicantID = $cja_current_user_obj->id;
				$newApplication->advertiserID = $currentAd->author;
				$newApplication->applicantName = $cja_current_user_obj->fullname;
				$newApplication->applicantLetter = $cja_current_user_obj->applicantLetter;
				$newApplication->cvurl = $cja_current_user_obj->cvurl;
				print_r($newApplication);
			}
			?>

			<h1><?php echo $currentAd->title; ?></h1>
			<p>Posted by <?php echo ($currentAd->authorHumanName); ?> on <?php echo ($currentAd->humanActivationDate); ?></p>
			<p><?php echo $currentAd->content; ?></p>

			<?php

				if ($cja_current_user_obj->is_logged_in == false) {
					?><a href="">LOG IN OR CREATE ACCOUNT TO APPLY</a><?php
				}

				if ($cja_current_user_obj->role == 'jobseeker' || $cja_current_user_obj->role == 'administrator') {
					?><a href="<?php echo get_the_permalink(); ?>?action=apply">APPLY</a><?php
				}



			?>

			<?php

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action( 'storefront_sidebar' );
get_footer();
