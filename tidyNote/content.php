<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 */
?>

<div id="post-<?php the_ID(); ?>" <?php post_class('post-block'); ?>>
	<?php
		// Post thumbnail.
		tidyNote_post_thumbnail();
	?>

		<?php
			if ( is_single() ) :
				the_title( '<h1 class="post-title">', '</h1>' );
				echo '<div class="post-info">';
				tidyNote_entry_meta();
				edit_post_link('编辑', '<span class="edit-link">', '</span>' );
				echo '</div>';
			else :
				the_title( sprintf( '<h2 class="post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			endif;
		?><!-- .entry-header -->

		<div class="post-body">
			<?php
				/* translators: %s: Name of current post */
				the_content( sprintf(
					'全文<i class="iconfont icon-pullright"></i>',
					the_title( '<span class="screen-reader-text">', '</span>', false )
				) );

				wp_link_pages( array(
					'before'      => '<div class="page-links"><span class="page-links-title">页数:</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
					'pagelink'    => '<span class="screen-reader-text">页</span>%',
					'separator'   => '<span class="screen-reader-text">, </span>',
				) );
			?>
		</div><!-- .entry-content -->

		<?php
			// Author bio.
			if ( is_single() && get_the_author_meta( 'description' ) ) :
				get_template_part( 'author-bio' );
			endif;
		?>

		<?php
			if ( !is_single() ) :
				echo '<div class="post-info">';
				tidyNote_entry_meta();
				edit_post_link('编辑', '<span class="edit-link">', '</span>' );
				echo '</div>';
			endif;
		?>

</div><!-- #post-## -->
