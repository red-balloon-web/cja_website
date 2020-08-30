<?php

if ($_POST['update-ad']) {

    $cja_update_ad = new CJA_Classified_Advert($_POST['advert-id']);
    $cja_update_ad->update_from_form(); 
    print_r($cja_update_ad);
    $cja_update_ad->save(); 
    ?><p class="cja_alert cja_alert--success">Your advert for "<?php echo ($cja_update_ad->title); ?>" has been updated.</p><?php
}

?>