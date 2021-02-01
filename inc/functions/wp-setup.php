<?php
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