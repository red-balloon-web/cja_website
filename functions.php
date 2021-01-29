<?php

/**
 * INCLUDE CONFIG AND OBJECTS
 */

include('config.php');
include('inc/class-cja-advert.php');
include('inc/class-cja-course-advert.php');
include('inc/class-cja-classified-advert.php');
include('inc/class-cja-user.php');
include('inc/class-cja-application.php');
include('inc/class-cja-course-application.php');

/**
 * REMOVE SIDEBAR
 */

function dano_remove_sidebar() {
    return false;
}
add_filter( 'is_active_sidebar', 'dano_remove_sidebar', 10, 2 );

/**
 * REGISTER CUSTOM POST TYPES
 */
add_action( 'init', 'register_custom_post_types' );
function register_custom_post_types() {

    // Job Advert
    register_post_type( 'job_ad',
        array(
        'labels' => array(
            'name' => __( 'Job Adverts' ),
            'singular_name' => __( 'Job Advert' ),
            'edit_item' => 'Edit Job',
            'add_new_item' => 'Add New Job',
            'item_updated' => 'Job Updated'
        ),
        'supports' => array (
            'title',
            'author'
        ),
        'public' => true,
        'has_archive' => false,
        'rewrite' => array('slug' => 'jobs'),
        )
    );

    // Course Advert
    register_post_type( 'course_ad',
    array(
      'labels' => array(
       'name' => __( 'Course Adverts' ),
       'singular_name' => __( 'Course Advert' ),
       'edit_item' => 'Edit Course',
       'add_new_item' => 'Add New Course'
      ),
      'supports' => array (
          'title'
      ),
      'public' => true,
      'has_archive' => false,
      'rewrite' => array('slug' => 'courses'),
     )
    );

    // Classified Advert
    register_post_type( 'classified_ad',
        array(
            'labels' => array(
                'name' => 'Classified Adverts',
                'singular_name' => 'Classified Advert',
                'edit_item' => 'Edit Classified Advert',
                'add_new_item' => 'Add New Classified Advert'
            ),
            'supports' => array(
                'title'
            ),
            'public' => true,
            'has_archive' => false,
            'rewrite' => array('slug' => 'classifieds')
        )
    );

    // Job Application
    register_post_type( 'application',
        array(
            'labels' => array(
                'name' => 'Job Applications',
                'singular_name' => 'Job Application'
            ),
            'supports' => array (
                'title',
                'custom-fields'
            ),
            'public' => true,
            'has_archive' => false,
            'rewrite' => array('slug' => 'applications')
        )
    );

    // Course Application
    register_post_type( 'course_application',
        array(
            'labels' => array(
                'name' => 'Course Applications',
                'singular_name' => 'Course Application'
            ),
            'supports' => array (
                'title',
                'custom-fields'
            ),
            'public' => true,
            'has_archive' => false,
            'rewrite' => array('slug' => 'course-applications')
        )
    );
}

/**
 * USER ROLES
 */
add_action( 'init', 'add_custom_user_roles' );
function add_custom_user_roles() {

    add_role(
        'advertiser',
        'Advertiser',
        array(
            'read' => true,
        )
    );

    add_role(
        'jobseeker',
        'Job Seeker',
        array(
            'read' => true,
        )
    );

}

/**
 * NAV MENUS
 */

 // Register custom menus
function cja_custom_menus($menus) {
    $menus['loggedout-primary'] = 'Main Menu Logged Out';
    $menus['jobseeker-primary'] = 'Main Menu Applicant';
    $menus['advertiser-primary'] = 'Main Menu Advertiser';
    $menus['admin-primary'] = 'Main Menu Admin';
    return $menus;
}
add_filter( 'storefront_register_nav_menus', 'cja_custom_menus');

// Display correct nav menu
function cja_primary_navigation() { ?>

    <!-- CJA PRIMARY NAVIGATION STARTS HERE -->
    <nav id="site-navigation" class="main-navigation cja_desktop-navigation" role="navigation" aria-label="<?php esc_html_e( 'Primary Navigation', 'storefront' ); ?>">
    <!--<button class="menu-toggle" aria-controls="site-navigation" aria-expanded="false"><span><?php echo esc_attr( apply_filters( 'storefront_menu_toggle_text', __( 'Menu', 'storefront' ) ) ); ?></span></button>-->
    <button class="menu-toggle" aria-controls="site-navigation" aria-expanded="false"><i class="fas fa-bars"></i></button>
        <?php

        $cja_current_user_obj = new CJA_User;

        if (!$cja_current_user_obj->is_logged_in) {
            wp_nav_menu(
                array(
                    'theme_location' => 'loggedout-primary',
                    'container_class' => 'primary-navigation',
                )
            );
            wp_nav_menu(
                array(
                    'theme_location' => 'loggedout-primary',
                    'container_class' => 'handheld-navigation',
                )
            );
        } else if ($cja_current_user_obj->role == 'administrator') {
            wp_nav_menu(
                array(
                    'theme_location' => 'admin-primary',
                    'container_class' => 'primary-navigation'
                )
            );
            wp_nav_menu(
                array(
                    'theme_location' => 'admin-primary',
                    'container_class' => 'handheld-navigation'
                )
            );
        } else if ($cja_current_user_obj->role == 'advertiser') {
            wp_nav_menu(
                array(
                    'theme_location' => 'advertiser-primary',
                    'container_class' => 'primary-navigation',
                )
            );
            wp_nav_menu(
                array(
                    'theme_location' => 'advertiser-primary',
                    'container_class' => 'handheld-navigation',
                )
            );
        } else if ($cja_current_user_obj->role == 'jobseeker') {
            wp_nav_menu(
                array(
                    'theme_location' => 'jobseeker-primary',
                    'container_class' => 'primary-navigation',
                )
            );
            wp_nav_menu(
                array(
                    'theme_location' => 'jobseeker-primary',
                    'container_class' => 'handheld-navigation',
                )
            );
        } ?>
    </nav><!-- #site-navigation --> <?php
}

/**
 * Include Form Processing Functions
 */
include('inc/functions/form-processing/admin_post_functions.php');

/**
 * WOOCOMMERCE MY ACCOUNT
 */

//Remove required field requirement for first/last name in My Account Edit form as these fields have been moved to another page
add_filter('woocommerce_save_account_details_required_fields', 'remove_required_fields');

function remove_required_fields( $required_fields ) {
    unset($required_fields['account_first_name']);
    unset($required_fields['account_last_name']);
    unset($required_fields['account_display_name']);

    return $required_fields;
}

/**
 * @snippet       WooCommerce Add New Tab @ My Account
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 3.5.7
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
  
// ------------------
// 1. Register new endpoint to use for My Account page
// Note: Resave Permalinks or it will give 404 error

add_action( 'init', 'cja_add_my_details_endpoint' );
function cja_add_my_details_endpoint() {
    add_rewrite_endpoint( 'my-details', EP_ROOT | EP_PAGES );
    add_rewrite_endpoint( 'purchase-credits', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint( 'purchase-subscriptions', EP_ROOT | EP_PAGES);
}
  
  
// 2. Add new query var
add_filter( 'query_vars', 'cja_my_details_query_vars', 0 );
function cja_my_details_query_vars( $vars ) {
    $vars[] = 'my-details';
    $vars[] = 'purchase-credits';
    $vars[] = 'purchase-subscriptions';
    return $vars;
}
  
  
// 3. Insert the new endpoint into the My Account menu
function cja_order_woocommerce_account_menu( $items ) {
    unset ($items['orders']);
    unset ($items['subscriptions']);
    unset ($items['edit-address']);
    unset ($items['edit-account']);
    unset ($items['customer-logout']);


    // $items['purchase-credits'] = 'Purchase Credits'; // temporarily disabled by client
    $items['my-details'] = 'Your Profile';
    $items['edit-account'] = 'Email / Password';
    // $items['orders'] = 'My Purchases'; // temporarily disabled by client
    
    // only display subscriptions tab to advertisers
    $the_current_user = new CJA_User;
    if ($the_current_user->role == 'advertiser' || $the_current_user->role == 'administrator') {
        // $items['purchase-subscriptions'] = 'Purchase Subscriptions'; // temporarily disabled by client
        // $items['subscriptions'] = 'My Subscriptions'; // temporarily disabled by client
    }

    $items['customer-logout'] = 'Log Out';
    return $items;
}
add_filter( 'woocommerce_account_menu_items', 'cja_order_woocommerce_account_menu' );
  
// 4. Add content to the new endpoint
add_action( 'woocommerce_account_my-details_endpoint', 'cja_my_details_content' );
function cja_my_details_content() { 
    include('inc/my-account/my-details-endpoint.php');
}

add_action( 'woocommerce_account_purchase-credits_endpoint', 'cja_purchase_credits_content' );
function cja_purchase_credits_content() {
    include('inc/my-account/purchase-credits.php');
}

add_action( 'woocommerce_account_purchase-subscriptions_endpoint', 'cja_purchase_subscriptions_content' );
function cja_purchase_subscriptions_content() {
    include('inc/my-account/purchase-subscriptions.php');
}
// Note: add_action must follow 'woocommerce_account_{your-endpoint-slug}_endpoint' format


/**
 * WOOCOMMERCE CHECKOUT
 */

 // Removes Order Notes Title - Additional Information & Notes Field
add_filter( 'woocommerce_enable_order_notes_field', '__return_false', 9999 );

// Remove Order Notes Field
add_filter( 'woocommerce_checkout_fields' , 'remove_order_notes' );

function remove_order_notes( $fields ) {
     unset($fields['order']['order_comments']);
     return $fields;
}

/**
 * LOG OUT USER
 */

function logoutUser(){
    if ( $_GET["cja-logout"] == 'true' ){ 
        wp_logout();
    }
}
add_action('init', 'logoutUser');

/**
 * ADD PURCHASED CREDITS
 * Adds purchased credits to user meta on checkout completion
 */

add_action( 'woocommerce_before_thankyou', 'add_purchased_credits' );
function add_purchased_credits( $order_id ){

    // Get order
    $cja_order = new WC_Order( $order_id );
    include('config.php');

    if ( $cja_order->has_status( 'failed' ) ) {
        exit;
    }
    
    // Does order already have credits added (prevent page refresh errors)
    if( ! get_post_meta( $order_id, 'cja_credits_added', true ) ) { 
        
        // get right number of credits
        $order = wc_get_order( $order_id );
        $new_credits = 0;
        $new_classified_credits = 0;
        foreach ( $order->get_items() as $item_id => $item ) {
            
            $product_id = $item->get_product_id();
            $quantity = $item->get_quantity();
            
            // 10 credit product
            if ($product_id == 7) {
                $new_credits += $quantity * 10;
            }
            
            // 1 credit product
            if ($product_id == 8) {
                $new_credits += $quantity;
            }

            // 1 classified ad product
            if ($product_id == 297) {
                $new_classified_credits += $quantity;
            }
        }

        // Update user credits and display correct message
        $user_id = get_current_user_id();        
        if ($new_credits) { // job / course credits
            $current_credits = get_user_meta( $user_id, "cja_credits", true );
            $new_total_credits = $new_credits + $current_credits;
            update_user_meta( $user_id, "cja_credits", $new_total_credits );

            if ($new_credits == 1) {
                $first_text = ' credit was ';
            } else {
                $first_text = ' credits were ';
            }

            if ($new_total_credits == 1) {
                $second_text = ' credit.';
            } else {
                $second_text = ' credits.';
            }
        
            ?><p class="cja_alert cja_alert--success"><?php echo ($new_credits . $first_text . "added to your account. You now have " . $new_total_credits . $second_text); ?></p>
            <p><a href="<?php echo get_site_url() . '/' . $cja_config['my-job-ads-slug']; ?>" class="cja_button cja_button--2">My Job Adverts</a></p>
            <?php
        }

        if ($new_classified_credits) { // classified credits
            $current_classified_credits = get_user_meta ($user_id, "cja_classified_credits", true );
            $new_total_classified_credits = $new_classified_credits + $current_classified_credits;
            update_user_meta( $user_id, "cja_classified_credits", $new_total_classified_credits );

            if ($new_classified_credits == 1) {
                $first_text = ' classified ad credit was ';
            } else {
                $first_text = ' classified ad credits were ';
            }

            if ($new_total_classified_credits == 1) {
                $second_text = ' classified ad credit.';
            } else {
                $second_text = ' classified ad credits.';
            }

            ?>
            <p class="cja_alert cja_alert--success"><?php echo ($new_classified_credits . $first_text . "added to your account. You now have " . $new_total_classified_credits . $second_text); ?></p>
            <p><a href="<?php echo get_site_url() . '/' . $cja_config['my-classified-ads-slug']; ?>" class="cja_button cja_button--2">My Classified Adverts</a></p>
            <?php
        }

        update_post_meta( $order_id, 'cja_credits_added', true );    
    }
}

/**
 * Remove thank you text from order received page
 */
add_filter( 'woocommerce_thankyou_order_received_text', 'remove_thankyou' );
function remove_thankyou() {
    return '';
}

/**
 * SPEND CREDITS
 */

// Jobs and courses
function spend_credits( $spend = 1 ) {
    $credits = get_user_meta( get_current_user_id(), "cja_credits", true);
	$credits = $credits - $spend;
	update_user_meta( get_current_user_id(), "cja_credits", $credits);
}

// Classified
function spend_classified_credits( $spend = 1 ) {
    $credits = get_user_meta( get_current_user_id(), "cja_classified_credits", true);
	$credits = $credits - $spend;
	update_user_meta( get_current_user_id(), "cja_classified_credits", $credits);
}

/**
 * REDIRECT ON LOGIN
 * Redirect user to my account page after login
 */

function my_login_redirect( $redirect_to, $request, $user ) {
            return get_site_url() . '/my-account';
}
 
add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );

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

/**
 * PAGINATION
 */

add_filter( 'paginate_links', function( $link ) {

        if (filter_input( INPUT_GET, 'extend-ad') ) {
            $link = remove_query_arg( 'extend-ad', $link );
        }
        if (filter_input( INPUT_GET, 'delete-ad') ) {
            $link = remove_query_arg('delete-ad', $link);
        }
        return $link;
    }
);

/**
 * PREVENT WP LOGIN ERRORS
 */

 /**
 * Function Name: front_end_login_fail.
 * Description: This redirects the failed login to the custom login page instead of default login page with a modified url
**/
add_action( 'wp_login_failed', 'front_end_login_fail' );
function front_end_login_fail( $username ) {

    // Getting URL of the login page
    $referrer = $_SERVER['HTTP_REFERER'];    

    // if there's a valid referrer, and it's not the default log-in screen
    if( !empty( $referrer ) && !strstr( $referrer,'wp-login' ) && !strstr( $referrer,'wp-admin' ) ) {
        wp_redirect( get_site_url() . "/my-account?login=failed" ); 
        exit;
    }

}

/**
 * Function Name: check_username_password.
 * Description: This redirects to the custom login page if user name or password is empty with a modified url
**/
add_action( 'authenticate', 'check_username_password', 1, 3);
function check_username_password( $login, $username, $password ) {

    // Getting URL of the login page
    $referrer = $_SERVER['HTTP_REFERER'];

    // if there's a valid referrer, and it's not the default log-in screen
    if( !empty( $referrer ) && !strstr( $referrer,'wp-login' ) && !strstr( $referrer,'wp-admin' ) ) { 
        if( $username == "" || $password == "" ){
            wp_redirect( get_site_url() . "/my-account?login=empty" );
            exit;
        }
    }

}

/**
 * Update Expired Ads
 * Filter ads and update ads which have expired to 'expired' if it hasn't been done already today.
 */

 add_action('init', 'update_expired_ads');
 function update_expired_ads() {

    // Do this if it hasn't been done already today
     if (get_option('cja_expired_check') != strtotime(date('j F Y'))) {

        // Query job ads
        $args = array(
            'post_type' => 'job_ad',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => 'cja_ad_status',
                    'value' => 'active'
                )
            )
        );
        $cja_update_expired = new WP_Query($args);

        // Loop through and mark as expired
        if ($cja_update_expired->have_posts()) {
            while ( $cja_update_expired->have_posts() ) {
                $cja_update_expired->the_post();
                if (get_post_meta(get_the_ID(), 'cja_ad_expiry_date', true) <= strtotime(date('j F Y'))) {
                    update_post_meta(get_the_ID(), 'cja_ad_status', 'expired');
                }
            }
        }
        wp_reset_postdata();

        // Query course ads
        $args = array(
            'post_type' => 'course_ad',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => 'cja_ad_status',
                    'value' => 'active'
                )
            )
        );

        // Loop through and mark as expired
        $cja_update_expired = new WP_Query($args);
        if ($cja_update_expired->have_posts()) {
            while ( $cja_update_expired->have_posts() ) {
                $cja_update_expired->the_post();
                if (get_post_meta(get_the_ID(), 'cja_ad_expiry_date', true) <= strtotime(date('j F Y'))) {
                    update_post_meta(get_the_ID(), 'cja_ad_status', 'expired');
                }
            }
        }
        wp_reset_postdata();

        // Query classified ads
        $args = array(
            'post_type' => 'classified_ad',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => 'cja_ad_status',
                    'value' => 'active'
                )
            )
        );
        $cja_update_expired = new WP_Query($args);

        // Loop through and mark as expired
        if ($cja_update_expired->have_posts()) {
            while ( $cja_update_expired->have_posts() ) {
                $cja_update_expired->the_post();
                if (get_post_meta(get_the_ID(), 'cja_ad_expiry_date', true) <= strtotime(date('j F Y'))) {
                    update_post_meta(get_the_ID(), 'cja_ad_status', 'expired');
                }
            }
        }
        wp_reset_postdata();

        // Update option to mark that this has been done today
        update_option('cja_expired_check', strtotime(date('j F Y')));
     }
 }

 // Send email if there is a new advert waiting for admin approval
function new_ad_email($title) {
    $to = get_option('admin_email');
    $subject = 'New advert for approval';
    $message = 'There is a new advert, ' . $title . ', awaiting approval at Courses and Jobs Advertiser';
    wp_mail($to, $subject, $message);
}

/**
 * Function name: Process and Redirect
 * Description: processes forms on init hook and redirects without form data if required. 
 * Prevents users duplicating an action by using the refresh button and allows database to be updated before page load.
 */

add_action('init', 'process_and_redirect');
function process_and_redirect() {

    // Create new job ad
    if ($_POST['process-create-ad']) {
        $cja_new_ad = new CJA_Advert;
        $cja_new_ad->create(); // create a new post in the database
        $cja_new_ad->update_from_form();
        // $cja_new_ad->activate(); // ads are now activated when approved by admin
        $cja_new_ad->save();
        new_ad_email($cja_new_ad->title);
        if (get_option('cja_charge_users')) { spend_credits(); }
        header('Location: ' . get_site_url() . '/my-job-ads?create-ad-success=' . $cja_new_ad->id . '&edit-ad=' . $cja_new_ad->id);
        exit;
    }

    // Create new course ad
    if ($_POST['process-create-course-ad']) {
        $cja_new_ad = new CJA_Course_Advert;
        $cja_new_ad->create(); // create a new post in the database
        $cja_new_ad->update_from_form();
        // $cja_new_ad->activate(); // ads are now activated when approved by admin
        $cja_new_ad->save();
        new_ad_email($cja_new_ad->title);
        if (get_option('cja_charge_users')) { spend_credits(); }
        header('Location: ' . get_site_url() . '/my-course-ads?create-ad-success=' . $cja_new_ad->id . '&edit-ad=' . $cja_new_ad->id);
        exit;
    }

    // Create new classified ad
    if ($_POST['process-create-classified-ad']) {
        $cja_new_ad = new CJA_Classified_Advert;
        $cja_new_ad->create(); // create a new post in the database
        $cja_new_ad->update_from_form();
        // $cja_new_ad->activate(); // ads are now activated when approved by admin
        $cja_new_ad->save();
        new_ad_email($cja_new_ad->title);
        if (get_option('cja_charge_users')) { spend_classified_credits(); }
        header('Location: ' . get_site_url() . '/my-classified-ads?create-ad-success=' . $cja_new_ad->id . '&edit-ad=' . $cja_new_ad->id);
        exit;
    }

    // User updates their details
    if ($_POST['user-details-update']) {
        $cja_current_user_obj = new CJA_User;
        $cja_current_user_obj->updateFromForm();
        $cja_current_user_obj->save();
        header('Location: ' . get_site_url() . '/my-account/my-details?update-user-details=true');
        exit;
    }
    
    // Extend job ad
    if ($_GET['extend-ad']) {
        $cja_extend_ad = new CJA_Advert($_GET['extend-ad']);
        $cja_extend_ad->extend();
        $cja_extend_ad->save();
        if (get_option('cja_charge_users')) { spend_credits(); }
        header('Location: ' . get_site_url() . '/my-job-ads?extend-ad-success=' . $cja_extend_ad->id);
        exit;
    }

    // Extend course ad
    if ($_GET['extend-course-ad']) {
        $cja_extend_ad = new CJA_Course_Advert($_GET['extend-course-ad']);
        $cja_extend_ad->extend();
        $cja_extend_ad->save();
        if (get_option('cja_charge_users')) { spend_credits(); }
        header('Location: ' . get_site_url() . '/my-course-ads?extend-ad-success=' . $cja_extend_ad->id);
        exit;
    }

    // Extend classified ad
    if ($_GET['extend-classified-ad']) {
        $cja_extend_ad = new CJA_Classified_Advert($_GET['extend-classified-ad']);
        $cja_extend_ad->extend();
        $cja_extend_ad->save();
        if (get_option('cja_charge_users')) { spend_classified_credits(); }
        header('Location: ' . get_site_url() . '/my-classified-ads?extend-ad-success=' . $cja_extend_ad->id);
        exit;
    }

    // Update theme options (sent from theme options in admin)
    if ($_POST['cja_action'] == 'update_theme_options') {

        // charge users for ads Y/N
        if ($_POST['cja_charge_users'] == 'true') {
            update_option('cja_charge_users', TRUE);
        } else {
            update_option('cja_charge_users', FALSE);
        }

        // number of days ad is still new
        update_option('cja_days_still_new', $_POST['days_new']);

        // number of user is still new
        update_option('cja_user_days_still_new', $_POST['user_days_new']);

        // Display homepage or holding page
        if ($_POST['display_homepage']) {
            update_option('cja_display_homepage', TRUE);
        } else {
            update_option('cja_display_homepage', FALSE);
        }

        // Display footer menu
        if ($_POST['display_footer_menu']) {
            update_option('cja_display_footer_menu', TRUE);
        } else {
            update_option('cja_display_footer_menu', FALSE);
        }

        update_option('cja_free_ads_message', $_POST['cja_free_ads_message']);
        update_option('profile_approval_email_subject', $_POST['profile_approval_email_subject']);
        update_option('profile_approval_email_message', $_POST['profile_approval_email_message']);
        update_option('attachment_approval_email_subject', $_POST['attachment_approval_email_subject']);
        update_option('attachment_approval_email_message', $_POST['attachment_approval_email_message']);
        update_option('attachment_edited_approval_email_message', $_POST['attachment_edited_approval_email_message']);
        update_option('approval_notification_cc', $_POST['approval_notification_cc']);
    }
}

/**
 * CJA Admin Menu
 * Adds menu pages to admin
 */

function cja_admin_menu() {

    // Notification bubbles

        // Profile approvals
        $args = array(
            'meta_key' => 'description_approved',
            'meta_value' => 'pending'
        );
        $user_query = new WP_User_Query($args);
        $profile_approvals = $user_query->get_total();

        // Attachment approvals
        $args = array(
            'meta_key' => 'files_approved',
            'meta_value' => 'pending'
        );
        $user_query = new WP_User_Query($args);
        $files_approvals = $user_query->get_total();

        // Advert approvals
        $args = array(
            'post_type' => array('job_ad', 'course_ad', 'classified_ad'),
            'meta_query' => array(
                array(
                    'key' => 'cja_ad_status',
                    'value' => 'inactive'
                )
            )
        );
        $cja_query = new WP_Query( $args );
        $advert_approvals = $cja_query->found_posts;

        // Any approvals
        if ($profile_approvals || $files_approvals || $advert_approvals) {
            $any_approvals = true;
        } else {
            $any_approvals = false;
        }

        $any_approvals = $profile_approvals + $files_approvals + $advert_approvals;
        
    

    // Theme options page
    add_menu_page(
        'Theme Options',
        'Theme Options',
        'manage_options',
        'cja_options',
        'cja_admin_page_contents',
        'dashicons-schedule',
        3
    );

    // Manage user credits page (add credits to user account)
    add_menu_page(
        'Manage User Credits',
        'Manage User Credits',
        'manage_options',
        'cja_user_credits',
        'cja_user_credits_page_contents',
        'dashicons-admin-tools',
        3
    );

    // Approvals top level menu item
    add_menu_page(
        'Approvals',
        $any_approvals ? sprintf('Approvals <span class="awaiting-mod">%d</span>', $any_approvals) : 'Approvals',
        'edit_pages',
        'cja_approve_ads',
        'cja_approve_ads_content',
        'dashicons-yes',
        4
    );

    // Approve adverts page (manually approve new adverts)
    add_submenu_page(
        'cja_approve_ads',
        'Approve Adverts',
        $advert_approvals ? sprintf('Approve Adverts <span class="awaiting-mod">%d</span>', $advert_approvals) : 'Approve Adverts',
        //'Approve Adverts',
        'manage_options',
        'cja_approve_ads', // this stops the menu header creating an extra submenu item
        'cja_approve_ads_content',
        'dashicons-yes',
        1
    );

    // Approve profiles page (manually approve new profiles)
    add_submenu_page(
        'cja_approve_ads',
        'Approve Profiles',
        $profile_approvals ? sprintf('Approve Profiles <span class="awaiting-mod">%d</span>', $profile_approvals) : 'Approve Profiles',
        //'Approve Profiles<span class="awaiting-mod">' . $profile_approvals . '</span>',
        'edit_pages',
        'cja_approve_profiles',
        'cja_approve_profiles_content',
        'dashicons-yes',
        2
    );

    // Approve attachments page (manually approve new attachments)
    add_submenu_page(
        'cja_approve_ads',
        'Approve Attachments',
        $files_approvals ? sprintf('Approve Attachments <span class="awaiting-mod">%d</span>', $files_approvals) : 'Approve Attachments',
        //'Approve Attachments',
        'edit_pages',
        'cja_approve_attachments',
        'cja_approve_attachments_content',
        'dashicons-yes',
        3
    );

    // Monitoring Screen (how many ads etc created on various days)
    add_menu_page(
        'Monitoring',
        'Monitoring',
        'manage_options',
        'cja_monitoring',
        'cja_monitoring_content',
        'dashicons-chart-bar',
        4
    );
}
add_action( 'admin_menu', 'cja_admin_menu' );

/**
 * CJA Admin Page Contents
 * Displays content for 'theme options' page in admin
 */
function cja_admin_page_contents() { ?>

        <h1>Theme Options</h1>
        <form action="<?php echo admin_url('admin.php?page=cja_options'); ?>" method="POST"><?php 

            // Charge for adverts ?>
            <p><input type="checkbox" name="cja_charge_users" value="true" <?php if (get_option('cja_charge_users')) { echo 'checked'; } ?>> Charge users to place adverts</p>
            <p class="label">Display message to users that adverts are free (leave blank for no message)</p>
            <p><input type="text" name="cja_free_ads_message" value="<?php echo get_option('cja_free_ads_message'); ?>"></p>
            <hr><?php

            // Number of days old an advert is still considered "new" ?>
            <p class="label">Number of days old an advert is still "new" (0 = today only, -1 = turn off)</p>
            <input type="number" name="days_new" value="<?php echo get_option('cja_days_still_new'); ?>" max="15" min="-1" >
            <hr><?php

            // Number of days old an advert is still considered "new" ?>
            <p class="label">Number of days old a user is still "new" (0 = today only, -1 = turn off)</p>
            <input type="number" name="user_days_new" value="<?php echo get_option('cja_user_days_still_new'); ?>" max="15" min="-1" >
            <hr><?php

            // Display homepage or holding page ?>
            <p><input type="checkbox" name="display_homepage" <?php if (get_option('cja_display_homepage')) { echo 'checked'; } ?>> Display full homepage</p><?php

            // Display footer menu ?>
            <p><input type="checkbox" name="display_footer_menu" <?php if (get_option('cja_display_footer_menu')) { echo 'checked'; } ?>> Display footer menu</p>
            
            <hr>
            <p class="label">Profile Approval Email Subject</p>
            <p><input type="text" name="profile_approval_email_subject" style="width: 500px;" value="<?php echo stripslashes(get_option('profile_approval_email_subject')); ?>"></p>

            <p class="label">Profile Approval Email Message</p>
            <textarea name="profile_approval_email_message" id="" cols="60" rows="10"><?php echo stripslashes(get_option('profile_approval_email_message')); ?></textarea>

            <p class="label">Attachment Approval Email Subject</p>
            <p><input type="text" name="attachment_approval_email_subject" style="width: 500px;" value="<?php echo stripslashes(get_option('attachment_approval_email_subject')); ?>"></p>

            <p class="label">Attachment Approval Email Message</p>
            <textarea name="attachment_approval_email_message" id="" cols="60" rows="10"><?php echo stripslashes(get_option('attachment_approval_email_message')); ?></textarea>

            <p class="label">Attachment Approval (edited) Email Message</p>
            <textarea name="attachment_edited_approval_email_message" id="" cols="60" rows="10"><?php echo stripslashes(get_option('attachment_edited_approval_email_message')); ?></textarea>

            <p class="label">Copy 'awaiting approval' notification emails to</p>
            <p><input type="text" name="approval_notification_cc" style="width: 500px;" value="<?php echo stripslashes(get_option('approval_notification_cc')); ?>"></p>
            <hr>

            <input type="submit" value="Update Options">
            <input type="hidden" name="cja_action" value="update_theme_options">

        </form><?php
}

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

/**
 * CJA Monitoring Content
 * Content for monitoring screen showing how many ads/users created on any given day
 */

function cja_monitoring_content() {

    $data_array = array();

    // Get start and end dates sent to page
    if($_POST['start_date']) {
        $first_date = $_POST['start_date'];
        $last_date = $_POST['end_date'];
    }
    
    // Start and end dates form ?>
    <form action="<?php echo get_site_url(); ?>/wp-admin/admin.php?page=cja_monitoring" method="post">
        <table style="margin-bottom: 30px; margin-top: 12px;">
            <tr>
                <td style="padding-right: 20px">
                    <p style="margin-bottom: 0;">Start Date</p>
                    <input type="date" name="start_date" <?php if ($first_date) {
                        echo('value="' . $first_date . '" ');
                    } ?>>
                </td>
                <td style="padding-right: 20px">
                    <p style="margin-bottom: 0;">End Date</p>
                    <input type="date" name="end_date" <?php if ($last_date) {
                        echo('value="' . $last_date . '" '); 
                    } ?>>
                </td>
                <td style="vertical-align: bottom; padding-right: 20px">
                    <input type="submit" name="display" value="Display" style="padding: 4px 10px;">  
                </td>
                <td style="vertical-align: bottom">
                <input type="submit" name="export" formaction="<?php echo get_site_url(); ?>/wp-admin/admin-post.php?action=print-monitoring.csv" value="Export CSV" style="padding: 4px 10px;">
                </td>
            </tr>
        </table>
    </form><?php 

    if ($_POST['start_date']) {

        
        // Convert to DateTime objects and echo table header
        $real_first_date = new DateTime($first_date);
        $real_last_date = new DateTime($last_date);
        $title = $real_first_date->format('D jS F Y') . ' - ' . $real_last_date->format('D jS F Y');
        echo ('<p style="font-size: 17px; margin-bottom: 4px;">' . $title . '</p>');
        $interval = new DateInterval('P1D'); 
        $real_last_date->add($interval); // add one day to end because DatePeriod will not include the final date
        
        // Initialise CSV data
        $csv_title = $title . '.csv';
        $csv_data_array = array();

        // Create date array for period
        $dates = array();
        $period = new DatePeriod($real_first_date, $interval, $real_last_date);
        foreach ($period as $key => $value) {
            $single_date = $value->format('Y-m-d');
            $dates[] = $single_date;      
        }

        // Initialise Table ?>
        <style>
            table#monitoringtable {
                border-collapse: collapse;
                border: 1px solid #333;
            }

            table#monitoringtable thead td {
                font-weight: 700;
            }

            table#monitoringtable tr.totals td {
                font-weight: 700;
            }

            table#monitoringtable tr td {
                padding: 5px 15px;
                text-align: center;
                border-bottom: 1px solid #333;
            }
        </style>

        <table id="monitoringtable">
            <thead>
                <tr>
                    <td>Date</td>
                    <td>New Jobs</td>
                    <td>New Courses</td>
                    <td>New Classifieds</td>
                    <td>Job Applications</td>
                    <td>Course Applications</td>
                    <td>New Advertisers</td>
                    <td>New Course/Job Seekers</td>
                    <td>Course Seekers</td>
                    <td>Job Seekers</td>
                </tr>
            </thead>
            <tbody><?php

        // CSV Header Line
        $csv_data_array[] = array('Date', 'New Jobs', 'New Courses', 'New Classifieds', 'Job Applications', 'Course Applications', 'New Advertisers', 'New Course/Job Seekers', 'Course Seekers', 'Job Seekers');

        // Initialise Running Totals Array
        $running_totals = array(
            'jobs' => 0,
            'courses' => 0,
            'classifieds' => 0,
            'job_applications' => 0,
            'course_applications' => 0,
            'advertisers' => 0,
            'seekers' => 0,
            'courseseekers' => 0,
            'jobseekers' => 0
        );

        // go through dates one at a time and display
        foreach ($dates as $date) {

            // initialise CSV line
            $csv_data_line = array();

            //echo '<tr><td>' . $date . '</td>';
            $date_time = new DateTime($date);
            $year = $date_time->format('Y');
            $month = $date_time->format('m');
            $day = $date_time->format('d');
            $csv_data_line[] = $date_time->format('D d M');
            echo '<tr><td>' . $date_time->format('D d M') . '</td>';
            
            // job ads
            $args = array(
                'post_type' => 'job_ad',
                'date_query' => array(
                    'year' => $year,
                    'month' => $month,
                    'day' => $day
                )
            );
            $query = new WP_Query($args);
            echo '<td>' . $query->found_posts . '</td>';
            $csv_data_line[] = $query->found_posts;
            $running_totals['jobs'] += $query->found_posts;

            // course ads
            $args['post_type'] = 'course_ad';
            $query = new WP_Query($args);
            echo '<td>' . $query->found_posts . '</td>';
            $csv_data_line[] = $query->found_posts;
            $running_totals['courses'] += $query->found_posts;

            // classified ads
            $args['post_type'] = 'classified_ad';
            $query = new WP_Query($args);
            echo '<td>' . $query->found_posts . '</td>';
            $csv_data_line[] = $query->found_posts;
            $running_totals['classifieds'] += $query->found_posts;

            // job applications
            $args['post_type'] = 'application';
            $query = new WP_Query($args);
            echo '<td>' . $query->found_posts . '</td>';
            $csv_data_line[] = $query->found_posts;
            $running_totals['job_applications'] += $query->found_posts;

            // course applications
            $args['post_type'] = 'course_application';
            $query = new WP_Query($args);
            echo '<td>' . $query->found_posts . '</td>';
            $csv_data_line[] = $query->found_posts;
            $running_totals['course_applications'] += $query->found_posts;

            // advertisers
            $args = array(
                'role' => 'advertiser',
                'date_query' => array(
                    'year' => $year,
                    'month' => $month,
                    'day' => $day
                )
            );
            $query = new WP_User_Query($args);
            echo '<td>' . $query->get_total() . '</td>';
            $csv_data_line[] = $query->get_total();
            $running_totals['advertisers'] += $query->get_total();

            // jobseekers
            $args['role'] = 'jobseeker';
            $query = new WP_User_Query($args);
            echo '<td>' . $query->get_total() . '</td>';
            $csv_data_line[] = $query->get_total();
            $running_totals['seekers'] += $query->get_total();

            
            // get totals of is_jobseeker and is_student
            $this_day_jobseekers = 0;
            $this_day_courseseekers = 0;
            if ( ! empty( $query->get_results() ) ) {
                foreach ( $query->get_results() as $user ) {
                    $cja_user = new CJA_User ($user->id);
                    if ($cja_user->is_jobseeker) {
                        $this_day_jobseekers++;
                    }
                    if ($cja_user->is_student) {
                        $this_day_courseseekers++;
                    }
                }
            }
            echo '<td>' . $this_day_courseseekers . '</td>';
            echo '<td>' . $this_day_jobseekers . '</td></tr>';
            $csv_data_line[] = $this_day_courseseekers;
            $csv_data_line[] = $this_day_jobseekers;
            $running_totals['jobseekers'] += $this_day_jobseekers;
            $running_totals['courseseekers'] += $this_day_courseseekers;

            $csv_data_array[] = $csv_data_line;
        }

        // End table ?>
        <tr class="totals">
            <td></td>
            <td>Total Jobs</td>
            <td>Total Courses</td>
            <td>Total Classifieds</td>
            <td>Total Job Applications</td>
            <td>Total Course Applications</td>
            <td>Total Advertisers</td>
            <td>Total C/J Seekers</td>
            <td>Course Seekers</td>
            <td>Job Seekers</td>
        </tr>
        <tr class="totals">
            <td></td>
            <td><?php echo $running_totals['jobs']; ?></td>
            <td><?php echo $running_totals['courses']; ?></td>
            <td><?php echo $running_totals['classifieds']; ?></td>
            <td><?php echo $running_totals['job_applications']; ?></td>
            <td><?php echo $running_totals['course_applications']; ?></td>
            <td><?php echo $running_totals['advertisers']; ?></td>
            <td><?php echo $running_totals['seekers']; ?></td>
            <td><?php echo $running_totals['courseseekers']; ?></td>
            <td><?php echo $running_totals['jobseekers']; ?></td>
        </tr>
        </tbody>
        </table><?php
        
        if ($_POST['export']) {
            outputCsv($csv_title, $csv_data_array);
        }
    }
}



/**
 * Print Monitoring CSV
 * This function exports the monitoring table as a csv
 * 
 * Todo: remove CSV functions from monitoring page, this is just that page duplicated with the screen bits stripped out
 */

add_action( 'admin_post_print-monitoring.csv', 'print_monitoring_csv' );
function print_monitoring_csv() {

    $data_array = array();

    // Get start and end dates sent to page
    if($_POST['start_date']) {
        $first_date = $_POST['start_date'];
        $last_date = $_POST['end_date'];
    }

    // If we have a start date let's make a csv
    if ($_POST['start_date']) {

        // Convert to DateTime objects and echo table header
        $real_first_date = new DateTime($first_date);
        $real_last_date = new DateTime($last_date);
        $title = $real_first_date->format('D jS F Y') . ' - ' . $real_last_date->format('D jS F Y');
        $interval = new DateInterval('P1D'); 
        $real_last_date->add($interval); // add one day to end because DatePeriod will not include the final date
        
        // Initialise CSV data
        $csv_title = $title . '.csv';
        $csv_data_array = array();

        // Create date array for period
        $dates = array();
        $period = new DatePeriod($real_first_date, $interval, $real_last_date);
        foreach ($period as $key => $value) {
            $single_date = $value->format('Y-m-d');
            $dates[] = $single_date;      
        }

        // CSV Header Line
        $csv_data_array[] = array('Date', 'New Jobs', 'New Courses', 'New Classifieds', 'Job Applications', 'Course Applications', 'New Advertisers', 'New Course/Job Seekers', 'Course Seekers', 'Job Seekers');

        // go through dates one at a time and display
        foreach ($dates as $date) {

            // initialise CSV line
            $csv_data_line = array();

            $date_time = new DateTime($date);
            $year = $date_time->format('Y');
            $month = $date_time->format('m');
            $day = $date_time->format('d');
            $csv_data_line[] = $date_time->format('D d M');
            
            // job ads
            $args = array(
                'post_type' => 'job_ad',
                'date_query' => array(
                    'year' => $year,
                    'month' => $month,
                    'day' => $day
                )
            );
            $query = new WP_Query($args);
            $csv_data_line[] = $query->found_posts;

            // course ads
            $args['post_type'] = 'course_ad';
            $query = new WP_Query($args);
            $csv_data_line[] = $query->found_posts;

            // classified ads
            $args['post_type'] = 'classified_ad';
            $query = new WP_Query($args);
            $csv_data_line[] = $query->found_posts;

            // job applications
            $args['post_type'] = 'application';
            $query = new WP_Query($args);
            $csv_data_line[] = $query->found_posts;

            // course applications
            $args['post_type'] = 'course_application';
            $query = new WP_Query($args);
            $csv_data_line[] = $query->found_posts;

            // advertisers
            $args = array(
                'role' => 'advertiser',
                'date_query' => array(
                    'year' => $year,
                    'month' => $month,
                    'day' => $day
                )
            );
            $query = new WP_User_Query($args);
            $csv_data_line[] = $query->get_total();

            // jobseekers
            $args['role'] = 'jobseeker';
            $query = new WP_User_Query($args);
            $csv_data_line[] = $query->get_total();

            
            // get totals of is_jobseeker and is_student
            $this_day_jobseekers = 0;
            $this_day_courseseekers = 0;
            if ( ! empty( $query->get_results() ) ) {
                foreach ( $query->get_results() as $user ) {
                    $cja_user = new CJA_User ($user->id);
                    if ($cja_user->is_jobseeker) {
                        $this_day_jobseekers++;
                    }
                    if ($cja_user->is_student) {
                        $this_day_courseseekers++;
                    }
                }
            }

            $csv_data_line[] = $this_day_courseseekers;
            $csv_data_line[] = $this_day_jobseekers;

            $csv_data_array[] = $csv_data_line;
        }
        
        if ($_POST['export']) {
            outputCsv($csv_title, $csv_data_array);
        }
    }
}

/**
 * Create job applicants CSV
 * Creates CSV of applicants for any given job
 */

add_action( 'admin_post_create-job-applicants-csv', 'create_job_applicants_csv');
function create_job_applicants_csv() {

    // Get the ID of the ad we're looking for
    $advert_id = $_GET['advert_id'];

    // Make sure that the ad belongs to the current user and they're not playing with the URL
    $advert = new CJA_Advert($advert_id);
    if ($advert->author != get_current_user_id()) {
        exit;
    }

    // Initialise CSV array
    $csv_array = array(
        array(
            'Applicant Code',
            'First Name',
            'Last Name',
            'Application Date',
            'Town/City',
            'Age Category',
            'GCSE Maths',
            'GCSE English',
            'Functional Skills Maths',
            'Functional Skills English',
            'Highest Qualification',
            'Opportunities Required',
            'Courses FT/PT',
            'Jobs FT/PT',
            'Job Role(s)',
            'Cover Work',
            'Weekends Availability',
            'Specialism Area(s)',
            'Current Status',
            'Unemployed',
            'Receiving Benefits',
            'Contact Preference',
            'Profile'
        )
    );


    // Retrieve all applications for this job
    $args = array(
        'post_type' => 'application',
        'meta_key' => 'advertID',
        'meta_value' => $advert_id,
        'orderby'=> 'date'
    );
    $query = new WP_Query($args);

    // Loop through applications
    if ($query->have_posts()) {
        while($query->have_posts()) {
            $query->the_post();

            // Populate new array row
            $current_application = new CJA_Application(get_the_ID());
            $current_applicant = new CJA_User($current_application->applicant_ID);
            $current_advert = new CJA_Advert($current_application->advert_ID);
            $csv_title = 'Applicants for ' . get_cja_code($current_advert->id) . ' ' . $current_advert->title . '.csv';
            $csv_row = [];
            
            $csv_row[] = get_cja_user_code($current_applicant->id); // code
            $csv_row[] = $current_applicant->first_name;
            $csv_row[] = $current_applicant->last_name;
            $csv_row[] = $current_application->human_application_date;
            $csv_row[] = $current_applicant->town_city;
            $csv_row[] = $current_applicant->age_category;
            $csv_row[] = $current_applicant->return_field('gcse_maths');
            $csv_row[] = $current_applicant->return_field('gcse_english');
            $csv_row[] = $current_applicant->return_field('functional_maths');
            $csv_row[] = $current_applicant->return_field('functional_english');
            $csv_row[] = $current_applicant->return_field('highest_qualification');
            $csv_row[] = $current_applicant->return_field('opportunity_required');
            $csv_row[] = $current_applicant->return_field('course_time');
            $csv_row[] = $current_applicant->return_field('job_time');
            $csv_row[] = $current_applicant->return_field('job_role');
            $csv_row[] = $current_applicant->return_field('cover_work');
            $csv_row[] = $current_applicant->return_field('weekends_availability');
            $csv_row[] = $current_applicant->return_field('specialism_area');
            $csv_row[] = $current_applicant->return_field('current_status');
            $csv_row[] = $current_applicant->return_field('unemployed');
            $csv_row[] = $current_applicant->return_field('receiving_benefits');
            $csv_row[] = $current_applicant->return_field('contact_preference');
            $csv_row[] = $current_applicant->return_field('company_description');

            // Push to master csv array
            $csv_array[] = $csv_row;
        }
    }
    
    outputCsv($csv_title, $csv_array);
    exit;
}

/**
 * Create course applicants CSV
 * Creates CSV of applicants for any given job
 */

add_action( 'admin_post_create-course-applicants-csv', 'create_course_applicants_csv');
function create_course_applicants_csv() {

    // Get the ID of the ad we're looking for
    $advert_id = $_GET['advert_id'];

    // Make sure that the ad belongs to the current user and they're not playing with the URL
    $advert = new CJA_Course_Advert($advert_id);
    if ($advert->author != get_current_user_id()) {
        exit;
    }

    // Initialise CSV array
    $csv_array = array(
        array(
            'Applicant Code',
            'First Name',
            'Last Name',
            'Application Date',
            'Town/City',
            'Age Category',
            'GCSE Maths',
            'GCSE English',
            'Functional Skills Maths',
            'Functional Skills English',
            'Highest Qualification',
            'Opportunities Required',
            'Courses FT/PT',
            'Jobs FT/PT',
            'Job Role(s)',
            'Cover Work',
            'Weekends Availability',
            'Specialism Area(s)',
            'Current Status',
            'Unemployed',
            'Receiving Benefits',
            'Contact Preference',
            'Profile'
        )
    );


    // Retrieve all applications for this job
    $args = array(
        'post_type' => 'course_application',
        'meta_key' => 'advertID',
        'meta_value' => $advert_id,
        'orderby'=> 'date'
    );
    $query = new WP_Query($args);

    // Loop through applications
    if ($query->have_posts()) {
        while($query->have_posts()) {
            $query->the_post();

            // Populate new array row
            $current_application = new CJA_Course_Application(get_the_ID());
            $current_applicant = new CJA_User($current_application->applicant_ID);
            $current_advert = new CJA_Course_Advert($current_application->advert_ID);
            $csv_title = 'Applicants for ' . get_cja_code($current_advert->id) . ' ' . $current_advert->title . '.csv';
            $csv_row = [];
            
            $csv_row[] = get_cja_user_code($current_applicant->id); // code
            $csv_row[] = $current_applicant->first_name;
            $csv_row[] = $current_applicant->last_name;
            $csv_row[] = $current_application->human_application_date;
            $csv_row[] = $current_applicant->town_city;
            $csv_row[] = $current_applicant->age_category;
            $csv_row[] = $current_applicant->return_field('gcse_maths');
            $csv_row[] = $current_applicant->return_field('gcse_english');
            $csv_row[] = $current_applicant->return_field('functional_maths');
            $csv_row[] = $current_applicant->return_field('functional_english');
            $csv_row[] = $current_applicant->return_field('highest_qualification');
            $csv_row[] = $current_applicant->return_field('opportunity_required');
            $csv_row[] = $current_applicant->return_field('course_time');
            $csv_row[] = $current_applicant->return_field('job_time');
            $csv_row[] = $current_applicant->return_field('job_role');
            $csv_row[] = $current_applicant->return_field('cover_work');
            $csv_row[] = $current_applicant->return_field('weekends_availability');
            $csv_row[] = $current_applicant->return_field('specialism_area');
            $csv_row[] = $current_applicant->return_field('current_status');
            $csv_row[] = $current_applicant->return_field('unemployed');
            $csv_row[] = $current_applicant->return_field('receiving_benefits');
            $csv_row[] = $current_applicant->return_field('contact_preference');
            $csv_row[] = $current_applicant->return_field('company_description');

            // Push to master csv array
            $csv_array[] = $csv_row;
        }
    }
    
    outputCsv($csv_title, $csv_array);
    exit;
}

 /**
  * Output CSV
 * 
 * Takes in a filename and an array associative data array and outputs a csv file
 * @param string $fileName
 * @param array $assocDataArray     
 */
function outputCsv($fileName, $assocDataArray)
{
    ob_clean();
    header('Pragma: public');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Cache-Control: private', false);
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=' . $fileName);    
    if(isset($assocDataArray['0'])){
        $fp = fopen('php://output', 'w');
        //fputcsv($fp, array_keys($assocDataArray['0']));
        foreach($assocDataArray AS $values){
            fputcsv($fp, $values);
        }
        fclose($fp);
    }
    ob_flush();
    exit;
}

/**
 * Has Woocommerce Subscription
 * Return whether user has a certain woocommerce subscription
 */
function has_woocommerce_subscription($the_user_id, $the_product_id, $the_status) {
	$current_user = wp_get_current_user();
	if (empty($the_user_id)) {
		$the_user_id = $current_user->ID;
	}
	if (WC_Subscriptions_Manager::user_has_subscription( $the_user_id, $the_product_id, $the_status)) {
		return true;
	}
}

/**
 * CJA Sendmail
 * Custom wrapper for wp_mail
 */

function cja_sendmail($details) {
    $to = $details['to'];
    $subject = $details['subject'];
    $body = $details['body'];
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: Courses and Jobs Advertiser <wordpress@coursesandjobs.co.uk>'
    );
    
    wp_mail( $to, $subject, $body, $headers );
}

/**
 * Filter the new user notification email.
 *
 * @param $email array New user notification email parameters.
 * @return $email array New user notification email parameters.
 */

function myplugin_new_user_notification_email_callback( $email, $user ) {
    $email['subject'] = 'Welcome to Courses and Jobs Advertiser';
    $email['message'] = "Thank you for your registration on Courses and Jobs Advertiser! \n\n";
    $email['message'] .= "Your username is '" . $user->data->user_login . "' and your password is the password you specified on signup.\n\n";
    $email['message'] .= "To log in to the site please go to www.coursesandjobs.co.uk/my-account. You can also reset your password from this page.\n\n";
    $email['headers'] = "From: Courses and Jobs Advertiser <wordpress@coursesandjobs.co.uk>";
    return $email;
}
add_filter( 'wp_new_user_notification_email', 'myplugin_new_user_notification_email_callback', 10, 2 );

/**
 * Allow user to upload files
 */
global $wp_roles; 
define( 'ALLOW_UNFILTERED_UPLOADS', true ); 
$current_user = wp_get_current_user(); 
$role = $current_user->roles; 
$wp_roles->add_cap( $role[0], 'unfiltered_upload' );

/**
 * Return CJA Code for Post ID
 */
function get_cja_code($id) {
    $type = get_post_type($id);
    if ($type) {
        if ($type == 'job_ad') {
            return 'JBA' . $id;
        }
        if ($type == 'course_ad') {
            return 'CSA' . $id;
        }
        if ($type == 'classified_ad') {
            return 'CLA' . $id;
        }
        if ($type == 'application') {
            return 'JAP' . $id;
        }
        if ($type == 'course_application') {
            return 'CAP' . $id;
        }
    }
    return false;
}

/**
 * Return CJA Code for User ID
 */
function get_cja_user_code($id) {
    $user = get_userdata($id);

    if (in_array('administrator', $user->roles)) {
        return 'ADM' . $id;
    } else if (in_array('advertiser', $user->roles)) {
        return 'CJA' . $id;
    } else if (in_array('jobseeker', $user->roles)) {
        return 'CJS' . $id;
    }

    return false;
}

/**
 * Return integer from user-inputted CJA code
 */
function strip_cja_code($code) {
    preg_match_all('!\d+!', $code, $result);
    return $result[0][0];
}

/**
 * Update database when adverts are edited via admin
 * See also cja_update_author_from_admin()
 */
add_action('init', 'update_post_from_admin');
function update_post_from_admin() {

    if ($_POST['update_job_ad_admin']) {
        $cja_update_ad = new CJA_Advert($_POST['advert-id']);
        $cja_update_ad->update_from_form();
        $cja_update_ad->save();
    }

    if ($_POST['update_course_ad_admin']) {
        $cja_update_ad = new CJA_Course_Advert($_POST['advert-id']);
        $cja_update_ad->update_from_form();
        $cja_update_ad->save();
    }

    if ($_POST['update_classified_ad_admin']) {
        $cja_update_ad = new CJA_Classified_Advert($_POST['advert-id']);
        $cja_update_ad->update_from_form();
        $cja_update_ad->save();
    }

    if ($_POST['cja_update_user_admin']) {
        $cja_update_user = new CJA_User($_POST['cja_user_id']);
        $cja_update_user->updateFromForm();
        $cja_update_user->save();
    }
}

/**
 * Display custom fields to edit for individual post types in admin
 */
add_action('edit_form_after_title', 'display_admin_custom_post_edit_form');
function display_admin_custom_post_edit_form() {

    $screen = get_current_screen();

    // If we are on an add new screen then display message
    if ($screen->action == 'add') {
        if ($screen->post_type == 'job_ad') {
            echo 'Time to create a new job. To start, type in the job title and click publish.';
        } else if ($screen->post_type == 'course_ad') {
            echo 'Time to create a new course. To start, type in the course title and click publish.';
        } else if ($screen->post_type == 'classified_ad') {
            echo 'Time to create a new classified ad. To start, type in the advert title and click publish';
        }

    // Otherwise check we're on our own custom post and display edit form
    } else if ($screen->post_type == 'job_ad' || $screen->post_type == 'course_ad' || $screen->post_type == 'classified_ad') {

        echo '<p>CJA Code: ' . get_cja_code($_GET['post']);

        // Create correct object

        if ($screen->post_type == 'job_ad') {
            $cja_edit_ad = new CJA_Advert($_GET['post']); 
        } else if ($screen->post_type == 'course_ad') {
            $cja_edit_ad = new CJA_Course_Advert($_GET['post']); 
        } else if ($screen->post_type == 'classified_ad') {
            $cja_edit_ad = new CJA_Classified_Advert($_GET['post']); 
        }

        $cja_advertiser = new CJA_User($cja_edit_ad->author);

        // Start of form and advertiser section ?>
        <div class="admin_edit_form">
            <h2 class="form_section_heading">Advertiser</h2>
            <div class="form_flexbox_2">
                <div>
                    <p style="font-size: 1.5rem; margin-bottom: 5px; margin-top: 15px;"><span id="show_advertiser"><?php echo $cja_advertiser->display_name(); ?></span></p>
                    <p style="margin-top: 0; font-size: 1rem;"><span id="show_code"> <?php echo get_cja_user_code($cja_advertiser->id); ?></span></p>
                    <input type="hidden" name="advertiser" id="advertiser" value="<?php echo $cja_edit_ad->author; ?>">
                </div>
                <div>
                    <p class="label">Change Advertiser - Select</p>
                    <div class="selector" style="height: 200px; overflow-y: scroll; background-color: white; border: 1px solid black; border-radius: 5px; padding: 5px 10px; width: 100%; box-sizing: border-box;">
                        <ul role="listbox"><?php
    
                        // WP_User_Query arguments
                        // Classifieds can also be placed by jobseekers
                        if ($screen->post_type == 'classified_ad') {
                            $args = array(
                                'role__in' => array('administrator', 'advertiser', 'jobseeker')
                            );
                        } else {
                            $args = array(
                                'role__in' => array('administrator', 'advertiser')
                            );
                        }
    
                        // The User Query
                        $user_query = new WP_User_Query( $args );

                        $select_array = array();
                        
                        foreach($user_query->get_results() as $user) {
                            $the_advertiser = new CJA_User( $user->data->ID );
                            $new_element = array();
                            $new_element['id'] = $user->data->ID;
                            $new_element['user_code'] = get_cja_user_code($user->data->ID);
                            $new_element['display_name'] = $the_advertiser->display_name();
                            $select_array[strtoupper($the_advertiser->display_name())] = $new_element;
                        }

                        ksort($select_array);

                        foreach($select_array as $option) { ?>
                            <li><a style="cursor: pointer" class="update_advertiser" data-display_string="<?php 
                                echo $option['display_name']; ?>" data-display_code="<?php echo $option['user_code']; ?>" data-id="<?php echo $option['id']; ?>"><?php 
                                echo $option['display_name']; 
                                echo ' : ';
                                echo $option['user_code'];
                                ?></a></li><?php
                        } ?>
                        </ul>
                    </div>
                    <p class="label">Change Advertiser - Enter Code</p>
                    <input type="text" id="enter_advertiser_id">
                    <p id="enter_advertiser_id_feedback"></p>
                </div>
            </div> <?php

            // include details form and hidden field
            if ($screen->post_type == 'job_ad') {
                include( ABSPATH . 'wp-content/themes/courses-and-jobs/inc/templates/job-details-form.php'); ?>
                <input type="hidden" name="update_job_ad_admin" value="true"><?php
            } else if ($screen->post_type == 'course_ad') {
                include( ABSPATH . 'wp-content/themes/courses-and-jobs/inc/templates/course-details-form.php'); ?>
                <input type="hidden" name="update_course_ad_admin" value="true"><?php
            } else if ($screen->post_type == 'classified_ad') {
                ?><h2 class="form_section_heading">Advert Details</h2><?php
                include( ABSPATH . 'wp-content/themes/courses-and-jobs/inc/templates/classified-details-form.php'); ?>
                <input type="hidden" name="update_classified_ad_admin" value="true"><?php
            }

            // Hidden ID field ?>
            <input type="hidden" name="advert-id" value="<?php echo ($cja_edit_ad->id); ?>">
        </div>
        
        <!-- Javascript for advertiser edit functions -->
        <script>
            jQuery(document).ready(function() {
                var advertiser_array = [];

                // Build array for search
                jQuery('.update_advertiser').each(function(index) {
                    advertiser_array[index] = [];
                    advertiser_array[index]['id'] = jQuery(this).data('id');
                    advertiser_array[index]['user_code'] = jQuery(this).data('display_code');
                    advertiser_array[index]['display_string'] = jQuery(this).data('display_string');
                });

                // click handler for list of advertisers
                jQuery('.update_advertiser').click(function() {
                    jQuery('#show_advertiser').html(jQuery(this).data('display_string'));
                    jQuery('#show_code').html(jQuery(this).data('display_code'));
                    jQuery('#advertiser').val(jQuery(this).data('id'));
                });

                // input handler for when user types in code
                jQuery('#enter_advertiser_id').on('input', function(e) {
                    // This version searches by ID not code
                    // var the_input_id = jQuery('#enter_advertiser_id').val().match(/\d+/);
                    var the_input_id = jQuery('#enter_advertiser_id').val();

                    var the_result = advertiser_array.filter(function (advertiser) { return advertiser.user_code == the_input_id });
                    
                    if (the_result[0]) {
                        jQuery('#enter_advertiser_id_feedback').html(the_input_id + ': ' + the_result[0]['display_string']);
                        jQuery('#show_advertiser').html(the_result[0]['display_string']);
                        jQuery('#show_code').html(the_result[0]['user_code']);
                        jQuery('#advertiser').val(the_result[0]['id']);
                    } else {
                        jQuery('#enter_advertiser_id_feedback').html(the_input_id + ': Not Recognised');
                    }
                });

                // blur handler for code input box
                jQuery('#enter_advertiser_id').on('blur', function(e) {
                    jQuery('#enter_advertiser_id').val('');
                    jQuery('#enter_advertiser_id_feedback').html('');
                });

            }); 
        </script><?php
    }
}


    /*

    LEAVING ALL THIS ORIGINAL CODE IN HERE FOR NOW FOR DEBUGGING IN CASE THERE IS ANY PROBLEM WITH CODE ABOVE. IF A COUPLE OF WEEKS GO BY AND IT'S FINE THEN DELETE THIS COMMENTED SECTION 12-1-21

    if ($screen->post_type == 'job_ad') {
        
        if ($screen->action == 'add') {
            echo 'Time to create a new job. To start, type in the job title and click publish.';
        } else {

            echo '<p>CJA Code: ' . get_cja_code($_GET['post']);
            $cja_edit_ad = new CJA_Advert($_GET['post']); 
            $cja_advertiser = new CJA_User($cja_edit_ad->author); ?>

            <div class="admin_edit_form">
                <h2 class="form_section_heading">Advertiser</h2>
                <div class="form_flexbox_2">
                    <div>
                        <p style="font-size: 1.5rem; margin-bottom: 5px; margin-top: 15px;"><span id="show_advertiser"><?php echo $cja_advertiser->display_name(); ?></span></p>
                        <p style="margin-top: 0; font-size: 1rem;"><span id="show_code"> <?php echo get_cja_user_code($cja_advertiser->id); ?></span></p>
                        <input type="hidden" name="advertiser" id="advertiser" value="<?php echo $cja_edit_ad->author; ?>">
                    </div>
                    <div>
                        <p class="label">Change Advertiser - Select</p>
                        <div class="selector" style="height: 200px; overflow-y: scroll; background-color: white; border: 1px solid black; border-radius: 5px; padding: 5px 10px; width: 100%; box-sizing: border-box;">
                            <ul role="listbox"><?php
        
                            // WP_User_Query arguments
                            $args = array(
                                'role' => 'advertiser',
                            );
        
                            // The User Query
                            $user_query = new WP_User_Query( $args );

                            $select_array = array();
                            
                            foreach($user_query->get_results() as $user) {
                                $the_advertiser = new CJA_User( $user->data->ID );
                                $new_element = array();
                                $new_element['id'] = $user->data->ID;
                                $new_element['user_code'] = get_cja_user_code($user->data->ID);
                                $new_element['display_name'] = $the_advertiser->display_name();
                                $select_array[strtoupper($the_advertiser->display_name())] = $new_element;
                            }
                            //print_r($select_array);
                            ksort($select_array);

                            foreach($select_array as $option) { ?>
                                <li><a style="cursor: pointer" class="update_advertiser" data-display_string="<?php 
                                    echo $option['display_name']; ?>" data-display_code="<?php echo $option['user_code']; ?>" data-id="<?php echo $option['id']; ?>"><?php 
                                    echo $option['display_name']; 
                                    echo ' : ';
                                    echo $option['user_code'];
                                    ?></a></li><?php
                            } ?>
                            </ul>
                        </div>
                        <p class="label">Change Advertiser - Enter Code</p>
                        <input type="text" id="enter_advertiser_id">
                        <p id="enter_advertiser_id_feedback"></p>
                    </div>
                </div>
                
                <?php

                // include details form
                include( ABSPATH . 'wp-content/themes/courses-and-jobs/inc/templates/job-details-form.php'); ?>

                <input type="hidden" name="update_job_ad_admin" value="true">
                <input type="hidden" name="advert-id" value="<?php echo ($cja_edit_ad->id); ?>">
            </div><?php
        }
    }

    if ($screen->post_type == 'course_ad') {

        if ($screen->action == 'add') {
            echo 'Time to create a new course. To start, type in the course title and click publish.';
        } else {

            echo '<p>CJA Code: ' . get_cja_code($_GET['post']);
            $cja_edit_ad = new CJA_Course_Advert($_GET['post']); 
            $cja_advertiser = new CJA_User($cja_edit_ad->author); ?>

            <div class="admin_edit_form">
                <h2 class="form_section_heading">Advertiser Yer Mam</h2>
                    <div class="form_flexbox_2">
                        <div>
                            <p style="font-size: 1.5rem; margin-bottom: 5px; margin-top: 15px;"><span id="show_advertiser"><?php echo $cja_advertiser->display_name(); ?></span></p>
                            <p style="margin-top: 0; font-size: 1rem;"><span id="show_code"> <?php echo get_cja_user_code($cja_advertiser->id); ?></span></p>
                            <input type="hidden" name="advertiser" id="advertiser" value="<?php echo $cja_edit_ad->author; ?>">
                        </div>
                        <div>
                            <p class="label">Change Advertiser - Select</p>
                            <div class="selector" style="height: 200px; overflow-y: scroll; background-color: white; border: 1px solid black; border-radius: 5px; padding: 5px 10px; width: 100%; box-sizing: border-box;">
                                <ul role="listbox"><?php
            
                                // WP_User_Query arguments
                                $args = array(
                                    'role' => 'advertiser',
                                );
            
                                // The User Query
                                $user_query = new WP_User_Query( $args );

                                $select_array = array();
                                
                                foreach($user_query->get_results() as $user) {
                                    $the_advertiser = new CJA_User( $user->data->ID );
                                    $new_element = array();
                                    $new_element['id'] = $user->data->ID;
                                    $new_element['user_code'] = get_cja_user_code($user->data->ID);
                                    $new_element['display_name'] = $the_advertiser->display_name();
                                    $select_array[strtoupper($the_advertiser->display_name())] = $new_element;
                                }
                                //print_r($select_array);
                                ksort($select_array);

                                foreach($select_array as $option) { ?>
                                    <li><a style="cursor: pointer" class="update_advertiser" data-display_string="<?php 
                                        echo $option['display_name']; ?>" data-display_code="<?php echo $option['user_code']; ?>" data-id="<?php echo $option['id']; ?>"><?php 
                                        echo $option['display_name']; 
                                        echo ' : ';
                                        echo $option['user_code'];
                                        ?></a></li><?php
                                } ?>
                                </ul>
                            </div>
                            <p class="label">Change Advertiser - Enter Code</p>
                            <input type="text" id="enter_advertiser_id">
                            <p id="enter_advertiser_id_feedback"></p>
                        </div>
                    </div>

                <?php
                // include details form
                include( ABSPATH . 'wp-content/themes/courses-and-jobs/inc/templates/course-details-form.php'); ?>

                <input type="hidden" name="update_course_ad_admin" value="true">
                <input type="hidden" name="advert-id" value="<?php echo ($cja_edit_ad->id); ?>">
            </div><?php
        }
    }

    if ($screen->post_type == 'classified_ad') {

        if ($screen->action == 'add') {
            echo 'Time to create a new classified ad. To start, type in the advert title and click publish.';
        } else {

            echo '<p>CJA Code: ' . get_cja_code($_GET['post']);
            $cja_edit_ad = new CJA_Classified_Advert($_GET['post']); 
            $cja_advertiser = new CJA_User($cja_edit_ad->author); ?>

            <div class="admin_edit_form">
                <!--<h2 class="form_section_heading">Advertiser</h2>
                <div class="form_flexbox_2">
                        <div>
                            <p style="font-size: 1.5rem; margin-bottom: 5px; margin-top: 15px;"><span id="show_advertiser"><?php echo $cja_advertiser->display_name(); ?></span></p>
                            <p style="margin-top: 0; font-size: 1rem;"><span id="show_code"> <?php echo get_cja_user_code($cja_advertiser->id); ?></span></p>
                            <input type="hidden" name="advertiser" id="advertiser" value="<?php echo $cja_edit_ad->author; ?>">
                        </div>
                        <div>
                            <p class="label">Change Advertiser</p>
                            <div class="selector" style="height: 200px; overflow-y: scroll; background-color: white; border: 1px solid black; border-radius: 5px; padding: 5px 10px; width: 100%; box-sizing: border-box;">
                                <ul role="listbox"><?php
            
                                // WP_User_Query arguments
                                $args = array(
                                    'role__in' => array('advertiser','jobseeker')
                                );
            
                                // The User Query
                                $user_query = new WP_User_Query( $args );
                                $select_array = array();
                            
                                foreach($user_query->get_results() as $user) {
                                    $the_advertiser = new CJA_User( $user->data->ID );
                                    $new_element = array();
                                    $new_element['id'] = $user->data->ID;
                                    $new_element['user_code'] = get_cja_user_code($user->data->ID);
                                    $new_element['display_name'] = $the_advertiser->display_name();
                                    $select_array[strtoupper($the_advertiser->display_name())] = $new_element;
                                }
                                //print_r($select_array);
                                ksort($select_array);

                                foreach($select_array as $option) { ?>
                                    <li><a style="cursor: pointer" class="update_advertiser" data-display_string="<?php 
                                        echo $option['display_name']; ?>" data-display_code="<?php echo $option['user_code']; ?>" data-id="<?php echo $option['id']; ?>"><?php 
                                        echo $option['display_name']; 
                                        echo ' : ';
                                        echo $option['user_code'];
                                        ?></a></li><?php
                                }?>
                                </ul>
                            </div>
                        </div>
                    </div>-->

                    <h2 class="form_section_heading">Advertiser Yer Mam</h2>
                    <div class="form_flexbox_2">
                        <div>
                            <p style="font-size: 1.5rem; margin-bottom: 5px; margin-top: 15px;"><span id="show_advertiser"><?php echo $cja_advertiser->display_name(); ?></span></p>
                            <p style="margin-top: 0; font-size: 1rem;"><span id="show_code"> <?php echo get_cja_user_code($cja_advertiser->id); ?></span></p>
                            <input type="hidden" name="advertiser" id="advertiser" value="<?php echo $cja_edit_ad->author; ?>">
                        </div>
                        <div>
                            <p class="label">Change Advertiser - Select</p>
                            <div class="selector" style="height: 200px; overflow-y: scroll; background-color: white; border: 1px solid black; border-radius: 5px; padding: 5px 10px; width: 100%; box-sizing: border-box;">
                                <ul role="listbox"><?php
            
                                // WP_User_Query arguments
                                $args = array(
                                    'role' => 'advertiser',
                                );
            
                                // The User Query
                                $user_query = new WP_User_Query( $args );

                                $select_array = array();
                                
                                foreach($user_query->get_results() as $user) {
                                    $the_advertiser = new CJA_User( $user->data->ID );
                                    $new_element = array();
                                    $new_element['id'] = $user->data->ID;
                                    $new_element['user_code'] = get_cja_user_code($user->data->ID);
                                    $new_element['display_name'] = $the_advertiser->display_name();
                                    $select_array[strtoupper($the_advertiser->display_name())] = $new_element;
                                }
                                //print_r($select_array);
                                ksort($select_array);

                                foreach($select_array as $option) { ?>
                                    <li><a style="cursor: pointer" class="update_advertiser" data-display_string="<?php 
                                        echo $option['display_name']; ?>" data-display_code="<?php echo $option['user_code']; ?>" data-id="<?php echo $option['id']; ?>"><?php 
                                        echo $option['display_name']; 
                                        echo ' : ';
                                        echo $option['user_code'];
                                        ?></a></li><?php
                                } ?>
                                </ul>
                            </div>
                            <p class="label">Change Advertiser - Enter Code</p>
                            <input type="text" id="enter_advertiser_id">
                            <p id="enter_advertiser_id_feedback"></p>
                        </div>
                    </div>
                
                
                <h2 class="form_section_heading">Advert Details</h2>
                <?php
                // include details form
                include( ABSPATH . 'wp-content/themes/courses-and-jobs/inc/templates/classified-details-form.php'); ?>

                <input type="hidden" name="update_classified_ad_admin" value="true">
                <input type="hidden" name="advert-id" value="<?php echo ($cja_edit_ad->id); ?>">
            </div><?php
        } /*
    } ?>

    <!-- Javascript for edit post screens -->
    <script>

        jQuery(document).ready(function() {
            var advertiser_array = [];

            // Build array for search
            jQuery('.update_advertiser').each(function(index) {
                advertiser_array[index] = [];
                advertiser_array[index]['id'] = jQuery(this).data('id');
                advertiser_array[index]['user_code'] = jQuery(this).data('display_code');
                advertiser_array[index]['display_string'] = jQuery(this).data('display_string');
            });

            // click handler for list of advertisers
            jQuery('.update_advertiser').click(function() {
                jQuery('#show_advertiser').html(jQuery(this).data('display_string'));
                jQuery('#show_code').html(jQuery(this).data('display_code'));
                jQuery('#advertiser').val(jQuery(this).data('id'));
            });

            // input handler for when user types in code
            jQuery('#enter_advertiser_id').on('input', function(e) {
                // This version searches by ID not code
                // var the_input_id = jQuery('#enter_advertiser_id').val().match(/\d+/);
                var the_input_id = jQuery('#enter_advertiser_id').val();

                var the_result = advertiser_array.filter(function (advertiser) { return advertiser.user_code == the_input_id });
                
                if (the_result[0]) {
                    jQuery('#enter_advertiser_id_feedback').html(the_input_id + ': ' + the_result[0]['display_string']);
                    jQuery('#show_advertiser').html(the_result[0]['display_string']);
                    jQuery('#show_code').html(the_result[0]['user_code']);
                    jQuery('#advertiser').val(the_result[0]['id']);
                } else {
                    jQuery('#enter_advertiser_id_feedback').html(the_input_id + ': Not Recognised');
                }
            });

            // blur handler for code input box
            jQuery('#enter_advertiser_id').on('blur', function(e) {
                jQuery('#enter_advertiser_id').val('');
                jQuery('#enter_advertiser_id_feedback').html('');
            });

        }); 
    </script><?php

}

/**
 * Custom Edit User Fields
 */
add_action( 'edit_user_profile', 'display_admin_user_custom_cja_fields' );
function display_admin_user_custom_cja_fields( $user ) {

    // This is mainly duplicated from my-details-endpoint.php and if updated here should probably be updated there too. Should be wrapped up in a template DRY.

    echo '<h2>CJA User Fields</h2>';
    $cja_current_user_obj = new CJA_User($_GET['user_id']); ?>

<!-- IF USER IS ADVERTISER DISPLAY ADVERTISER DETAILS -->
<?php if($cja_current_user_obj->role == 'advertiser' || $cja_current_user_obj->role == 'administrator') { ?>
        <div id="poststuff"><div class="admin_edit_form">
            <p style="color: #666">ID: <?php echo get_cja_user_code($cja_current_user_obj->id); ?></p>
            <?php $cja_current_user_obj->display_form_field('company_name');

            // Show the actual or pending description
            if ($cja_current_user_obj->description_approved == 'pending') { ?>
                <p class="label">Company Description</p>
                <textarea name="company_description" cols="30" rows="10"><?php echo $cja_current_user_obj->pending_description; ?></textarea>
                <p style="margin-top: 0; color: #A00">Your profile is pending approval by our admin team. You will be notified by email when it is approved.</p><?php
            } else {
                $cja_current_user_obj->display_form_field('company_description'); 
            } ?>
            
            <div class="form_flexbox_2">
                <div><?php $cja_current_user_obj->display_form_field('contact_person'); ?></div>
                <div><?php $cja_current_user_obj->display_form_field('phone'); ?></div>
            </div>
            
            
            <?php $cja_current_user_obj->display_form_field('address'); ?>
            <?php $cja_current_user_obj->display_form_field('postcode'); ?>
        </div></div>

<!-- AND IF THEY ARE AN APPLICANT DISPLAY APPLICANT DETAILS -->	
<?php } else if ($cja_current_user_obj->role == 'jobseeker') { ?>
        <div id="poststuff"><div class="admin_edit_form">
            <p style="color: #666">ID: <?php echo get_cja_user_code($cja_current_user_obj->id); ?></p>

            <div class="form_flexbox_2">
                <div><?php $cja_current_user_obj->display_form_field('first_name'); ?></div>
                <div><?php $cja_current_user_obj->display_form_field('last_name'); ?></div>
            </div> 
            <div class="form_flexbox_2">
                <div><?php $cja_current_user_obj->display_form_field('town_city'); ?></div>
                <div><?php $cja_current_user_obj->display_form_field('phone'); ?></div>
            </div>

            
            <h2 class="form_section_heading mb-0">Photo</h2>
            <p class="muted">You can include an optional photo of yourself to display on your profile</p>
            <?php if ($cja_current_user_obj->photo_url == '') { ?> 
                <p class="label">Choose Photo (Accepted filetypes: .gif .jpg .jpeg .png)</p>
                <input type="file" name="photo">
            <?php } else { ?>
                <img src="<?php echo $cja_current_user_obj->photo_url; ?>" width="100px"; ><br>
                <p class="label">Change Photo (Accepted filetypes: .gif .jpg .jpeg .png)</p>
                <input type="file" name="photo">
                <p><input type="checkbox" name="delete_photo" value="true"> Delete Photo</p>
            <?php } ?>
            
            <h2 class="form_section_heading mb-0">Address and Postcode</h2>
            
            <p class="muted"><em>Your address and postcode will not be published. Your address is for office use only and your postcode is so we can show you opportunities in your area.</em></p><?php
            $cja_current_user_obj->display_form_field('address');
            $cja_current_user_obj->display_form_field('postcode'); ?>


            <h2 class="form_section_heading">About the Opportunities You're Looking For</h2><?php
            $cja_current_user_obj->display_form_field('opportunity_required');?>
            <div class="form_flexbox_2">
                <div><?php $cja_current_user_obj->display_form_field('course_time'); ?></div>
                <div><?php $cja_current_user_obj->display_form_field('job_time'); ?></div>
            </div>
            <div class="form_flexbox_2">
                <div><?php $cja_current_user_obj->display_form_field('job_role'); ?></div>
                <div><?php $cja_current_user_obj->display_form_field('cover_work'); ?></div>
            </div><?php 
            $cja_current_user_obj->display_form_field('weekends_availability');
            $cja_current_user_obj->display_form_field('specialism_area'); ?>
            <h2 class="form_section_heading">Education</h2>
            <div class="form_flexbox_2">
                <div><?php $cja_current_user_obj->display_form_field('gcse_maths'); ?></div>
                <div><?php $cja_current_user_obj->display_form_field('gcse_english'); ?></div>
            </div>
            <div class="form_flexbox_2">
                <div><?php $cja_current_user_obj->display_form_field('functional_maths'); ?></div>
                <div><?php $cja_current_user_obj->display_form_field('functional_english'); ?></div>
            </div><?php
            $cja_current_user_obj->display_form_field('highest_qualification'); ?>
            <h2 class="form_section_heading">Some More About You</h2>
            <div class="form_flexbox_2">
                <div><?php $cja_current_user_obj->display_form_field('age_category'); ?></div>
                <div><?php $cja_current_user_obj->display_form_field('current_status'); ?></div>
            </div>
            <div class="form_flexbox_2">
                <div><?php $cja_current_user_obj->display_form_field('unemployed'); ?></div>
                <div><?php $cja_current_user_obj->display_form_field('receiving_benefits'); ?></div>
            </div>
            <?php
            $cja_current_user_obj->display_form_field('contact_preference');
    ?>
            <h2 class="form_section_heading">Appear in Searches</h2>
            <p class="muted"><em>Our search features allow employers and course providers to search profiles and contact jobseekers and students who might be a good fit for their opportunity. We reccommend you choose to appear in searches for the type(s) of opportunity you're looking for.</em></p><?php
            $cja_current_user_obj->display_form_field('is_jobseeker');
            $cja_current_user_obj->display_form_field('is_student'); ?>
            <h2 class="form_section_heading">Profile and CV</h2>
            <p class="label">My Profile<br><em style="color: #999">Tell employers and course providers a bit about yourself and why they should choose you</em></p><?php
            
            // Show the actual or pending description
            if ($cja_current_user_obj->description_approved == 'pending') { ?>
                <textarea name="company_description" cols="30" rows="10"><?php echo $cja_current_user_obj->pending_description; ?></textarea>
                <p style="margin-top: 0; color: #A00">Your profile is pending approval by our admin team. You will be notified by email when it is approved.</p><?php
            } else {
                $cja_current_user_obj->display_form_field('company_description', false); 
            }
            
            ?>

            
            <h2 class="form_section_heading mb-0">Attachments</h2>
            <p class="muted">Any other documents you want employers or course providers to see e.g. your CV, portfolio etc.</p>

            <?php 
                if ($cja_current_user_obj->files_array) {
                    echo '<table class="attachments_table">';
                    echo '<thead><td>File</td><td class="center">Delete</td></thead>';
                    foreach($cja_current_user_obj->files_array as $file) {
                        ?><tr>
                            <td><?php echo $file['name']; ?></td>
                            <td class="center"><input type="checkbox" name="delete_files[]" value="<?php echo $file['url']; ?>"></td>
                            </tr>
                        <?php
                    }
                    echo '</table>';
                }

                if ($cja_current_user_obj->pending_files_array) { ?>

                    <p style="color: #900">The following files are pending approval by our admin team</p><?php
                    echo '<table class="attachments_table">';
                    echo '<thead><td>File</td><td class="center">Delete</td></thead>';
                    foreach($cja_current_user_obj->pending_files_array as $file) {
                        ?><tr>
                            <td><?php echo $file['name']; ?></td>
                            <td class="center"><input type="checkbox" name="delete_pending_files[]" value="<?php echo $file['url']; ?>"></td>
                            </tr>
                        <?php
                    }
                    echo '</table>';
                }
            ?>

            <p>Add more files<br>
            <input type="file" name="files[]" id="files" multiple></p>
        </div></div>

<?php } ?>
    <input type="hidden" name="cja_update_user_admin" value="true">
    <input type="hidden" name="cja_user_id" value="<?php echo $_GET['user_id']; ?>"><?php

}

/**
 * Add enctype to default admin form tags
 */
add_action( 'post_edit_form_tag' , 'post_edit_form_tag' );
function post_edit_form_tag( ) {
   echo ' enctype="multipart/form-data"';
}

add_action( 'user_edit_form_tag' , 'user_edit_form_tag' );
function user_edit_form_tag( ) {
   echo ' enctype="multipart/form-data"';
}

/**
 * Enqueue admin script
 */
add_action( 'admin_enqueue_scripts', 'enqueue_style_admin' );
function enqueue_style_admin() {
    wp_enqueue_style('admin_css', get_stylesheet_directory_uri() . '/style-admin.css');
}

/**
 * Update the author of a custom post from the admin
 * Activate ad if created from admin
 * See also update_post_from_admin()
 */
add_action( 'save_post', 'cja_update_author_from_admin');
function cja_update_author_from_admin() {
    
    if ($_POST['update_job_ad_admin']) {
        $values = array(
            'ID' => $_POST['advert-id'],
            'post_author' => strip_cja_code($_POST['advertiser'])
        );
        remove_action('save_post', 'cja_update_author_from_admin');
        wp_update_post($values);

        // If this is new then activate ad to create activation date, status etc.
        if ( !get_post_meta($_POST['advert-id'], 'cja_ad_status', true) ) {
            $new_ad = new CJA_Advert($_POST['advert-id']);
            $new_ad->activate();
            $new_ad->save();
        }

        add_action( 'save_post', 'cja_update_author_from_admin');
    }

    if ($_POST['update_course_ad_admin']) {
        $values = array(
            'ID' => $_POST['advert-id'],
            'post_author' => strip_cja_code($_POST['advertiser'])
        );
        remove_action('save_post', 'cja_update_author_from_admin');
        wp_update_post($values);

        // If this is new then activate ad to create activation date, status etc.
        if ( !get_post_meta($_POST['advert-id'], 'cja_ad_status', true) ) {
            $new_ad = new CJA_Course_Advert($_POST['advert-id']);
            $new_ad->activate();
            $new_ad->save();
        }
        add_action( 'save_post', 'cja_update_author_from_admin');
    }

    if ($_POST['update_classified_ad_admin']) {
        $values = array(
            'ID' => $_POST['advert-id'],
            'post_author' => strip_cja_code($_POST['advertiser'])
        );
        remove_action('save_post', 'cja_update_author_from_admin');
        wp_update_post($values);
        
        // If this is new then activate ad to create activation date, status etc.
        if ( !get_post_meta($_POST['advert-id'], 'cja_ad_status', true) ) {
            $new_ad = new CJA_Classified_Advert($_POST['advert-id']);
            $new_ad->activate();
            $new_ad->save();
        }
        add_action( 'save_post', 'cja_update_author_from_admin');
    }
}

/**
 * Remove unwanted fields from edit user screen
 */
remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );

if ( ! function_exists( 'cor_remove_personal_options' ) ) {

    function cor_remove_personal_options( $subject ) {
        $subject = preg_replace( '#<h2>Personal Options</h2>#s', '', $subject, 1 );
        $subject = preg_replace( '#<h2>Name</h2>#s', '', $subject, 1 );
        $subject = preg_replace( '#<h2>Contact Info</h2>#s', '', $subject, 1 );
        $subject = preg_replace( '#<h2>About the user</h2>#s', '', $subject, 1 );
        $subject = preg_replace( '#<h2>Account Management</h2>#s', '', $subject, 1 );
        return $subject;
    }

    function cor_profile_subject_start() {
        ob_start( 'cor_remove_personal_options' );
    }

    function cor_profile_subject_end() {
        ob_end_flush();
    }
}
add_action( 'admin_head', 'cor_profile_subject_start' );
add_action( 'admin_footer', 'cor_profile_subject_end' );


/**
 * Allows posts to be searched by ID in the admin area.
 * https://wordpress.stackexchange.com/questions/296566/how-to-search-post-by-id-in-wp-admin
 * 
 * @param WP_Query $query The WP_Query instance (passed by reference).
 */
add_action( 'pre_get_posts','wpse_admin_search_include_ids' );
function wpse_admin_search_include_ids( $query ) {
    // Bail if we are not in the admin area
    if ( ! is_admin() ) {
        return;
    }

    // Bail if this is not the search query.
    if ( ! $query->is_main_query() && ! $query->is_search() ) {
        return;
    }   

    // Get the value that is being searched.
    $search_string = get_query_var( 's' );

    // Bail if the search string is not an integer.
    if ( ! filter_var( $search_string, FILTER_VALIDATE_INT ) ) {
        return;
    }

    // Set WP Query's p value to the searched post ID.
    $query->set( 'p', intval( $search_string ) );

    // Reset the search value to prevent standard search from being used.
    $query->set( 's', '' );
}