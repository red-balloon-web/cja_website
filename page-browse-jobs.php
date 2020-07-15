<?php

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<h1>Browse Job Adverts</h1>
		
		<?php

		$cja_current_user_obj = new Cja_current_user;
		$cja_current_user_obj->populate();

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

				$currentadvert = new Advert;


				echo ($currentadvert->populate(get_the_ID()));
				?>
				<div class="jobs-archive-item">
					<p class="jai-title"><strong><?php echo ($currentadvert->title); ?></strong> at <?php echo ($currentadvert->authorHumanName); ?></p>
					<p class="jai-content"><?php echo ($currentadvert->content); ?></p>
					<p>Posted on <?php echo ($currentadvert->humanActivationDate); ?></p>
					<a href="<?php echo get_the_permalink($currentadvert->id); ?>">VIEW</a>
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
do_action( 'storefront_sidebar' );
get_footer();
