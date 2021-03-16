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
        // 'date_query' => array(
		// 	//set date ranges with strings!
		// 	'after' => 'today',
		// 	//allow exact matches to be returned
		// 	'inclusive'         => true,
		// ),
    
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
                if( 'all' === esc_html( $_GET['category'] ) )
                {
                    return;
                }
                $taxquery = array(
                        array(
                                'taxonomy' => 'book_category',
                                'field' => 'slug',
                                'terms' => esc_html($_GET['category']),
                        ),
                );
                if( $_GET['price_srt'] != 'default' )
                {
                    $query->set( 'meta_key', 'price' );
                    $query->set( 'orderby', 'meta_value' );
                    $query->set( 'order', esc_html($_GET['price_srt'] ));
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


//Woocommerce support
function mytheme_add_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );


//woocommerce 
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

// //woocommerce 
// remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
// add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title',9 );

//Single product page
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 15 );


//
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price',10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 16 );

//
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 9 );


//ajax add to cart ajax callback
add_action('wp_ajax_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');
add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');

function my_function_custom_archive_description() {
	$new_description = 'Welcome to my shop, Game hard!.'; 
	return $new_description; 
} 
        
function woocommerce_ajax_add_to_cart() {

            $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
            $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
            $variation_id = absint($_POST['variation_id']);
            $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
            $product_status = get_post_status($product_id);

            if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {

                do_action('woocommerce_ajax_added_to_cart', $product_id);

                if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
                    wc_add_to_cart_message(array($product_id => $quantity), true);
                }

                WC_AJAX :: get_refreshed_fragments();
            } else {

                $data = array(
                    'error' => true,
                    'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id));

                echo wp_send_json($data);
            }

            wp_die();
        }

        //filter by attribute form
        function display_att_shop(){
            $subheadingvalues = get_terms('pa_limited-edition', array(
                'hide_empty' => false,
                ));
                ?>
                <form method='get'>
                <label for='game_attribute'>Game Type: </label><select name='game_attribute' class='game_attribute'>
                    <option value='all'>--Select--</option>
                    <?php foreach ($subheadingvalues as $subheadingvalue): ?>
                    <option value="<?php echo $subheadingvalue->slug; ?>">
                        <?php echo $subheadingvalue->name; ?>
                    </option>
                    <?php endforeach;?>
                </select>
                <input type='submit' value='filter' name='submit'>
                </form>
                <?php
        }
        add_action('woocommerce_before_shop_loop','display_att_shop');


        //filter by attribute callback
        function fiter_att_shop($q){
            if(isset($_GET['game_attribute']))
            {
                $attribute_type=esc_html($_GET['game_attribute']);
                if('all' === $attribute_type || $attribute_type == '' )
            {
                return;
            }

            $tax_query = $q->get( 'tax_query' );

            $taxonomy = 'pa_limited-edition'; 
            $tax_query[] = array(
                'taxonomy'  => $taxonomy,
                'field'     => 'slug',
                // 'operator'  => 'IN',
                'terms'     => $attribute_type,
            );
        
            $q->set( 'tax_query', $tax_query );
            }
            
        }
        add_action('woocommerce_product_query','fiter_att_shop');