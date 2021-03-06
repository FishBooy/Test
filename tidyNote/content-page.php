<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 */
?>

<div id="post-<?php the_ID(); ?>" <?php post_class('post-block'); ?>>
	<?php
		// Post thumbnail.
		tidyNote_post_thumbnail();
	?>

	<?php the_title( '<h1 class="post-title">', '</h1>' ); ?>

	<div class="post-body">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">页数:</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">页 </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php edit_post_link( '编辑', '<footer class="entry-footer"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>

</div><!-- #post-## -->
