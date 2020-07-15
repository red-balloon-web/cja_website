<?php

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php

		$pageaddress = get_page_link();

			?>

			<h2>Applications I Have Made</h2>
			

            <?php
            
            $cja_current_user_obj = new Cja_current_user;
	        $cja_current_user_obj->populate(); 

			// Query Arguments
			$args = array(  
				'post_type' => 'application',
				'author' => get_current_user_id(),
				'order' => 'ASC', 
			);
			$the_query = new WP_Query( $args );

			// The Loop to list job ads
			if ( $the_query->have_posts() ) {

				while ( $the_query->have_posts() ) : $the_query->the_post(); 
                    
                    $currentApplication = new Application;
                    $currentApplication->populate(get_the_ID());
                    //print_r($currentApplication);

                    $currentAd = new Advert;
                    $currentAd->populate($currentApplication->advertID);
                    //print_r($currentAd);

                    $currentAdvertiser = new Cja_current_user;
                    $currentAdvertiser->populate($currentApplication->advertiserID);
                    //print_r($currentAdvertiser);
                    
                    ?>
                        
						<div class="my-account-job-advert">
							<div class="maja_title_row">
								<div class="maja_title">
                                    <h3><?php echo $currentAd->title; ?></h3>
                                    <p>At: <?php echo $currentAdvertiser->companyname; ?></p>
                                    <p>Applied on: <?php echo $currentApplication->humanApplicationDate; ?></p>
                                    <p>My Application Letter:</p>
                                    <p><?php echo $currentApplication->applicantLetter; ?></p>
                                    <a href="<?php echo get_the_permalink($currentApplication->id); ?>">VIEW</a>
									<?php echo $currentApplication->id ?>
								</div>
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
            
            <h2>Applications to My Jobs</h2>

            <?php

			// Query Arguments
			$args = array(  
				'post_type' => 'application',
				'meta_query' => array(
					array(
						'key' => 'advertiserID',
                        'value' => $cja_current_user_obj->id
                    )
                ),
				'order' => 'ASC', 
			);
			$the_query = new WP_Query( $args );

			// The Loop to list job ads
			if ( $the_query->have_posts() ) {

				while ( $the_query->have_posts() ) : $the_query->the_post(); 
                    
                    $currentApplication = new Application;
                    $currentApplication->populate(get_the_ID());

                    $currentAd = new Advert;
                    $currentAd->populate($currentApplication->advertID);
                    
                    ?>
                        
						<div class="my-account-job-advert">
							<div class="maja_title_row">
								<div class="maja_title">
                                    <h3><?php echo $currentAd->title; ?></h3>
                                    <p>Application by: <?php echo $cja_current_user_obj->fullname; ?></p>
									<?php echo get_the_ID(); ?>
								</div>
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
