<?php

/**
 * Remove unwanted fields from edit user screen
 */
remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );

if ( ! function_exists( 'cor_remove_personal_options' ) ) {

    function cor_remove_personal_options( $subject ) {
        $subject = preg_replace( '#<h2>Personal Options</h2>#s', '', $subject, 1 );
        $subject = preg_replace( '#<h2>Name</h2>#s', '', $subject, 1 );
        $subject = preg_replace( '#<h2>Contact Info</h2>#s', '', $subject, 1 );
        $subject = preg_replace( '#<h2>About the user</h2>#s', '', $subject, 1 );
        $subject = preg_replace( '#<h2>Account Management</h2>#s', '', $subject, 1 );
        return $subject;
    }

    function cor_profile_subject_start() {
        ob_start( 'cor_remove_personal_options' );
    }

    function cor_profile_subject_end() {
        ob_end_flush();
    }
}
add_action( 'admin_head', 'cor_profile_subject_start' );
add_action( 'admin_footer', 'cor_profile_subject_end' );

/**
 * Custom Edit User Fields
 */
add_action( 'edit_user_profile', 'display_admin_user_custom_cja_fields' );
function display_admin_user_custom_cja_fields( $user ) {

    // This is mainly duplicated from my-details-endpoint.php and if updated here should probably be updated there too. Should be wrapped up in a template DRY.

    echo '<h2>CJA User Fields</h2>';
    $cja_current_user_obj = new CJA_User($_GET['user_id']); ?>

<!-- IF USER IS ADVERTISER DISPLAY ADVERTISER DETAILS -->
<?php if($cja_current_user_obj->role == 'advertiser' || $cja_current_user_obj->role == 'administrator') { ?>
        <div id="poststuff"><div class="admin_edit_form">
            <p style="color: #666">ID: <?php echo get_cja_user_code($cja_current_user_obj->id); ?></p>
            <?php $cja_current_user_obj->display_form_field('company_name');

            // Show the actual or pending description
            if ($cja_current_user_obj->description_approved == 'pending') { ?>
                <p class="label">Company Description</p>
                <textarea name="company_description" cols="30" rows="10"><?php echo $cja_current_user_obj->pending_description; ?></textarea>
                <p style="margin-top: 0; color: #A00">Your profile is pending approval by our admin team. You will be notified by email when it is approved.</p><?php
            } else {
                $cja_current_user_obj->display_form_field('company_description'); 
            } ?>
            
            <div class="form_flexbox_2">
                <div><?php $cja_current_user_obj->display_form_field('contact_person'); ?></div>
                <div><?php $cja_current_user_obj->display_form_field('phone'); ?></div>
            </div>
            
            
            <?php $cja_current_user_obj->display_form_field('address'); ?>
            <?php $cja_current_user_obj->display_form_field('postcode'); ?>
        </div></div>

<!-- AND IF THEY ARE AN APPLICANT DISPLAY APPLICANT DETAILS -->	
<?php } else if ($cja_current_user_obj->role == 'jobseeker') { ?>
        <div id="poststuff"><div class="admin_edit_form">
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
                <p style="margin-top: 0; color: #A00">Your profile is pending approval by our admin team. You will be notified by email when it is approved.</p><?php
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
        </div></div>

<?php } ?>
    <input type="hidden" name="cja_update_user_admin" value="true">
    <input type="hidden" name="cja_user_id" value="<?php echo $_GET['user_id']; ?>"><?php

}