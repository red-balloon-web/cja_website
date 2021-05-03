<?php

/**
 * Display custom fields to edit for individual post types in admin
 */
add_action('edit_form_after_title', 'display_admin_custom_post_edit_form');
function display_admin_custom_post_edit_form() {

    $screen = get_current_screen();

    // If we are on an add new screen then display message
    if ($screen->action == 'add') {
        if ($screen->post_type == 'job_ad') {
            echo 'Time to create a new job. To start, type in the job title and click publish.';
        } else if ($screen->post_type == 'course_ad') {
            echo 'Time to create a new course. To start, type in the course title and click publish.';
        } else if ($screen->post_type == 'classified_ad') {
            echo 'Time to create a new classified ad. To start, type in the advert title and click publish';
        }

    // Otherwise check we're on our own custom post and display edit form
    } else if ($screen->post_type == 'job_ad' || $screen->post_type == 'course_ad' || $screen->post_type == 'classified_ad') {

        echo '<p>CJA Code: ' . get_cja_code($_GET['post']);

        // Create correct object

        if ($screen->post_type == 'job_ad') {
            $cja_edit_ad = new CJA_Advert($_GET['post']); 
        } else if ($screen->post_type == 'course_ad') {
            $cja_edit_ad = new CJA_Course_Advert($_GET['post']); 
        } else if ($screen->post_type == 'classified_ad') {
            $cja_edit_ad = new CJA_Classified_Advert($_GET['post']); 
        }

        $cja_advertiser = new CJA_User($cja_edit_ad->author);

        // Start of form and advertiser section ?>
        <div class="admin_edit_form">
            <h2 class="form_section_heading">Advertiser</h2>
            <div class="form_flexbox_2">
                <div>
                    <p style="font-size: 1.5rem; margin-bottom: 5px; margin-top: 15px;"><span id="show_advertiser"><?php echo $cja_advertiser->display_name(); ?></span></p>
                    <p style="margin-top: 0; font-size: 1rem;"><span id="show_code"> <?php echo get_cja_user_code($cja_advertiser->id); ?></span></p>
                    <input type="hidden" name="advertiser" id="advertiser" value="<?php echo $cja_edit_ad->author; ?>">
                </div>
                <div>
                    <p class="label">Change Advertiser - Select</p>
                    <div class="selector" style="height: 200px; overflow-y: scroll; background-color: white; border: 1px solid black; border-radius: 5px; padding: 5px 10px; width: 100%; box-sizing: border-box;">
                        <ul role="listbox"><?php
    
                        // WP_User_Query arguments
                        // Classifieds can also be placed by jobseekers
                        if ($screen->post_type == 'classified_ad') {
                            $args = array(
                                'role__in' => array('administrator', 'advertiser', 'jobseeker')
                            );
                        } else {
                            $args = array(
                                'role__in' => array('administrator', 'advertiser')
                            );
                        }
    
                        // The User Query
                        $user_query = new WP_User_Query( $args );

                        $select_array = array();
                        
                        foreach($user_query->get_results() as $user) {
                            $the_advertiser = new CJA_User( $user->data->ID );
                            $new_element = array();
                            $new_element['id'] = $user->data->ID;
                            $new_element['user_code'] = get_cja_user_code($user->data->ID);
                            $new_element['display_name'] = $the_advertiser->display_name();
                            $select_array[strtoupper($the_advertiser->display_name())] = $new_element;
                        }

                        ksort($select_array);

                        foreach($select_array as $option) { ?>
                            <li><a style="cursor: pointer" class="update_advertiser" data-display_string="<?php 
                                echo $option['display_name']; ?>" data-display_code="<?php echo $option['user_code']; ?>" data-id="<?php echo $option['id']; ?>"><?php 
                                echo $option['display_name']; 
                                echo ' : ';
                                echo $option['user_code'];
                                ?></a></li><?php
                        } ?>
                        </ul>
                    </div>
                    <p class="label">Change Advertiser - Enter Code</p>
                    <input type="text" id="enter_advertiser_id">
                    <p id="enter_advertiser_id_feedback"></p>
                </div>
            </div> <?php

            // include details form and hidden field
            if ($screen->post_type == 'job_ad') {
                include( ABSPATH . 'wp-content/themes/courses-and-jobs/inc/templates/job-details-form.php'); ?>
                <input type="hidden" name="update_job_ad_admin" value="true"><?php
            } else if ($screen->post_type == 'course_ad') {
                include( ABSPATH . 'wp-content/themes/courses-and-jobs/inc/templates/course-details-form.php'); ?>
                <input type="hidden" name="update_course_ad_admin" value="true"><?php
            } else if ($screen->post_type == 'classified_ad') {
                ?><h2 class="form_section_heading">Advert Details</h2><?php
                include( ABSPATH . 'wp-content/themes/courses-and-jobs/inc/templates/classified-details-form.php'); ?>
                <input type="hidden" name="update_classified_ad_admin" value="true"><?php
            }

            // Hidden ID field ?>
            <input type="hidden" name="advert-id" value="<?php echo ($cja_edit_ad->id); ?>">
        </div>
        
        <!-- Javascript for advertiser edit functions -->
        <script>
            jQuery(document).ready(function() {
                var advertiser_array = [];

                // Build array for search
                jQuery('.update_advertiser').each(function(index) {
                    advertiser_array[index] = [];
                    advertiser_array[index]['id'] = jQuery(this).data('id');
                    advertiser_array[index]['user_code'] = jQuery(this).data('display_code');
                    advertiser_array[index]['display_string'] = jQuery(this).data('display_string');
                });

                // click handler for list of advertisers
                jQuery('.update_advertiser').click(function() {
                    jQuery('#show_advertiser').html(jQuery(this).data('display_string'));
                    jQuery('#show_code').html(jQuery(this).data('display_code'));
                    jQuery('#advertiser').val(jQuery(this).data('id'));
                });

                // input handler for when user types in code
                jQuery('#enter_advertiser_id').on('input', function(e) {
                    // This version searches by ID not code
                    // var the_input_id = jQuery('#enter_advertiser_id').val().match(/\d+/);
                    var the_input_id = jQuery('#enter_advertiser_id').val();

                    var the_result = advertiser_array.filter(function (advertiser) { return advertiser.user_code == the_input_id });
                    
                    if (the_result[0]) {
                        jQuery('#enter_advertiser_id_feedback').html(the_input_id + ': ' + the_result[0]['display_string']);
                        jQuery('#show_advertiser').html(the_result[0]['display_string']);
                        jQuery('#show_code').html(the_result[0]['user_code']);
                        jQuery('#advertiser').val(the_result[0]['id']);
                    } else {
                        jQuery('#enter_advertiser_id_feedback').html(the_input_id + ': Not Recognised');
                    }
                });

                // blur handler for code input box
                jQuery('#enter_advertiser_id').on('blur', function(e) {
                    jQuery('#enter_advertiser_id').val('');
                    jQuery('#enter_advertiser_id_feedback').html('');
                });
            }); 
        </script><?php
    }
}