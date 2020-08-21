<?php

if ($_POST) {

// This is now handled from functions.php to redirect to page without form data
/*
if ($_POST['process-create-ad']) {

    $cja_new_ad = new CJA_Advert;
    $cja_new_ad->create(); // create a new post in the database
    $cja_new_ad->update_from_form(); 
    $cja_new_ad->save(); 
    
    if (!$_GET['draft']) {
        $cja_new_ad->activate();
        $cja_new_ad->save();
        spend_credits();
        ?><p class="cja_alert cja_alert--success">Your Advert "<?php echo $cja_new_ad->title; ?>" Was Created for 1 Credit!</p><?php
    } else {
    
    ?><p class="cja_alert cja_alert--success">Your Advert "<?php echo $cja_new_ad->title; ?>" Was Created!</p><?php

    }
}
*/

if ($_POST['update-ad']) {

    $cja_update_ad = new CJA_Course_Advert($_POST['advert-id']);
    $cja_update_ad->update_from_form(); 
    //print_r($cja_update_ad);
    $cja_update_ad->save(); 
    ?><p class="cja_alert cja_alert--success">Your advert for "<?php echo ($cja_update_ad->title); ?>" has been updated.</p><?php
}

}

?>