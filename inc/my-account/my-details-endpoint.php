<?php $cja_current_user_obj = new CJA_User;

// UPDATE USER INFORMATION IF POST DATA SENT
		if ($_POST['form-update']) {
			$cja_current_user_obj->updateFromForm();
			$cja_current_user_obj->save();
			?><p class="cja_alert cja_alert--success">Your Details Were Updated!</p><?php
			$cja_current_user_obj = new CJA_User;
        }
?>

<!-- IF USER IS ADVERTISER DISPLAY ADVERTISER DETAILS -->
<?php if($cja_current_user_obj->role == 'advertiser') { ?>
    
    <h1 class="with-subtitle">Public Details</h1>
    <p class="header_subtitle">These are the details that will appear on your adverts</p>
    <form action="<?php echo $cja_config['user-details-page-slug']; ?>" method="post" enctype="multipart/form-data">
        <p class="label">Organisation Name</p>
        <input type="text" name="company_name" value="<?php echo stripslashes($cja_current_user_obj->company_name); ?>" style="width: 300px">
        <p class="label">Short Description of Your Organisation</p>
        <textarea name="company_description" id="" cols="30" rows="10"><?php echo stripslashes($cja_current_user_obj->company_description); ?></textarea>
        <p class="label">Contact Person</p>
        <input type="text" name="contact_person" value="<?php echo $cja_current_user_obj->contact_person; ?>">
        <p class="label">Contact Phone Number</p>
        <input type="text" name="phone" value="<?php echo $cja_current_user_obj->phone; ?>">
        <p class="label">Address</p>
        <textarea name="address" id="" cols="30" rows="5"><?php echo stripslashes($cja_current_user_obj->address); ?></textarea>
        <p class="label">Postcode</p>
        <input type="text" name="postcode" value="<?php echo $cja_current_user_obj->postcode; ?>">
        <input type="hidden" name="form-update" value="advertiser">
        <p><input class="cja_button cja_button--2" type="submit" value="Update Details"></p>
    </form>

<!-- AND IF THEY ARE AN APPLICANT DISPLAY APPLICANT DETAILS -->	
<?php } else if ($cja_current_user_obj->role == 'jobseeker') { ?>
    <h1 class="with-subtitle">Public Details</h1>
    <p class="header_subtitle">These Details Will Be Sent with Your Applications</p>
    <form id="edit_user_form" action="<?php echo $cja_config['user-details-page-slug']; ?>" method="post" enctype="multipart/form-data">
        <p>Username: <?php echo $cja_current_user_obj->login_name; ?><br><em>Your username cannot be changed</em></p>
        <p class="label">First Name</p>
        <input type="text" name="first_name" value="<?php echo $cja_current_user_obj->first_name; ?>">
        <p class="label">Last Name</p>
        <input type="text" name="last_name" value="<?php echo $cja_current_user_obj->last_name; ?>">
        <p class="label">Phone Number</p>
        <input type="text" name="phone" value="<?php echo $cja_current_user_obj->phone; ?>">
        <p class="label">Postcode</p>
        <input type="text" name="postcode" value="<?php echo $cja_current_user_obj->postcode; ?>">
        <p class="label">Age Category</p>
        <select name="age_category" form="edit_user_form">
            <option value="16-18" <?php if ($cja_current_user_obj->age_category == '16-18') { echo 'selected'; } ?>>16-18</option>
            <option value="19+" <?php if ($cja_current_user_obj->age_category == '19+') { echo 'selected'; } ?>>19+</option>
        </select>
        <p class="label">GCSE Maths Grade</p>
        <select name="gcse_maths" form="edit_user_form">
            <option value="a" <?php if ($cja_current_user_obj->gcse_maths == 'a') { echo 'selected'; } ?>>A</option>
            <option value="b" <?php if ($cja_current_user_obj->gcse_maths == 'b') { echo 'selected'; } ?>>B</option>
            <option value="c" <?php if ($cja_current_user_obj->gcse_maths == 'c') { echo 'selected'; } ?>>C</option>
            <option value="d" <?php if ($cja_current_user_obj->gcse_maths == 'd') { echo 'selected'; } ?>>D</option>
            <option value="e" <?php if ($cja_current_user_obj->gcse_maths == 'e') { echo 'selected'; } ?>>E</option>
            <option value="f" <?php if ($cja_current_user_obj->gcse_maths == 'f') { echo 'selected'; } ?>>F</option>
            <option value="n" <?php if ($cja_current_user_obj->gcse_maths == 'n') { echo 'selected'; } ?>>n/a</option>
        </select>
        <p class="label">Weekends Availability</p>
        <select name="weekends_availability" form="edit_user_form">
            <option value="none" <?php if ($cja_current_user_obj->weekends_availability == 'none') { echo 'selected'; } ?>>None</option>
            <option value="sat" <?php if ($cja_current_user_obj->weekends_availability == 'sat') { echo 'selected'; } ?>>Saturday Only</option>
            <option value="sun" <?php if ($cja_current_user_obj->weekends_availability == 'sun') { echo 'selected'; } ?>>Sunday Only</option>
            <option value="satsun" <?php if ($cja_current_user_obj->weekends_availability == 'satsun') { echo 'selected'; } ?>>Saturday and Sunday</option>
        </select>
        <?php if ($cja_current_user_obj->cv_url) { ?>
            <p>Upload New CV<br><input type="file" name="cv-file"></p>
            <p><em>Current CV: <?php echo $cja_current_user_obj->cv_filename; ?></em><br><a href="<?php echo $cja_current_user_obj->cvurl; ?>" target="_blank">VIEW / DOWNLOAD CV</a></p>
        <?php } else { ?>
            <p class="label">Upload CV</p>
            <input type="file" name="cv-file"></p>
        <?php } ?>
        <input type="hidden" name="form-update" value="jobseeker">
        <p><input class="cja_button cja_button--2" type="submit" value="Update My Details"></p>
        <!--<p>My CV URL: <?php echo $cja_current_user_obj->cvurl; ?></p>-->
    </form>
<?php } ?>