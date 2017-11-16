<?php
/**
 * Custom template tags for tidyNote
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package WordPress
 */

if ( ! function_exists( 'tidyNote_comment_nav' ) ) :
/**
 * Display navigation to next/previous comments when applicable.
 */
function tidyNote_comment_nav() {
	// Are there comments to navigate through?
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
	?>
	<nav class="navigation comment-navigation" role="navigation">
		<h2 class="screen-reader-text">评论导航</h2>
		<div class="nav-links">
			<?php
				if ( $prev_link = get_previous_comments_link( '较早评论' ) ) :
					printf( '<div class="nav-previous">%s</div>', $prev_link );
				endif;

				if ( $next_link = get_next_comments_link( '较新评论' ) ) :
					printf( '<div class="nav-next">%s</div>', $next_link );
				endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .comment-navigation -->
	<?php
	endif;
}
endif;

if ( ! function_exists( 'tidyNote_entry_meta' ) ) :
/**
 * Prints HTML with meta information for the categories, tags.
 */
function tidyNote_entry_meta() {
	if ( is_sticky() && is_home() && ! is_paged() ) {
		printf( '<span class="sticky-post"><i class="iconfont icon-favorfill"></i> 置顶</span>');
	}

	$format = get_post_format();
	if ( current_theme_supports( 'post-formats', $format ) ) {
		printf( '<span class="entry-format"><span class="screen-reader-text">格式 </span><i class="iconfont icon-text"></i> <a href="%1$s">%2$s</a></span>',
			esc_url( get_post_format_link( $format ) ),
			get_post_format_string( $format )
		);
	}

	if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			get_the_date(),
			esc_attr( get_the_modified_date( 'c' ) ),
			get_the_modified_date()
		);

		printf( '<span class="post-info-date"><i class="iconfont icon-time"></i><span class="screen-reader-text">发布于</span> %1$s</span>',
			$time_string
		);
	}

	if ( 'post' == get_post_type() ) {
		if ( is_singular() || is_multi_author() ) {
			printf( '<span class="byline"><i class="iconfont icon-my"></i> <span class="screen-reader-text">作者 </span><a class="url fn n" href="%1$s">%2$s</a></span>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				get_the_author()
			);
		}

		$categories_list = get_the_category_list(', ');
		if ( $categories_list && tidyNote_categorized_blog() ) {
			printf( '<span class="cat-links"><i class="iconfont icon-copy"></i><span class="screen-reader-text">分类 </span> %1$s</span>',
				$categories_list
			);
		}

		$tags_list = get_the_tag_list( '', ', ' );
		if ( $tags_list ) {
			printf( '<span class="tags-links"><i class="iconfont icon-tag"></i> <span class="screen-reader-text">标签 </span>%1$s</span>',
				$tags_list
			);
		}
	}

	if ( is_attachment() && wp_attachment_is_image() ) {
		// Retrieve attachment metadata.
		$metadata = wp_get_attachment_metadata();

		printf( '<span class="full-size-link"><span class="screen-reader-text">原始尺寸 </span><a href="%1$s">%2$s &times; %3$s</a></span>',
			esc_url( wp_get_attachment_url() ),
			$metadata['width'],
			$metadata['height']
		);
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link"><i class="iconfont icon-mark"></i> ';
		/* translators: %s: post title */
		comments_popup_link( sprintf( '留下评论<span class="screen-reader-text"> on %s</span>', get_the_title() ) );
		echo '</span>';
	}
}
endif;

/**
 * Determine whether blog/site has more than one category.
 *
 * @return bool True of there is more than one category, false otherwise.
 */
function tidyNote_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'tidyNote_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'tidyNote_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 || is_preview() ) {
		// This blog has more than 1 category so tidyNote_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so tidyNote_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in {@see tidyNote_categorized_blog()}.
 */
function tidyNote_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'tidyNote_categories' );
}
add_action( 'edit_category', 'tidyNote_category_transient_flusher' );
add_action( 'save_post',     'tidyNote_category_transient_flusher' );

if ( ! function_exists( 'tidyNote_post_thumbnail' ) ) :
/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 *
 */
function tidyNote_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
	?>

	<div class="post-thumbnail">
		<?php the_post_thumbnail(); ?>
	</div><!-- .post-thumbnail -->

	<?php else : ?>

	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
		<?php
			the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title() ) );
		?>
	</a>

	<?php endif; // End is_singular()
}
endif;

if ( ! function_exists( 'tidyNote_get_link_url' ) ) :
/**
 * Return the post URL.
 *
 * Falls back to the post permalink if no URL is found in the post.
 *
 * @see get_url_in_content()
 *
 * @return string The Link format URL.
 */
function tidyNote_get_link_url() {
	$has_url = get_url_in_content( get_the_content() );

	return $has_url ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}
endif;

if ( ! function_exists( 'tidyNote_excerpt_more' ) && ! is_admin() ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and a 'Continue reading' link.
 *
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function tidyNote_excerpt_more( $more ) {
	$link = sprintf( '<a href="%1$s" class="more-link">%2$s</a>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( 'Continue reading %s', '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>' )
		);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'tidyNote_excerpt_more' );
endif;

if ( ! function_exists( 'tidyNote_the_custom_logo' ) ) :
/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 */
function tidyNote_the_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}
endif;
