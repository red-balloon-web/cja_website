<?php

/**
 * CJA User Credits Page Contents
 * Displays content for 'Manage User Credits' page in admin
 */
function cja_user_credits_page_contents() {

    // Update if we have returned to page on submitting form (this should be in process and redirect) and display message
    if ($_POST['new_credits']) {
        update_user_meta($_POST['search_user_id'], 'cja_credits', $_POST['new_credits']);
        update_user_meta($_POST['search_user_id'], 'cja_classified_credits', $_POST['new_classified_credits']);?>
        <h2>User ID <?php echo $_POST['search_user_id']; ?> successfully updated!</h2><?php
    }

    // Page proper ?>
    <h1>Manage User Credits</h1><?php

    // Find user by ID ?>
    <h2>Look Up User</h2>
    <form action="<?php echo admin_url('admin.php?page=cja_user_credits'); ?>" method="post">
        <p class="label">Enter User ID</p>
        <input type="text" name="search_user_id">
        <input type="submit" value="Find User">
    </form><?php

    // Set new credit amounts if the user has been looked up ?>
    <h2>Manage User Credits</h2><?php
    if ($_POST['search_user_id']) {
        $the_user = new CJA_User($_POST['search_user_id']);
        if (!$the_user->login_name) {
            echo "There is no user with ID: " . $_POST['search_user_id'];
        } else { ?>
            <p>User ID: <?php echo $_POST['search_user_id']; ?></p>
            <p>Name: <?php echo $the_user->display_name(); ?></p>
            <form action="<?php echo admin_url('admin.php?page=cja_user_credits'); ?>" method="post">
            <p>Job / Course Credits: <input type="text" name="new_credits" value="<?php echo $the_user->credits; ?>"></p>
            <p>Classified Credits: <input type="text" value="<?php echo $the_user->classified_credits; ?>" name="new_classified_credits"></p>
            <p><input type="submit" value="Update Credits"></p>
            <input type="hidden" name="search_user_id" value="<?php echo $_POST['search_user_id']; ?>">
            </form><?php 
        }
    }
}