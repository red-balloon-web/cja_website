<div class="basic_details application_box">

    <h2 class="form_section_heading">Application Details</h2>

    <table class="display_table">
        <tr>
            <td>Applicant</td>
            <td><?php echo $cja_current_applicant->full_name; ?></td>
        </tr>
        <tr>
            <td>Job Applied For</td>
            <td><?php echo $cja_current_ad->title; ?></td>
        </tr>
        <tr>
            <td>Company</td>
            <td><?php echo $cja_current_advertiser->company_name; ?></td>
        </tr>
        <tr>
            <td>Application Date</td>
            <td><?php echo $cja_current_application->human_application_date; ?></td>
        </tr>
    </table>
</div>