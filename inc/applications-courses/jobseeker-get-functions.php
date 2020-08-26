<?php
if ($_GET['applicant_archive']) {
    $cja_archive_application = new CJA_Course_Application($_GET['applicant_archive']);
    $cja_archive_application_advert = new CJA_Course_Advert($cja_archive_application->advert_ID);
    $cja_archive_application->applicant_archive();
    $cja_archive_application->save();
    ?><p class="cja_alert cja_alert--success">You archived your application to '<?php echo $cja_archive_application_advert->title; ?>' with <?php echo $cja_archive_application_advert->author_human_name; ?>.</p><?php
}
?>