
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
function create_posttype()
{

    register_post_type(
        'sports',
        // CPT  
        array(
            'labels' => array(
                'name' => __('Sports'),
                'singular_name' => __('Sports'),
                'add_new' => 'Add Sports',

            ),
            'public' => true,
        )
    );
}
add_action('init', 'create_posttype');

function themes_taxonomy()
{
    $posts = array(
        'sports',
        'post'
    );
    register_taxonomy(
        'games',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
        $posts,             // post type name
        array(
            'hierarchical' => false,
            'label' => 'Games', // display name
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'themes',    // This controls the base slug that will display before each term
                'with_front' => false  // Don't display the category base before
            )
        )
    );
}

add_action('init', 'themes_taxonomy');

function themes_taxonomy2()
{
    register_taxonomy(
        'new',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
        'sports',             // post type name
        array(
            'hierarchical' => true,
            'label' => 'new', // display name
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'themes',    // This controls the base slug that will display before each term
                'with_front' => false  // Don't display the category base before
            )
        )
    );
}
add_action('init', 'themes_taxonomy2');

//meta bbox
function custom_meta_box()
{
    add_meta_box("price", "Price", "custom_meta_box_markup", "sports");
}
add_action('add_meta_boxes', 'custom_meta_box');

function custom_meta_box_markup()
{
    include plugin_dir_path(__FILE__) . '/Meta_form.php';
}

function save_meta_values($postid)
{
    $fields = array('price');
    foreach ($fields as $field) {
        if (key_exists($field, $_POST)) {
            update_post_meta($postid, $field, $_POST[$field]);
        }
    }
}
add_action('save_post', 'save_meta_values');




function my_admin_ajax() {
  wp_enqueue_script('custom',get_template_directory_uri() . '/assets/js/custom.js',array('jquery'));
  wp_localize_script( 'custom', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
}

add_action('wp_enqueue_scripts', 'my_admin_ajax');
?>
