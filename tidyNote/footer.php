<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 */
?>


	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<a href="https://wordpress.org/" class="wp-copy">Powered by Wordpress <i class="iconfont icon-wordpress"></i> </a>
			<?php
				/**
				 * Fires before the  footer text for footer customization.
				 *
				 */
				echo '<span class="icp-info">备案号 ';
				zh_cn_l10n_icp_num();
				echo '</span>';
			?>
		</div><!-- .site-info -->
	</footer><!-- .site-footer -->

</div><!-- .site -->

<?php wp_footer(); ?>

</body>
</html>
