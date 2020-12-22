<div class="basic_details application_box">
    <!--<h4>Basic Details</h4>
    <p class="cja_listing_item">Applicant: <strong><?php echo $cja_current_applicant->full_name; ?></strong></p>
    <p class="cja_listing_item">Course Title: <strong><?php echo $cja_current_ad->title; ?></strong></p>
    <p class="cja_listing_item">Organisation: <strong><?php echo $cja_current_advertiser->company_name; ?></strong></p>
    <p class="cja_listing_item">Date: <strong><?php echo $cja_current_application->human_application_date; ?></strong></p>-->
    <!--<p class="cja_listing_item">Covering Letter:</p> 
    <div class="cja_description"><?php echo wpautop($cja_current_application->applicant_letter); ?></div>-->

    <h2 class="form_section_heading">Application Details</h2>

    <table class="display_table">
        <tr>
            <td>Applicant</td>
            <td><?php echo $cja_current_applicant->full_name; ?></td>
        </tr>
        <tr>
            <td>Course Applied For</td>
            <td><?php echo $cja_current_ad->title; ?></td>
        </tr>
        <tr>
            <td>Organisation</td>
            <td><?php echo $cja_current_advertiser->company_name; ?></td>
        </tr>
        <tr>
            <td>Application Date:</td>
            <td><?php echo $cja_current_application->human_application_date; ?></td>
        </tr>
    </table>
</div>