<?php
$pageaddress = get_page_link();
get_header(); ?>

	<div id="primary" class="content-area cja-create-account-login">
		<main id="main" class="site-main" role="main"><?php

			if ($_POST) {

				$username = $_POST['username'];
				$email = $_POST['email'];
				$password = $_POST['password'];
				$role = $_POST['role'];
				
				echo ('<p>username: ' . $username . '</p>');
				echo ('<p>email: ' . $email . '</p>');
				echo ('<p>password: ' . $password . '</p>');
				echo ('<p>role: ' . $role . '</p>');
				
				$userdata = array(
					'user_login' => $username,
					'user_email' => $email,
					'user_pass' => $password,
					'role' => $role
				);

				$result = wp_insert_user($userdata);
				//print_r($result);

				if (is_int($result)) {
					echo ('<p>Your account was successfully created</p>');
				} else {
					echo $result->get_error_message();
				}
			} ?>

			<div class="existing-user-login">
				<h4>LOG IN</h4>
				<form action="<?php echo get_site_url(); ?>/wp-login.php" method="post" class="loginform">
					<p>Username or Email<br>
					<input type="text" name="log"></p>
					<p>Password<br>
					<input type="password" name="pwd"></p>
					<p><input type="checkbox" name="rememberme" value="forever"> Remember Me</p>
					<input type="hidden" name="redirect_to" value="<?php echo get_page_link(); ?>">
					<p><input type="submit" name="wp-submit"></p>
				</form>
			</div>

			<div class="new-user-account">
				<h4>CREATE ACCOUNT</h4>
				<form action="<?php echo $pageaddress; ?>" method="POST">
					<p>Username<br>
					<input type="text" name="username">
					</p>
					<p>Email Address<br>
					<input type="text" name="email">
					</p>
					<p>Password<br>
					<input type="text" name="password">
					</p>
					
					<p class="account-choice"><input type="radio" name="role" value="advertiser" checked> <strong>Advertiser Account</strong> - I want to place adverts for my jobs or courses</p>
					<p class="account-choice"><input type="radio" name="role" value="jobseeker"> <strong>Job Seeker Account</strong> - I want to apply for jobs or courses</p>
					<input type="submit">
				</form>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
// do_action( 'storefront_sidebar' );
get_footer();
