<?php

/**
 * CJA Approve Profiles Content
 * Displays the content for the Approve Profiles screen in the admin
 */

function cja_approve_profiles_content() { ?>

    <h1>Approve Profiles</h1><?php 

    // Query profiles that are awaiting approval (description_approved = 'pending')
    $args = array(
        'meta_key' => 'description_approved',
        'meta_value' => 'pending'
    );
    $query = new WP_User_Query( $args );
    //print_r($query);

    $query_results = $query->get_results();
    //print_r($query_results);

    if (!empty($query_results)) { ?>
        <table>
            <thead>
                <td style="padding: 8px"><strong>Name</strong></td>
                <td style="padding: 8px"><strong>Description</strong></td>
                <td style="padding: 8px"><strong>Approve</strong></td>
            </thead>
            </tbody><?php
                foreach ($query_results as $result) {
                    $cja_user = new CJA_User($result->id); ?>
                    <tr>
                        <form action="<?php echo get_site_url(); ?>/wp-admin/admin-post.php?action=approve-profile" method="post">
                            <input type="hidden" name="approve_user_id" value="<?php echo $cja_user->id; ?>">
                            <td style="padding: 8px"><?php 
                                if ($cja_user->company_name) {
                                    echo $cja_user->company_name;
                                } else {
                                    echo $cja_user->full_name;
                                } ?>
                            </td>
                            <td style="padding: 8px; width: 80%">
                                <textarea name="user_description" style="width:100%" rows="5"><?php echo $cja_user->pending_description; ?></textarea>
                            </td>
                            <td style="padding: 8px">
                                <input type="submit" value="Approve">
                            </td>
                        </form>
                    </tr><?php
                } ?>
            </tbody>
        </table><?php
    } else { ?>
        <p>There are no profiles awaiting approval</p> <?php
    }
} 