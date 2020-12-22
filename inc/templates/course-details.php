<div class="application_box">

    <?php if ($cja_current_ad->photo_url) { ?>
        <img src="<?php echo $cja_current_ad->photo_url; ?>" alt="" style="display: block; width: 100%; max-width: 500px; height: auto; margin-left: auto; margin-right: auto; margin-bottom: 40px">
    <?php } ?>

    <h2 class="form_section_heading">Course Title and Description</h2>
    <h4><strong><?php echo $cja_current_ad->title; ?></strong></h4>
    <div class="cja_description"><?php echo wpautop($cja_current_ad->description); ?></div>
    
    <h2 class="form_section_heading">About The Course</h2>
    <table class="display_table">
        <tr>
            <td>Deadline</td>
            <td><?php $cja_current_ad->display_field('deadline'); ?></td>
        </tr>
        <tr>
            <td>Offer Type</td>
            <td><?php $cja_current_ad->display_field('offer_type'); ?></td>
        </tr>
        <tr>
            <td>Category</td>
            <td><?php echo $cja_current_ad->display_field('category'); ?></td>
        </tr>
        <tr>
            <td>Sector</td>
            <td><?php echo $cja_current_ad->display_field('sector'); ?></td>
        </tr>
        <tr>
            <td>Qualification Level</td>
            <td><?php echo $cja_current_ad->display_field('qualification_level'); ?></td>
        </tr>
        <tr>
            <td>Total Units</td>
            <td><?php $cja_current_ad->display_field('total_units'); ?></td>
        </tr>
        <tr>
            <td>Awarding Body</td>
            <td><?php echo $cja_current_ad->display_field('awarding_body'); ?></td>
        </tr>
        <tr>
            <td>Duration</td>
            <td><?php echo $cja_current_ad->display_field('duration'); ?></td>
        </tr>
        <tr>
            <td>Delivery Route</td>
            <td><?php echo $cja_current_ad->display_field('delivery_route'); ?></td>
        </tr>
        <tr>
            <td>Career Level</td>
            <td><?php echo $cja_current_ad->display_field('career_level'); ?></td>
        </tr>
        <tr>
            <td>Available to Start</td>
            <td><?php echo $cja_current_ad->display_field('available_start'); ?></td>
        </tr>
    </table>
    <!--
    <?php if ($cja_current_ad->course_file_url) { ?>
        <p class="cja_listing_item"><a class="cja_button" href="<?php echo $cja_current_ad->course_file_url; ?>" target="_blank">Download Course Information</a></p>
    <?php } ?>
    -->

    <h2 class="form_section_heading">Funding and Eligibility</h2>
    <table class="display_table">
        <tr>
            <td>Price for students not eligible for funding (if applicable)</td>
            <td><?php $cja_current_ad->display_field('price'); ?></td>
        </tr>
        <tr>
            <td>Deposit Required</td>
            <td><?php echo $cja_current_ad->display_field('deposit_required'); ?></td>
        </tr>
        <tr>
            <td>Experience Required</td>
            <td><?php echo $cja_current_ad->display_field('experience_required'); ?></td>
        </tr>
        <tr>
            <td>Previous Qualification Required</td>
            <td><?php echo $cja_current_ad->display_field('previous_qualification'); ?></td>
        </tr>
        <tr>
            <td>Course Pathway</td>
            <td><?php $cja_current_ad->display_field('course_pathway'); ?></td>
        </tr>
        <tr>
            <td>Course Funding Options</td>
            <td><?php echo $cja_current_ad->display_field('funding_options'); ?></td>
        </tr>
        <tr>
            <td>Payment Plan</td>
            <td><?php echo $cja_current_ad->display_field('payment_plan'); ?></td>
        </tr>
        <tr>
            <td>DBS Required</td>
            <td><?php echo $cja_current_ad->display_field('dbs_required'); ?></td>
        </tr>
        <tr>
            <td>Allowance Available</td>
            <td><?php echo $cja_current_ad->display_field('allowance_available'); ?></td>
        </tr>
        <tr>
            <td>Social Services - Service Users</td>
            <td><?php echo $cja_current_ad->display_field('social_services'); ?></td>
        </tr>
        <tr>
            <td>Suitable for Those on Benefits</td>
            <td><?php echo $cja_current_ad->display_field('suitable_benefits'); ?></td>
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
                </tr>-->              
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