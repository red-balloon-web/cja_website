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
?>

<h1>Account Dashboard</h1>
<?php // print_r($cja_current_user_obj); ?>

<?php 

if ($cja_current_user_obj->role == 'advertiser') {
	?>
		<p>You have <?php echo $cja_current_user_obj->credits; ?> advertising credits</p>
		<p>To edit your company details as they will appear on your adverts, go to <a href="<?php echo get_site_url(); ?>/my-account/my-details">Public Details</a></p>
	<?php
} ?>

<?php
/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
