<?php

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<h1>Contact Us</h1>

		<p class="cja_center">Questions? We're here to help!</p>
		<p class="cja_center">You can contact us on <strong>020 3475 9775</strong> or use the form below.</p><?php 

		// echo do_shortcode('[contact-form-7 id="355" title="Contact Form"]') // dev form;
		echo do_shortcode('[contact-form-7 id="371" title="Contact form 1"]');?>


		</main><!-- #main -->
	</div><!-- #primary --> <?php
	
//do_action( 'storefront_sidebar' );
get_footer();
