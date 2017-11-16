<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 */

get_header(); ?>

	<div class="site-content-content">

		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			/*
			 * Include the post format-specific template for the content. If you want to
			 * use this in a child theme, then include a file called called content-___.php
			 * (where ___ is the post format) and that will be used instead.
			 */
			get_template_part( 'content', get_post_format() );

			// Previous/next post navigation.
			the_post_navigation( array(
				'next_text' => '<span class="screen-reader-text">下一篇</span> ' .
					'<span>%title</span>'.
					'<span class="meta-nav" aria-hidden="true"> <i class="iconfont icon-arrow-right"></i></span> ' ,
				'prev_text' => '<span class="meta-nav" aria-hidden="true"><i class="iconfont icon-arrow-left1"></i></span> ' .
					'<span class="screen-reader-text">上一篇</span> ' .
					'<span>%title</span>',
			) );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;



		// End the loop.
		endwhile;
		?>

	</div><!-- .content-area -->

<?php get_footer(); ?>
