<?php

// $cja_edit_ad = ad to edit or blank if new ad
if (!$cja_edit_ad) {
    $cja_edit_ad = new CJA_Advert;
}
$cja_current_user = new CJA_User;

?>

<h2 class="form_section_heading">Title and Description</h2>

<div class="form_flexbox_2">
    <div>
        <p class="label">Opportunity Title</p>
        <input type="text" name="ad-title" value="<?php echo ($cja_edit_ad->title); ?>">
    </div>
    <div>
        <?php $cja_edit_ad->display_form_field('deadline'); ?>
    </div>
</div>


<p class="label">Opportunity Description</p>
<textarea name="ad-content" id="" cols="30" rows="10"><?php echo ($cja_edit_ad->content); ?></textarea>

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

<h2 class="form_section_heading">Salary</h2>

<p class="label">Salary</p>
<input type="text" name="salary_numeric" value="£<?php echo ($cja_edit_ad->salary_numeric); ?>">
<?php $cja_edit_ad->display_form_field('salary_per', false); ?>
<?php $cja_edit_ad->display_form_field('payment_frequency'); ?>

<h2 class="form_section_heading">About The Job</h2>

<div class="form_flexbox_2">
    <div>
        <?php $cja_edit_ad->display_form_field('career_level'); ?>
    </div>
    <div>
        <?php $cja_edit_ad->display_form_field('job_type'); ?>
    </div>
</div>

<div class="form_flexbox_2">
    <div>
        <?php $cja_edit_ad->display_form_field('shift_work'); ?>
    </div>
    <div>
        <?php $cja_edit_ad->display_form_field('location_options'); ?>
    </div>
</div>

<div class="form_flexbox_2">
    <div>
        <?php $cja_edit_ad->display_form_field('sector'); ?>
    </div>
    <div>
    </div>
</div>
<?php $cja_edit_ad->display_form_field('shifts'); ?>
    


<h2 class="form_section_heading">Qualifications</h2>
<div class="form_flexbox_2">
    <div>
        <?php $cja_edit_ad->display_form_field('minimum_qualification'); ?>
    </div>
    <div>
        <?php $cja_edit_ad->display_form_field('experience_required'); ?>
    </div>
</div>
<?php $cja_edit_ad->display_form_field('dbs_required'); ?>

<h2 class="form_section_heading">About Your Organisation</h2>

<div class="form_flexbox_2">
    <div>
        <p class="label">Contact Person</p>
        <input type="text" name="contact_person" value="<?php     
            if ($_GET['edit-ad']) {
                echo ($cja_edit_ad->contact_person); 
            } else {
                echo ($cja_current_user->contact_person);
            }
        ?>">
    </div>
    <div>
        <p class="label">Contact Phone Number</p>
        <input type="text" name="contact_phone_number" value="<?php 
            if ($_GET['edit-ad']) {
                echo ($cja_edit_ad->contact_phone_number);
            } else {
                echo ($cja_current_user->phone);
            }
        ?>">
    </div>
</div>

<div class="form_flexbox_2">
    <div>
        <p class="label">Postcode</p>
        <input type="text" name="postcode" value="<?php 
            if ($_GET['edit-ad']) {
                echo ($cja_edit_ad->postcode); 
            } else {
                echo ($cja_current_user->postcode);
            }
        ?>">
    </div>
    <div>
        <?php $cja_edit_ad->display_form_field('employer_type'); ?>
    </div>
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

