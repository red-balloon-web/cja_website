<?php

// create search object
if ($search_type == 'job') {
    $cja_search = new CJA_Advert;
} else if ($search_type == 'course') {
    $cja_search = new CJA_Course_Advert;
} else if ($search_type == 'classified') {
    $cja_search = new CJA_Classified_Advert;
}

// If there is postdata then update object from POST (this can be the same for all search types)
if ($_POST['update_search']) {
    $cja_search->update_from_form();

// Otherwise populate from cookies
} else {
    // $cja_jobsearch->update_from_cookies(); // search criteria in $_POST are already stored as cookies on the init hook - this feature disabled by client which breaks the pagination but client also decided they didn't want the pagination
} ?>