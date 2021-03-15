<?php

// $cja_edit_ad = ad to edit or blank if new ad

if (!$cja_edit_ad) {
    $cja_edit_ad = new CJA_Course_Advert;
}
$cja_current_user = new CJA_User;

?>

<h2 class="form_section_heading">Title and Description</h2>

<div class="form_flexbox_2"><?php 
    if (!is_admin()) { ?>
        <div>
            <p class="label">Opportunity Title</p>
            <input type="text" name="ad-title" value="<?php echo ($cja_edit_ad->title); ?>">
        </div><?php
    } ?>
    <div>
        <?php $cja_edit_ad->display_form_field('deadline'); ?>
    </div>
</div>


<p class="label">Description</p>
<textarea name="ad-content" id="" cols="30" rows="10"><?php echo ($cja_edit_ad->description); ?></textarea>

<?php $cja_edit_ad->display_form_field('can_apply_online'); ?>

<h2 class="form_section_heading mb-0">Image</h2>
<?php // print_r($cja_edit_ad); ?>
<p class="muted">If you upload an image (photo, logo etc) this will appear at the top of your advert</p>
<?php if ($cja_edit_ad->photo_url == '') { ?> 
    <p class="label">Choose Photo (Accepted filetypes: .gif .jpg .jpeg .png)</p>
    <input type="file" name="photo">
<?php } else { ?>
    <img src="<?php echo $cja_edit_ad->photo_url; ?>" width="100px"; ><br>
    <p class="label">Change Photo (Accepted filetypes: .gif .jpg .jpeg .png)</p>
    <input type="file" name="photo">
    <p><input type="checkbox" name="delete_photo" value="true"> Delete Photo</p>
<?php } ?>

<h2 class="form_section_heading">About the Course</h2>

<div class="form_flexbox_2">
    <div><?php $cja_edit_ad->display_form_field('offer_type'); ?></div>
    <div><?php $cja_edit_ad->display_form_field('category'); ?></div>
</div>
<div class="form_flexbox_2">
    <div><?php $cja_edit_ad->display_form_field('sector'); ?></div>
    <div><?php $cja_edit_ad->display_form_field('qualification_level'); ?></div>
</div>
<div class="form_flexbox_2">
    <div><?php $cja_edit_ad->display_form_field('qualification_type'); ?></div>
    <div><?php $cja_edit_ad->display_form_field('total_units'); ?></div>
</div>
<div class="form_flexbox_2">
    <div><?php $cja_edit_ad->display_form_field('awarding_body'); ?></div>
    <div><?php $cja_edit_ad->display_form_field('duration'); ?></div>
</div>
<div class="form_flexbox_2">
    <div><?php $cja_edit_ad->display_form_field('delivery_route'); ?></div>
    <div><?php $cja_edit_ad->display_form_field('career_level'); ?></div>
</div>
<?php $cja_edit_ad->display_form_field('available_start'); ?>


<h2 class="form_section_heading">Funding and Eligibility</h2>

<div class="form_flexbox_2">
    <div><?php $cja_edit_ad->display_form_field('price'); ?></div>
    <div><?php $cja_edit_ad->display_form_field('deposit_required'); ?></div>
</div>
<div class="form_flexbox_2">
    <div><?php $cja_edit_ad->display_form_field('experience_required'); ?></div>
    <div><?php $cja_edit_ad->display_form_field('previous_qualification'); ?></div>
</div>
<div class="form_flexbox_2">
    <div><?php $cja_edit_ad->display_form_field('course_pathway'); ?></div>
    <div><?php $cja_edit_ad->display_form_field('funding_options'); ?></div>
</div>
<div class="form_flexbox_2">
    <div><?php $cja_edit_ad->display_form_field('payment_plan'); ?></div>
    <div><?php $cja_edit_ad->display_form_field('dbs_required'); ?></div>
</div>
<div class="form_flexbox_2">
    <div><?php $cja_edit_ad->display_form_field('allowance_available'); ?></div>
    <div><?php $cja_edit_ad->display_form_field('social_services'); ?></div>
</div>
<div class="form_flexbox_2">
    <div><?php $cja_edit_ad->display_form_field('suitable_benefits'); ?></div>
    <div><?php $cja_edit_ad->display_form_field('availability_period'); ?></div>
</div>


<h2 class="form_section_heading">About the Provider</h2>
<div class="form_flexbox_2">
    <div>
        <p class="label">Organisation Name</p>
        <input type="text" name="organisation_name" value="<?php 
            if ($_GET['create-ad']) {
                echo $cja_current_user->company_name;
            } else {
                echo $cja_edit_ad->organisation_name;
            }
        ?>">
    </div>
    <div>
        <p class="label">Contact Phone Number</p>
        <input type="text" name="phone" value="<?php 
            if ($_GET['create-ad']) {
                echo $cja_current_user->phone;
            } else {
                echo $cja_edit_ad->phone;
            }
        ?>">
    </div>
</div>

<p class="label">Address</p>
<textarea name="address" cols="30" rows="10"><?php 
    if ($_GET['create-ad']) {
        echo $cja_current_user->address;
    } else {
        echo $cja_edit_ad->address;
    }
?></textarea>

<div class="form_flexbox_2">
    <div>
        <p class="label">Postcode</p>
        <input type="text" name="postcode" value="<?php 
            if ($_GET['create-ad']) {
                echo $cja_current_user->postcode;
            } else {
                echo $cja_edit_ad->postcode;
            }
        ?>">
    </div>
    <div><?php $cja_edit_ad->display_form_field('contact_for_enquiry'); ?></div>
</div>
<div class="form_flexbox_2">
    <div>
        <p class="label">Contact Person</p>
        <input type="text" name="contact_person" value="<?php 
            if ($_GET['create-ad']) {
                echo $cja_current_user->contact_person;
            } else {
                echo $cja_edit_ad->contact_person;
            }
        ?>">
    </div>
    <div><?php $cja_edit_ad->display_form_field('provider_type'); ?></div>
</div>


<h2 class="form_section_heading">Attachments</h2>

<?php 
    if ($cja_edit_ad->files_array) {
        echo '<table class="attachments_table">';
        echo '<thead><td>File</td><td class="center">Delete</td></thead>';
        foreach($cja_edit_ad->files_array as $file) {
            ?><tr>
                <td><?php echo $file['name']; ?></td>
                <td class="center"><input type="checkbox" name="delete_files[]" value="<?php echo $file['url']; ?>"></td>
                </tr>
            <?php
        }
        echo '</table>';
    }
?>

<p>Add more files<br>
<input type="file" name="files[]" id="files" multiple></p>

<h2 class="form_section_heading mb-0">More Information</h2>
<p class="muted">Any more information you would like to add</p>
<?php $cja_edit_ad->display_form_field('more_information', false); ?>



<!--
<p class="label">Upload File</p>
<?php if ($cja_edit_ad->course_file_url == '') { ?> 
    <input type="file" name="course_file">
<?php } else { ?>
    <p>Current File: <?php echo $cja_edit_ad->course_file_filename; ?></p>
    <p>Load New File:<br><input type="file" name="course_file"></p>
<?php } ?>
-->