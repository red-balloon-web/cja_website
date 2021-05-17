</div><!-- .col-full -->
	</div><!-- #content -->

	<?php do_action( 'storefront_before_footer' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="col-full">
			<?php $sidebars_widgets  = wp_get_sidebars_widgets(); ?>
			<?php if(! empty( $sidebars_widgets[ 'footer-1' ] )) { ?>
				<div class="address">
					<?php dynamic_sidebar('footer-1'); ?>
				</div> 
			<?php } ?>
			<?php
			// Only display footer menu if enabled in admin
			/*if (get_option('cja_display_footer_menu')) { ?>
				<div class="address links">
					<p>
						<a href="<?php echo get_site_url(); ?>/terms-and-conditions">Terms and Conditions</a><br>
						<a href="<?php echo get_site_url(); ?>/privacy-policy">Privacy Policy</a><br>
						<a href="<?php echo get_site_url(); ?>/cookie-policy">Cookie Policy</a><br><br>
						<!--<a href="<?php echo get_site_url(); ?>/contact">Contact Us</a>-->
					</p>
				</div> <?php
			}*/ 
		
			// do_action( 'storefront_footer' ); ?>
			
			<?php if(! empty( $sidebars_widgets[ 'footer-2' ] )) { ?>
				<div class="address">
					<?php dynamic_sidebar('footer-2'); ?>
				</div> 
			<?php } ?>
			
			<?php if(! empty( $sidebars_widgets[ 'footer-3' ] )) { ?>
				<div class="address">
					<?php dynamic_sidebar('footer-3'); ?>
				</div> 
			<?php } ?>

			<?php if(! empty( $sidebars_widgets[ 'footer-4' ] )) { ?>
				<div class="address">
					<?php dynamic_sidebar('footer-4'); ?>
				</div> 
			<?php } ?>
		</div>
		
		<?php if(! empty( $sidebars_widgets[ 'footer-5' ] )) { ?>
			<div class="col-full copyright">
				<?php dynamic_sidebar('footer-5'); ?>
			</div> 
		<?php } ?>
	</footer>

	<?php do_action( 'storefront_after_footer' ); ?>

	<!-- Chris added a comment in here -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
