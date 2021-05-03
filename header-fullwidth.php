<!-- 
This is the header for the front page.
The difference is the opening div tags at the end, which are allowed to be full width so we can have a full width frontpage -->

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Catamaran" rel="stylesheet">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>




<?php wp_body_open(); ?>

<?php do_action( 'storefront_before_site' ); ?>

<div id="page" class="hfeed site">
	<?php do_action( 'storefront_before_header' ); ?>

	<header id="masthead" class="site-header homepage" role="banner" style="<?php storefront_header_styles(); ?>">

		<?php include('inc/navigation/mobile-menu.php'); ?>
		<div class="col-full header-top">
			
			<?php 
			// Display top of screen login box if we are displaying full homepage
			if (get_option('cja_display_homepage')) { ?>
				<div class="logged-in-message"><?php
					$cja_current_user = new CJA_User;
					if ($cja_current_user->is_logged_in) {
						if ($cja_current_user->company_name) {
						?><p>Logged in as <?php echo $cja_current_user->company_name;
						} else if ($cja_current_user->first_name) {
							?><p>Logged in as <?php echo $cja_current_user->full_name;
						} else {
							?><p>Logged in as <?php echo $cja_current_user->login_name; 
						}
						?>&nbsp;&nbsp;<a href="<?php echo wp_logout_url( home_url() ); ?>"><i class="fas fa-sign-out-alt"></i></a><?php
					} else { ?>
						<form action="<?php echo get_site_url(); ?>/wp-login.php?redirect_to=<?php echo get_site_url() . '/' . $cja_config['user-details-page-slug']; ?>" method="post" class="cja_home_login">
							<div class="header_login_form">
								<div class="username">
									<p>Email or Username</p>
									<input type="text" name="log">
								</div>
								<div class="password">
									<p>Password</p>
									<input type="password" name="pwd">
								</div>
								<div class="login">
									<p class="input-right"><input class="cja_button cja_button--home_login" name="wp-submit" type="submit" value="Log In"></p>
								</div>
							</div>
						</form>
						<div class="header_login_button">
							<a href="<?php echo get_site_url(); ?>/my-account" class="cja_button cja_button--home_login"><!--Create Account / -->Log In</a>
						</div><?php
					} ?>
				</div><?php 
			} 
			
			// Logo and site title ?>
			<div class="logo-title">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo3.jpg" class="logo"><h2 class="cja_site_title">Courses and Jobs Advertiser</h2>
			</div>
		</div>
		<div class="col-full">

			<?php
			/**
			 * Functions hooked into storefront_header action LEFT THIS FOR REFERENCE
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
			//do_action( 'storefront_header' );

			// display the menu if we are displaying full homepage (controlled in theme options)
				if (get_option('cja_display_homepage')) {
				cja_primary_navigation();
				$cja_current_user = new CJA_User;
				if ($cja_current_user->role == 'advertiser') {
					storefront_header_cart();
				}
			} ?>
		</div>
	</header><!-- #masthead -->

	<?php
	/**
	 * Functions hooked in to storefront_before_content LEFT THIS FOR REFERENCE
	 *
	 * @hooked storefront_header_widget_region - 10
	 * @hooked woocommerce_breadcrumb - 10
	 */
	//do_action( 'storefront_before_content' );
	?>

	<!--<div id="content" class="site-content" tabindex="-1">
		<div class="col-full">-->

		<!-- replace above opening div tags with no id or class to create fullwidth -->
	<div>
	<div>

	<?php
	do_action( 'storefront_content_top' );