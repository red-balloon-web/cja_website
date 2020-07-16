<?php get_header(); ?>

	<?php			

	// Set up current user object
	$cja_current_user_obj = new Cja_current_user;
	$cja_current_user_obj->populate(); 

	// Get page URL
	$pageaddress = get_page_link();

	// Has user just created account (for highlighted login section)
	$freshaccountcreation = false;
	?>

	<div id="primary" class="content-area cja-account-details">
		<main id="main" class="site-main" role="main">

		<?php 

		// CREATE NEW ACCOUNT IF POST DATA SENT
		if ($_POST['createaccount']) {

			$username = $_POST['username'];
			$email = $_POST['email'];
			$password = $_POST['password'];
			$role = $_POST['role'];
			
			/*
			echo ('<p>username: ' . $username . '</p>');
			echo ('<p>email: ' . $email . '</p>');
			echo ('<p>password: ' . $password . '</p>');
			echo ('<p>role: ' . $role . '</p>');
			*/
			
			$userdata = array(
				'user_login' => $username,
				'user_email' => $email,
				'user_pass' => $password,
				'role' => $role
			);

			$result = wp_insert_user($userdata);
			//print_r($result);

			if (is_int($result)) {
				?><p class="cja_alert"><?php echo $username; ?>, Your Account Has Been Created!<br>Please use your password to login!</p><?php
				$freshaccountcreation = true;
			} else {
				echo $result->get_error_message();
			}
		}

		// UPDATE USER INFORMATION IF POST DATA SENT
		if ($_POST['form-update']) {
			$cja_current_user_obj->updateFromForm();
			//print_r($cja_current_user_obj);
			$cja_current_user_obj->saveToDatabase();
			?><p class="cja_alert">Your Details Were Updated!</p><?php
		}
		
		/*
		if ($_GET['action']) {
			if ($_GET['action'] == 'edit') {
				?>
					Edit Account Form

					<form action="<?php echo $pageaddress; ?>" method="post" enctype="multipart/form-data">
						<p>Company Name: <input type="text" name="companyname" value="<?php echo $cja_current_user_obj->companyname; ?>"></p>
						<p>Nicename: <input type="text" name="nicename" value="<?php echo $cja_current_user_obj->nicename; ?>"></p>
						<p>First Name: <input type="text" name="firstname" value="<?php echo $cja_current_user_obj->firstname; ?>"></p>
						<p>Last Name: <input type="text" name="surname" value="<?php echo $cja_current_user_obj->surname; ?>"></p>
						<p>My Statement:</p>
						<textarea name="statement" id="" cols="30" rows="10"><?php echo $cja_current_user_obj->statement; ?></textarea>
						<p>My CV</p>
						<input type="file" name="cv-file">
						<input type="submit" value="Update Details">
					</form>
				<?php
			}
		}
		*/

		?>

		<!-- IF USER IS LOGGED IN DISPLAY THEIR DETAILS -->
		<?php if(is_user_logged_in()) { ?>

			<!-- IF USER IS ADVERTISER DISPLAY ADVERTISER DETAILS -->
			<?php if($cja_current_user_obj->role == 'advertiser') { ?>
				
				<h1>My Organisation Details - <?php echo $cja_current_user_obj->companyname; ?></h1>
				<p><a href="<?php echo get_page_link(); ?>?cja-logout=true">LOG OUT</a></p>
				<form action="<?php echo $pageaddress; ?>" method="post" enctype="multipart/form-data">
					<p>Username: <?php echo $cja_current_user_obj->loginname; ?></p>
					<p>Organisation Name<br><input type="text" name="companyname" value="<?php echo stripslashes($cja_current_user_obj->companyname); ?>"></p>
					<p>Short Description of Your Organisation<br>
					<textarea name="statement" id="" cols="30" rows="10"><?php echo stripslashes($cja_current_user_obj->statement); ?></textarea></p>
					<input type="hidden" name="form-update" value="advertiser">
					<p><input type="submit" value="Update"></p>
				</form>

			<!-- AND IF THEY ARE AN APPLICANT DISPLAY APPLICANT DETAILS -->	
			<?php } else if ($cja_current_user_obj->role == 'jobseeker') { ?>
				<h1>My Details - <?php echo $cja_current_user_obj->fullname; ?></h1>
				<p><a href="<?php echo get_page_link(); ?>?cja-logout=true">LOG OUT</a></p>
				<form action="<?php echo $pageaddress; ?>" method="post" enctype="multipart/form-data">
					<p>Username: <?php echo $cja_current_user_obj->loginname; ?><br><em>Your username cannot be changed</em></p>
					<p>First Name<br><input type="text" name="firstname" value="<?php echo $cja_current_user_obj->firstname; ?>"></p>
					<p>Last Name<br><input type="text" name="surname" value="<?php echo $cja_current_user_obj->surname; ?>"></p>
					<?php if ($cja_current_user_obj->cvurl) { ?>
						<p>Upload New CV<br><input type="file" name="cv-file"></p>
						<p><em>Current CV: <?php echo $cja_current_user_obj->cvfilename; ?></em><br><a href="<?php echo $cja_current_user_obj->cvurl; ?>" target="_blank">VIEW / DOWNLOAD CV</a></p>
					<?php } else { ?>
						Upload CV<br><input type="file" name="cv-file"></p>
					<?php } ?>
					<input type="hidden" name="form-update" value="jobseeker">
					<p><input type="submit" value="Update"></p>
					<!--<p>My CV URL: <?php echo $cja_current_user_obj->cvurl; ?></p>-->
				</form>
			<?php } ?>
		
		<!-- IF USER IS NOT LOGGED IN DISPLAY LOGIN SCREEN -->
		<?php } else { ?>
			<div class="cja-login-screen">
				<div class="existing-user-login<?php if($freshaccountcreation) { echo(' highlight'); } ?>">
					<h4>LOG IN</h4>
					<form action="<?php echo get_site_url(); ?>/wp-login.php" method="post" class="loginform">
						<p>Username or Email<br>
						<input type="text" name="log" <?php if ($freshaccountcreation) { echo ('value="' . $_POST['username'] . '"'); }?>></p>
						<p>Password<br>
						<input type="password" name="pwd"></p>
						<p><input type="checkbox" name="rememberme" value="forever"> Remember Me</p>
						<input type="hidden" name="redirect_to" value="<?php echo get_page_link(); ?>">
						<p><input type="submit" name="wp-submit" value="Log In"></p>

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
						<input type="password" name="password">
						</p>
						
						<p class="account-choice"><input type="radio" name="role" value="advertiser" checked> <strong>Advertiser Account</strong> - I want to place adverts for my jobs or courses</p>
						<p class="account-choice"><input type="radio" name="role" value="jobseeker"> <strong>Job Seeker Account</strong> - I want to apply for jobs or courses</p>
						<input type="hidden" name="createaccount" value="true">
						<input type="submit" value="Create Account">
					</form>
				</div>
			</div>
			
		<?php } ?>


		<?php
		/*
		print_r(wp_get_current_user());
		$get_user = wp_get_current_user();
		*/
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
// do_action( 'storefront_sidebar' );
get_footer();
