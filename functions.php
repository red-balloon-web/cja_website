<?php


// Load config and classes
include('config.php');
include('inc/class-cja-advert.php');
include('inc/class-cja-course-advert.php');
include('inc/class-cja-classified-advert.php');
include('inc/class-cja-user.php');
include('inc/class-cja-application.php');
include('inc/class-cja-course-application.php');

// Other functions
include('inc/functions/wp-setup.php'); // Post types, user roles, menus
include('inc/functions/form-processing-admin.php'); // Admin form processing
include('inc/functions/form-processing-frontend.php'); // Frontend form processing
include('inc/functions/woocommerce.php'); // WooCommerce functions and my-account endpoints
include('inc/functions/daily-admin.php'); // Daily functions (check for expiration etc)

include('inc/functions/search-cookies.php'); // Set search cookies (client disabled)
include('inc/functions/wp-admin-menu.php'); // Set up our custom admin menus (loads child pages)

// CSV Creation functions
include('inc/functions/csv/monitoring-csv.php'); // Admin monitoring screen CSV
include('inc/functions/csv/job-applicants-csv.php'); // Job Applicants CSV
include('inc/functions/csv/course-applicants-csv.php'); // Course Applicants CSV



/**
 * REMOVE SIDEBAR
 */

function dano_remove_sidebar() {
    return false;
}
add_filter( 'is_active_sidebar', 'dano_remove_sidebar', 10, 2 );

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

// Send email if there is a new advert waiting for admin approval
function new_ad_email($title) {
    $to = get_option('admin_email');
    $subject = 'New advert for approval';
    $message = 'There is a new advert, ' . $title . ', awaiting approval at Courses and Jobs Advertiser';
    wp_mail($to, $subject, $message);
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