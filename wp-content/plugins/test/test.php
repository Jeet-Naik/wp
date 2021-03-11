
<?php
/*
Plugin Name: jeet
Plugin URI: https://akismet.com/
Description: Descitpionjsad
Version:1.0
Author: jeet
Author URI: https://automattic.com/wordpress-plugins/
License: GPLv2 or later
Text Domain: akismet
*/

//custom post type
function create_posttype()
{
    $labels = array(
        'name'                  => _x( 'Books', 'Post type general name', 'textdomain' ),
        'singular_name'         => _x( 'Book', 'Post type singular name', 'textdomain' ),
        'menu_name'             => _x( 'Books', 'Admin Menu text', 'textdomain' ),
        'name_admin_bar'        => _x( 'Book', 'Add New on Toolbar', 'textdomain' ),
        'add_new'               => __( 'Add New', 'textdomain' ),
        'add_new_item'          => __( 'Add New Book', 'textdomain' ),
        'new_item'              => __( 'New Book', 'textdomain' ),
        'edit_item'             => __( 'Edit Book', 'textdomain' ),
        'view_item'             => __( 'View Book', 'textdomain' ),
        'all_items'             => __( 'All Books', 'textdomain' ),
        'search_items'          => __( 'Search Books', 'textdomain' ),
        'parent_item_colon'     => __( 'Parent Books:', 'textdomain' ),
        'not_found'             => __( 'No books found.', 'textdomain' ),
        'not_found_in_trash'    => __( 'No books found in Trash.', 'textdomain' ),
        'featured_image'        => _x( 'Book Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'archives'              => _x( 'Book archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
        'insert_into_item'      => _x( 'Insert into book', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
        'uploaded_to_this_item' => _x( 'Uploaded to this book', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain' ),
        'filter_items_list'     => _x( 'Filter books list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
        'items_list_navigation' => _x( 'Books list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
        'items_list'            => _x( 'Books list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain' ),
    );
 
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'book' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
    );

    register_post_type('book',$args);
}
add_action('init', 'create_posttype');


//custom taxonomy
function themes_taxonomy()
{
    $posts = array('book');
    register_taxonomy(
        'book_category',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
        $posts,             // post type name
        array(
            'hierarchical' => true,
            'labels' => array(
                'name' => _x( 'Book Category', 'taxonomy general name' ),
                'singular_name' => _x( 'Book Category', 'taxonomy singular name' ),
                'search_items' =>  __( 'Search Book Category' ),
                'all_items' => __( 'All Book Category' ),
                'parent_item' => __( 'Parent Book' ),
                'parent_item_colon' => __( 'Parent Book' ),
                'edit_item' => __( 'Edit Book Category' ),
                'update_item' => __( 'Update Book Category' ),
                'add_new_item' => __( 'Add New Book Category' ),
                'new_item_name' => __( 'New Book Category Name' ),
                'menu_name' => __( 'Book Category' ),
              ),
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'themes',    // This controls the base slug that will display before each term
                'with_front' => false  // Don't display the category base before
            )
        )
    );
}

add_action('init', 'themes_taxonomy');


//meta bbox
function custom_meta_box()
{
    add_meta_box("price", "Book Data", "custom_meta_box_markup", "book");
}
add_action('add_meta_boxes', 'custom_meta_box');


//Meta box form
function custom_meta_box_markup()
{
    include plugin_dir_path(__FILE__) . '/Meta_form.php';
}


//Save meta box values
function save_meta_values($postid)
{
    $fields = array('price','pdate');
    foreach ($fields as $field) {
        if (key_exists($field, $_POST)) {
            update_post_meta($postid, $field, $_POST[$field]);
        }
    }
}
add_action('save_post', 'save_meta_values');

//Custom js
function my_admin_ajax() {
  wp_enqueue_script( 'custom', get_template_directory_uri() . '-child/assets/js/custom.js',array( 'jquery' ) );
  wp_enqueue_style( 'flexslider', get_template_directory_uri() . '-child/assets/css/flexslider.css' );
  wp_enqueue_script( 'flexslider', get_template_directory_uri() . '-child/assets/js/jquery.flexslider.js',array( 'jquery' ) );
  wp_localize_script( 'custom', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
  
}
add_action( 'wp_enqueue_scripts', 'my_admin_ajax' );

//Sort code
add_shortcode('books','fun_book_listing');

add_action( 'wp_enqueue_scripts', 'my_admin_ajax' );
function fun_book_listing( $atts ) {
    extract(shortcode_atts(array(
        'category'=>'all',
        'count' => 5,
     ), $atts));

     $args=array(
        'post_type' => 'book',
        'post_status' => 'publish',
        'orderby' => 'date', 
        'order' => 'DESC' , 
        'showposts' => $count
    );

     //taxonomy
     if( $category != 'all' )
     $args['tax_query'] = array(
         array(
             'taxonomy'  =>  'book_category',
             'field'     =>  'slug',
             'terms'     =>  $category
         )
     );

     $return_string = '<ul>';

     $customQuery = new WP_Query( $args );

     if ($customQuery->have_posts()) :
        while ($customQuery->have_posts()) : $customQuery->the_post();
        //    $return_string .= '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';

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
        </div>
        <?php
        endwhile;
     endif;
     $return_string .= '</ul>';

    return $return_string;
}


//custom header option  


//custom wirdget area
function wpb_widgets_init() {
 
    register_sidebar( array(
        'name'          => __('Books Sidebar'),
        'id'            => 'custom-books-widget',
        'description'   => __( 'Appears on the books archive page'),
        'before_widget' => '<div class="chw-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="chw-title">',
        'after_title'   => '</h2>',
    ) );
 
}
add_action( 'widgets_init', 'wpb_widgets_init' );

//theme customizer
function cd_customizer_settings( $wp_customize ) {
 
    $wp_customize->add_section( 'cd_header' , array(
        'title'      => 'Change Header',
        'priority'   => 20,
    ) );
  
    $wp_customize->add_setting( 'cd_header_display' , array(
        'default'     => true,
        'transport'   => 'refresh',
    ) );
  
    $wp_customize->add_control( 'cd_header_display', array(
    'label'     => 'Select Header',
    'section'   => 'cd_header',
    'settings'  => 'cd_header_display',
    'type'      => 'select',
    'choices'   => array(
        'Header_1'  => 'Header Layout 1',
        'Header_2'  => 'Header Layout 2',
    ),
  ) );

}
add_action( 'customize_register', 'cd_customizer_settings' );



  /**
  * Book_list widget class
  *
  */
class WP_Widget_My_Custom_Recent_Posts extends WP_Widget {

    function __construct() {

        parent::__construct(
            // Base ID of  widget
            'WP_Widget_My_Custom_Recent_Posts', 
                
            // Widget name will appear in UI
            __('Book List', 'wpb_widget_domain'), 
                
            // Widget description
            array( 'description' => __( 'Book list will be displayed', 'wpb_widget_domain' ), ) 
        );

        add_action( 'save_post', array(&$this, 'flush_widget_cache') );
        add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
        add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
    }

    function widget($args, $instance) {
        $cache = wp_cache_get('widget_my_custom_recent_posts', 'widget');

        if ( !is_array($cache) )
            $cache = array();

        if ( isset($cache[$args['widget_id']]) ) {
            echo $cache[$args['widget_id']];
            return;
        }

        ob_start();
        extract($args);

        $title = apply_filters('widget_title', empty($instance['title']) ? __('My Custom Recent Posts') : $instance['title'], $instance, $this->id_base);
        if ( !$number = (int) $instance['number'] )
            $number = 10;
        else if ( $number < 1 )
            $number = 1;
        else if ( $number > 15 )
            $number = 15;

        $category = isset($instance['category']) ? esc_html($instance['category']) : 'action';    

        $query_args=array(
            'showposts'             => $number, 
            'nopaging'              => 0, 
            'post_status'           => 'publish', 
            'ignore_sticky_posts'   => true, 
            'post_type'             => array('book')
        );
        //taxonomy filter
        if( $category != 'all' )
        $query_args['tax_query'] = array(
            array(
                'taxonomy'  =>  'book_category',
                'field'     =>  'name',
                'terms'     =>  $category
            )
        );
        $r = new WP_Query( $query_args );
        
        if ($r->have_posts()) :
        ?>
        <?php echo $before_widget; ?>
        <?php if ( $title ) echo $before_title . $title . $after_title; ?>
        <ul>
        
        <?php
        while ($r->have_posts()) : $r->the_post(); ?>
        <li><a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a></li>
        <?php endwhile; ?>
        </ul>
        <?php echo $after_widget; ?>
        <?php
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();

        endif;

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_my_custom_recent_posts', $cache, 'widget');
    }

    function update( $new_instance, $old_instance ) {
        $instance               = $old_instance;
        $instance['title']      = strip_tags($new_instance['title']);
        $instance['category']   = strip_tags($new_instance['category']);
        $instance['number']     = (int) $new_instance['number'];
        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset( $alloptions['widget_my_custom_recent_entries'] ) )
            delete_option( 'widget_my_custom_recent_entries' );

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete( 'widget_my_custom_recent_posts', 'widget' );
    }

    function form( $instance ) {
        $title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';

        $category = isset( $instance['category'] ) ? esc_attr( $instance['category'] ) : '';
        
        if ( !isset($instance['number']) || !$number = (int) $instance['number'] )
            $number = 5;
            ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

            <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
            <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

            <p><label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Select category:'); ?></label>
            <select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">
            <option value="all">All</option>
            <?php $get_categories = get_categories(array('taxonomy'=>'book_category')); ?>
            <?php
			if ( $get_categories ) :
				foreach ( $get_categories as $cat ) :
			    ?>
			    <option value="<?php echo $cat->name; ?>"<?php selected( $category, $cat->name ); ?>>
			        <?php echo $cat->name; ?>
			    </option>
			    <?php 
                endforeach; 
			endif;
			?>
        </select>
<?php
    }
}
// Register and load the widget
function wpb_load_widget() {
    register_widget( 'WP_Widget_My_Custom_Recent_Posts' );
}
add_action( 'widgets_init', 'wpb_load_widget' );
?>
