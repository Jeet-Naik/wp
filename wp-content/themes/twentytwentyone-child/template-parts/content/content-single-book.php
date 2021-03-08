<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header alignwide">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php twenty_twenty_one_post_thumbnail(); ?>
	</header>
	<?php
	$user = wp_get_current_user();
    if (in_array('administrator', (array) $user->roles)) 
         {
    ?>
    <center>
    <label for="price">Price: </label>
    <input type="text" name="price" id="price" value="<?php echo get_post_meta(get_the_ID(),'price',true); ?>"/>
	<input type="hidden" name="pid" id="pid" value="<?php echo get_the_ID(); ?>" />
	<button  name="btnUpdate" id="btnUpdate">Update</button>
	<br/>
	<?php if(get_post_meta(get_the_ID(),'pdate',true) != "") 
	{?>
	
			<label for="price">Publish Date: </label>
			<span><?php echo get_post_meta(get_the_ID(),'pdate',true); ?></span>
	<?php } ?>
    </center>
    <?php
         }
		 else
		 {
			 ?>
			 <center>
			<label for="price">Price: </label>
			<span><?php echo get_post_meta(get_the_ID(),'price',true); ?></span>
			<br/>
			<label for="price">Publish Date: </label>
			<span><?php echo get_post_meta(get_the_ID(),'pdate',true); ?></span>
			</center>
			<?php
		 }
?>
	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before'   => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'twentytwentyone' ) . '">',
				'after'    => '</nav>',
				/* translators: %: page number. */
				'pagelink' => esc_html__( 'Page %', 'twentytwentyone' ),
			)
		);
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer default-max-width">
		<?php twenty_twenty_one_entry_meta_footer(); ?>
	</footer><!-- .entry-footer -->

	<?php if ( ! is_singular( 'attachment' ) ) : ?>
		<?php get_template_part( 'template-parts/post/author-bio' ); ?>
	<?php endif; ?>

</article><!-- #post-<?php the_ID(); ?> -->
