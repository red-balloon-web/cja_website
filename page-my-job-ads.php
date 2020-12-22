<?php
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main"><?php

		$cja_page_address = get_page_link();
		$do_list = true; // show the list of job ads

		// update ad if we have been sent the post data
		if ($_POST['update-ad']) {

			$cja_update_ad = new CJA_Advert($_POST['advert-id']);
			$cja_update_ad->update_from_form(); 
			$cja_update_ad->save(); 
			?><p class="cja_alert cja_alert--success">Your advert for "<?php echo ($cja_update_ad->title); ?>" has been updated.<span class="right"><a href="<?php echo get_site_url() . '/' . $cja_config['my-job-ads-slug']; ?>"> Return to My Adverts</a></span></p><?php
		}

		/**
		 * GET FUNCTIONS
		 * 
		 *  - Display new ad form
		 *  - Display update ad form
		 *  - Activate ad
		 *  - Delete ad
		 *  - Extend ad
		 */
		include('inc/my-adverts/get-functions.php');

		// Display the advert list if we're displaying it
		if ($do_list) {
			$cja_current_user = new CJA_User; 
			
			// Header - client temporarily disabled credits section ?>
			<!--<div class="my-jobs-header">
				<div class="cja_credits_remaining"><span class="credits-large"><?php echo ($cja_current_user->credits); ?></span>&nbsp;&nbsp;advert credits remaining</div><?php 
				if ($cja_current_user->credits > 0) { ?>
					<a href="<?php echo get_page_link() . '?create-ad=true'; ?>" class="cja_button cja_button--2 my-jobs-header-button create-advert-button">Create Advert</a><?php 
				} ?>
				<a href="<?php echo get_site_url(); ?>/my-account/purchase-credits'; ?>" class="cja_button cja_button--2 my-jobs-header-button">Buy Credits</a>
			</div>-->
			
			<!-- replaced above with this line - delete it when we put credits back -->
			<a href="<?php echo get_page_link() . '?create-ad=true'; ?>" class="cja_button cja_button--2 my-jobs-header-button create-advert-button">Create Advert</a><?php 
			
			if ($cja_current_user->credits < 1) {
				?><p class="cja_alert cja_alert--amber">Please purchase credits to create, extend or reactivate your ads</p><?php
			} ?>

			<h1>My Job Adverts</h1>
			<div class="results"><?php

			// Query Arguments
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
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
        		'paged' => $paged
			);
			$query = new WP_Query( $args );

			// The Loop to list ads
			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) : $query->the_post(); 

					$currentad = new CJA_Advert(get_the_ID());
					$query->reset_postdata();?>
					
					<!-- result container -->
					<div class="cja_list_item">

						<!-- icons for delete, extend, etc. -->
						<div class="cja_icon_set">
							<div class="cja_icon cja_call_are_you_sure" data-linkurl="<?php echo $cja_page_address; ?>?delete-ad=<?php echo get_the_ID(); ?>" data-yaybutton="Delete" data-text="Delete Advert"><i class="fa fa-trash cja_tooltip"><div class="tooltiptext">delete</div></i></div>

							<a class="cja_icon" href="<?php echo $cja_page_address; ?>?edit-ad=<?php echo get_the_ID(); ?>"><i class="fas fa-edit cja_tooltip"><div class="tooltiptext">edit</div></i></a>
							<a class="cja_icon" href="<?php echo get_the_permalink($currentad->id); ?>"><i class="fas fa-eye cja_tooltip"><div class="tooltiptext">view</div></i></a><?php 
							
							// Display extend icon if advert is active
							// Replace data-text="Extend Advert" with data-text="Extend Advert (1 Credit)" when we put credits back. See also reactivate icon below
							if ($currentad->status == 'active') {
								if ($cja_current_user->credits > 0) { 
									if (get_option('cja_charge_users') || $currentad->days_left < 35) {?>
										<div class="cja_icon cja_extend_button cja_call_are_you_sure" data-text="Extend Advert" data-yaybutton="Extend" data-linkurl="<?php echo ($cja_page_address . '?extend-ad=' . get_the_ID()); ?>"><i class="fas fa-clock cja_tooltip"><div class="tooltiptext">extend</div></i></div><?php 
									}
								}
							// else display reactivate icon
							} else if ($currentad->status == 'expired' && $cja_current_user->credits > 0) { ?>
									<div class="cja_icon cja_extend_button cja_call_are_you_sure" data-text="Reactivate Advert for 1 month" data-yaybutton="Activate" data-linkurl="<?php echo ($cja_page_address . '?activate-ad=' . get_the_ID()); ?>"><i class="fas fa-clock cja_tooltip"><div class="tooltiptext">reactivate</div></i></div><?php
							} ?>
						</div>

						<!-- advert details -->
						<h4 class="item-title"><?php echo $currentad->title; ?></h4>
						<p class="item-meta <?php echo $currentad->status; ?>">
							<span><?php 
								if ($currentad->status == 'inactive') {
									echo 'AWAITING APPROVAL';
								} else {
									echo strtoupper($currentad->status); 
								} ?>
							</span><?php 
							if ($currentad->status == 'active') {
								echo (" ({$currentad->days_left} days remaining)");
							} ?>
						</p>
					</div><?php

				endwhile; ?>
				</div><!-- results -->

				<!-- pagination -->
				<div class="cja_pagination">
					<?php 
						echo paginate_links( array(
							'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
							'total'        => $query->max_num_pages,
							'current'      => max( 1, get_query_var( 'paged' ) ),
							'format'       => '?paged=%#%',
							'show_all'     => false,
							'type'         => 'plain',
							'end_size'     => 2,
							'mid_size'     => 1,
							'prev_next'    => true,
							'prev_text'    => '<<<',
							'next_text'    => '>>>',
							'add_args'     => false,
							'add_fragment' => '',
						) ); ?>
				</div> <?php
			} else {
				echo ("You have not yet created any ads");
			}
			// End Loop
			wp_reset_postdata();
		} ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<script>
jQuery(document).ready(function() {

	// Bring up the are you sure modal
	jQuery('.cja_call_are_you_sure').on('click', function(e) {
		jQuery('#cja_modal_message').text(jQuery(this).data('text'));
		jQuery('#modal-yay').attr('href', jQuery(this).data('linkurl'));
		jQuery('#modal-yay').text(jQuery(this).data('yaybutton'));
		jQuery('#cja_are_sure_modal_wrapper').fadeIn(200).css('display', 'flex');
	}); 

	// Fade out the modal if the user clicks outside the box
	jQuery('#cja_are_sure_modal_wrapper').on('click', function(e) {
		if (e.target == this) {
			jQuery('#cja_are_sure_modal_wrapper').fadeOut(200);
		}
	});

	// Fade out the modal if the user clicks the no button
	jQuery('#modal-nay').on('click', function(e) {
		jQuery('#cja_are_sure_modal_wrapper').fadeOut(200);
	});

});
</script>

<?php
//do_action( 'storefront_sidebar' );
get_footer();