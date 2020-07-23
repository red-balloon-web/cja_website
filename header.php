<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>




<?php wp_body_open(); ?>

<?php do_action( 'storefront_before_site' ); ?>

<div id="page" class="hfeed site">
	<?php do_action( 'storefront_before_header' ); ?>

	

	<header id="masthead" class="site-header" role="banner" style="<?php storefront_header_styles(); ?>">
		<div class="col-full header-top">
			<div class="logged-in-message">
				<?php
					$cja_current_user = new CJA_User;
					if ($cja_current_user->is_logged_in) {
						if ($cja_current_user->company_name) {
						?><p>Logged in as <?php echo $cja_current_user->company_name; ?></p><?php
						} else if ($cja_current_user->full_name) {
							?><p>Logged in as <?php echo $cja_current_user->full_name; ?></p><?php
						} else {
							?><p>Logged in as <?php echo $cja_current_user->login_name; ?></p><?php
						}
					} else {
						?><p><a href="<?php echo get_site_url(); ?>/my-details">Create Account / Log In</a></p><?php
					}
				?>
			</div>
			<h2>Courses and Jobs Advertiser</h2>
		</div>
		<div class="col-full">

		<?php
		/**
		 * Functions hooked into storefront_header action
		 *
		 * @hooked storefront_header_container                 - 0
		 * @hooked storefront_skip_links                       - 5
		 * @hooked storefront_social_icons                     - 10
		 * @hooked storefront_site_branding                    - 20
		 * @hooked storefront_secondary_navigation             - 30
		 * @hooked storefront_product_search                   - 40
		 * @hooked storefront_header_container_close           - 41
		 * @hooked storefront_primary_navigation_wrapper       - 42
		 * @hooked storefront_primary_navigation               - 50
		 * @hooked storefront_header_cart                      - 60
		 * @hooked storefront_primary_navigation_wrapper_close - 68
		 */
		// do_action( 'storefront_header' );

		cja_primary_navigation();
		$cja_current_user = new CJA_User;
		if ($cja_current_user->role == 'advertiser') {
			storefront_header_cart();
		}
		?>

</div>

	</header><!-- #masthead -->

	<?php
	/**
	 * Functions hooked in to storefront_before_content
	 *
	 * @hooked storefront_header_widget_region - 10
	 * @hooked woocommerce_breadcrumb - 10
	 */
	// do_action( 'storefront_before_content' );
	?>

	<div id="content" class="site-content" tabindex="-1">
		<div class="col-full">

		<?php
		do_action( 'storefront_content_top' );