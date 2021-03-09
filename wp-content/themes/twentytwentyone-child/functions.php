<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    $parenthandle = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.
    $theme = wp_get_theme();
    wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css', 
        array(),  // if the parent theme code has a dependency, copy it to here
        $theme->parent()->get('Version')
    );
    wp_enqueue_style( 'child-style', get_stylesheet_uri(),
        array( $parenthandle ),
        $theme->get('Version') // this only works if you have Version in the style header
    );
}

//save price
add_action('wp_ajax_my_action', 'my_callback');

function my_callback() {
  $price  =  esc_html__($_POST['price']);
  $pid    =  esc_html__($_POST['pid']);

  $res= update_post_meta($pid, 'price', __( $price) );
	if($res)
	{
		echo "Updated successfully";
	}
	else
    {
		echo "Seomething went wrong!";
	}
  wp_die();
}


//  Custom pagination function 
// function cq_pagination($pages = '', $range = 4)
// {
    
//     $showitems = ($range * 2)+1;
//     global $paged;
    
//     if(empty($paged)) $paged = 1;
//     if($pages == '')
//     {
//         global $wp_query;
//         $pages = $wp_query->max_num_pages;
//         if(!$pages)
//         {
//             $pages = 1;
//         }
//     }
//     if(1 != $pages)
//     {
//         echo "<nav aria-label='Page navigation example'>  <ul class='pagination'> <span>Page ".$paged." of ".$pages."</span>";
//         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
//         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";
//         for ($i=1; $i <= $pages; $i++)
//         {
//             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
//             {
//                 echo ($paged == $i)? "<li class=\"page-item active\"><a class='page-link' id='".$i."'>".$i."</a></li>":"<li class='page-item' id='".$i."'> <a href='".get_pagenum_link($i)."' class=\"page-link\" id='".$i."'>".$i."</a></li>";
//             }
//         }
//         if ($paged < $pages && $showitems < $pages) echo " <li class='page-item' id='".$i."'><a class='page-link' href=\"".get_pagenum_link($paged + 1)."\">i class='flaticon flaticon-back'></i></a></li>";
//         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo " <li class='page-item'><a class='page-link' id='".$i."' href='".get_pagenum_link($pages)."'><i class='flaticon flaticon-arrow'></i></a></li>";
//         echo "</ul></nav>\n";
//     }
// }


//filter
function ajax_filterposts_handler() {
    $category = esc_attr( $_POST['category'] );

   // $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
   $paged = $_POST['paged'];
    $args = array(
        'post_type' => 'book',
        'post_status' => 'publish',
        'posts_per_page' => 2,
        'paged' => $paged ,
    );

    //taxonomy
    if( $category != 'all' )
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'book_category',
            'field' => 'id',
            'terms' =>$category
        )
    );

    $posts = 'No posts found.';

    $customQuery = new WP_Query( $args );
 
    if ( $customQuery->have_posts() ) :

        ob_start();
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
  

        //pagination
        $total_pages = $customQuery->max_num_pages;

        if ($total_pages > 1){
    
             $current_page = max(1, get_query_var('paged'));

            // $args=array(
            //     'base' => get_pagenum_link(1) . '%_%',
            //     'format' => '/page/%#%',
            //     'current' => $current_page,
            //     'total' => $total_pages,
            //     'prev_text'    => __('« prev'),
            //     'next_text'    => __('next »'),
            // );
            $args=array(
                'base' => '%_%',
                'format' => '?page=%#%',
                'current' => $paged,
                'total' => $total_pages,
                'prev_text'    => __('« prev'),
                'next_text'    => __('next »'),
            );

            $links = paginate_links($args);

            if ( $links ) {
                echo '<div class="pagination">';
                    echo $links;
                echo '</div>';
            }
            
        }
      
		wp_reset_query();

		  ?>	
 
		 </main><!-- #main -->
		 
	 </div><!-- #primary -->
		 
 </div><!-- .wrap -->
<?php
    $posts = ob_get_clean();
     
    endif;

    $return = array(
        'posts' => $posts
    );

    wp_send_json($return);
    wp_die();
}
add_action( 'wp_ajax_filterposts', 'ajax_filterposts_handler' );
add_action( 'wp_ajax_nopriv_filterposts', 'ajax_filterposts_handler' );




//new pagination
