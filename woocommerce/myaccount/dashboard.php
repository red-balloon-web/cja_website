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
?>
<?php
$cja_current_user_obj = new CJA_User;
// print_r ($cja_current_user_obj);
?>

<h1>Account Dashboard</h1>
<?php // print_r($cja_current_user_obj); ?>

<?php 

if ($cja_current_user_obj->role == 'advertiser') {

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
	$job_ads = $sub_query->found_posts;
	// print_r ($sub_query);

	?>
		<p>Welcome, <strong><?php echo $cja_current_user_obj->display_name(); ?></strong>!</p>
		<p>You have <strong><?php echo $cja_current_user_obj->credits; ?></strong> advertising credits</p>
		<p>You have <strong><?php echo $job_ads; ?></strong> active job adverts</p>
		<p>To edit your company details as they will appear on your adverts, go to <a href="<?php echo get_site_url(); ?>/my-account/my-details">Public Details</a>.</p>
	<?php
} else if ($cja_current_user_obj->role == 'jobseeker') { ?>

<p>Welcome, <strong><?php echo $cja_current_user_obj->display_name(); ?></strong>!</p>
<p><strong>Job Search and Applications</strong><br>
It is FREE to search jobs and to apply online with your CV. To search for jobs just go to <a href="<?php echo get_site_url(); ?>/browse-jobs">Browse Jobs</a>.
</p>

<p><strong>Your Details and CV</strong><br>
Make sure your details are up to date and your latest CV is uploaded. These will be forwarded to employers when you make an application. To check and edit your details go to <a href="<?php echo get_site_url(); ?>/my-details">Public Details</a>.
</p>

<p><strong>Classified Ads and Credits</strong><br>
You will need to purchase credits if you want to place classified adverts. A classified ad credit costs £40. <a href="<?php echo get_site_url(); ?>/purchase-credits">Purchase Credits</a></p>
<p><em>You do not need to buy credits to search and apply to jobs and courses or to respond to other people's classified ads</em>
</p>

<?php } ?>



<?php
/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
