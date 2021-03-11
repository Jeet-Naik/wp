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


//filter
function ajax_filterposts_handler() {
    $category = esc_attr( $_POST['category'] );
    $price=esc_attr( $_POST['price_srt'] );

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
    {
        $args['tax_query'] = array(
            array(
                'taxonomy'  =>  'book_category',
                'field'     =>  'id',
                'terms'     =>  $category
            )
        );
    }

    

    //meta value sorting
    if( $price != 'default' )
    {
        $args['meta_key']   =   'price' ;
        $args['orderby']    =   'meta_value' ;
        $args['order']      =   $price ;
    }

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
                                         <br/>
                                         <span><b>Price: </b>$<?php echo get_post_meta(get_the_ID(),'price',true) ?></span>
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
    
            // $current_page = max(1, get_query_var('paged'));

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

// book archive page filtering
function filter_archive_drpdwn( $query ) {
    if ( is_post_type_archive( 'book' )  ) {          
            if (!empty( $_GET['category'] )) 
            {
                if( 'all' === $_GET['category'] )
                {
                    return;
                }
                $taxquery = array(
                        array(
                                'taxonomy' => 'book_category',
                                'field' => 'slug',
                                'terms' => $_GET['category'],
                        ),
                );
                if( $_GET['price_srt'] != 'default' )
                {
                    $query->set( 'meta_key', 'price' );
                    $query->set( 'orderby', 'meta_value' );
                    $query->set( 'order', $_GET['price_srt'] );
                }
                $query->set( 'tax_query', $taxquery );
            }
    }
    return $query;
}
add_action( 'pre_get_posts', 'filter_archive_drpdwn' );



// price sorting
// function wpd_sort_by_meta( $query ) {
//     if($query->is_archive())
//     {
//         $query->set( 'meta_key', 'price' );
//         $query->set( 'orderby', 'meta_value' );
//         $query->set( 'order', 'DESC' );
//     }
// }
// add_action( 'pre_get_posts', 'wpd_sort_by_meta' );


