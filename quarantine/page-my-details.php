<?php

/**
 * THIS FILE IS NO LONGER USED, SEE INC/MY-DETAILS-ENDPOINT.PHP
 */

?>
<?php get_header(); ?>

	<?php			

	// Set up current user object
	$cja_current_user_obj = new CJA_User;

	// Get page URL
	$cja_page_address = get_page_link();

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
			
			$userdata = array(
				'user_login' => $username,
				'user_email' => $email,
				'user_pass' => $password,
				'role' => $role
			);

			$result = wp_insert_user($userdata);

			if (is_int($result)) {
				// Give new user 1 credit
				add_user_meta($result, 'cja_credits', 1, true);
				?><p class="cja_alert cja_alert--success"><?php echo $username; ?>, Your Account Has Been Created!<br>Please use your password to login!</p><?php
				$freshaccountcreation = true;
			} else {
				echo $result->get_error_message();
			}
		}

		// UPDATE USER INFORMATION IF POST DATA SENT
		if ($_POST['form-update']) {
			$cja_current_user_obj->updateFromForm();
			$cja_current_user_obj->save();
			?><p class="cja_alert cja_alert--success">Your Details Were Updated!</p><?php
			$cja_current_user_obj = new CJA_User;
		}
		
		?>

		<!-- IF USER IS LOGGED IN DISPLAY THEIR DETAILS -->
		<?php if(is_user_logged_in()) { ?>

			<!-- IF USER IS ADVERTISER DISPLAY ADVERTISER DETAILS -->
			<?php if($cja_current_user_obj->role == 'advertiser' || $cja_current_user_obj->role == 'administrator') { ?>
				
				<h1>My Organisation Details<?php if ($cja_current_user_obj->company_name) { echo ' - ' . stripslashes($cja_current_user_obj->company_name); } ?></h1>
				<form action="<?php echo $cja_page_address; ?>" method="post" enctype="multipart/form-data">
					<p>Username: <?php echo $cja_current_user_obj->login_name; ?><br><em>Your username cannot be changed</em></p>
					<p>Organisation Name<br><input type="text" name="company_name" value="<?php echo stripslashes($cja_current_user_obj->company_name); ?>"></p>
					<p>Short Description of Your Organisation<br>
					<textarea name="company_description" id="" cols="30" rows="10"><?php echo stripslashes($cja_current_user_obj->company_description); ?></textarea></p>
					<input type="hidden" name="form-update" value="advertiser">
					<p><input class="cja_button cja_button--2" type="submit" value="Update Details">&nbsp;&nbsp;<a class="cja_button" href="<?php echo wp_logout_url( home_url() ); ?>">LOG OUT</a></p>
				</form>

			<!-- AND IF THEY ARE AN APPLICANT DISPLAY APPLICANT DETAILS -->	
			<?php } else if ($cja_current_user_obj->role == 'jobseeker') { ?>
				<h1>My Details - <?php echo $cja_current_user_obj->full_name; ?></h1>
				<p><a href="<?php echo wp_logout_url( home_url() ); ?>">LOG OUT</a></p>
				<form id="edit_user_form" action="<?php echo $cja_page_address; ?>" method="post" enctype="multipart/form-data">
					<p>Username: <?php echo $cja_current_user_obj->login_name; ?><br><em>Your username cannot be changed</em></p>
					<p>First Name<br><input type="text" name="first_name" value="<?php echo $cja_current_user_obj->first_name; ?>"></p>
					<p>Last Name<br><input type="text" name="last_name" value="<?php echo $cja_current_user_obj->last_name; ?>"></p>
					<p>Phone Number<br><input type="text" name="phone" value="<?php echo $cja_current_user_obj->phone; ?>"></p>
					<p>Postcode<br><input type="text" name="postcode" value="<?php echo $cja_current_user_obj->postcode; ?>"></p>
					<p class="label">Age Category</p>
					<select name="age_category" form="edit_user_form">
						<option value="16-18" <?php if ($cja_current_user_obj->age_category == '16-18') { echo 'selected'; } ?>>16-18</option>
						<option value="19+" <?php if ($cja_current_user_obj->age_category == '19+') { echo 'selected'; } ?>>19+</option>
					</select><br><br>
					<p class="label">GCSE Maths Grade</p>
					<select name="gcse_maths" form="edit_user_form">
						<option value="a" <?php if ($cja_current_user_obj->gcse_maths == 'a') { echo 'selected'; } ?>>A</option>
						<option value="b" <?php if ($cja_current_user_obj->gcse_maths == 'b') { echo 'selected'; } ?>>B</option>
						<option value="c" <?php if ($cja_current_user_obj->gcse_maths == 'c') { echo 'selected'; } ?>>C</option>
						<option value="d" <?php if ($cja_current_user_obj->gcse_maths == 'd') { echo 'selected'; } ?>>D</option>
						<option value="e" <?php if ($cja_current_user_obj->gcse_maths == 'e') { echo 'selected'; } ?>>E</option>
						<option value="f" <?php if ($cja_current_user_obj->gcse_maths == 'f') { echo 'selected'; } ?>>F</option>
						<option value="n" <?php if ($cja_current_user_obj->gcse_maths == 'n') { echo 'selected'; } ?>>n/a</option>
					</select><br><br>
					<p class="label">Weekends Availability</p>
					<select name="weekends_availability" form="edit_user_form">
						<option value="none" <?php if ($cja_current_user_obj->weekends_availability == 'none') { echo 'selected'; } ?>>None</option>
						<option value="sat" <?php if ($cja_current_user_obj->weekends_availability == 'sat') { echo 'selected'; } ?>>Saturday Only</option>
						<option value="sun" <?php if ($cja_current_user_obj->weekends_availability == 'sun') { echo 'selected'; } ?>>Sunday Only</option>
						<option value="satsun" <?php if ($cja_current_user_obj->weekends_availability == 'satsun') { echo 'selected'; } ?>>Saturday and Sunday</option>
					</select><br><br>
					<?php if ($cja_current_user_obj->cv_url) { ?>
						<p>Upload New CV<br><input type="file" name="cv-file"></p>
						<p><em>Current CV: <?php echo $cja_current_user_obj->cv_filename; ?></em><br><a href="<?php echo $cja_current_user_obj->cvurl; ?>" target="_blank">VIEW / DOWNLOAD CV</a></p>
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
				
				<h4>Log In</h4>
				<form action="<?php echo get_site_url(); ?>/wp-login.php" method="post" class="cja_home_login">
					<div class="topbox">
						<div class="username">
							<p>Username</p>
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
				</form>
				</div>

				<div class="new-user-account">
				<h4 class="account_create">Create an Account</h4>
				<form action="<?php echo get_site_url() . '/' . $cja_config['user-details-page-slug']; ?>" method="post" class="cja_home_create">
					<div class="topbox">
						<div class="username">
							<p>Username</p>
							<input type="text" name="username">
						</div>
						<div class="password">
							<p>Password</p>
							<input type="password" name="password">
						</div>
					</div>
					<p>Email Address</p>
					<input type="text" name="email">
					<div class="rolebox">
						<div class="role_option">
							<input type="radio" name="role" value="jobseeker" checked> I am looking for a job or course</input>
						</div>
						<div class="role_option">
							<input type="radio" name="role" value="employer"> I am an employer or course provider</input>
						</div>
					</div>
					<input type="hidden" name="createaccount" value="true">
					<p class="input-right"><input class="cja_button cja_button--home_login" type="submit" value="Create Free Account"></p>
				</form>
				</div>
			</div>
			
		<?php } ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
