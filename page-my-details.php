<?php
/**
 * The template for displaying all single posts.
 *
 * @package storefront
 */

get_header(); ?>

	<?php			
	// Set up current user object
	$cja_current_user_obj = new Cja_current_user;
	$cja_current_user_obj->populate(); 

	// Get page URL
	$pageaddress = get_page_link();
	?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php 
		
		if ($_POST) {
			$cja_current_user_obj->updateFromForm();
			//print_r($cja_current_user_obj);
			$cja_current_user_obj->saveToDatabase();
			?><p class="cja_alert">Your Details Were Updated!</p><?php
		}
		
		
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

		?>

		
		<?php //print_r($cja_current_user_obj); ?>
		<p>Company Name: <?php echo $cja_current_user_obj->companyname; ?></p>
		<p>Nicename: <?php echo $cja_current_user_obj->nicename; ?></p>
		<p>First Name: <?php echo $cja_current_user_obj->firstname; ?></p>
		<p>Surname: <?php echo $cja_current_user_obj->surname; ?></p>
		<p>My Statement:</p>
		<p><?php echo nl2br($cja_current_user_obj->statement); ?></p>
		<p>My CV Filename: <?php echo $cja_current_user_obj->cvfilename; ?></p>
		<p>My CV URL: <?php echo $cja_current_user_obj->cvurl; ?></p>

		<a href="<?php echo $pageaddress; ?>?action=edit">EDIT</a>


		<?php
		/*
		print_r(wp_get_current_user());
		$get_user = wp_get_current_user();
		*/
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action( 'storefront_sidebar' );
get_footer();
