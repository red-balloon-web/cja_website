<div class="application_box">
    <h4>About <?php echo $cja_current_ad->author_human_name; ?></h4>
    <p class="cja_listing_item">Contact person: <strong><?php echo $cja_current_advertiser->contact_person; ?></strong></p>
    <p class="cja_listing_item">Phone Number: <strong><?php echo $cja_current_advertiser->phone; ?></strong></p>
    <p class="cja_listing_item">Address: <strong><?php echo wpautop($cja_current_advertiser->address); ?></strong></p>
    <h4>Company Description</h4>
    <div class="cja_description"><?php echo wpautop($cja_current_advertiser->company_description); ?></div>
</div>