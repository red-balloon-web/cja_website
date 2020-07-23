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
        } else if ($cja_current_user_obj->role == 'advertiser') {
            wp_nav_menu(
                array(
                    'theme_location' => 'advertiser-primary',
                    'container_class' => 'primary-navigation',
                )
            );
        } else if ($cja_current_user_obj->role == 'jobseeker') {
            wp_nav_menu(
                array(
                    'theme_location' => 'jobseeker-primary',
                    'container_class' => 'primary-navigation',
                )
            );
        }
        
        /*wp_nav_menu(
            array(
                'theme_location'  => 'primary',
                'container_class' => 'primary-navigation',
            )
        );

        wp_nav_menu(
            array(
                'theme_location'  => 'handheld',
                'container_class' => 'handheld-navigation',
            )
        );*/
        ?>
    </nav><!-- #site-navigation -->
    <?php
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

add_action( 'woocommerce_thankyou', 'add_purchased_credits' );
function add_purchased_credits( $order_id ){
    
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

        echo ($new_credits . " credits were added to your account. You now have " . $new_total_credits . " credits.");
    
    }
}

/**
 * SPEND CREDITS
 */

function spend_credits( $spend = 1 ) {
    $credits = get_user_meta( get_current_user_id(), "cja_credits", true);
	$credits = $credits - $spend;
	update_user_meta( get_current_user_id(), "cja_credits", $credits);
}


?>