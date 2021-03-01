<?php

if ($_GET['edit-search']) { 
    $cja_classifiedsearch = new CJA_Classified_Advert; // just for persistent search
    // $cja_classifiedsearch->update_from_cookies(); // disabled by client

    ?>



    <h1>Edit My Classifieds Search</h1>

    <!--<p style="text-align: center; font-style: italic; color: #666; margin-bottom: 40px;">Please remember to set any fields you no longer wish to search by back to "any".</p>-->


    <form action="<?php echo get_the_permalink(); ?>" method="post" id="edit_classified_search_form" class="smart_form">

        <p class="label">Search by ID</p>
        <input type="text" name="cja_id"><?php 
        
        if ($cja_current_user_obj->postcode) { ?>
            <h2 class="form_section_heading">Search</h2>
            <div class="form_flexbox_2">
                <div>
                    <p class="label">Maximum Distance from my Postcode:</p>
                    <select name="max_distance" form="edit_classified_search_form">
                        <option value="">-- Any --</option>
                        <option value="10" <?php if ($cja_classifiedsearch->max_distance == '10') { echo 'selected'; } ?>>10 Miles</option>
                        <option value="20" <?php if ($cja_classifiedsearch->max_distance == '20') { echo 'selected'; } ?>>20 Miles</option>
                        <option value="30" <?php if ($cja_classifiedsearch->max_distance == '30') { echo 'selected'; } ?>>30 Miles</option>
                        <option value="50" <?php if ($cja_classifiedsearch->max_distance == '50') { echo 'selected'; } ?>>50 Miles</option>
                        <option value="100" <?php if ($cja_classifiedsearch->max_distance == '100') { echo 'selected'; } ?>>100 Miles</option>
                    </select>
                </div>
                <div>
                    <p class="label">Order Results By</p>
                    <select name="order_by" form="edit_classified_search_form">
                        <option value="date">Newest Adverts First</option>
                        <option value="distance" <?php if ($cja_classifiedsearch->order_by == 'distance') { echo 'selected'; } ?>>Closest Adverts First</option>
                    </select>
                </div>
            </div><?php
        } else { ?>
            <input type="hidden" name="order_by" value="date"><?php 
        } ?>

        <h2 class="form_section_heading">Category</h2>

        <p class="label">Advert Category</p>
        <select name="category" form="edit_classified_search_form">
            <option value="">-- Any --</option>
            <option value="for_sale" <?php if ($cja_classifiedsearch->category == 'for_sale') { echo 'selected'; } ?>>For Sale</option>
            <option value="for_hire" <?php if ($cja_classifiedsearch->category == 'for_hire') { echo 'selected'; } ?>>For Hire</option>
            <option value="motors" <?php if ($cja_classifiedsearch->category == 'motors') { echo 'selected'; } ?>>Motors</option>
            <option value="pets" <?php if ($cja_classifiedsearch->category == 'pets') { echo 'selected'; } ?>>Pets</option>
            <option value="properties" <?php if ($cja_classifiedsearch->category == 'properties') { echo 'selected'; } ?>>Properties</option>
            <option value="services" <?php if ($cja_classifiedsearch->category == 'services') { echo 'selected'; } ?>>Services</option>
            <option value="exchange" <?php if ($cja_classifiedsearch->category == 'exchange') { echo 'selected'; } ?>>Exchange</option>
            <option value="freebies" <?php if ($cja_classifiedsearch->category == 'freebies') { echo 'selected'; } ?>>Freebies</option>
            <option value="lost_found" <?php if ($cja_classifiedsearch->category == 'lost_found') { echo 'selected'; } ?>>Lost and Found</option>
            <option value="make_offer" <?php if ($cja_classifiedsearch->category == 'make_offer') { echo 'selected'; } ?>>Make an Offer</option>
            <option value="notices" <?php if ($cja_classifiedsearch->category == 'notices') { echo 'selected'; } ?>>Notices</option>
            <option value="events" <?php if ($cja_classifiedsearch->category == 'events') { echo 'selected'; } ?>>Events</option>
            <option value="urgent_jobs" <?php if ($cja_classifiedsearch->category == 'urgent_jobs') { echo 'selected'; } ?>>Urgent Jobs</option>
        </select> 

        <h2 class="form_section_heading">Date Posted on Site</h2>

        <div class="form_flexbox_2">
            <div>
                <p class="label">Earliest Date Posted</p>
                <input type="date" name="earliest_creation_date">
            </div>
            <div>
                <p class="label">Latest Date Posted</p>
                <input type="date" name="latest_creation_date">
            </div>
        </div>
        
        <input type="hidden" name="update_search" value="true">
        <input type="hidden" name="cja_set_classified_cookies" value="true">

        <p>
            <input type="submit" class="cja_button cja_button--2" value="Search Classifieds">
        </p>
    </form><?php

    // Don't display the search results
    $display_search = false;
}

?>