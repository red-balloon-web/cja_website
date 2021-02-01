<?php

/**
 * CJA Approve Attachments Content
 * Displays the content for the Approve Attachments screen in the admin
 */

function cja_approve_attachments_content() { ?>

    <h1>Approve Attachments</h1><?php 

    // Query profiles that are awaiting approval (description_approved = 'pending')
    $args = array(
        'meta_key' => 'files_approved',
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
                <td style="padding: 8px"><strong>File</strong></td>
                <td style="padding: 8px"><strong>Replace</strong></td>
                <td style="padding: 8px"><strong>Approve</strong></td>
            </thead>
            </tbody><?php
                foreach ($query_results as $result) {
                    $cja_user = new CJA_User($result->id); 
                    foreach ($cja_user->pending_files_array as $pending_file) { ?>
                        <tr>
                            <form action="<?php echo get_site_url(); ?>/wp-admin/admin-post.php?action=approve-attachment" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="approve_user_id" value="<?php echo $cja_user->id; ?>">
                                <input type="hidden" name="approve_attachment_name" value="<?php echo $pending_file['name']; ?>">
                                <td style="padding: 8px"><?php 
                                    if ($cja_user->company_name) {
                                        echo $cja_user->company_name;
                                    } else {
                                        echo $cja_user->full_name;
                                    } ?>
                                </td>
                                <td style="padding: 8px;">
                                    <a href="<?php echo $pending_file['url']; ?>" target="_blank"><?php echo $pending_file['name']; ?></a>
                                </td>
                                <td style="padding: 8px">
                                <input type="file" name="cja_replace_file[]" id="cja_replace_file">
                                </td>
                                <td style="padding: 8px">
                                    <input type="submit" value="Approve">
                                </td>
                            </form>
                        </tr><?php
                    }
                } ?>
            </tbody>
        </table><?php
    } else { ?>
        <p>There are no attachments awaiting approval</p> <?php
    }
} 