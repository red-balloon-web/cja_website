<?php

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
			$cja_current_page_url = get_the_permalink();
			$cja_current_user_obj = new CJA_User;
			
			/**
			 * JOBSEEKER SECTION
			 */
			if ($cja_current_user_obj->role == 'jobseeker') {

				/**
				 * JOBSEEKER GET FUNCTIONS
				 *  - Archive Application
				 */
				include ('inc/applications/jobseeker-get-functions.php');
				?>

				<h1>Applications I Have Made</h1>
				
				<?php
				$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
				$args = array(  
					'post_type' => 'application',
					'author' => get_current_user_id(),
					'order' => 'ASC', 
					'meta_query' => array(
						array(
							'key' => 'applicant_archived',
							'value' => '0'
						)
					),
					'paged' => $paged
				);
				$the_query = new WP_Query( $args );

				// The Loop
				if ( $the_query->have_posts() ) {

					while ( $the_query->have_posts() ) : $the_query->the_post(); 

					// Set up objects
					$cja_current_application = new CJA_Application(get_the_ID());
					$cja_current_advert = new CJA_Advert($cja_current_application->advert_ID);
					$the_query->reset_postdata();
					$cja_current_advertiser = new CJA_User($cja_current_application->advertiser_ID);
					$cja_current_applicant = new CJA_User($cja_current_application->applicant_ID);
					?>
							
					<div class="cja_list_item">
						<a href="<?php echo $cja_current_page_url; ?>?applicant_archive=<?php echo $cja_current_application->id; ?>" class="cja_icon"><i class="fa fa-trash cja_tooltip"><div class="tooltiptext">archive</div></i></a>
						<a href="<?php echo get_the_permalink($cja_current_application->id); ?>" class="cja_icon"><i class="fas fa-eye cja_tooltip"><div class="tooltiptext">view</div></i></a>
						<h4 class="item-title"><?php echo $cja_current_advert->title; ?></h4>
						<p class="item-meta"><?php echo $cja_current_advertiser->company_name; ?></p>
						<p class="item-meta"><em>You applied on <?php echo $cja_current_application->human_application_date; ?></em></p>
					</div>
					<?php

					endwhile;
					?>
					<div class="cja_pagination">
					<?php 
						echo paginate_links( array(
							'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
							'total'        => $the_query->max_num_pages,
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
						echo ("You have not yet made any applications");
				}
				// End Loop

				wp_reset_postdata();

			}
			/**
			 * ADVERTISER SECTION
			 */
			else if ($cja_current_user_obj->role == 'advertiser') {

				/**
				 * ADVERTISER GET FUNCTIONS
				 *  - Archive Application
				 */
				include ('inc/applications/advertiser-get-functions.php');
				?>
            
				<h1>Applications to My Jobs</h1>

				<?php
				$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
				$args = array(  
					'post_type' => 'application',
					'meta_query' => array(
						array(
							'key' => 'advertiserID',
							'value' => $cja_current_user_obj->id
						),
						array(
							'key' => 'advertiser_archived',
							'value' => '0'
						)
					),
					'order' => 'ASC', 
					'paged' => $paged
				);

				$the_query = new WP_Query( $args );

				// Loop
				if ( $the_query->have_posts() ) {
					while ( $the_query->have_posts() ) : $the_query->the_post(); 

					// Set up objects
					$cja_current_application = new CJA_Application(get_the_ID());
					$cja_current_advert = new CJA_Advert($cja_current_application->advert_ID);
					$the_query->reset_postdata();
					$cja_current_advertiser = new CJA_User($cja_current_application->advertiser_ID);
					$cja_current_applicant = new CJA_User($cja_current_application->applicant_ID);
					?>
							
					<div class="cja_list_item">
						<a href="<?php echo $cja_current_page_url; ?>?advertiser_archive=<?php echo $cja_current_application->id; ?>" class="cja_icon"><i class="fa fa-trash cja_tooltip"><div class="tooltiptext">archive</div></i></a>
						<a href="<?php echo get_the_permalink($cja_current_application->id); ?>" class="cja_icon"><i class="fas fa-eye cja_tooltip"><div class="tooltiptext">view</div></i></a>
						<h4 class="item-title"><?php echo $cja_current_advert->title; ?></h4>
						<p class="item-meta"><em><?php echo $cja_current_applicant->full_name; ?> :: <?php echo $cja_current_application->human_application_date; ?></em></p>
					</div>

					<?php

					endwhile;

					?>
					<div class="cja_pagination">
					<?php 
						echo paginate_links( array(
							'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
							'total'        => $the_query->max_num_pages,
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
						echo ("You have not yet received any applications");
				}
				// End Loop

				wp_reset_postdata();

			} // end if (role == advertiser)

            ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//do_action( 'storefront_sidebar' );
get_footer();
