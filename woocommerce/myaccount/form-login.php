<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

<?php

// CREATE NEW ACCOUNT IF POST DATA SENT
if ($_POST['createaccount'] && $_POST['email']) {

	$username = $_POST['email']; // set username to email address
	$email = $_POST['email'];
	$password = $_POST['password'];
	$role = $_POST['role'];

	// Validate email address test
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		
	
		$userdata = array(
			'user_login' => $username, // set username to email address
			'user_email' => $email,
			'user_pass' => $password,
			'role' => $role
		);

		$result = wp_insert_user($userdata);

		if (is_int($result)) {
			
			// Send new user email
			// wp_new_user_notification($result,'','both');

			// Give new user 1 credit
			add_user_meta($result, 'cja_credits', 1, true);
			add_user_meta($result, 'cja_classified_credits', 1, true);
			?><p class="cja_alert cja_alert--success"><strong><?php echo $username; ?></strong>, Your Account Has Been Created!<br>Please use your password to login!</p><?php
			$freshaccountcreation = true;
		} else { ?>

		<p class="cja_alert cja_alert--red"><?php echo $result->get_error_message(); ?></p>
		<?php }
	} else {
		?><p class="cja_alert cja_alert--red">Email address not valid</p><?php
	}
} else if ($_POST['createaccount'] && !$_POST['email']) {
	?><p class="cja_alert cja_alert--red">Please include an email address</p><?php
}

// DISPLAY ERROR MESSAGE IF LOGIN FAILED
if ($_GET['login']) {
	if ($_GET['login'] == 'failed') {
		?><p class="cja_alert cja_alert--red">Your username/email or password are incorrect. <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a></p><?php
	}
	if ($_GET['login'] == 'empty') {
		?><p class="cja_alert cja_alert--red">Please complete both the username/email and password</p><?php
	}
}

?>

<div class="cja-login-screen">
	<div class="existing-user-login<?php if($freshaccountcreation) { echo(' highlight'); } ?>">
	
	<h4 class="box-header">Log In</h4>
	<form action="<?php echo get_site_url(); ?>/wp-login.php" method="post" class="cja_home_login">
		<div class="topbox">
			<div class="username">
				<p>Email or Username</p>
				<input type="text" name="log" <?php if ($freshaccountcreation) { echo ('value="' . $_POST['username'] . '"'); } ?>>
			</div>
			<div class="password">
				<p>Password</p>
				<input type="password" name="pwd">
			</div>
		</div>
		<input type="hidden" name="redirect_to" value="<?php echo get_site_url() . '/' . $cja_config['user-details-page-slug']; ?>">
		<div class="login">
			<p class="input-right"><input class="cja_button cja_button--home_login" name="wp-submit" type="submit" value="Log In"></p>
		</div>
		<p class="woocommerce-LostPassword lost_password">
				<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
			</p>
	</form>
	</div>

	<!-- disabled by client -->
	<div class="new-user-account">
		<h4 class="account_create box-header">Create an Account</h4>
		<form action="<?php echo get_site_url() . '/my-account' ?>" method="post" class="cja_home_create">
			<div class="topbox">
				<div class="username">
					<!--
					We removed functionality to create username. All usernames are the same as the email address.	
					<p>Username</p>
					<input type="text" name="username">-->
					<p>Email Address</p>
					<input type="text" name="email">
				</div>
				<div class="password">
					<p>Password</p>
					<input type="password" name="password">
				</div>
			</div>
			
			<div class="rolebox">
				<!-- email address field used to go here -->
				<table class="login_table">
					<tr>
						<td><input type="radio" name="role" value="jobseeker" checked></td>
						<td>
							<p class="role_main">Job or Course Seeker Account</p>
							<p class="role_sub">I am looking for a job or course</p>
						</td>
					</tr>
					<tr>
						<td><input type="radio" name="role" value="advertiser"></td>
						<td>
							<p class="role_main">Employer or Course Provider Account</p>
							<p class="role_sub">I want to advertise my jobs or courses</p>
						</td>
					</tr>
				</table>
				
				<!--
					<div class="role_option">
						<input type="radio" name="role" value="jobseeker" checked>Jobseeker Account<br> I am looking for a job or course</input>
					</div>
					<div class="role_option">
						<input type="radio" name="role" value="advertiser"> I am an employer or course provider</input>
					</div>-->
				</div>
				<input type="hidden" name="createaccount" value="true">
				<p class="input-right"><input class="cja_button cja_button--home_login" type="submit" value="Create Free Account"></p>
				<p class="classifieds">All accounts can place classified adverts</p>
		</form>
	</div>
	<!-- -->
</div>

<?php
/*
do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

<div class="u-columns col2-set" id="customer_login">

	<div class="u-column1 col-1">

<?php endif; ?>

		<h2><?php esc_html_e( 'Login', 'woocommerce' ); ?></h2>

		<form class="woocommerce-form woocommerce-form-login login" method="post">

			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="username"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
				<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
			</p>

			<?php do_action( 'woocommerce_login_form' ); ?>

			<p class="form-row">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
				</label>
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				<button type="submit" class="woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
			</p>
			<p class="woocommerce-LostPassword lost_password">
				<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
			</p>

			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>

<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

	</div>

	<div class="u-column2 col-2">

		<h2><?php esc_html_e( 'Register', 'woocommerce' ); ?></h2>

		<form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

			<?php do_action( 'woocommerce_register_form_start' ); ?>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
				</p>

			<?php endif; ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
			</p>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
					<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
				</p>

			<?php else : ?>

				<p><?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?></p>

			<?php endif; ?>

			<?php do_action( 'woocommerce_register_form' ); ?>

			<p class="woocommerce-form-row form-row">
				<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
				<button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
			</p>

			<?php do_action( 'woocommerce_register_form_end' ); ?>

		</form>

	</div>

</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
*/
