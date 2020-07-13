<?php

$pageaddress = get_page_link();

get_header();

?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php

			$loginargs = array();

			if ($_POST['username']) {
				$loginargs = array(
					'value_username' => $_POST['username']
				);
			}

			wp_login_form($loginargs);

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
			}

		?>

		<form action="<?php echo $pageaddress; ?>" method="POST">
		<p>Username:
		<input type="text" name="username">
		</p>
		<p>Email Address:
		<input type="text" name="email">
		</p>
		<p>Password:
		<input type="text" name="password">
		</p>
		<p>Role:</p>
		<p><input type="radio" name="role" value="advertiser" checked> Advertiser</p>
		<p><input type="radio" name="role" value="jobseeker"> Job Seeker</p>
		
		<input type="submit">
		</form>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action( 'storefront_sidebar' );
get_footer();
