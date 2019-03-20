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
        add_action('generate_rewrite_rules', 'register_tlc_rewrite_rules');
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

    register_taxonomy('event-category', ['events'],
        [
            'labels' => [
                'name' => __('Event Categories'),
                'menu_name' => __('Event Categories'),
                'singular_name' => __('Event Category'),
                'all_items' => __('All Categories'),
            ],
            'public' => true,
            'hierarchical' => true,
            'show_ui' => true,
            'rewrite' => [
                'slug' => 'event-category',
                'hierarchical' => true,
                'with_front' => false,
            ],
        ]
    );

    register_post_type('events',
        [
            'labels' => [
                'name' => __('Events'),
                'menu_name' => __('Event Manager'),
                'singular_name' => __('Event'),
                'all_items' => __('All Events'),
                'add_new_item' => __('Add New Event'),
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
            'taxonomies' => ['event-category'],
            'rewrite' => [
                'slug' => 'event',
                'hierarchical' => true,
                'with_front' => false,
            ],
        ]
    );

    register_post_type('affiliations',
        [
            'labels' => [
                'name' => __('Affiliations'),
                'menu_name' => __('Affiliation Manager'),
                'singular_name' => __('Affiliation'),
                'all_items' => __('All Affiliations'),
                'add_new_item' => __('Add New Affiliation'),
            ],
            'public' => false,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => false,
            'supports' => [
                'title', 
                'thumbnail', 
                'post-formats', 
                'revisions', 
                'page-attributes'
            ],
            'hierarchical' => false,
            'has_archive' => false,
        ]
    );
}

function register_tlc_rewrite_rules($wp_rewrite)
{
    $tlc_rules = [
        'service/([^/]+)/?$' => 'index.php?post_type=services&services=' . $wp_rewrite->preg_index(1),
        'service-category/([^/]+)/?$' => 'index.php?service-category=' . $wp_rewrite->preg_index(1),
        'event/([^/]+)/?$' => 'index.php?post_type=events&events=' . $wp_rewrite->preg_index(1),
        'event-category/([^/]+)/?$' => 'index.php?event-category=' . $wp_rewrite->preg_index(1),
    ];
    $wp_rewrite->rules = $tlc_rules + $wp_rewrite->rules;
}

$TLC_Post_Types = new TLC_Post_Types();
