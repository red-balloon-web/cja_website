<div class="applicant_details application_box smart_form">
    
    <h2 class="form_section_heading">Basic Candidate Details</h2>

    <?php if ($cja_current_applicant->photo_url) { ?>
        <img src="<?php echo $cja_current_applicant->photo_url; ?>" alt="" style="display: block; width: 100%; max-width: 500px; height: auto; margin-left: auto; margin-right: auto; margin-bottom: 40px">
    <?php } ?>

    <table class="display_table">
        <tr>
            <td>Name</td>
            <td><?php echo $cja_current_applicant->full_name; ?></td>
        </tr>
        <tr>
            <td>Phone</td>
            <td><?php echo $cja_current_applicant->phone; ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?php echo $cja_current_applicant->email; ?></td>
        </tr>
        <tr>
            <td>Town / City</td>
            <td><?php echo $cja_current_applicant->town_city; ?></td>
        </tr>
        <tr>
            <td>ID</td>
            <td><?php echo get_cja_user_code($cja_current_applicant->id); ?></td>
        </tr>
    </table>

    <h2 class="form_section_heading">Education</h2>
    <table class="display_table">
        <tr>
            <td>GCSE Maths</td>
            <td><?php echo($cja_current_applicant->display_field('gcse_maths')); ?></td>
        </tr>
        <tr>
            <td>GCSE English</td>
            <td><?php echo $cja_current_applicant->display_field('gcse_english'); ?></td>
        </tr>
        <tr>
            <td>Functional Skills Maths</td>
            <td><?php echo $cja_current_applicant->display_field('functional_maths'); ?></td>
        </tr>
        <tr>
            <td>Functional Skills English</td>
            <td><?php echo $cja_current_applicant->display_field('functional_english'); ?></td>
        </tr>
        <tr>
            <td>Highest Qualification</td>
            <td><?php echo $cja_current_applicant->display_field('highest_qualification'); ?></td>
        </tr>
    </table>

    <h2 class="form_section_heading">Opportunities and Specialisms</h2>

    <table class="display_table">
        <tr>
            <td>Opportunities Sought</td>
            <td><?php $cja_current_applicant->display_field('opportunity_required'); ?></td>
        </tr><?php 
        if ($candidate_template == 'jobseeker') { ?>
            <tr>
                <td>Jobs Part / Full Time</td>
                <td><?php echo $cja_current_applicant->display_field('job_time'); ?></td>
            </tr>
            <tr>
                <td>Preferred Job Roles</td>
                <td><?php echo $cja_current_applicant->display_field('job_role'); ?></td>
            </tr>
            <tr>
                <td>Are you interested in cover work?</td>
                <td><?php echo $cja_current_applicant->display_field('cover_work'); ?></td>
            </tr><?php
        }
        if ($candidate_template == 'courseseeker') { ?>
            <tr>
                <td>Courses Part / Full Time</td>
                <td><?php echo $cja_current_applicant->display_field('course_time'); ?></td>
            </tr>
            <tr>
                <td>What course are you looking for?</td>
                <td><?php echo $cja_current_applicant->display_field('what_course'); ?></td>
            </tr>
            <tr>
                <td>Looking for a student loan / advanced learner loan</td>
                <td><?php echo $cja_current_applicant->display_field('looking_for_loan'); ?></td>
            </tr>
            <tr>
                <td>Looking for a course to progress to university</td>
                <td><?php echo $cja_current_applicant->display_field('progress_to_university'); ?></td>
            </tr>
            <tr>
                <td>Looking for a course to enter employment (e.g. CSCS)</td>
                <td><?php echo $cja_current_applicant->display_field('progress_to_employment'); ?></td>
            </tr><?php
        } ?>
        <tr>
            <td>Sectors of Interest or Specialism</td>
            <td><?php $cja_current_applicant->display_field('specialism_area'); ?></td>
        </tr>
        
        
        <tr>
            <td>Weekends Availability</td>
            <td><?php echo $cja_current_applicant->display_field('weekends_availability'); ?></td>
        </tr>
    </table>

    <h2 class="form_section_heading">Further Information</h2>
    <table class="display_table">
        <tr>
            <td>Age Category</td>
            <td><?php $cja_current_applicant->display_field('age_category'); ?></td>
        </tr>
        <tr>
            <td>Current Employment of Education Status</td>
            <td><?php $cja_current_applicant->display_field('current_status'); ?></td>
        </tr>
        <tr>
            <td>Unemployed Yes/No</td>
            <td><?php $cja_current_applicant->display_field('unemployed'); ?></td>
        </tr>
        <tr>
            <td>Receiving Benefits Yes/No</td>
            <td><?php $cja_current_applicant->display_field('receiving_benefits'); ?></td>
        </tr>
        <tr>
            <td>DBS Yes/No</td>
            <td><?php $cja_current_applicant->display_field('dbs'); ?></td>
        </tr>
        <tr>
            <td>Current Availability</td>
            <td><?php $cja_current_applicant->display_field('current_availability'); ?></td>
        </tr>
        <tr>
            <td>How far can you travel?</td>
            <td><?php $cja_current_applicant->display_field('how_far_travel'); ?></td>
        </tr>
        <tr>
            <td>Have you done the Prevent or Safeguarding training?</td>
            <td><?php $cja_current_applicant->display_field('prevent_safeguarding'); ?></td>
        </tr>
        <tr>
            <td>Contact Preference</td>
            <td><?php $cja_current_applicant->display_field('contact_preference'); ?></td>
        </tr>
    </table>

    <h2 class="form_section_heading">Candidate Profile and Attachments</h2>
    <div class="cja_description"><?php echo wpautop($cja_current_applicant->company_description); ?></div>

    <?php if ($cja_current_applicant->files_array) { ?>
        <table class="display_table"><?php
            foreach ($cja_current_applicant->files_array as $file) {?>
                <tr>
                    <td>
                        <?php echo $file['name']; ?>
                    </td>
                    <td style="text-align: right">
                        <a class="cja_button" href="<?php echo $file['url']; ?>" target="_blank">View / Download Attachment</a>
                    </td>
                </tr>                
            <?php } ?>  
        </table>
    <?php } ?>

    <!--<?php if ($cja_current_application->cv_url) { ?>
        <p><a target="_blank" href="<?php echo $cja_current_application->cv_url; ?>" class="cja_button">View / Download CV</a></p>

    <?php } ?>-->
</div>