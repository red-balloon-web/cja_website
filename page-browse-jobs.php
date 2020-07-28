<?php

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<h1>Browse Jobs</h1>
		
		<?php

		$cja_current_user_obj = new CJA_User;

		$args = array(  
				'post_type' => 'job_ad',
				'meta_query' => array(
					array(
						'key' => 'cja_ad_status',
						'value' => 'active'
					),
					'order-clause' => array(
						'key' => 'cja_ad_activation_date',
						'type' => 'NUMERIC'
					)
				),
				'orderby' => 'order-clause', 
				'order' => 'DSC', 
			);
			$the_query = new WP_Query( $args );

			if ( $the_query->have_posts() ) {

				while ( $the_query->have_posts() ) : $the_query->the_post();

				$cja_current_advert = new CJA_Advert(get_the_ID());

				?>
				<div class="cja_list_item">
					<?php 
					if ($cja_current_advert->applied_to_by_current_user) {
							$cja_user_application = new CJA_Application($cja_current_advert->applied_to_by_current_user);
							?><a class="cja_button" href="<?php echo get_the_permalink($cja_current_advert->applied_to_by_current_user); ?>">View My Application</a><?php	
					} else {
						?><a class="cja_button" href="<?php echo get_the_permalink($cja_current_advert->id); ?>">View Job<?php if ($cja_current_user_obj->role == 'jobseeker') { echo (' and Apply'); } ?></a><?php
					}
					?>
					
					<h4 class="item-title"><?php echo ($cja_current_advert->title); ?></h4>
					<p class="item-meta"><?php echo ($cja_current_advert->author_human_name); ?></p>
					<p class="item-meta"><em>Posted <?php echo ($cja_current_advert->days_old); ?> days ago</em></p>
					<?php if ($cja_current_advert->applied_to_by_current_user) {
						$cja_user_application = new CJA_Application($cja_current_advert->applied_to_by_current_user);
						?><p class="green"><strong>You applied on <?php echo $cja_user_application->human_application_date; ?>.</strong></p>
						<?php
					} else { ?>
					<?php } ?>
				</div>
				<?php

				endwhile;

			} else {

				echo("There are no jobs to view");
			}

		wp_reset_postdata();
		?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//do_action( 'storefront_sidebar' );
get_footer();
