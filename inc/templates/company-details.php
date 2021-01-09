<div class="application_box">

    <h2 class="form_section_heading">About The Advertiser</h2>

        <table class="display_table">
            <tr>
                <td>Organisation Name</td>
                <td><?php echo $cja_current_advertiser->display_field('company_name'); ?></td>
            </tr>
            <tr>
                <td>Contact Person</td>
                <td><?php echo $cja_current_advertiser->display_field('contact_person'); ?></td>
            </tr>
            <tr>
                <td>Phone Number</td>
                <td><?php echo $cja_current_advertiser->display_field('phone'); ?></td>
            </tr>
            <tr>
                <td>Address</td>
                <td><?php echo $cja_current_advertiser->display_field('address'); ?></td>
            </tr>
            <tr>
                <td>Postcode</td>
                <td><?php echo $cja_current_advertiser->display_field('postcode'); ?></td>
            </tr>
            <tr>
                <td>ID</td>
                <td><?php echo get_cja_user_code($cja_current_advertiser->id); ?></td>
            </tr>
        </table>

    <h2 class="form_section_heading">Advertiser Profile</h2>
    <div class="cja_description">
        <?php echo $cja_current_advertiser->display_field('company_description'); ?>
    </div>
</div>