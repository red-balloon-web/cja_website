<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$cja_current_user_obj = new CJA_User; ?>

<h1>Account Dashboard</h1><?php

// display dashboard for advertisers / admins
if ($cja_current_user_obj->role == 'advertiser' || $cja_current_user_obj->role == 'administrator') {

	$query_args = array(
		'post_type' => 'job_ad',
		'author' => $cja_current_user_obj->id,
		'meta_query' => array(
			array(
				'key' => 'cja_ad_status',
				'value' => 'active'
			)
		)
	);
	
	$sub_query = new WP_Query($query_args);
	$job_ads = $sub_query->found_posts; ?>

		<p style="color: #00A">We are currently updating and revamping our search and application submission functionality and this will be restored soon. In the meantime, your opportunities will be made available regularly via text alerts and emails</p>
		<!-- temporarily disabled by client
		<p>Welcome, <strong><?php echo $cja_current_user_obj->display_name(); ?></strong>!</p>
		<p>You have <strong><?php echo $cja_current_user_obj->credits; ?></strong> job and course advert credits</p>
		<p>You have <strong><?php echo $cja_current_user_obj->classified_credits; ?></strong> classified advert credits</p>
		<p>You have <strong><?php echo $job_ads; ?></strong> active job adverts</p>
		<p>To edit your company details as they will appear on your adverts, go to <a href="<?php echo get_site_url(); ?>/my-account/my-details">Public Details</a>.</p>--><?php

// display dashboard for job / course applicants
} else if ($cja_current_user_obj->role == 'jobseeker') { ?>

<p>Welcome, <strong><?php echo $cja_current_user_obj->display_name(); ?></strong>!</p>
<p><!--<strong>Job Search and Applications</strong><br>-->
<!-- It is FREE to search jobs and to apply online with your CV. Search functionality will be coming soon. To search for jobs or courses just go to <a href="<?php echo get_site_url(); ?>/search-jobs">Search Jobs</a> or <a href="<?php echo get_site_url(); ?>/search-courses">Search Courses</a>.-->
<span style="color: #00A">We are currently updating and revamping our search functionality, therefore, the search option will be restored soon.  In the meantime, ensure to respond to opportunities alerts sent by text and email.</span>
</p>

<!-- temporarily disabled by client
<p><strong>Your Details and CV</strong><br>
Make sure your details are up to date and your latest CV is uploaded. These will be forwarded to employers when you make an application. To check and edit your details go to <a href="<?php echo get_site_url(); ?>/my-account/my-details">Your Profile</a>.
</p>

<p><strong>Classified Ads and Credits</strong><br>
You will need to purchase credits if you want to place classified adverts. A classified ad credit costs £40. <a href="<?php echo get_site_url(); ?>/my-account/purchase-credits">Purchase Credits</a></p>
<p><em>You do not need to buy credits to search and apply to jobs and courses or to respond to other classified ads</em>
</p>-->

<?php } 

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
