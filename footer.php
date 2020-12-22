		</div><!-- .col-full -->
	</div><!-- #content -->

	<?php do_action( 'storefront_before_footer' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="col-full">

			<div class="address">
				<p>3 Oakfield House<br>
				Ilford<br>
				Essex<br>
				IG1 1EF<br>
				020 3475 9775</p>
			</div> <?php

			// Only display footer menu if enabled in admin
			if (get_option('cja_display_footer_menu')) { ?>
				<div class="links">
					<p>
						<a href="<?php echo get_site_url(); ?>/terms-and-conditions">Terms and Conditions</a><br>
						<a href="<?php echo get_site_url(); ?>/privacy-policy">Privacy Policy</a><br>
						<a href="<?php echo get_site_url(); ?>/cookie-policy">Cookie Policy</a><br><br>
						<a href="<?php echo get_site_url(); ?>/contact">Contact Us</a>
					</p>
				</div> <?php
			} 
		
			// do_action( 'storefront_footer' ); ?>
		</div>

		<div class="col-full copyright">
			<p>&#169 2020 Courses and Jobs Ltd. Registered in England and Wales, Reg Number 11958672. All rights reserved.</p>
		</div>
	</footer>

	<?php do_action( 'storefront_after_footer' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
