<?php

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php

		$cja_page_address = get_page_link();

			if ($_POST) {

				if ($_POST['process-create-ad']) {

					$cja_new_ad = new CJA_Advert;
					$cja_new_ad->create(); // create a new post in the database
					$cja_new_ad->update_from_form(); 
					$cja_new_ad->save(); 
					?><p class="cja_alert">Your Advert "<?php echo $cja_new_ad->title; ?>" Was Created!</p><?php
				}

				if ($_POST['update-ad']) {

					$cja_update_ad = new CJA_Advert($_POST['advert-id']);
					$cja_update_ad->update_from_form(); 
					$cja_update_ad->save(); 
					?><p class="cja_alert">Your advert for "<?php echo ($cja_update_ad->title); ?>" has been updated.</p><?php
				}

			}

			if ($_GET) {

				if ($_GET['delete-ad']) {

					$cja_delete_ad = new CJA_Advert($_GET['delete-ad']);
					$cja_delete_ad->delete(); 
					$cja_delete_ad->save();
					?><p class="cja_alert">Your advert for "<?php echo ($cja_delete_ad->title); ?>" has been deleted.</p><?php
				}

				if ($_GET['edit-ad']) {
					$cja_edit_ad = new CJA_Advert($_GET['edit-ad']);
					?>
					<form action="<?php echo $cja_page_address; ?>" method="POST">
						<p>Advert Title</p>
						<input type="text" name="ad-title" value="<?php echo ($cja_edit_ad->title); ?>">
						<p>Advert Text</p>
						<textarea name="ad-content" id="" cols="30" rows="10"><?php echo ($cja_edit_ad->content); ?></textarea>
						<input type="hidden" name="update-ad" value="true" >
						<input type="hidden" name="advert-id" value="<?php echo ($cja_edit_ad->id); ?>">
						<input type="submit" value="Update Advert">
					</form>
					<?php
				}

				if ($_GET['create-ad']) { ?>
					<form action="<?php echo $cja_page_address; ?>" method="POST">
						<p>Advert Title</p>
						<input type="text" name="ad-title">
						<p>Advert Text</p>
						<textarea name="ad-content" id="" cols="30" rows="10"></textarea>
						<input type="hidden" name="process-create-ad" value="true">
						<input type="submit" value="Create Advert">
					</form>
				<?php }

				if ($_GET['extend-ad']) {
					$cja_extend_ad = new CJA_Advert($_GET['extend-ad']);
					$cja_extend_ad->extend();
					$cja_extend_ad->save();
					spend_credits();
					?><p class="cja_alert">Your advert for "<?php echo ($cja_extend_ad->title); ?>" has been extended for 1 credit.</p><?php
				}

				if ($_GET['activate-ad']) {

					$cja_activate_ad = new CJA_Advert($_GET['activate-ad']);
					$cja_activate_ad->activate();
					$cja_activate_ad->save();
					spend_credits();
					?><p class="cja_alert">Your advert for "<?php echo ($cja_activate_ad->title); ?>" has been activated for 1 credit.</p><?php
				}
			}
			?>

			<h2>My Job Ads</h2>
			<div class="job-ads-header">
				<p>You have <?php echo (get_user_meta( get_current_user_id(), "cja_credits", true)); ?> advert credits remaining</p>
				<a href="<?php echo $cja_page_address . '?create-ad=true'; ?>">CREATE AD</a>
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

					$currentad = new CJA_Advert(get_the_ID());
					// print_r($currentad); // testing

					?>
						<div class="my-account-job-advert">
							<div class="maja_title_row">
								<div class="maja_title">
									<strong><?php echo $currentad->title; ?></strong><br>
									<?php echo strtoupper($currentad->status); 
									if ($currentad->status == 'active') {
										echo (" ({$currentad->days_left} days remaining)");
									} ?>
								</div>
								<div class="maja_view"><a href="<?php echo get_the_permalink($currentad->id); ?>">VIEW</a></div>
								<div class="maja_option">
									<?php if ($currentad->status == 'active') { ?>
										<a href="<?php echo ($cja_page_address . '?extend-ad=' . get_the_ID()); ?>">EXTEND</a>
									<?php } else if ($currentad->status == 'inactive') { ?>
										<a href="<?php echo ($cja_page_address . '?activate-ad=' . get_the_ID()); ?>">ACTIVATE</a>
									<?php } else if ($currentad->status == 'expired') { ?>
										<a href="<?php echo ($cja_page_address . '?activate-ad=' . get_the_ID()); ?>">REACTIVATE</a>
									<?php } ?>
								</div>
								<div class="maja_edit"><a href="<?php echo $cja_page_address; ?>?edit-ad=<?php echo get_the_ID(); ?>">EDIT</a></div>
								<div class="maja_delete"><a href="<?php echo $cja_page_address; ?>?delete-ad=<?php echo get_the_ID(); ?>">DELETE</a></div>
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
