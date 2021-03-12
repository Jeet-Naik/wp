<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

$description = get_the_archive_description();
?>

<?php if ( have_posts() ) : ?>
	<header class="page-header alignwide">
		<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
		<?php if ( $description ) : ?>
			<div class="archive-description"><?php echo wp_kses_post( wpautop( $description ) ); ?></div>
		<?php endif; ?>
	</header><!-- .page-header -->
	<form method='get' action='#'>
	<center>
		<label>Select category: </label>
		<?php $get_categories = get_categories(array('taxonomy'=>'book_category')); ?>
		<select name="category">
			<option value='all'>All</option>
			<?php
			
			
			if ( $get_categories ) :
				
				foreach ( $get_categories as $cat ) :
					 if(isset($_GET['category'])){
						?>
						<option value="<?php echo $cat->slug; ?>"<?php selected( esc_html( $_GET['category'] ) ,$cat->slug); ?>>
						<?php
					}
					else{
						?>
						<option value="<?php echo $cat->slug; ?>">
						<?php
					}
			?>
			
			<?php echo $cat->name; ?>
			</option>
			<?php endforeach; 
				endif;
			?>
		</select>
		<br/><br/>
		<label>Select Price order: </label>
		<select name="price_srt">
			<option value="default">Default</option>
			<?php
			if(isset($_GET['price_srt'])){
				?><option value='ASC' <?php  selected( esc_html( $_GET['price_srt'] ),'ASC'); ?>>Low to High</option><?php
			}
			else{
				?><option value='ASC'>Low to High</option><?php
			} ?>

			<?php
			if(isset($_GET['price_srt'])){
				?><option value="DESC"  <?php selected( esc_html( $_GET['price_srt'] ),'DESC'); ?>>High to Low</option><?php
			}
			else{
				?><option value="DESC" >High to Low</option><?php
			} ?>		
		</select>
		<br/><br/>
		<input type="submit" value="Filter" name="submit">
	</center>
	</form>

	<!-- Anchor tags for filtering -->
	<!-- <div class="filter-custom-taxonomy">
	<center>
		<?php
			$terms = get_terms( 'book_category' );
			?>
			<h7><b>Select book category</h7></b></br>
			<a href="?getby=cat&cat=all">all</a>
			<?php
			foreach ( $terms as $term ) : ?>
			<a href="?getby=cat&cat=<?php echo esc_attr( $term->slug ); ?>">
				<?php echo esc_html( $term->name ); ?>
			</a>
		<?php endforeach; ?>
	</div> -->


	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<?php get_template_part( 'template-parts/content/content-book', get_theme_mod( 'display_excerpt_or_full_post', 'excerpt' ) ); ?>
		<!-- <h8><b>Price: </b><?php echo get_post_meta(get_the_ID(),'price',true)?></h8> -->
	<?php endwhile; ?>

	<?php twenty_twenty_one_the_posts_navigation(); ?>

<?php else : ?>
	<?php get_template_part( 'template-parts/content/content-none' ); ?>
<?php endif; ?>

<?php
if ( is_active_sidebar( 'custom-books-widget' ) ) : ?>
    <div id="header-widget-area" class="chw-widget-area widget-area" role="complementary">
    <?php dynamic_sidebar( 'custom-books-widget' ); ?>
    </div>
<?php endif; ?>

<?php get_footer();


?>
