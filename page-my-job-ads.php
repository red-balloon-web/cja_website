<?php

get_header(); ?>

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
		include('inc/my-adverts/post-functions.php');

		/**
		 * GET FUNCTIONS
		 * 
		 *  - Display new ad form
		 *  - Display update ad form
		 *  - Display buy credits page
		 *  - Activate ad
		 *  - Delete ad
		 *  - Extend ad
		 */
		include('inc/my-adverts/get-functions.php');

		if ($do_list) {
			$cja_current_user = new CJA_User; ?>
			<div class="my-jobs-header">
				<span class="credits-large"><?php echo ($cja_current_user->credits); ?></span>&nbsp;&nbsp;advert credits remaining
				<a href="<?php echo get_page_link() . '?create-ad=true'; ?>" class="cja_button cja_button--2 my-jobs-header-button create-advert-button">Create Advert</a>
				<a href="<?php echo get_page_link() . '?buy-credits=true'; ?>" class="cja_button cja_button--2 my-jobs-header-button">Buy Credits</a>
		</div>
			<h1>My Job Adverts</h1>
			<div class="results">

			<?php

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
				//'posts_per_page' => 5,
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
							<a class="cja_icon" href="<?php echo $cja_page_address; ?>?delete-ad=<?php echo get_the_ID(); ?>"><i class="fa fa-trash"></i></a>
							<a class="cja_icon" href="<?php echo $cja_page_address; ?>?edit-ad=<?php echo get_the_ID(); ?>"><i class="fas fa-edit"></i></a>
							<a class="cja_icon" href="<?php echo get_the_permalink($currentad->id); ?>"><i class="fas fa-eye"></i></a>
							<?php if ($currentad->status == 'active') {
								?><a class="cja_icon" href="<?php echo ($cja_page_address . '?extend-ad=' . get_the_ID()); ?>"><i class="fas fa-clock"></i></a><?php
							} else if ($currentad->status == 'inactive') {
								?><a class="cja_spend_button" href="<?php echo ($cja_page_address . '?activate-ad=' . get_the_ID()); ?>"><span>ACTIVATE</span><br>1 Credit</a><?php
							}

							?>

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

<?php
//do_action( 'storefront_sidebar' );
get_footer();