<?php
/*
Plugin Name: TLC Post Types
Plugin URI:
Description: Custom post types to be used with thelotuscentre.ca's WordPress theme built by Jonathan Howard
Author: Jonathan Howard
Author URI:
 */

/**
 * @classname TLC_Post_Types
 * @author remi (exomel.com)
 * @version 20100119
 */
class TLC_Post_Types
{

    /**
     * @constructor
     */
    public function TLC_Post_Types()
    {
        $this->set_hooks();
    }

    /**
     * Set actions and filters
     * @return void
     */
    public function set_hooks()
    {
        add_action('init', 'register_tlc_post_types');
        add_action('generate_rewrite_rules', 'register_services_rewrite_rules');
    }

    /**
     * A sample action
     * @return WP_Query
     */
    // function parse_request( $wp ) {
    //     return $wp;
    // }

}

function register_tlc_post_types()
{
    register_taxonomy('service-category', ['services'],
        [
            'labels' => [
                'name' => __('Service Categories'),
                'menu_name' => __('Service Categories'),
                'singular_name' => __('Service Category'),
                'all_items' => __('All Categories'),
            ],
            'public' => true,
            'hierarchical' => true,
            'show_ui' => true,
            'rewrite' => [
                'slug' => 'service-category',
                'hierarchical' => true,
                'with_front' => false,
            ],
        ]
    );

    register_post_type('services',
        [
            'labels' => [
                'name' => __('Services'),
                'menu_name' => __('Service Manager'),
                'singular_name' => __('Service'),
                'all_items' => __('All Services'),
                'add_new_item' => __('Add New Service'),
            ],
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'supports' => [
                'title', 
                'editor', 
                'excerpt', 
                'thumbnail', 
                'post-formats', 
                'revisions', 
                'page-attributes'
            ],
            'hierarchical' => false,
            'has_archive' => true,
            'taxonomies' => ['service-category'],
            'rewrite' => [
                'slug' => 'service',
                'hierarchical' => true,
                'with_front' => false,
            ],
        ]
    );
}

function register_services_rewrite_rules($wp_rewrite)
{
    $new_rules = array(
        'service/([^/]+)/?$' => 'index.php?post_type=service&services=' . $wp_rewrite->preg_index(1),
        'service-category/([^/]+)/?$' => 'index.php?service-category=' . $wp_rewrite->preg_index(1),
    );
    $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
}

$TLC_Post_Types = new TLC_Post_Types();
