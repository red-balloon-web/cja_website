<?php

// Requires $cja_edit_ad = CJA_Advert to edit existing ad otherwise will leave fields blank if $cja_edit_ad is unset

$cja_current_user = new CJA_User;

?>

<p class="label">Advert Title</p>
<input type="text" name="ad-title" value="<?php echo ($cja_edit_ad->title); ?>">

<p class="label">Advert Category</p>
<select name="category" form="edit_ad_form">
    <option value="for_sale" <?php if ($cja_edit_ad->category == 'for_sale') { echo 'selected'; } ?>>For Sale</option>
    <option value="for_hire" <?php if ($cja_edit_ad->category == 'for_hire') { echo 'selected'; } ?>>For Hire</option>
    <option value="lost_found" <?php if ($cja_edit_ad->category == 'lost_found') { echo 'selected'; } ?>>Lost and Found</option>
    <option value="freebies" <?php if ($cja_edit_ad->category == 'freebies') { echo 'selected'; } ?>>Freebies</option>
</select>

<p class="label">Advert Subcategory</p>
<select name="subcategory" form="edit_ad_form">
    <option value="motors" <?php if ($cja_edit_ad->subcategory == 'motors') { echo 'selected'; } ?>>Motors</option>
    <option value="properties" <?php if ($cja_edit_ad->subcategory == 'properties') { echo 'selected'; } ?>>Properties</option>
    <option value="restaurants" <?php if ($cja_edit_ad->subcategory == 'restaurants') { echo 'selected'; } ?>>Restaurants</option>
    <option value="pets" <?php if ($cja_edit_ad->subcategory == 'pets') { echo 'selected'; } ?>>Pets</option>
    <option value="plumbers" <?php if ($cja_edit_ad->subcategory == 'plumbers') { echo 'selected'; } ?>>Plumbers</option>
    <option value="news_events" <?php if ($cja_edit_ad->subcategory == 'pets') { echo 'selected'; } ?>>News and Events</option>
</select>

<p class="label">Postcode</p>
<input type="text" name="postcode" value="<?php 
    if ($cja_edit_ad->postcode) {
        echo ($cja_edit_ad->postcode); 
    } else if ($cja_current_user->postcode) {
        echo $cja_current_user->postcode;
    }        
?>">

<p class="label">Email Address</p>
<input type="text" name="email" value="<?php 
    if ($cja_edit_ad->email) {
        echo $cja_edit_ad->email;
    } else if ($cja_current_user->email) {
        echo $cja_current_user->email;
    }
?>">

<p class="label">Phone Number</p>
<input type="text" name="phone" value="<?php echo $cja_edit_ad->phone; ?>">

<p class="label">Advert Text</p>
<textarea name="content" id="" cols="30" rows="10"><?php echo ($cja_edit_ad->content); ?></textarea>

<p class="label">Photo</p>
<?php if ($cja_edit_ad->class_photo_url == '') { ?> 
    <input type="file" name="class_photo">
<?php } else { ?>
    <p>Current File: <?php echo $cja_edit_ad->class_photo_filename; ?></p>
    <p class="label">Upload New File:</p>
    <input type="file" name="class_photo">
<?php } ?>
