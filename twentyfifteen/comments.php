<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	<div class="comments-area-wrap">

		<?php if ( have_comments() ) : ?>
			<h2 class="comments-title">
				<?php
					printf( '<i class="iconfont icon-mark"></i>共有 %1$s 条评论', get_comments_number());
				?>
			</h2>

			<?php twentyfifteen_comment_nav(); ?>

			<ol class="comment-list">
				<?php
					wp_list_comments( array(
						'style'       => 'ol',
						'short_ping'  => true,
						'avatar_size' => 56,
					) );
				?>
			</ol><!-- .comment-list -->

			<?php twentyfifteen_comment_nav(); ?>

		<?php endif; // have_comments() ?>

		<?php
			// If comments are closed and there are comments, let's leave a little note, shall we?
			if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
			<p class="no-comments"><?php _e( 'Comments are closed.', 'twentyfifteen' ); ?></p>
		<?php endif; ?>

		<?php comment_form(array(
			'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title"><i class="iconfont icon-edit"></i>',
			'title_reply_after'    => '</h3>'
		)); ?>

	</div>

</div><!-- .comments-area -->
