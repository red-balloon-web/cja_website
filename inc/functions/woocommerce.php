<?php
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
    $items['edit-account'] = 'Change Password';
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
    include('wc-endpoints/my-details-endpoint.php');
}

add_action( 'woocommerce_account_purchase-credits_endpoint', 'cja_purchase_credits_content' );
function cja_purchase_credits_content() {
    include('wc-endpoints/purchase-credits.php');
}

add_action( 'woocommerce_account_purchase-subscriptions_endpoint', 'cja_purchase_subscriptions_content' );
function cja_purchase_subscriptions_content() {
    include('wc-endpoints/purchase-subscriptions.php');
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