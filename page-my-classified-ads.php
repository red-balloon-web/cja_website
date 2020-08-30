<?php

get_header(); 
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">


		<?php

		$cja_page_address = get_page_link();
		$do_list = true; // show the list of job ads

		/**
		 * POST FUNCTIONS
		 * 
		 *  - Create advert from form
		 *  - Update advert from form
		 */
		include('inc/my-classified-adverts/post-functions.php');

		/**
		 * GET FUNCTIONS
		 * 
		 *  - Display new ad form
		 *  - Display update ad form
		 *  - Activate ad
		 *  - Delete ad
		 *  - Extend ad
		 */
		include('inc/my-classified-adverts/get-functions.php');

		if ($do_list) {
			$cja_current_user = new CJA_User; 
			?>

			<div class="my-jobs-header">
				<div class="cja_credits_remaining"><span class="credits-large"><?php 
						if ($cja_current_user->classified_credits) {
							echo ($cja_current_user->classified_credits); 
						} else {
							echo '0';
						}
							?></span>&nbsp;&nbsp;classified advert credits remaining</div>
				<?php if ($cja_current_user->classified_credits > 0) { ?>
					<a href="<?php echo get_page_link() . '?create-ad=true'; ?>" class="cja_button cja_button--2 my-jobs-header-button create-advert-button">Create Advert</a>
				<?php } ?>
				<a href="<?php echo get_site_url(); ?>/my-account/purchase-credits" class="cja_button cja_button--2 my-jobs-header-button">Buy Credits</a>
			</div>

			<?php if ($cja_current_user->classified_credits < 1) {
				?><p class="cja_alert cja_alert--amber">Please purchase credits to create, extend or reactivate your ads</p><?php
			} ?>

			<h1>My Classified Adverts</h1>
			<div class="results">

			<?php

			// Query Arguments
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			$args = array(  
				'post_type' => 'classified_ad',
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
			//global $wp_query;
			//print_r($wp_query);
			$query = new WP_Query( $args );
			//print_r($wp_query);
			//$wp_query = new WP_Query( $args );

			// The Loop to list job ads
			if ( $query->have_posts() ) {

				while ( $query->have_posts() ) : $query->the_post(); 

					$currentad = new CJA_Advert(get_the_ID());
					$query->reset_postdata();

					?>
						<div class="cja_list_item">
							<div class="cja_icon_set">
								<div class="cja_icon cja_call_are_you_sure" data-linkurl="<?php echo $cja_page_address; ?>?delete-ad=<?php echo get_the_ID(); ?>" data-yaybutton="Delete" data-text="Delete Advert"><i class="fa fa-trash cja_tooltip"><div class="tooltiptext">delete</div></i></div>

								<a class="cja_icon" href="<?php echo $cja_page_address; ?>?edit-ad=<?php echo get_the_ID(); ?>"><i class="fas fa-edit cja_tooltip"><div class="tooltiptext">edit</div></i></a>
								<a class="cja_icon" href="<?php echo get_the_permalink($currentad->id); ?>"><i class="fas fa-eye cja_tooltip"><div class="tooltiptext">view</div></i></a>
								<?php if ($currentad->status == 'active') {
									?>

									<?php if ($cja_current_user->credits > 0) { 
										if (get_option('cja_charge_users') || $currentad->days_left < 35) {
										?>
											<div class="cja_icon cja_extend_button cja_call_are_you_sure" data-text="Extend Advert (1 Credit)" data-yaybutton="Extend" data-linkurl="<?php echo ($cja_page_address . '?extend-classified-ad=' . get_the_ID()); ?>"><i class="fas fa-clock cja_tooltip"><div class="tooltiptext">extend</div></i></div>
										<?php } ?>
									<?php } ?>

									
									<?php
								} else if ($currentad->status == 'expired' && $cja_current_user->credits > 0) {
									?>
										<div class="cja_icon cja_extend_button cja_call_are_you_sure" data-text="Reactivate Advert for 1 month (1 Credit)" data-yaybutton="Activate" data-linkurl="<?php echo ($cja_page_address . '?activate-ad=' . get_the_ID()); ?>"><i class="fas fa-clock cja_tooltip"><div class="tooltiptext">reactivate</div></i></div>
									<?php
								}

								?>
							</div>

							<h4 class="item-title"><?php echo $currentad->title; ?></h4>
							<p class="item-meta <?php echo $currentad->status; ?>">
								<span><?php echo strtoupper($currentad->status); ?></span><?php 
								if ($currentad->status == 'active') {
									echo (" ({$currentad->days_left} days remaining)");
								} ?>
							</p>
						</div>
					<?php

				endwhile; ?>
				</div>

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
						) );
					?>
				</div> 
			
			<?php
			} else {
					echo ("You have not yet created any ads");
			}
			// End Loop

			wp_reset_postdata();
		}
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<script>
jQuery(document).ready(function() {

	jQuery('.cja_call_are_you_sure').on('click', function(e) {
		jQuery('#cja_modal_message').text(jQuery(this).data('text'));
		jQuery('#modal-yay').attr('href', jQuery(this).data('linkurl'));
		jQuery('#modal-yay').text(jQuery(this).data('yaybutton'));
		jQuery('#cja_are_sure_modal_wrapper').css('visibility', 'visible');
	}); 

	jQuery('#cja_are_sure_modal_wrapper').on('click', function(e) {
		if (e.target == this) {
			jQuery('#cja_are_sure_modal_wrapper').css('visibility', 'hidden');
		}
	});

	jQuery('#modal-nay').on('click', function(e) {
		jQuery('#cja_are_sure_modal_wrapper').css('visibility', 'hidden');
	});

});
</script>

<?php
//do_action( 'storefront_sidebar' );
get_footer();