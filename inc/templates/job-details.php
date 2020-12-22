<div class="application_box">

    <?php if ($cja_current_ad->photo_url) { ?>
        <img src="<?php echo $cja_current_ad->photo_url; ?>" alt="" style="display: block; width: 100%; max-width: 500px; height: auto; margin-left: auto; margin-right: auto; margin-bottom: 40px">
    <?php } ?>
    <!--<p class="cja_listing_item job_description">Job Description:</p>--> 
    <h2 class="form_section_heading">Job Title and Description</h2>
    <h4><strong><?php echo $cja_current_ad->title; ?></strong></h4>
    <div class="cja_description"><?php echo wpautop($cja_current_ad->content); ?></div>
    <h2 class="form_section_heading">Job Details</h2>

    <table class="display_table">
        <tr>
            <td>Salary</td>
            <td>£<?php echo $cja_current_ad->salary_numeric; ?> per <?php echo $cja_current_ad->salary_per; ?></td>
        </tr>
        <tr>
            <td>Payment Frequency</td>
            <td><?php echo $cja_current_ad->display_field('payment_frequency'); ?></td>
        </tr>
        <tr>
            <td>Deadline</td>
            <td><?php echo $cja_current_ad->display_field('deadline'); ?></td>
        </tr>
        <tr>
            <td>Sector</td>
            <td><?php echo $cja_current_ad->display_field('sector'); ?></td>
        </tr>
        <tr>
            <td>Job Type</td>
            <td><?php echo $cja_current_ad->display_field('job_type'); ?></td>
        </tr>
        <tr>
            <td>Career Level</td>
            <td><?php echo $cja_current_ad->display_field('career_level'); ?></td>
        </tr>
        <tr>
            <td>Experience Required</td>
            <td><?php echo $cja_current_ad->display_field('experience_required'); ?></td>
        </tr>
        <tr>
            <td>Minimum Qualification Required</td>
            <td><?php echo $cja_current_ad->display_field('minimum_qualification'); ?></td>
        </tr>
        <tr>
            <td>DBS Required</td>
            <td><?php echo $cja_current_ad->display_field('dbs_required'); ?></td>
        </tr>
        <tr>
            <td>Shift Work</td>
            <td><?php echo $cja_current_ad->display_field('shift_work'); ?></td>
        </tr>
        <?php if ($cja_current_ad->shift_work == 'yes') { ?>
            <tr>
                <td>Shifts</td>
                <td><?php echo $cja_current_ad->display_field('shifts'); ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td>Location Options</td>
            <td><?php echo $cja_current_ad->display_field('location_options'); ?></td>
        </tr>
        <tr>
            <td>Employer Type</td>
            <td><?php echo $cja_current_ad->display_field('employer_type'); ?></td>
        </tr>
        <tr>
            <td>Postcode</td>
            <td><?php echo $cja_current_ad->display_field('postcode'); ?></td>
        </tr>
        <tr>
            <td>Contact Person</td>
            <td><?php echo $cja_current_ad->display_field('contact_person'); ?></td>
        </tr>
        <tr>
            <td>Contact Phone Number</td>
            <td><?php echo $cja_current_ad->display_field('contact_phone_number'); ?></td>
        </tr>
    </table>

    <h2 class="form_section_heading">Additional Information</h2>
    <?php $cja_current_ad->display_field('more_information'); ?>

    <?php 
    
    if ($cja_current_ad->files_array) { ?>
        <h2 class="form_section_heading">Attachments</h2>
        <table><?php
            foreach ($cja_current_ad->files_array as $file) {?>
                <!--<tr>
                    <td><a href="<?php echo $file['url']; ?>" target="_blank"><?php echo $file['name']; ?></a></td>
                </tr>   -->      
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

</div>