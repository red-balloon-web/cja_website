<div class="application_box">
    
    <?php if ($cja_current_ad->class_photo_url) { ?>
        <img src="<?php echo $cja_current_ad->class_photo_url; ?>" alt="" style="display: block; width: 100%; max-width: 500px; height: auto; margin-left: auto; margin-right: auto;">
    <?php } ?>

    <h4>Advert Content</h4>
    <div class="cja_description"><?php echo wpautop($cja_current_ad->content); ?></div>
    <hr>
    <h4>Advert Details</h4>

    <p class="cja_listing_item">Category: <strong><?php echo $cja_current_ad->return_human('category'); ?></strong></p>
    <!--<p class="cja_listing_item">Subcategory: <strong><?php echo $cja_current_ad->return_human('subcategory'); ?></strong></p>-->
    <p class="cja_listing_item">Postcode: <strong><?php echo $cja_current_ad->postcode; ?></strong></p>
    <p class="cja_listing_item">Contact Phone Number: <strong><?php echo $cja_current_ad->phone; ?></strong></p>
    <p class="cja_listing_item">Email: <strong><?php echo $cja_current_ad->email; ?></strong></p>

</div>