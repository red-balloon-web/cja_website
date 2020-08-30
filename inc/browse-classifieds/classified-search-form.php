<?php

if ($_GET['edit-search']) { 
    $cja_classifiedsearch = new CJA_Classified_Advert;
    $cja_classifiedsearch->update_from_cookies();

    ?>



    <h1>Edit My Classifieds Search</h1>


    <form action="<?php echo get_the_permalink(); ?>" method="post" id="edit_classified_search_form">

        <?php if ($cja_user->postcode) { ?>
            <p class="label">Maximum Distance from my Postcode:</p>
            <select name="max_distance" form="edit_classified_search_form">
                <option value="">-- Any --</option>
                <option value="10" <?php if ($cja_classifiedsearch->max_distance == '10') { echo 'selected'; } ?>>10 Miles</option>
                <option value="20" <?php if ($cja_classifiedsearch->max_distance == '20') { echo 'selected'; } ?>>20 Miles</option>
                <option value="30" <?php if ($cja_classifiedsearch->max_distance == '30') { echo 'selected'; } ?>>30 Miles</option>
                <option value="50" <?php if ($cja_classifiedsearch->max_distance == '50') { echo 'selected'; } ?>>50 Miles</option>
                <option value="100" <?php if ($cja_classifiedsearch->max_distance == '100') { echo 'selected'; } ?>>100 Miles</option>
            </select>
        <?php } ?>

        <p class="label">Advert Category</p>
        <select name="category" form="edit_classified_search_form">
            <option value="">-- Any --</option>
            <option value="for_sale" <?php if ($cja_classifiedsearch->category == 'for_sale') { echo 'selected'; } ?>>For Sale</option>
            <option value="for_hire" <?php if ($cja_classifiedsearch->category == 'for_hire') { echo 'selected'; } ?>>For Hire</option>
            <option value="lost_found" <?php if ($cja_classifiedsearch->category == 'lost_found') { echo 'selected'; } ?>>Lost and Found</option>
            <option value="freebies" <?php if ($cja_classifiedsearch->category == 'freebies') { echo 'selected'; } ?>>Freebies</option>
        </select>

        <p class="label">Advert Subcategory</p>
        <select name="subcategory" form="edit_classified_search_form">
            <option value="">-- Any --</option>
            <option value="motors" <?php if ($cja_classifiedsearch->subcategory == 'motors') { echo 'selected'; } ?>>Motors</option>
            <option value="properties" <?php if ($cja_classifiedsearch->subcategory == 'properties') { echo 'selected'; } ?>>Properties</option>
            <option value="restaurants" <?php if ($cja_classifiedsearch->subcategory == 'restaurants') { echo 'selected'; } ?>>Restaurants</option>
            <option value="pets" <?php if ($cja_classifiedsearch->subcategory == 'pets') { echo 'selected'; } ?>>Pets</option>
            <option value="plumbers" <?php if ($cja_classifiedsearch->subcategory == 'plumbers') { echo 'selected'; } ?>>Plumbers</option>
            <option value="news_events" <?php if ($cja_classifiedsearch->subcategory == 'news_events') { echo 'selected'; } ?>>News and Events</option>
        </select>

        <?php if ($cja_user->postcode) { ?>
            <p class="label">Order Results By</p>
            <select name="order_by" form="edit_classified_search_form">
                <option value="date">Newest Adverts First</option>
                <option value="distance" <?php if ($cja_classifiedsearch->order_by == 'distance') { echo 'selected'; } ?>>Closest Adverts First</option>
            </select>
        <?php } else { ?>
            <input type="hidden" name="order_by" value="date">
        <?php } ?>

        <input type="hidden" name="update_classified_search" value="true">
        <input type="hidden" name="cja_set_classified_cookies" value="true">

        <p>
            <input type="submit" class="cja_button cja_button--2" value="Search Classifieds">
        </p>
    </form>

    <?php
    $display_search = false;
}

?>