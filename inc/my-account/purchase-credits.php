<?php $cja_current_user = new CJA_User; ?>

<?php if ($cja_current_user->role == 'advertiser') { ?>

<h1>Purchase Credits</h1>
<p><span class="credits-large"><?php echo ($cja_current_user->credits); ?></span>&nbsp;&nbsp;advert credits remaining</p>

<hr>

<div class="cja_buy_credits_list">
    <div class="cja_list_item">
        <a href="<?php echo get_site_url(); ?>/basket?add-to-cart=8" class="cja_button cja_button--2">Add to Cart</a>
        <p class="item-title">1 Credit: £30</p>
        <p class="item-meta">1 Course or Job Advert Credit</p>
    </div>
    <div class="cja_list_item">
        <a href="<?php echo get_site_url(); ?>/basket?add-to-cart=7" class="cja_button cja_button--2">Add to Cart</a>
        <p class="item-title">10 Credits: £150</p>
        <p class="item-meta">10 Course or Job Advert Credits</p>
    </div>
</div>

<h2 class="cja_margin_top">How it Works</h2>

<p>To place an advert on the site you need <strong>credits</strong>. It costs one credit to place an advert for one month. If you want to extend the advert you can extend it for one credit for each month it is extended.</p>
<p>Any questions? Contact Us!</p>

<?php } else if ($cja_current_user->role == 'jobseeker') { ?>

    <h1>Purchase Classified Ad Credits</h1>
    <p>Puchase advert credits to place classified ads.</p>
    <p><strong>You do not need to purchase credits to search and respond to adverts, only to place an advert of your own.</strong></p>

<?php } ?>