<?php

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<h1>Browse Job Adverts</h1>
		
		<?php

		$cja_current_user_obj = new CJA_User;

		$args = array(  
				'post_type' => 'job_ad',
				'meta_query' => array(
					array(
						'key' => 'cja_ad_status',
						'value' => 'deleted',
						'compare' => '!='
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
				<div class="jobs-archive-item">
					<p class="jai-title"><strong><?php echo ($cja_current_advert->title); ?></strong> at <?php echo ($cja_current_advert->author_human_name); ?></p>
					<p class="jai-content"><?php echo ($cja_current_advert->content); ?></p>
					<p>Posted on <?php echo ($cja_current_advert->human_activation_date); ?></p>
					<?php if ($cja_current_advert->applied_to_by_current_user) {
						$cja_user_application = new CJA_Application($cja_current_advert->applied_to_by_current_user);
						?><p><strong>You applied on <?php echo $cja_user_application->human_application_date; ?>.</strong></p>
						<!--<a class="button" href="<?php echo get_the_permalink($cja_current_advert->id); ?>">View Job</a>&nbsp;--><a class="button" href="<?php echo get_the_permalink($cja_current_advert->applied_to_by_current_user); ?>">View My Application</a>	
						<?php
					} else { ?>
					<a class="button" href="<?php echo get_the_permalink($cja_current_advert->id); ?>">View Job<?php if ($cja_current_user_obj->role == 'jobseeker') { echo (' and Apply'); } ?></a>
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
