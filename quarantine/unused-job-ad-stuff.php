
<!--
                <p><?php echo get_the_content(); ?></p>
                <?php if (get_post_meta(get_the_ID(), 'cja_ad_status', true) == 'active') { ?>
                    <p>Activated on <?php echo date('j F Y', get_post_meta(get_the_id(), 'cja_ad_activation_date', true)); ?> :: Expires on <?php echo date('j F Y', get_post_meta(get_the_id(), 'cja_ad_expiry_date', true)); ?></p> <?php
                } else if (get_post_meta(get_the_ID(), 'cja_ad_status', true) == 'inactive'){ ?>
                    <p>Not Activated</p>
                    <form action="<?php echo get_site_url() . '/my-account/job-ads'; ?>" method="POST">
                        <input type="hidden" name="activate-ad" value="<?php echo get_the_ID(); ?>">
                        <input type="submit" value="Activate Ad">
                    </form>
                    <p>You have <?php echo get_user_meta( get_current_user_id(), "cja_credits", true ); ?> advertising credits left</p>
                    
                     <?php

                } ?>
                

                /*
//date time playing around
echo ("<p>Today's date from PHP date function: " . date('j F Y') . "</p>");

$dt = strtotime(date('j F Y'));
$date_plus_one_month = date("j F Y", strtotime("+1 month", $dt));
echo ("<p>Today's date plus one month: " . $date_plus_one_month . "</p>");

$random_date = strtotime('7 July 2020');
$random_date_formatted = date('j F Y', $random_date);
echo ("<p>Random date: " . $random_date_formatted . "</p>");

if ($dt > $random_date) {
    echo ("<p>The random date is in the past</p>");
} else if ($dt < $random_date) {
    echo ("<p>The random date is in the future</p>");
} else if ($dt == $random_date) {
    echo ("<p>The random date is today</p>");
}
*/

-->


/**
 * REGISTER CUSTOM ACCOUNT ENDPOINTS
 */
add_action( 'init', 'register_custom_account_endpoints');
function register_custom_account_endpoints() {
    // add_rewrite_endpoint('job-ads', EP_ROOT | EP_PAGES);
}

/** 
 * REGISTER CUSTOM ACCOUNT ENDPOINT TABS
 */
add_filter('woocommerce_account_menu_items', function($items) {
	$logout = $items['customer-logout'];
	unset($items['customer-logout']);
    // $items['job-ads'] = 'My Job Adverts';
	$items['customer-logout'] = $logout;
	return $items;
});

/**
 * REGISTER CUSTOM ACCOUNT ENDPOINT CONTENT
 */

 /*
add_action('woocommerce_account_job-ads_endpoint', function() {

	/*$licenses = [];  // Replace with function to return licenses for current logged in user
	wc_get_template('myaccount/license-keys.php', [
		'licenses' => $licenses
    ]);*/
/*
    wc_get_template('myaccount/job-ads.php');
});

*/