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

            <h2 class="form_section_heading">Profile Status</h2>
            <p class="label">Set your profile status to "Not Currently Available" if you are not currently looking for work or education and do not want to be included in searches</p>
            <?php $cja_current_user_obj->display_form_field('profile_status'); ?>

            <h2 class="form_section_heading">About You</h2>

        <!-- role management - select courses/jobs. JS updates UI and hidden is_jobseeker and is_courseseeker fields on click -->
        
        <p class="label">You are looking for:</p>
        <div class="role_select_box">
            <div class="role<?php 
                if ($cja_current_user_obj->is_jobseeker && !$cja_current_user_obj->is_student) {
                    echo ' current';
                }
            ?>" id="role-js-only">Jobs</div>
            <div class="role<?php 
                if (!$cja_current_user_obj->is_jobseeker && $cja_current_user_obj->is_student) {
                    echo ' current';
                }
            ?>" id="role-cs-only">Courses</div>
            <div class="role<?php 
                if ($cja_current_user_obj->is_jobseeker && $cja_current_user_obj->is_student) {
                    echo ' current';
                }
            ?>" id="role-both">Jobs and Courses</div>
        </div>

        <input type="hidden" name="is_jobseeker" id="is_jobseeker" value="<?php
            if ($cja_current_user_obj->is_jobseeker) {
                echo 'true';
            } else {
                echo '';
            }
        ?>">

        <input type="hidden" name="is_student" id="is_student" value="<?php
            if ($cja_current_user_obj->is_student) {
                echo 'true';
            } else {
                echo '';
            }
        ?>">

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

            <h2 class="form_section_heading">About the Opportunities You're Looking For</h2>
            <p class="label checkbox_list_label">Opportunity Required</p>
            <div class="checkbox_list">
                <p class="checkbox_list courseseeker-only"><input type="checkbox" name="opportunity_required[]" value="apprenticeship" <?php 
                    if (in_array('apprenticeship', $cja_current_user_obj->opportunity_required)) {
                        echo " checked";
                    } ?>> Apprenticeship</p>                
                <p class="checkbox_list courseseeker-only"><input type="checkbox" name="opportunity_required[]" value="traineeship" <?php 
                    if (in_array('traineeship', $cja_current_user_obj->opportunity_required)) {
                        echo " checked";
                    } ?>> Traineeship</p>                
                <p class="checkbox_list jobseeker-only"><input type="checkbox" name="opportunity_required[]" value="internship"  <?php 
                    if (in_array('internship', $cja_current_user_obj->opportunity_required)) {
                        echo " checked";
                    } ?>> Internship for University</p>                
                <p class="checkbox_list jobseeker-only"><input type="checkbox" name="opportunity_required[]" value="work_experience" <?php 
                    if (in_array('work_experience', $cja_current_user_obj->opportunity_required)) {
                        echo " checked";
                    } ?>> Work Experience</p>                
                <p class="checkbox_list jobseeker-only"><input type="checkbox" name="opportunity_required[]" value="paid_employment" <?php 
                    if (in_array('paid_employment', $cja_current_user_obj->opportunity_required)) {
                        echo " checked";
                    } ?>> Paid Employment</p>                
                <p class="checkbox_list courseseeker-only"><input type="checkbox" name="opportunity_required[]" value="course_employment" <?php 
                    if (in_array('course_employment', $cja_current_user_obj->opportunity_required)) {
                        echo " checked";
                    } ?>> Course for Employment</p>                
                <p class="checkbox_list courseseeker-only"><input type="checkbox" name="opportunity_required[]" value="course_university"  <?php 
                    if (in_array('course_university', $cja_current_user_obj->opportunity_required)) {
                        echo " checked";
                    } ?>> Course for University</p>                
                <p class="checkbox_list courseseeker-only"><input type="checkbox" name="opportunity_required[]" value="placement_course" <?php 
                    if (in_array('placement_course', $cja_current_user_obj->opportunity_required)) {
                        echo " checked";
                    } ?>> A Placement for my Course</p>
                <p class="checkbox_list courseseeker-only"><input type="checkbox" name="opportunity_required[]" value="cpd" <?php 
                    if (in_array('cpd', $cja_current_user_obj->opportunity_required)) {
                    echo " checked";
                } ?>> Looking for CPD</p>
            </div>
            <div class="jobseeker-only">
                <div class="form_flexbox_2">
                    <div><?php $cja_current_user_obj->display_form_field('job_time'); ?></div>
                    <div><?php $cja_current_user_obj->display_form_field('job_role'); ?></div>
                </div>
                <?php $cja_current_user_obj->display_form_field('cover_work'); ?>
            </div>
            <div class="courseseeker-only">
                <div class="form_flexbox_2">
                    <div><?php $cja_current_user_obj->display_form_field('course_time'); ?></div>
                    <div><?php $cja_current_user_obj->display_form_field('what_course'); ?></div>
                </div><?php
                $cja_current_user_obj->display_form_field('looking_for_loan');
                $cja_current_user_obj->display_form_field('progress_to_university');
                $cja_current_user_obj->display_form_field('progress_to_employment'); ?>
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
                <div><?php //$cja_current_user_obj->display_form_field('current_status');
                    // Recreating this manually to have job/courseseeker specific fields ?>
                    <p class="label">Current Employment or Education Status</p>
                    <select name="current_status" id="current_status">
                        <option value=""> -- Select -- </option>
                        <option value="unemployed_work" <?php if ($cja_current_user_obj->current_status == 'unemployed_work') {
                            echo ' selected'; }
                        ?>>Unemployed looking for work</option>                   
                        <option value="unemployed_course" <?php if ($cja_current_user_obj->current_status == 'unemployed_course') {
                            echo ' selected'; }
                        ?>>Unemployed looking for a course</option>                    
                        <option value="unemployed_not_education" <?php if ($cja_current_user_obj->current_status == 'unemployed_not_education') {
                            echo ' selected'; }
                        ?>>Unemployed and not in education</option>                    
                        <option value="unemployed_work_experience" <?php if ($cja_current_user_obj->current_status == 'unemployed_work_experience') {
                            echo ' selected'; }
                        ?>>Unemployed seeking work experience </option>                    
                        <option value="employed_career_change" <?php if ($cja_current_user_obj->current_status == 'employed_career_change') {
                            echo ' selected'; }
                        ?>>Employed but looking for career change</option>                    
                        <option value="not_education_training" <?php if ($cja_current_user_obj->current_status == 'not_education_training') {
                            echo ' selected'; }
                        ?>>Not in education or training </option>                    
                        <option value="education_work_experience" <?php if ($cja_current_user_obj->current_status == 'education_work_experience') {
                            echo ' selected'; }
                        ?>>In education looking for work experience</option>            
                    </select>
                    
                </div>
            </div>
            <div class="form_flexbox_2">
                <div><?php $cja_current_user_obj->display_form_field('unemployed'); ?></div>
                <div><?php $cja_current_user_obj->display_form_field('receiving_benefits'); ?></div>
            </div>
            <div class="form_flexbox_2">
                <div><?php $cja_current_user_obj->display_form_field('dbs'); ?></div>
                <div><?php $cja_current_user_obj->display_form_field('current_availability'); ?></div>
            </div>

            <?php $cja_current_user_obj->display_form_field('how_far_travel'); ?>
            <?php $cja_current_user_obj->display_form_field('prevent_safeguarding'); ?>
            <?php $cja_current_user_obj->display_form_field('contact_preference'); ?>

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
    <input type="hidden" name="cja_user_id" value="<?php echo $_GET['user_id']; ?>">

    <script>

        // Hide inappropriate fields on page ready
        jQuery(document).ready(function() { 

            // If not looking for jobs
            if (jQuery('#is_jobseeker').val() == '') {
                jQuery('.jobseeker-only').hide();
                removeOption('current_status', 'unemployed_work');
            }
            // If not looking for courses
            if (jQuery('#is_student').val() == '') {
                jQuery('.courseseeker-only').hide();
                removeOption('current_status', 'unemployed_course');
            }

        });

        // click on jobs
        jQuery('#role-js-only').click(function() {

            // Update boxes
            jQuery('#role-js-only').addClass('current');
            jQuery('#role-cs-only').removeClass('current');
            jQuery('#role-both').removeClass('current');

            // Update hidden fields
            jQuery('#is_jobseeker').val('true');
            jQuery('#is_student').val('');

            // Update UI 
            jQuery('.jobseeker-only').show();
            jQuery('.courseseeker-only').hide();
            removeOption('current_status', 'unemployed_course');
            addOption('current_status', 'Unemployed looking for work', 'unemployed_work');
        });

        // click on courses
        jQuery('#role-cs-only').click(function() {

            // Update boxes
            jQuery('#role-js-only').removeClass('current');
            jQuery('#role-cs-only').addClass('current');
            jQuery('#role-both').removeClass('current');

            // Update hidden fields
            jQuery('#is_jobseeker').val('');
            jQuery('#is_student').val('true');

            // Update UI
            jQuery('.jobseeker-only').hide();
            jQuery('.courseseeker-only').show();
            removeOption('current_status', 'unemployed_work');
            addOption('current_status', 'Unemployed looking for a course', 'unemployed_course');
        });

        // click on both
        jQuery('#role-both').click(function() {
            jQuery('#role-js-only').removeClass('current');
            jQuery('#role-cs-only').removeClass('current');
            jQuery('#role-both').addClass('current');

            // Update hidden fields
            jQuery('#is_jobseeker').val('true');
            jQuery('#is_student').val('true');

            // Update UI
            jQuery('.jobseeker-only').show();
            jQuery('.courseseeker-only').show();
            addOption('current_status', 'Unemployed looking for a course', 'unemployed_course');
            addOption('current_status', 'Unemployed looking for work', 'unemployed_work');
            })

            // Remove all options from select list // not used
            function removeAllOptions(selectId) {
                const selectBox = document.getElementById(selectId);
                while(selectBox.options[0]) {
                    selectBox.remove(0);
                }
            }

            // Dynamically remove option from select list
            function removeOption(selectId, value) {
                const selectBox = document.getElementById(selectId);
                var i = 0;
                while (selectBox.options[i]) {
                    if (value == selectBox.options[i].value) {
                        selectBox.remove(i);
                    }
                    i++;
                }
            }

            // Dynamically add option to select list
            function addOption(selectId, label, value) {
                const selectBox = document.getElementById(selectId);

                // Make sure it doesn't already exist
                var i = 0;
                while (selectBox.options[i]) {
                    if (value == selectBox.options[i].value) {
                        return;
                    }
                    i++;
                }

                // Add new option
                let newOption = new Option(label, value);
                selectBox.add(newOption);
            }
            </script><?php
} ?>