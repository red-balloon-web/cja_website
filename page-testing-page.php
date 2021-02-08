<?php

get_header();

$advert = new CJA_Advert(679);
$message = preg_replace('/%ad-title%/', $advert->title, stripslashes(get_option('advert_running_out_email_message')));
$message = preg_replace('/%expiry-date%/', date("j F", $advert->expiry_date), $message);
$login_link = '<a href="' . get_site_url() . '/my-account">Log in to your account</a>';
$message = preg_replace('/%login-link%/', $login_link, $message);
echo $message;

echo strtotime(date("j F Y"));

//return date("j F Y", $this->activation_date);


get_footer();