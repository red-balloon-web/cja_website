<?php $cja_current_user_obj = new CJA_User;

// See also display_admin_user_custom_cja_fields in functions.php as the same table is used there. This should be wrapped in a template.

// UPDATE USER INFORMATION IF POST DATA SENT
		if ($_GET['update-user-details']) {
			?><p class="cja_alert cja_alert--success">Your Details Were Updated!</p><?php
        }
?>

<!-- IF USER IS ADVERTISER DISPLAY ADVERTISER DETAILS -->
<?php if($cja_current_user_obj->role == 'advertiser' || $cja_current_user_obj->role == 'administrator') {

    if ($cja_current_user_obj->description_approved == 'pending') { ?>
        <p class="cja_alert cja_alert--amber">Your profile is pending approval by our admin team.</p><?php
    } ?>
    
    <h1 class="with-subtitle">Your Profile</h1>
    <p class="header_subtitle">These are the details that will appear on your adverts</p>

    <form action="<?php echo $cja_config['user-details-page-slug']; ?>" class="smart_form" method="post" enctype="multipart/form-data">
        <p style="color: #666">ID: <?php echo get_cja_user_code($cja_current_user_obj->id); ?></p>
        <?php $cja_current_user_obj->display_form_field('company_name');

        // Show the actual or pending description
        if ($cja_current_user_obj->description_approved == 'pending') { ?>
            <textarea name="company_description" cols="30" rows="10"><?php echo $cja_current_user_obj->pending_description; ?></textarea>
            <p style="margin-top: -23px; color: #A00">Your profile is pending approval by our admin team. You will be notified by email when it is approved.</p><?php
        } else {
            $cja_current_user_obj->display_form_field('company_description', false); 
        } ?>
        
        <div class="form_flexbox_2">
            <div><?php $cja_current_user_obj->display_form_field('contact_person'); ?></div>
            <div><?php $cja_current_user_obj->display_form_field('phone'); ?></div>
        </div>
        
        
        <?php $cja_current_user_obj->display_form_field('address'); ?>
        <?php $cja_current_user_obj->display_form_field('postcode'); ?>
        <input type="hidden" name="user-details-update" value="advertiser">
        <p><input class="cja_button cja_button--2" type="submit" value="Update Details"></p>
    </form>

<!-- AND IF THEY ARE AN APPLICANT DISPLAY APPLICANT DETAILS -->	
<?php } else if ($cja_current_user_obj->role == 'jobseeker') {

    if ($cja_current_user_obj->description_approved == 'pending') { ?>
        <p class="cja_alert cja_alert--amber">Your profile is pending approval by our admin team.</p><?php
    } 
    
    if ($cja_current_user_obj->pending_files_array) { ?>
        <p class="cja_alert cja_alert--amber">One or more of your files are pending approval by our admin team.</p><?php
    }?>

    <h1>Your Profile</h1>


    <!--<p class="header_subtitle">These Details Will Be Sent with Your Applications</p>-->
    <form id="edit_user_form" class="smart_form" action="<?php echo $cja_config['user-details-page-slug']; ?>" method="post" enctype="multipart/form-data">
        <p style="color: #666">ID: <?php echo get_cja_user_code($cja_current_user_obj->id); ?></p>

        <div class="form_flexbox_2">
            <div><?php $cja_current_user_obj->display_form_field('first_name'); ?></div>
            <div><?php $cja_current_user_obj->display_form_field('last_name'); ?></div>
        </div> 
        <div class="form_flexbox_2">
            <div><?php $cja_current_user_obj->display_form_field('town_city'); ?></div>
            <div><?php $cja_current_user_obj->display_form_field('phone'); ?></div>
        </div>

        <h2 class="form_section_heading mb-0">Photo</h2>
        <?php // print_r($cja_edit_ad); ?>
        <p class="muted">You can include an optional photo of yourself to display on your profile</p>
        <?php if ($cja_current_user_obj->photo_url == '') { ?> 
            <p class="label">Choose Photo (Accepted filetypes: .gif .jpg .jpeg .png)</p>
            <input type="file" name="photo">
        <?php } else { ?>
            <img src="<?php echo $cja_current_user_obj->photo_url; ?>" width="100px"; ><br>
            <p class="label">Change Photo (Accepted filetypes: .gif .jpg .jpeg .png)</p>
            <input type="file" name="photo">
            <p><input type="checkbox" name="delete_photo" value="true"> Delete Photo</p>
        <?php } ?>
        
        <h2 class="form_section_heading mb-0">Address and Postcode</h2>
        
        <p class="muted"><em>Your address and postcode will not be published. Your address is for office use only and your postcode is so we can show you opportunities in your area.</em></p><?php
        $cja_current_user_obj->display_form_field('address');
        $cja_current_user_obj->display_form_field('postcode'); ?>


        <h2 class="form_section_heading">About the Opportunities You're Looking For</h2><?php
        $cja_current_user_obj->display_form_field('opportunity_required');?>
        <div class="form_flexbox_2">
            <div><?php $cja_current_user_obj->display_form_field('course_time'); ?></div>
            <div><?php $cja_current_user_obj->display_form_field('job_time'); ?></div>
        </div>
        <div class="form_flexbox_2">
            <div><?php $cja_current_user_obj->display_form_field('job_role'); ?></div>
            <div><?php $cja_current_user_obj->display_form_field('cover_work'); ?></div>
        </div><?php 
        $cja_current_user_obj->display_form_field('weekends_availability');
        $cja_current_user_obj->display_form_field('specialism_area'); ?>
        <h2 class="form_section_heading">Education</h2>
        <div class="form_flexbox_2">
            <div><?php $cja_current_user_obj->display_form_field('gcse_maths'); ?></div>
            <div><?php $cja_current_user_obj->display_form_field('gcse_english'); ?></div>
        </div>
        <div class="form_flexbox_2">
            <div><?php $cja_current_user_obj->display_form_field('functional_maths'); ?></div>
            <div><?php $cja_current_user_obj->display_form_field('functional_english'); ?></div>
        </div><?php
        $cja_current_user_obj->display_form_field('highest_qualification'); ?>
        <h2 class="form_section_heading">Some More About You</h2>
        <div class="form_flexbox_2">
            <div><?php $cja_current_user_obj->display_form_field('age_category'); ?></div>
            <div><?php $cja_current_user_obj->display_form_field('current_status'); ?></div>
        </div>
        <div class="form_flexbox_2">
            <div><?php $cja_current_user_obj->display_form_field('unemployed'); ?></div>
            <div><?php $cja_current_user_obj->display_form_field('receiving_benefits'); ?></div>
        </div>
        <?php
        $cja_current_user_obj->display_form_field('contact_preference');
 ?>
        <h2 class="form_section_heading">Appear in Searches</h2>
        <p class="muted"><em>Our search features allow employers and course providers to search profiles and contact jobseekers and students who might be a good fit for their opportunity. We reccommend you choose to appear in searches for the type(s) of opportunity you're looking for.</em></p><?php
        $cja_current_user_obj->display_form_field('is_jobseeker');
        $cja_current_user_obj->display_form_field('is_student'); ?>
        <h2 class="form_section_heading">Profile and CV</h2>
        <p class="label">My Profile<br><em style="color: #999">Tell employers and course providers a bit about yourself and why they should choose you</em></p><?php
        
        // Show the actual or pending description
        if ($cja_current_user_obj->description_approved == 'pending') { ?>
            <textarea name="company_description" cols="30" rows="10"><?php echo $cja_current_user_obj->pending_description; ?></textarea>
            <p style="margin-top: -23px; color: #A00">Your profile is pending approval by our admin team. You will be notified by email when it is approved.</p><?php
        } else {
            $cja_current_user_obj->display_form_field('company_description', false); 
        }
        
        ?>

        <h2 class="form_section_heading mb-0">Attachments</h2>
        <p class="muted">Any other documents you want employers or course providers to see e.g. your CV, portfolio etc.</p>

        <?php 
            if ($cja_current_user_obj->files_array) {
                echo '<table class="attachments_table">';
                echo '<thead><td>File</td><td class="center">Delete</td></thead>';
                foreach($cja_current_user_obj->files_array as $file) {
                    ?><tr>
                        <td><?php echo $file['name']; ?></td>
                        <td class="center"><input type="checkbox" name="delete_files[]" value="<?php echo $file['url']; ?>"></td>
                        </tr>
                    <?php
                }
                echo '</table>';
            }

            if ($cja_current_user_obj->pending_files_array) { ?>

                <p style="color: #900">The following files are pending approval by our admin team</p><?php
                echo '<table class="attachments_table">';
                echo '<thead><td>File</td><td class="center">Delete</td></thead>';
                foreach($cja_current_user_obj->pending_files_array as $file) {
                    ?><tr>
                        <td><?php echo $file['name']; ?></td>
                        <td class="center"><input type="checkbox" name="delete_pending_files[]" value="<?php echo $file['url']; ?>"></td>
                        </tr>
                    <?php
                }
                echo '</table>';
            }
        ?>

        <p>Add more files<br>
        <input type="file" name="files[]" id="files" multiple></p>

        <!--<h2 class="form_section_heading">Your CV</h2>
        <?php if ($cja_current_user_obj->cv_url) { ?>
            <p><em>Current CV File: <?php echo $cja_current_user_obj->cv_filename; ?></em><br><a href="<?php echo $cja_current_user_obj->cv_url; ?>" target="_blank">VIEW MY CV</a></p>
            <p>Upload New CV<br><input type="file" name="cv-file"></p>
            <p><input type="checkbox" name="delete_cv"> Delete your CV (there will be no CV attached to your profile)</p>
        <?php } else { ?>
            <p class="label">Upload CV</p>
            <input type="file" name="cv-file"></p>
        <?php } ?>-->
        <input type="hidden" name="user-details-update" value="jobseeker">
        <p class="form_submit_right"><input class="cja_button cja_button--2" type="submit" value="Update My Details"></p>
        <!--<p>My CV URL: <?php echo $cja_current_user_obj->cvurl; ?></p>-->
    </form>
<?php } ?>