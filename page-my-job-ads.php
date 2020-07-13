<?php

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php

		$pageaddress = get_page_link();

			if ($_POST) {

				if ($_POST['process-create-ad']) {

					$newAd = new Advert;
					$newAd->create(); // save a new post in the database
					$newAd->updateFromForm(); // put form values into advert object
					$newAd->status = 'inactive'; // because we created a new advert
					$newAd->expiryDate = 100; // Must have expiry date to show in list
					$newAd->saveToDatabase(); // save the object values into the database
					?><p class="cja_alert">Your Advert "<?php echo $newAd->title; ?>" Was Created!</p><?php
				}

				if ($_POST['update-ad']) {

					$updateAd = new Advert;
					$updateAd->populate($_POST['advert-id']); // populate with the current values
					$updateAd->updateFromForm(); // replace where there is fresh information in form
					$updateAd->saveToDatabase(); // save all values to DB
					?><p class="cja_alert">Your advert for "<?php echo ($updateAd->title); ?>" has been updated.</p><?php
				}

			}

			if ($_GET) {

				if ($_GET['delete-ad']) {

					$deleteAd = new Advert;
					$deleteAd->populate($_GET['delete-ad']);
					$deleteAd->delete(); //saves in database also
					?><p class="cja_alert">Your advert for "<?php echo ($deleteAd->title); ?>" has been deleted.</p><?php
				}

				if ($_GET['edit-ad']) {
					$editAd = new Advert;
					$editAd->populate($_GET['edit-ad'])
					?>
					<form action="<?php echo $pageaddress; ?>" method="POST">
						<p>Advert Title</p>
						<input type="text" name="ad-title" value="<?php echo ($editAd->title); ?>">
						<p>Advert Text</p>
						<textarea name="ad-content" id="" cols="30" rows="10"><?php echo ($editAd->content); ?></textarea>
						<input type="hidden" name="update-ad" value="true" >
						<input type="hidden" name="advert-id" value="<?php echo ($editAd->id); ?>">
						<input type="submit" value="Update Advert">
					</form>
					<?php
				}

				if ($_GET['create-ad']) { ?>
					<form action="<?php echo $pageaddress; ?>" method="POST">
						<p>Advert Title</p>
						<input type="text" name="ad-title">
						<p>Advert Text</p>
						<textarea name="ad-content" id="" cols="30" rows="10"></textarea>
						<input type="hidden" name="process-create-ad" value="true">
						<input type="submit" value="Create Advert">
					</form>
				<?php }

				if ($_GET['extend-ad']) {
					$extendAd = new Advert;
					$extendAd->populate($_GET['extend-ad']);
					$extendAd->extend(); // saves to database
					spend_credits();
					?><p class="cja_alert">Your advert for "<?php echo ($extendAd->title); ?>" has been extended for 1 credit.</p><?php
				}

				if ($_GET['activate-ad']) {

					$activateAd = new Advert;
					$activateAd->populate($_GET['activate-ad']);
					$activateAd->activate(); // saves in database
					spend_credits();
					?><p class="cja_alert">Your advert for "<?php echo ($activateAd->title); ?>" has been activated for 1 credit.</p><?php
				}
			}
			?>

			<h2>My Job Ads</h2>
			<div class="job-ads-header">
				<p>You have <?php echo (get_user_meta( get_current_user_id(), "cja_credits", true)); ?> advert credits remaining</p>
				<a href="<?php echo $pageaddress . '?create-ad=true'; ?>">CREATE AD</a>
				<a href="">BUY CREDITS</a>
			</div>

			<?php

			// Query Arguments
			$args = array(  
				'post_type' => 'job_ad',
				'author' => get_current_user_id(),
				'meta_query' => array(
					array(
						'key' => 'cja_ad_status',
						'value' => 'deleted',
						'compare' => '!='
					),
					'order-clause' => array(
						'key' => 'cja_ad_expiry_date',
						'type' => 'NUMERIC'
					)
				),
				'orderby' => 'order-clause', 
				'order' => 'ASC', 
			);
			$the_query = new WP_Query( $args );

			// The Loop to list job ads
			if ( $the_query->have_posts() ) {

				while ( $the_query->have_posts() ) : $the_query->the_post(); 

					$currentad = new Advert;
					$currentad->populate(get_the_ID());
					// print_r($currentad); // testing

					?>
						<div class="my-account-job-advert">
							<div class="maja_title_row">
								<div class="maja_title">
									<strong><?php echo $currentad->title; ?></strong><br>
									<?php echo strtoupper($currentad->status); 
									if ($currentad->isActive()) {
										echo (" ({$currentad->daysLeft()} days remaining)");
									} ?>
								</div>
								<div class="maja_option">
									<?php if ($currentad->status == 'active') { ?>
										<a href="<?php echo ($pageaddress . '?extend-ad=' . get_the_ID()); ?>">EXTEND</a>
									<?php } else if ($currentad->status == 'inactive') { ?>
										<a href="<?php echo ($pageaddress . '?activate-ad=' . get_the_ID()); ?>">ACTIVATE</a>
									<?php } else if ($currentad->status == 'expired') { ?>
										<a href="<?php echo ($pageaddress . '?activate-ad=' . get_the_ID()); ?>">REACTIVATE</a>
									<?php } ?>
								</div>
								<div class="maja_edit"><a href="<?php echo $pageaddress; ?>?edit-ad=<?php echo get_the_ID(); ?>">EDIT</a></div>
								<div class="maja_delete"><a href="<?php echo $pageaddress; ?>?delete-ad=<?php echo get_the_ID(); ?>">DELETE</a></div>
							</div>
						</div>
					<?php

				endwhile;

			} else {
					echo ("You have not yet created any ads");
			}
			// End Loop

			wp_reset_postdata();

			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//do_action( 'storefront_sidebar' );
get_footer();
