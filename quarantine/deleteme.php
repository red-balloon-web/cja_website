


<!-- good -->
<h1><?php echo get_the_title(); ?></h1>
<h2><?php
    if ($user->role == 'admin') {
        // do something
    } ?>
</h2> 

<!-- bad -->
<h1><?php echo get_the_title(); ?></h1>
<h2>
    <?php if ($user->role == 'admin') {
        // do something
    }
    ?>
</h2>




<?php



$potential_client = new PotentialClient();
$potential_client->do_something();
do_something($potential_client);


// good
if ($_POST['website_address']) {
    update_post_meta($potential_client->id, 'website_address', $_POST['website_address']);
}

// bad
if ($_POST['website_address']) {
    update_post_meta($potential_client->id, 'client_url', $_POST['website_address']);
}



?>

<!-- introduction and photo (desktop) -->
<div class="rb-container-fullwidth about-us_intro-photo desktop"> 
    <div class="rb-container"> 
        <!-- desktop version goes in here -->
    </div>
</div>

<!-- introduction and photo (mobile) -->
<div class="rb-container-fullwidth about-us_intro-photo mobile"> 
    <div class="rb-container"> 
        <!-- mobile version goes in here -->
    </div>
</div>



<!-- promo video -->
<div class="rb-container-fullwidth about-us_video"> 
    <div class="rb-container"> 

        <!-- promo video section goes in here -->

    </div>
</div>

<!-- testimonials -->
<div class="rb-container-fullwidth about-us_testimonials"> 
    <div class="rb-container"> 

        <!-- testimonials section goes in here -->

    </div>
</div>







