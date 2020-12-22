<?php 
get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main"><?php

		while ( have_posts() ) :
			the_post();

			$cja_current_user_obj = new CJA_User();
			$cja_current_ad = new CJA_Classified_Advert(get_the_ID());
			$display_advert = true;

			// Send email from form if form sent to page
			if ($_POST['process_contact_form']) {
				$mail_to = $_POST['send_to_address'];
				if ($_POST['subject'] == 'enquiry') {
					$mail_subject = 'New enquiry for your classified ad "' . $cja_current_ad->title . '" from ' . $_POST['sender'];
				} else if ($_POST['subject'] == 'bid') {
					$mail_subject = 'New bid/proposal for your classified ad "' . $cja_current_ad->title . '" from ' . $_POST['sender'];
				}
				$mail_message = $_POST['message'];
				$mail_headers = 'Reply-To: ' . $_POST['reply_to_address'];
				$mail_success = wp_mail($mail_to, $mail_subject, $mail_message, $mail_headers);

				if ($mail_success) {
					?><p class="cja_alert cja_alert--success cja_center">Your email was sent</p><?php
				} else {
					?><p class="cja_alert cja_alert--amber">There was a problem sending your email. Please contact the advertiser directly.</p><?php
				}
			}

			// Display the ad if we're displaying it
			if ($display_advert) {
			
				// Display user messages
				if ($cja_current_ad->created_by_current_user) {
					if ($cja_current_ad->status == 'inactive') {?>
						<p class="cja_alert cja_alert--amber">This Advert Is a Draft</p><?php
					}
					if ($cja_current_ad->status == 'deleted') {?>
						<p class="cja_alert cja_alert--red">This Advert Has Been Deleted</p><?php
					}
				}
		
				$cja_current_advertiser = new CJA_User($cja_current_ad->author); ?>
				<h1 class="with-subtitle"><?php echo $cja_current_ad->title; ?></h1><?php 
				if ($cja_current_ad->status == 'deleted') {?>
					<p class="red"><strong>This advert has been deleted</strong></p><?php 
				} ?>
				<p class="cja_center header_subtitle">Posted by <?php echo ($cja_current_ad->author_human_name); 
					if ($cja_current_ad->status == 'active') {
						echo ' on ' . ($cja_current_ad->human_activation_date); 
					} ?>
				</p><?php 
				
				include('inc/templates/classified-details.php');

				/**
				 * DISPLAY USER OPTIONS
				 * 
				 * ADVERTISER
				 *  - Activate
				 *  - Edit
				 *  - Extend
				 *  - Delete
				 */
				include('inc/single-classified-ad/display-user-options.php');
			}

			// Contact Form ?>
			<h2 class="form_section_heading mb-0">Contact The Advertiser</h2>
			<p class="muted">Your email address will be sent with your message</p>
			<form action="<?php echo get_the_permalink(); ?>" method="post">
				<p class="label">Subject</p>
				<select name="subject">
					<option value="enquiry">Make an enquiry</option>
					<option value="bid">Make a bid or proposal</option>
				</select>
				<p class="label">Your Message</p>
				<textarea name="message" id="" cols="30" rows="10"></textarea>
				<input type="hidden" name="process_contact_form" value="true">
				<input type="hidden" name="send_to_address" value="<?php echo $cja_current_advertiser->email; ?>">
				<input type="hidden" name="reply_to_address" value="<?php echo $cja_current_user_obj->email; ?>">
				<input type="hidden" name="sender" value="<?php echo $cja_current_user_obj->display_name(); ?>">
				<input type="submit" class="cja_button cja_button--2" value="Send Email">
			</form><?php 
			
		endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//do_action( 'storefront_sidebar' );
get_footer();
