<?php

if ($_GET['edit-search']) { 
    $cja_usersearch = new CJA_User;
    // $cja_usersearch->update_from_cv_cookies();

    $display_search = false;

    ?>

    <h1>Edit CV Search</h1>


    <form class="smart_form" action="<?php echo get_the_permalink(); ?>" method="post" id="edit_cv_search_form">

        <p class="label">Search by ID</p>
        <input type="text" name="cja_id">

        <h2 class="form_section_heading">Distance</h2>

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
        <!-- Opportunities Sought -->
        <h2 class="form_section_heading mb-0">Opportunities Sought</h2>
        <p class="muted">Will match any ticked, leave boxes unticked for any opportunities</p>
        <?php $cja_usersearch->display_form_field('opportunity_required', false); ?>

        <!-- Jobs PT / FT -->
        <!-- Cover Work -->
        <div class="form_flexbox_2">
            <div><?php $cja_usersearch->display_form_field('job_time',true,true); ?></div>
            <div><?php $cja_usersearch->display_form_field('cover_work',true,true); ?></div>
        </div>

        <!-- Weekends Availability -->
        <div class="form_flexbox_2">
            <div><?php $cja_usersearch->display_form_field('weekends_availability',true,true); ?></div>
        </div>

        <!-- Specialism Area(s) -->
        <h2 class="form_section_heading mb-0">Specialism Area(s)</h2>
        <p class="muted">Will match any ticked, leave all boxes unticked for any areas</p>
        <?php $cja_usersearch->display_form_field('specialism_area', false); ?>


        <h2 class="form_section_heading">Education</h2>
        <div class="form_flexbox_2">
            <!-- GCSE Maths -->
            <div>
                <p class="label">Minimum GCSE Maths grade</p>
                <?php $cja_usersearch->display_form_field('gcse_maths', false, true); ?>
            </div>
            <!-- GCSE English -->
            <div>
                <p class="label">Minimum GCSE English grade</p>
                <?php $cja_usersearch->display_form_field('gcse_english', false, true); ?>
            </div>
        </div>
        <div class="form_flexbox_2">
            <!-- Functional Maths -->
            <div>
                <p class="label">Minimum functional maths grade</p>
                <?php $cja_usersearch->display_form_field('functional_maths', false, true); ?>
            </div>
            <!-- Functional English -->
            <div>
                <p class="label">Minimum functional English grade</p>
                <?php $cja_usersearch->display_form_field('functional_english', false, true); ?>
            </div>
        </div>
        <!-- Highest Qualification -->
        <div class="form_flexbox_2">
            <div>
                <p class="label">Minimum current highest qualification</p>
                <?php $cja_usersearch->display_form_field('highest_qualification', false, true); ?>
            </div>
            <div>
                <p class="label">Upskilling and CPD Status</p>
                <?php $cja_usersearch->display_form_field('upskill_status', false, true); ?>
            </div>
        </div>
        <p class="label">Pre Trained</p>
        <?php $cja_usersearch->display_form_field('pre_trained', false, true); ?>


        <h2 class="form_section_heading">Other Details</h2>
        <div class="form_flexbox_2">
            <!-- Age Category -->
            <div>
                <?php $cja_usersearch->display_form_field('age_category', true, true); ?>
            </div>
            <!-- Current Status -->
            <div>
                <?php $cja_usersearch->display_form_field('current_status', true, true); ?>
            </div>
        </div>
        <div class="form_flexbox_2">
            <!-- Unemployed -->
            <div><?php $cja_usersearch->display_form_field('unemployed', true, true); ?></div>
            <!-- Benefits -->
            <div><?php $cja_usersearch->display_form_field('receiving_benefits', true, true); ?></div>
        </div>
        <div class="form_flexbox_2">

            <!-- DBS -->
            <div><?php $cja_usersearch->display_form_field('dbs', true, true); ?>
            </div>

            <!-- Current Availability -->
            <div><?php $cja_usersearch->display_form_field('current_availability', true, true); ?></div>
        </div>
        
        <!-- Prevent Safeguarding -->
        <?php $cja_usersearch->display_form_field('prevent_safeguarding', true, true); ?>

        <!-- Date Registered -->
        <h2 class="form_section_heading">Date Registered</h2>

        <div class="form_flexbox_2">
            <div>
                <p class="label">Earliest Date Registered</p>
                <input type="date" name="earliest_creation_date">
            </div>
            <div>
                <p class="label">Latest Date Registered</p>
                <input type="date" name="latest_creation_date">
            </div>
        </div>

        <input type="hidden" name="update_cv_search" value="true">
        <input type="hidden" name="cja_set_cv_cookies" value="true">

        <p>
            <input type="submit" class="cja_button cja_button--2" value="Search CVs">
        </p>
    </form>
<?php }