<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">


		<?php
		while ( have_posts() ) :
			the_post();

			$cja_current_user_obj = new CJA_User();
			$cja_current_ad = new CJA_Advert(get_the_ID());
			print_r ($cja_current_ad);

			// Do this stuff for jobseekers
			if ($cja_current_user_obj->role == 'jobseeker') {
						
				// Display form to apply
				if ($_GET['action'] == 'apply') {
					?>

					<h2>Apply for Job: <?php echo $cja_current_ad->title; ?></h2>
					<form action="<?php echo get_the_permalink(); ?>" method="post">
						<input type="hidden" name="do-application" value="true">
						<p>Covering letter:</p>
						<textarea name="letter" id="" cols="30" rows="10"></textarea>
						<p></p>
						<p><input type="submit" value="Send Application"></p>
					</form>

					<?php
				}

				// Create new application
				if ($_POST['do-application']) {
					$cja_new_application = new CJA_Application;
					$cja_new_application->create(get_the_ID());
					$cja_new_application->update_from_form($cja_current_ad, $cja_current_user_obj);
					$cja_new_application->save();
					?><p class="cja_alert">You Applied to <?php echo $cja_current_ad->title; ?></p><?php
				}
			}
			?>

			<?php
			// Does this ad belong to the current user
			if ($cja_current_ad->created_by_current_user) {

				// Extend this ad
				if ($_GET['extend-ad']) {
					$cja_extend_ad = new CJA_Advert(get_the_ID());
					$cja_extend_ad->extend();
					$cja_extend_ad->save();
					spend_credits();
					?><p class="cja_alert">Your advert for "<?php echo ($cja_extend_ad->title); ?>" has been extended for 1 credit.</p><?php
					$cja_current_ad = new CJA_Advert(get_the_ID());
				}

				// Display edit ad form
				if ($_GET['edit-ad']) { 
					$cja_edit_ad = new CJA_Advert(get_the_ID()); ?>
					<form action="<?php echo get_the_permalink() ?>" method="POST">
						<p>Advert Title</p>
						<input type="text" name="ad-title" value="<?php echo ($cja_edit_ad->title); ?>">
						<p>Advert Text</p>
						<textarea name="ad-content" id="" cols="30" rows="10"><?php echo ($cja_edit_ad->content); ?></textarea>
						<input type="hidden" name="update-ad" value="true" >
						<input type="hidden" name="advert-id" value="<?php echo ($cja_edit_ad->id); ?>">
						<input type="submit" value="Update Advert">
					</form>
				<?php }

				// Update advert if form submitted
				if ($_POST['update-ad']) {

					$cja_update_ad = new CJA_Advert($_POST['advert-id']);
					$cja_update_ad->update_from_form(); 
					$cja_update_ad->save(); 
					?><p class="cja_alert">Your advert for "<?php echo ($cja_update_ad->title); ?>" has been updated.</p><?php
					$cja_current_ad = new CJA_Advert(get_the_ID());
				}

				?><p><strong>You placed this advert on <?php echo $cja_current_ad->human_activation_date; ?> (<?php echo $cja_current_ad->days_left; ?> days left)</strong></p>
				<p><a href="<?php echo get_the_permalink(); ?>?edit-ad=true">EDIT</a> <a href="<?php echo get_the_permalink(); ?>/?extend-ad=true">EXTEND</a> <a href="<?php echo get_site_url() . '/' . $cja_config['my-jobs-admin-page-slug'] . '?delete-ad=' . $cja_current_ad->id; ?>">DELETE</a></p><?php
			}
			?>
			<?php $cja_current_advertiser = new CJA_User($cja_current_ad->author); ?>
			<h1><?php echo $cja_current_ad->title; ?></h1>
			<p>Posted by <?php echo ($cja_current_ad->author_human_name); ?> on <?php echo ($cja_current_ad->human_activation_date); ?></p>
			<h3>About The Job</h3>
			<p><?php echo $cja_current_ad->content; ?></p>
			<h3>About <?php echo $cja_current_ad->author_human_name; ?></h3>
			<p><?php echo $cja_current_advertiser->company_description; ?></p>

			

			<?php

				if ($cja_current_user_obj->is_logged_in == false) {
					?><a href="<?php echo get_site_url(); ?>/my-details" class="button">LOG IN OR CREATE ACCOUNT TO APPLY</a><?php
				}

				// show apply button if user is jobseeker and if we are not on the application page already
				if ($cja_current_user_obj->role == 'jobseeker' && $_GET['action'] != 'apply') {
					?><a class="button" href="<?php echo get_the_permalink(); ?>?action=apply">APPLY FOR THIS JOB</a><?php
				}

			?>

			<?php

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//do_action( 'storefront_sidebar' );
get_footer();
