<?php

/**
 * INCLUDE CONFIG AND OBJECTS
 */

include('config.php');
include('inc/class-cja-advert.php');
include('inc/class-cja-user.php');
include('inc/class-cja-application.php');

/**
 * REMOVE SIDEBAR
 */

function dano_remove_sidebar() {
    return false;
}

add_filter( 'is_active_sidebar', 'dano_remove_sidebar', 10, 2 );

/**
 * ENQUEUE STYLESHEET
 */

 add_action( 'wp_enqueue_scripts', 'enqueue_child_scripts');
 function enqueue_child_scripts() {
     // wp_enqueue_style( 'child_stylesheet', get_stylesheet_uri() );
     // commented out because it was loading it twice
 }


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
      'public' => true,
      'has_archive' => false,
      'rewrite' => array('slug' => 'jobs'),
     )
    );

    // Application
    register_post_type( 'application',
        array(
            'labels' => array(
                'name' => 'Applications',
                'singular_name' => 'Application'
            ),
            'public' => true,
            'has_archive' => false,
            'rewrite' => array('slug' => 'applications')
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

function cja_custom_menus($menus) {
    $menus['loggedout-primary'] = 'Main Menu Logged Out';
    $menus['jobseeker-primary'] = 'Main Menu Applicant';
    $menus['advertiser-primary'] = 'Main Menu Advertiser';
    return $menus;
}

add_filter( 'storefront_register_nav_menus', 'cja_custom_menus');

function cja_primary_navigation() {
    ?>
    <!-- CJA PRIMARY NAVIGATION STARTS HERE -->
    <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_html_e( 'Primary Navigation', 'storefront' ); ?>">
    <button class="menu-toggle" aria-controls="site-navigation" aria-expanded="false"><span><?php echo esc_attr( apply_filters( 'storefront_menu_toggle_text', __( 'Menu', 'storefront' ) ) ); ?></span></button>
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
        }
    ?>
    </nav><!-- #site-navigation -->
    <?php
}

/**
 * WOOCOMMERCE MY ACCOUNT
 */

 /*
add_filter( 'woocommerce_account_menu_items', 'bbloomer_remove_address_my_account', 999 );
function bbloomer_remove_address_my_account( $items ) {
    unset($items['edit-address']);
    return $items;
}
add_action( 'woocommerce_account_edit-account_endpoint', 'woocommerce_account_edit_address' );
*/

//Remove required field requirement for first/last name in My Account Edit form
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
}
  
  
// 2. Add new query var
  
add_filter( 'query_vars', 'cja_my_details_query_vars', 0 );
function cja_my_details_query_vars( $vars ) {
    $vars[] = 'my-details';
    $vars[] = 'purchase-credits';
    return $vars;
}
  
  
// 3. Insert the new endpoint into the My Account menu
  
function cja_order_woocommerce_account_menu( $items ) {
    unset ($items['orders']);
    unset ($items['subscriptions']);
    unset ($items['edit-address']);
    unset ($items['edit-account']);
    unset ($items['customer-logout']);


    $items['purchase-credits'] = 'Purchase Credits';
    $items['my-details'] = 'Public Details';
    $items['edit-account'] = 'Email / Password';
    $items['orders'] = 'My Purchases';
    
    // only display subscriptions tab to advertisers
    $the_current_user = new CJA_User;
    if ($the_current_user->role == 'advertiser') {
        $items['subscriptions'] = 'Subscriptions';
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
// Note: add_action must follow 'woocommerce_account_{your-endpoint-slug}_endpoint' format

/*
add_filter( 'woocommerce_endpoint_my-details_title', 'change_my_account_my_details_title', 10, 2 );
function change_my_account_my_details_title( $title, $endpoint ) {
    $title = __( "Public Details", "woocommerce" );
    return $title;
}  

add_filter( 'woocommerce_endpoint_edit-account_title', 'change_my_account_edit_account_title', 10, 2 );
function change_my_account_edit_account_title( $title, $endpoint ) {
    $title = __( "Edit Email Address and Password", "woocommerce" );
    return $title;
}

add_filter( 'woocommerce_endpoint_edit-address_title', 'change_my_account_edit_address_title', 10, 2 );
function change_my_account_edit_address_title( $title, $endpoint ) {
    $title = __( "Billing Details", "woocommerce" );
    return $title;
}
*/

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
        //header("refresh:0.5;url=".$_SERVER['REQUEST_URI']."");
        //header("refresh:0.5;url=".get_page_link()."");
    }
}
add_action('init', 'logoutUser');

/**
 * ADD PURCHASED CREDITS
 * Adds purchased credits to user meta on checkout completion
 */

add_action( 'woocommerce_before_thankyou', 'add_purchased_credits' );
function add_purchased_credits( $order_id ){

    $cja_order = new WC_Order( $order_id );

    if ( $cja_order->has_status( 'failed' ) ) {
        exit;
    }
    
    if( ! get_post_meta( $order_id, 'cja_credits_added', true ) ) { // prevent user re-adding by refreshing page
        
        $order = wc_get_order( $order_id );
        $new_credits = 0;
        
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
        }

        $user_id = get_current_user_id();
        $current_credits = get_user_meta( $user_id, "cja_credits", true );
        $new_total_credits = $new_credits + $current_credits;
        update_user_meta( $user_id, "cja_credits", $new_total_credits );
        update_post_meta( $order_id, 'cja_credits_added', true );

        include('config.php');

        ?><p class="cja_alert cja_alert--success">Thank you for your order. <?php echo ($new_credits . " credits were added to your account. You now have " . $new_total_credits . " credits."); ?></p>
        <p><a href="<?php echo get_site_url() . '/' . $cja_config['my-job-ads-slug']; ?>" class="cja_button cja_button--2">My Job Adverts</a></p>
        <?php
    
    }
}

add_filter( 'woocommerce_thankyou_order_received_text', 'remove_thankyou' );
function remove_thankyou() {
    return '';
}

/**
 * SPEND CREDITS
 */

function spend_credits( $spend = 1 ) {
    $credits = get_user_meta( get_current_user_id(), "cja_credits", true);
	$credits = $credits - $spend;
	update_user_meta( get_current_user_id(), "cja_credits", $credits);
}

/**
 * REDIRECT ON LOGIN
 */

function my_login_redirect( $redirect_to, $request, $user ) {
            return get_site_url() . '/my-account';
}
 
add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );

/**
 * SAVE SEARCH COOKIES
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
    }
}

/**
 * PAGINATION
 */

add_filter( 'paginate_links', function( $link )
    {

    if (filter_input( INPUT_GET, 'extend-ad') ) {
        $link = remove_query_arg( 'extend-ad', $link );
    }
    if (filter_input( INPUT_GET, 'delete-ad') ) {
        $link = remove_query_arg('delete-ad', $link);
    }
    return $link;
    
}
    /*return  
       filter_input( INPUT_GET, 'extend-ad' )
       ? remove_query_arg( 'extend-ad', $link )
       : $link;
    } */
);