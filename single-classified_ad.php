<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) :
			the_post();

			$cja_current_user_obj = new CJA_User();
			$cja_current_ad = new CJA_Classified_Advert(get_the_ID());
			$display_advert = true;

			?>

			<?php
			if ($display_advert) {
			
				// Display user messages
				if ($cja_current_ad->created_by_current_user) {

					if ($cja_current_ad->status == 'inactive') {
						?><p class="cja_alert cja_alert--amber">This Advert Is a Draft</p><?php
					}
					
					if ($cja_current_ad->status == 'deleted') {
						?><p class="cja_alert cja_alert--red">This Advert Has Been Deleted</p><?php
					}
				}
				?>

				<?php $cja_current_advertiser = new CJA_User($cja_current_ad->author); ?>
				<?php // print_r($cja_current_ad); ?>
				<h1 class="with-subtitle"><?php echo $cja_current_ad->title; ?></h1>
				<?php if ($cja_current_ad->status == 'deleted') {
					?><p class="red"><strong>This advert has been deleted</strong></p>
				<?php } ?>
				<p class="cja_center header_subtitle">Posted by <?php echo ($cja_current_ad->author_human_name); 
					if ($cja_current_ad->status == 'active') {
						echo ' on ' . ($cja_current_ad->human_activation_date); 
					}
				?></p>

				<?php include('inc/templates/classified-details.php'); ?>
				
				<?php

				/**
				 * DISPLAY USER OPTIONS
				 * 
				 * ADVERTISER
				 *  - Activate
				 *  - Edit
				 *  - Extend
				 *  - Delete
				 */
				include('inc/single-classified-ad/display-user-options.php');

			
			}

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//do_action( 'storefront_sidebar' );
get_footer();
