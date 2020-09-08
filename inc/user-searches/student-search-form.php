<?php

if ($_GET['edit-search']) { 
    $cja_usersearch = new CJA_User;
    $cja_usersearch->update_from_cookies();

    $display_search = false;

    ?>

    <h1>Edit Student Search</h1>


    <form action="<?php echo get_the_permalink(); ?>" method="post" id="edit_cv_search_form">

        <?php if ($cja_user->postcode) { ?>
            <p class="label">Maximum Distance from my Postcode:</p>
            <select name="max_distance" form="edit_cv_search_form">
                <option value="">-- Any --</option>
                <option value="10" <?php if ($cja_usersearch->max_distance == '10') { echo 'selected'; } ?>>10 Miles</option>
                <option value="20" <?php if ($cja_usersearch->max_distance == '20') { echo 'selected'; } ?>>20 Miles</option>
                <option value="30" <?php if ($cja_usersearch->max_distance == '30') { echo 'selected'; } ?>>30 Miles</option>
                <option value="50" <?php if ($cja_usersearch->max_distance == '50') { echo 'selected'; } ?>>50 Miles</option>
                <option value="100" <?php if ($cja_usersearch->max_distance == '100') { echo 'selected'; } ?>>100 Miles</option>
            </select>
        <?php } ?>

        <p class="label">Age Category</p>
        <select name="age_category" form="edit_cv_search_form">
            <option value="">-- Any --</option>
            <option value="16-18" <?php if ($cja_usersearch->age_category == '16-18') { echo 'selected'; } ?>>16-18</option>
            <option value="19+" <?php if ($cja_usersearch->age_category == '19+') { echo 'selected'; } ?>>19+</option>
        </select>

        <p class="label">GCSE Maths Grade</p>
        <select name="gcse_maths" form="edit_cv_search_form">
            <option value="">-- Any --</option>
            <option value="a" <?php if ($cja_usersearch->gcse_maths == 'a') { echo 'selected'; } ?>>A</option>
            <option value="b" <?php if ($cja_usersearch->gcse_maths == 'b') { echo 'selected'; } ?>>B</option>
            <option value="c" <?php if ($cja_usersearch->gcse_maths == 'c') { echo 'selected'; } ?>>C</option>
            <option value="d" <?php if ($cja_usersearch->gcse_maths == 'd') { echo 'selected'; } ?>>D</option>
            <option value="e" <?php if ($cja_usersearch->gcse_maths == 'e') { echo 'selected'; } ?>>E</option>
            <option value="f" <?php if ($cja_usersearch->gcse_maths == 'f') { echo 'selected'; } ?>>F</option>
            <option value="n" <?php if ($cja_usersearch->gcse_maths == 'n') { echo 'selected'; } ?>>n/a</option>
        </select>

        <p class="label">Weekends Availability</p>
        <select name="weekends_availability" form="edit_cv_search_form">
            <option value="">-- Any --</option>
            <option value="none" <?php if ($cja_usersearch->weekends_availability == 'none') { echo 'selected'; } ?>>None</option>
            <option value="sat" <?php if ($cja_usersearch->weekends_availability == 'sat') { echo 'selected'; } ?>>Saturday Only</option>
            <option value="sun" <?php if ($cja_usersearch->weekends_availability == 'sun') { echo 'selected'; } ?>>Sunday Only</option>
            <option value="satsun" <?php if ($cja_usersearch->weekends_availability == 'satsun') { echo 'selected'; } ?>>Saturday and Sunday</option>
        </select>

        <!--
        <?php if ($cja_user->postcode) { ?>
            <p class="label">Order Results By</p>
            <select name="order_by" form="edit_cv_search_form">
                <option value="alphabet">Alphabetical</option>
                <option value="distance" <?php if ($cja_jobsearch->order_by == 'distance') { echo 'selected'; } ?>>Closest Users First</option>
            </select>
        <?php } else { ?>
            <input type="hidden" name="order_by" value="alphabet">
        <?php } ?>
        -->

        <input type="hidden" name="update_cv_search" value="true">
        <input type="hidden" name="cja_set_cv_cookies" value="true">

        <p>
            <input type="submit" class="cja_button cja_button--2" value="Search Students">
        </p>
    </form>
<?php }