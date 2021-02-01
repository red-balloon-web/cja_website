<?php
/**
 * CJA Approve Ads Content
 * Displays the content for the Approve Ads screen in the admin
 */

function cja_approve_ads_content() { ?>
    
    <h1>Approve Adverts</h1><?php 

    // Query adverts that are awaiting approval (status 'inactive')
    $args = array(
        'post_type' => array('job_ad', 'course_ad', 'classified_ad'),
        'meta_query' => array(
            array(
                'key' => 'cja_ad_status',
                'value' => 'inactive'
            )
        )
    );
    $query = new WP_Query( $args );

    // Loop through and display ads in form
    if ( $query->have_posts() ) { ?>
        <form action="<?php echo get_site_url(); ?>/wp-admin/admin-post.php?action=approve-advert" method="post">
            <table>
                <thead>
                    <td style="padding: 8px"><strong>Title</strong></td>
                    <td style="padding: 8px"><strong>Advertiser</strong></td>
                    <td style="padding: 8px"><strong>Type</strong></td>
                    <td style="padding: 8px"><strong>View</strong></td>
                    <td style="padding: 8px"><strong>Approve</strong></td>
                </thead><?php

                while ( $query->have_posts() ) : $query->the_post();
                    if (get_post_type() == 'job_ad') {
                        $current_ad = new CJA_Advert(get_the_ID());
                        $current_post_type = 'Job';
                    } else if (get_post_type() == 'course_ad') {
                        $current_ad = new CJA_Course_Advert(get_the_ID());
                        $current_post_type = 'Course';
                    } else if (get_post_type() == 'classified_ad') {
                        $current_ad = new CJA_Classified_Advert(get_the_ID());
                        $current_post_type = 'Classified';
                    } ?>    

                    <tr>
                        <td style="padding: 8px"><?php echo get_the_title(); ?></td>
                        <td style="padding: 8px"><?php echo $current_ad->author_human_name; ?></td>
                        <td style="padding: 8px"><?php echo $current_post_type ?></td>
                        <td style="padding: 8px"><a href="<?php echo get_the_permalink(); ?>" target="blank">VIEW</a></td>
                        <td style="padding: 8px"><input type="checkbox" name="cja_approve_ad[]" value="<?php echo get_the_ID(); ?>"></td>
                    </tr><?php
                endwhile; ?>
            </table>
            
            <br><br>
            <input type="submit" value="Approve Adverts">
        </form><?php 
    } else { ?>
        <p>There are no adverts awaiting approval</p><?php
    }     
}