<?php
/*
Template Name: Book list
*/
get_header();

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

$today = date( 'Y-m-d' );
$customQuery = new WP_Query(
	array(
		'post_type' => 'book', 
		'posts_per_page' => 2,
		'paged' => $paged ,
		'date_query' => array(
			//set date ranges with strings!
			'after' => 'today',
			//allow exact matches to be returned
			'inclusive'         => true,
		),
	)
);
?>

<div class="wrap">
 
 <div id="primary" class="content-area">
	 
	 <main id="main" class="site-main" role="main">
	 
		 <?php
		 
		 if($customQuery->have_posts() ): 
		 
			while($customQuery->have_posts()) :
				
					$customQuery->the_post();
					
					  global $post;
			 ?>
	 
			   <div class ="inner-content-wrap">
			   
					 <ul class ="cq-posts-list">
					 
					  <li>
						<h3 class ="cq-h3"><a href="<?php the_permalink(); ?>" ><?php the_title(); ?></a></h3>
							 <div>
							   <ul>
								 <div>
										 <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
								 </div>
							   </ul>
							   
							   <ul>
										 <p><?php echo the_content(); ?></p>
							   </ul>
							 
							 </div>
					   </li>
					 </ul>
			 </div> <!-- end blog posts -->
					   
		 <?php endwhile; 
		 
	  endif; 
  
		  wp_reset_query();
		  
		 // Step  3 : Call the Pagination Function Here  
		  
		 if (function_exists("cq_pagination")) {
			 
			   cq_pagination($customQuery->max_num_pages);
		  
		 }
				 
		 ?>	
 
		 </main><!-- #main -->
		 
	 </div><!-- #primary -->
		 
 </div><!-- .wrap -->
 
<!----end of page-------->
<?php
get_footer();
