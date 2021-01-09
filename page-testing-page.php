<?php

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<h1>Testing Stuff</h1>

		<p>Return code for id=396 (job ad)</p>
		<p><?php echo get_cja_code(396); ?></p>

		<p>Return code for id=392 (course ad)</p>
		<p><?php echo get_cja_code(392); ?></p>

		<p>Return code for id=391 (classified ad)</p>
		<p><?php echo get_cja_code(391); ?></p>

		<p>Return code for id=395 (job application)</p>
		<p><?php echo get_cja_code(395); ?></p>

		<p>Return code for id=394 (course application)</p>
		<p><?php echo get_cja_code(394); ?></p>

		<p>Return code for id=1 (admin)</p>
		<p><?php print_r(get_cja_user_code(1)); ?></p>

		<p>Return code for id=15 (advertiser)</p>
		<p><?php print_r(get_cja_user_code(15)); ?></p>

		<p>Return code for id=17 (jobseeker)</p>
		<p><?php print_r(get_cja_user_code(17)); ?></p>


		</main><!-- #main -->
	</div><!-- #primary --> <?php
	
//do_action( 'storefront_sidebar' );
get_footer();
