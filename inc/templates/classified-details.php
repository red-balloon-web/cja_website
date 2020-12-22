<div class="application_box">
    
    <?php if ($cja_current_ad->class_photo_url) { ?>
        <img src="<?php echo $cja_current_ad->class_photo_url; ?>" alt="" style="display: block; width: 100%; max-width: 500px; height: auto; margin-left: auto; margin-right: auto; margin-bottom: 40px">
    <?php } ?>

    <div class="cja_description"><?php echo wpautop($cja_current_ad->content); ?></div>
    
    <h2 class="form_section_heading">Advert Details</h2>
    
    <table class="display_table">
        <tr>
            <td>Category</td>
            <td><?php echo $cja_current_ad->return_human('category'); ?></td>
        </tr>
        <tr>
            <td>Postcode</td>
            <td><?php echo $cja_current_ad->postcode; ?></td>
        </tr>
        <tr>
            <td>Contact Phone Number</td>
            <td><?php echo $cja_current_ad->phone; ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?php echo $cja_current_ad->email; ?></td>
        </tr>
    </table>
        <?php if ($cja_current_ad->files_array) { ?>
            <h2 class="form_section_heading">Attachments</h2>
            <table><?php
                foreach ($cja_current_ad->files_array as $file) {?>
                    <!--<tr>
                        <td><a href="<?php echo $file['url']; ?>" target="_blank"><?php echo $file['name']; ?></a></td>
                    </tr>-->                
                    <tr>
                        <td>
                            <?php echo $file['name']; ?>
                        </td>
                        <td style="text-align: right">
                            <a class="cja_button" href="<?php echo $file['url']; ?>" target="_blank">View / Download Attachment</a>
                        </td>
                    </tr> 
                <?php } ?>  
            </table>
        <?php } ?>

</div>