<?php

// Requires $cja_edit_ad = CJA_Advert to edit existing ad otherwise will leave fields blank if $cja_edit_ad is unset

$cja_current_user = new CJA_User;

?>

<p class="label">Advert Title</p>
<input type="text" name="ad-title" value="<?php echo ($cja_edit_ad->title); ?>">

<div class="form_flexbox_2">
    <div>
        <p class="label">Advert Category</p>
        <select name="category" form="edit_ad_form">
            <option value="for_sale" <?php if ($cja_edit_ad->category == 'for_sale') { echo 'selected'; } ?>>For Sale</option>
            <option value="for_hire" <?php if ($cja_edit_ad->category == 'for_hire') { echo 'selected'; } ?>>For Hire</option>
            <option value="motors" <?php if ($cja_edit_ad->category == 'motors') { echo 'selected'; } ?>>Motors</option>
            <option value="pets" <?php if ($cja_edit_ad->category == 'pets') { echo 'selected'; } ?>>Pets</option>
            <option value="properties" <?php if ($cja_edit_ad->category == 'properties') { echo 'selected'; } ?>>Properties</option>
            <option value="services" <?php if ($cja_edit_ad->category == 'services') { echo 'selected'; } ?>>Services</option>
            <option value="exchange" <?php if ($cja_edit_ad->category == 'exchange') { echo 'selected'; } ?>>Exchange</option>
            <option value="freebies" <?php if ($cja_edit_ad->category == 'freebies') { echo 'selected'; } ?>>Freebies</option>
            <option value="lost_found" <?php if ($cja_edit_ad->category == 'lost_found') { echo 'selected'; } ?>>Lost and Found</option>
            <option value="make_offer" <?php if ($cja_edit_ad->category == 'make_offer') { echo 'selected'; } ?>>Make an Offer</option>
            <option value="notices" <?php if ($cja_edit_ad->category == 'notices') { echo 'selected'; } ?>>Notices</option>
            <option value="events" <?php if ($cja_edit_ad->category == 'events') { echo 'selected'; } ?>>Events</option>
            <option value="urgent_jobs" <?php if ($cja_edit_ad->category == 'urgent_jobs') { echo 'selected'; } ?>>Urgent Jobs</option>
        </select>
    </div>
    <div>
        <p class="label">Postcode</p>
        <input type="text" name="postcode" value="<?php 
            if ($cja_edit_ad->postcode) {
                echo ($cja_edit_ad->postcode); 
            } else if ($cja_current_user->postcode) {
                echo $cja_current_user->postcode;
            }        
        ?>">
    </div>
</div>

<div class="form_flexbox_2">
    <div>
        <p class="label">Email Address</p>
        <input type="text" name="email" value="<?php 
            if ($cja_edit_ad->email) {
                echo $cja_edit_ad->email;
            } else if ($cja_current_user->email) {
                echo $cja_current_user->email;
            }
        ?>"> 
    </div>

    <div>
        <p class="label">Phone Number</p>
        <input type="text" name="phone" value="<?php echo $cja_edit_ad->phone; ?>">
    </div>
</div>




<p class="label">Advert Text</p>
<textarea name="content" id="" cols="30" rows="10"><?php echo ($cja_edit_ad->content); ?></textarea>

<h2 class="form_section_heading mb-0">Main Photo</h2>
<p class="muted">If you upload a main photo this will appear at the top of your advert</p>
<?php if ($cja_edit_ad->class_photo_url == '') { ?> 
    <p class="label">Choose Photo (Accepted filetypes: .gif .jpg .jpeg .png)</p>
    <input type="file" name="class_photo">
<?php } else { ?>
    <img src="<?php echo $cja_edit_ad->class_photo_url; ?>" width="100px"; ><br>
    <p class="label">Change Photo (Accepted filetypes: .gif .jpg .jpeg .png)</p>
    <input type="file" name="class_photo">
    <p><input type="checkbox" name="delete_photo" value="true"> Delete Photo</p>
<?php } ?>

<h2 class="form_section_heading mb-0">Attachments</h2>
<p class="muted">Attachments may include more photos, documents, PDF, etc.</p>
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

