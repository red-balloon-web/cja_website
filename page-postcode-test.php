<?php

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<h1>Postcode Test</h1>

			<?php

			//$user = new CJA_User(39);
			//print_r($user);
			//echo $user->email;
/*
				$to = 'chris@chrisdann.com';
				$subject = 'The subject';
				$body = 'The email body content';
				$headers = array('Content-Type: text/html; charset=UTF-8');
				
				echo (wp_mail( $to, $subject, $body, $headers ));

*/
				//$get_attachment = new CJA_User(39);
				//print_r($get_attachment);

				$details = array(
					'to' => 'chrisdwac@gmail.com',
					'subject' => 'This is my test email',
					'body' => "Hello this is the body \n\nof my \n\nemail"
				);
				cja_sendmail($details);
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//do_action( 'storefront_sidebar' );
get_footer();
