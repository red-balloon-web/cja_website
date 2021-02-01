<?php
/**
 * SAVE SEARCH COOKIES
 * Saves search for individual user as cookies so their search options persist when coming back to the search
 * (Client disabled this feature)
 */

add_action('init', 'cja_save_cookies');
function cja_save_cookies() {
    if ($_POST['cja_set_cookies'] && $_POST['update_job_search']) {
        if (array_key_exists('salary_numeric',$_POST)) {
            $sal_num = (float) filter_var( $_POST['salary_numeric'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
            setcookie( get_current_user_id() . '_salary_numeric', $sal_num);
        } else {
            setcookie( get_current_user_id() . '_salary_numeric', $_POST['salary_numeric']);
        }
        setcookie( get_current_user_id() . '_salary_per', $_POST['salary_per']);
        setcookie( get_current_user_id() . '_max_distance', $_POST['max_distance']);
        setcookie( get_current_user_id() . '_job_type', $_POST['job_type']);
        setcookie( get_current_user_id() . '_sector', $_POST['sector']);
        setcookie( get_current_user_id() . '_career_level', $_POST['career_level']);
        setcookie( get_current_user_id() . '_experience_required', $_POST['experience_required']);
        setcookie( get_current_user_id() . '_employer_type', $_POST['employer_type']);
        setcookie( get_current_user_id() . '_minimum_qualification', $_POST['minimum_qualification']);
        setcookie( get_current_user_id() . '_dbs_required', $_POST['dbs_required']);
        setcookie( get_current_user_id() . '_payment_frequency', $_POST['payment_frequency']);
        setcookie( get_current_user_id() . '_shift_work', $_POST['shift_work']);
        setcookie( get_current_user_id() . '_location_options', $_POST['location_options']);
        setcookie( get_current_user_id() . '_order_by', $_POST['order_by']);
        setcookie( get_current_user_id() . '_show_applied', $_POST['show_applied']);
    }

    if ($_POST['cja_set_course_cookies'] && $_POST['update_course_search']) {
        setcookie( get_current_user_id() . '_course_max_distance', $_POST['max_distance']);
        setcookie( get_current_user_id() . '_course_order_by', $_POST['order_by']);
        setcookie( get_current_user_id() . '_course_offer_type', $_POST['offer_type']);
        setcookie( get_current_user_id() . '_course_category', $_POST['category']);
        setcookie( get_current_user_id() . '_course_sector', $_POST['sector']);
        setcookie( get_current_user_id() . '_course_deposit_required', $_POST['deposit_required']);
        setcookie( get_current_user_id() . '_course_career_level', $_POST['career_level']);
        setcookie( get_current_user_id() . '_course_experience_required', $_POST['experience_required']);
        setcookie( get_current_user_id() . '_course_provider_type', $_POST['provider_type']);
        setcookie( get_current_user_id() . '_course_previous_qualification', $_POST['previous_qualification']);
        setcookie( get_current_user_id() . '_course_course_pathway', $_POST['course_pathway']);
        setcookie( get_current_user_id() . '_course_payment_plan', $_POST['payment_plan']);
        setcookie( get_current_user_id() . '_course_qualification_level', $_POST['qualification_level']);
        setcookie( get_current_user_id() . '_course_qualification_type', $_POST['qualification_type']);
        setcookie( get_current_user_id() . '_course_total_units', $_POST['total_units']);
        setcookie( get_current_user_id() . '_course_dbs_required', $_POST['dbs_required']);
        setcookie( get_current_user_id() . '_course_availability_period', $_POST['availability_period']);
        setcookie( get_current_user_id() . '_course_allowance_available', $_POST['allowance_available']);
        setcookie( get_current_user_id() . '_course_awarding_body', $_POST['awarding_body']);
        setcookie( get_current_user_id() . '_course_duration', $_POST['duration']);
        setcookie( get_current_user_id() . '_course_suitable_benefits', $_POST['suitable_benefits']);
        setcookie( get_current_user_id() . '_course_social_services', $_POST['social_services']);
        setcookie( get_current_user_id() . '_course_delivery_route', $_POST['delivery_route']);
        setcookie( get_current_user_id() . '_course_available_start', $_POST['available_start']);
        setcookie( get_current_user_id() . '_course_show_applied', $_POST['show_applied']);
    }

    if ($_POST['cja_set_classified_cookies'] && $_POST['update_classified_search']) {
        setcookie( get_current_user_id() . '_classified_max_distance', $_POST['max_distance']);
        setcookie( get_current_user_id() . '_classified_category', $_POST['category']);
        setcookie( get_current_user_id() . '_classified_subcategory', $_POST['subcategory']);
        setcookie( get_current_user_id() . '_classified_order_by', $_POST['order_by']);
    }

    if ($_POST['cja_set_cv_cookies'] && $_POST['update_cv_search']) {
        setcookie( get_current_user_id() . '_cv_max_distance', $_POST['max_distance']);
        setcookie( get_current_user_id() . '_cv_order_by', $_POST['order_by']);

        setcookie( get_current_user_id() . '_cv_opportunity_required', base64_encode(serialize($_POST['opportunity_required'])));
        setcookie( get_current_user_id() . '_cv_course_time', $_POST['course_time']);
        setcookie( get_current_user_id() . '_cv_job_time', $_POST['job_time']);
        setcookie( get_current_user_id() . '_cv_weekends_availability', $_POST['weekends_availability']);
        setcookie( get_current_user_id() . '_cv_cover_work', $_POST['cover_work']);

        setcookie( get_current_user_id() . '_cv_specialism_area', base64_encode(serialize($_POST['specialism_area'])));

        setcookie( get_current_user_id() . '_cv_gcse_maths', $_POST['gcse_maths']);
        setcookie( get_current_user_id() . '_cv_gcse_english', $_POST['gcse_english']);
        setcookie( get_current_user_id() . '_cv_functional_maths', $_POST['functional_maths']);
        setcookie( get_current_user_id() . '_cv_functional_english', $_POST['functional_english']);
        setcookie( get_current_user_id() . '_cv_highest_qualification', $_POST['highest_qualification']);

        setcookie( get_current_user_id() . '_cv_age_category', $_POST['age_category']);
        setcookie( get_current_user_id() . '_cv_current_status', $_POST['current_status']);
        setcookie( get_current_user_id() . '_cv_unemployed', $_POST['unemployed']);
        setcookie( get_current_user_id() . '_cv_receiving_benefits', $_POST['receiving_benefits']);
    }

    if ($_POST['cja_set_student_cookies'] && $_POST['update_student_search']) {
        setcookie( get_current_user_id() . '_student_max_distance', $_POST['max_distance']);
        setcookie( get_current_user_id() . '_student_order_by', $_POST['order_by']);

        setcookie( get_current_user_id() . '_student_opportunity_required', base64_encode(serialize($_POST['opportunity_required'])));
        setcookie( get_current_user_id() . '_student_course_time', $_POST['course_time']);
        setcookie( get_current_user_id() . '_student_job_time', $_POST['job_time']);
        setcookie( get_current_user_id() . '_student_weekends_availability', $_POST['weekends_availability']);
        setcookie( get_current_user_id() . '_student_cover_work', $_POST['cover_work']);

        setcookie( get_current_user_id() . '_student_specialism_area', base64_encode(serialize($_POST['specialism_area'])));

        setcookie( get_current_user_id() . '_student_gcse_maths', $_POST['gcse_maths']);
        setcookie( get_current_user_id() . '_student_gcse_english', $_POST['gcse_english']);
        setcookie( get_current_user_id() . '_student_functional_maths', $_POST['functional_maths']);
        setcookie( get_current_user_id() . '_student_functional_english', $_POST['functional_english']);
        setcookie( get_current_user_id() . '_student_highest_qualification', $_POST['highest_qualification']);

        setcookie( get_current_user_id() . '_student_age_category', $_POST['age_category']);
        setcookie( get_current_user_id() . '_student_current_status', $_POST['current_status']);
        setcookie( get_current_user_id() . '_student_unemployed', $_POST['unemployed']);
        setcookie( get_current_user_id() . '_student_receiving_benefits', $_POST['receiving_benefits']);
    }
}