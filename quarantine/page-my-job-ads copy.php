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
					//print_r($newAd);
					
					/*
					$postarray = array(
					
						'post_title' => wp_strip_all_tags( $_POST['ad-title'] ),
						'post_content' => wp_strip_all_tags( $_POST['ad-content'] ),
						'post_type' => 'job_ad',
						'post_status' => 'publish'
					);
				
					$success = wp_insert_post( $postarray, true );
					*/
				
					/*
					if ($success) {
						?><p class="cja_alert">Your Advert "<?php echo get_the_title($success); ?>" Was Created!</p><?php
						update_post_meta( $success, 'cja_ad_status', 'inactive');
					} else {
						?><p class="cja_alert">Oh no! There was an error!!</p><?php
					}
					*/
				}

				if ($_POST['update-ad']) {

					$updateAd = new Advert;
					$updateAd->populate($_POST['advert-id']); // populate with the current values
					$updateAd->updateFromForm(); // replace where there is fresh information in form
					$updateAd->saveToDatabase(); // save all values to DB
					print_r($updateAd);

					/*
					$update_post_values = array(
						'ID'           => $_POST['advert-id'],
						'post_title'   => $_POST['ad-title'],
						'post_content' => $_POST['ad-content'],
					);
					wp_update_post( $update_post_values );
					?>
					<p class="cja_alert">Your advert for "<?php echo get_the_title($_POST['advert-id']); ?>" has been updated.</p>
					
					<?php
					*/
				}

			}

			if ($_GET) {

				if ($_GET['delete-ad']) {
					//$ad_id_to_delete = $_GET['delete-ad'];
					//update_post_meta($ad_id_to_delete, 'cja_ad_status', 'deleted');

					$deleteAd = new Advert;
					$deleteAd->populate($_GET['delete-ad']);
					$deleteAd->delete(); //saves in database also
					?>
					<p class="cja_alert">Your advert for "<?php echo ($deleteAd->title); ?>" has been deleted.</p>
					<?php
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

					//$ad_id_to_extend = $_GET['extend-ad'];
					/*$current_expiration_timestamp = get_post_meta($ad_id_to_extend, 'cja_ad_expiry_date', true);
					update_post_meta($ad_id_to_extend, 'cja_ad_expiry_date', strtotime(date("j F Y", strtotime("+1 month", $current_expiration_timestamp))));
					$credits = get_user_meta( get_current_user_id(), "cja_credits", true);
					$credits--;
					update_user_meta( get_current_user_id(), "cja_credits", $credits);*/
					?>
					<p class="cja_alert">Your advert for "<?php echo ($extendAd->title); ?>" has been extended for 1 credit.</p>
					<?php
				}

				if ($_GET['activate-ad']) {

					$activateAd = new Advert;
					$activateAd->populate($_GET['activate-ad']);
					$activateAd->activate(); // saves in database
					spend_credits();

					//$ad_id_to_activate = $_GET['activate-ad'];
					//update_post_meta($ad_id_to_activate, 'cja_ad_status', 'active');
					//update_post_meta($ad_id_to_activate, 'cja_ad_activation_date', strtotime(date('j F Y')));
					//update_post_meta($ad_id_to_activate, 'cja_ad_expiry_date', strtotime(date("j F Y", strtotime("+1 month", strtotime(date('j F Y'))))));
					//$credits = get_user_meta( get_current_user_id(), "cja_credits", true);
					//$credits--;
					//update_user_meta( get_current_user_id(), "cja_credits", $credits);
					?>
					<p class="cja_alert">Your advert for "<?php echo ($activateAd->title); ?>" has been activated for 1 credit.</p>
					<?php
				}

				/*
				if ($_GET['reactivate-ad']) {
					$ad_id_to_activate = $_GET['reactivate-ad'];
					update_post_meta($ad_id_to_activate, 'cja_ad_status', 'active');
					update_post_meta($ad_id_to_activate, 'cja_ad_expiry_date', strtotime(date("j F Y", strtotime("+1 month", strtotime(date('j F Y'))))));
					$credits = get_user_meta( get_current_user_id(), "cja_credits", true);
					$credits--;
					update_user_meta( get_current_user_id(), "cja_credits", $credits);
					?>
					<p class="cja_alert">Your advert for "<?php echo get_the_title($ad_id_to_activate); ?>" has been reactivated for 1 credit.</p>
					<?php
				}
				*/

			}


			?>

			<div class="job-ads-header">
				<p>You have <?php echo (get_user_meta( get_current_user_id(), "cja_credits", true)); ?> advert credits remaining</p>
				<a href="<?php echo $pageaddress . '?create-ad=true'; ?>">CREATE AD</a>
				<a href="">BUY CREDITS</a>
			</div>

			<!-- testing --> 
			<?php
			/*
			function has_woocommerce_subscription($the_user_id, $the_product_id, $the_status) {
				$current_user = wp_get_current_user();
				if (empty($the_user_id)) {
					$the_user_id = $current_user->ID;
				}
				if (WC_Subscriptions_Manager::user_has_subscription( $the_user_id, $the_product_id, $the_status)) {
					return true;
				}

			}
			
			if (WC_Subscriptions_Manager::user_has_subscription( get_current_user_id(), 48, 'active')) {
				echo ("subscritpion to 48 badman");
			} else {
				echo ("no subscription found");
			}

			*/
			?>
			<!-- end testing -->

			<?php

			// Custom Query
			/*$args = array(  
				'post_type' => 'job_ad',
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
			); */

			$args = array(  
				'post_type' => 'job_ad',
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
					print_r($currentad);

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
do_action( 'storefront_sidebar' );
get_footer();
