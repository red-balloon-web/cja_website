<?php
/**
 * The template for displaying all single posts.
 *
 * @package storefront
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) :
			the_post();

			$currentAd = new Advert;
			$currentAd->populate(get_the_ID());
			print_r($currentAd);
			?>

			<h1><?php echo $currentAd->title; ?></h1>
			<p>Posted by -- on <?php echo ($currentAd->humanActivationDate); ?></p>
			<p><?php echo $currentAd->content; ?></p>

			<?php

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action( 'storefront_sidebar' );
get_footer();
