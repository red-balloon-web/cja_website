<?php

if ($_GET['advertiser_archive']) {
    $cja_archive_application = new CJA_Course_Application($_GET['advertiser_archive']);
        if (!$cja_archive_application->advertiser_archived) {
        $cja_archive_application_advert = new CJA_Course_Advert($cja_archive_application->advert_ID);
        $cja_archive_application->advertiser_archive();
        $cja_archive_application->save();
        ?><p class="cja_alert cja_alert--success">You archived <?php echo $cja_archive_application->applicant_name; ?>'s application for '<?php echo $cja_archive_application_advert->title; ?>'.</p><?php
    }
}

?>