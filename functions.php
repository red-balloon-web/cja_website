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
       'singular_name' => __( 'Job Advert' )
      ),
      'supports' => array (
          'title',
          'custom-fields'
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
       'singular_name' => __( 'Course Advert' )
      ),
      'supports' => array (
          'title',
          'custom-fields'
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
                'singular_name' => 'Classified Advert'
            ),
            'supports' => array(
                'title',
                'custom-fields'
            ),
            'public' => true,
            'has_archive' => false,
            'rewrite' => array('slug' => 'classifieds')
        )
    );

    // Application
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
    }
}

/**
 * CJA Admin Menu
 * Adds menu pages to admin
 */

function cja_admin_menu() {

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

    // Approve adverts page (manually approve new adverts)
    add_menu_page(
        'Approve Adverts',
        'Approve Adverts',
        'manage_options',
        'cja_approve_ads',
        'cja_approve_ads_content',
        'dashicons-yes',
        3
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

            // Display homepage or holding page ?>
            <p><input type="checkbox" name="display_homepage" <?php if (get_option('cja_display_homepage')) { echo 'checked'; } ?>> Display full homepage</p><?php

            // Display footer menu ?>
            <p><input type="checkbox" name="display_footer_menu" <?php if (get_option('cja_display_footer_menu')) { echo 'checked'; } ?>> Display footer menu</p>
            
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
    
    // Activate and save ads that have been approved by admin
    if ($_POST['cja_approve_ad']) {
        foreach($_POST['cja_approve_ad'] as $advert) {
            if (get_post_type($advert) == 'job_ad') {
                $approve_ad = new CJA_Advert($advert);
            } else if (get_post_type($advert) == 'course_ad') {
                $approve_ad = new CJA_Course_Advert($advert);
            } else if (get_post_type($advert) == 'classified_ad') {
                $approve_ad = new CJA_Classified_Advert($advert);
            }
            $approve_ad->activate();
            $approve_ad->save();
        }
    }

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
        <form action="<?php echo admin_url('admin.php?page=cja_approve_ads'); ?>" method="post">
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