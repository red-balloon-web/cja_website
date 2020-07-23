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
					
					if (!$_GET['draft']) {
						$cja_new_ad->activate();
						$cja_new_ad->save();
						spend_credits();
						?><p class="cja_alert">Your Advert "<?php echo $cja_new_ad->title; ?>" Was Created for 1 Credit!</p><?php
					} else {
					
					?><p class="cja_alert">Your Advert "<?php echo $cja_new_ad->title; ?>" Was Created!</p><?php

					}
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
						<input type="submit" value="Create Advert (1 Credit)">
						<input type="submit" formaction="<?php echo $cja_page_address; ?>?draft=true" value="Save as Draft">
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

			<?php $cja_current_user = new CJA_User; ?>
			<p>
			<span class="credits-large"><?php echo ($cja_current_user->credits); ?></span>&nbsp;&nbsp;advert credits remaining
			<a href="" class="cja_button create-ad-button">Create Advert</a>
			<a href="" class="cja_button create-ad-button">Buy Credits</a>
			</p>
			<h1>My Job Adverts</h1>
			<!--<div class="job-ads-header">
				<p>You have <?php echo (get_user_meta( get_current_user_id(), "cja_credits", true)); ?> advert credits remaining</p>
				<a href="<?php echo get_page_link(); ?>?add-to-cart=8">1 Credit £30</a>
				<a href="<?php echo get_page_link(); ?>?add-to-cart=8">10 Credits £150</a>
			</div>-->
			
			<!--<a href="<?php echo $cja_page_address . '?create-ad=true'; ?>">CREATE NEW ADVERT</a>-->

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
					$the_query->reset_postdata();

					?>
						<div class="cja_list_item">
							<a class="cja_button" href="<?php echo $cja_page_address; ?>?delete-ad=<?php echo get_the_ID(); ?>">DELETE</a>
							<a class="cja_button" href="<?php echo $cja_page_address; ?>?edit-ad=<?php echo get_the_ID(); ?>">EDIT</a>
							<?php if ($currentad->status == 'active') { ?>
								<a class="cja_button" href="<?php echo ($cja_page_address . '?extend-ad=' . get_the_ID()); ?>">EXTEND</a>
							<?php } else if ($currentad->status == 'inactive') { ?>
								<a class="cja_button" href="<?php echo ($cja_page_address . '?activate-ad=' . get_the_ID()); ?>">ACTIVATE</a>
							<?php } else if ($currentad->status == 'expired') { ?>
								<a class="cja_button" href="<?php echo ($cja_page_address . '?activate-ad=' . get_the_ID()); ?>">REACTIVATE</a>
							<?php } ?>
							<a class="cja_button" href="<?php echo get_the_permalink($currentad->id); ?>">VIEW</a>
							<h4 class="item-title"><?php echo $currentad->title; ?></h4>
							<p class="item-meta">
								<?php echo strtoupper($currentad->status); 
								if ($currentad->status == 'active') {
									echo (" ({$currentad->days_left} days remaining)");
								} ?>
							</p>
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
