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
 * @author Jonathan Howard
 * @version 20190410
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
		add_filter("rest_prepare_services", 'tlc_rest_prepare_post', 10, 3);
		add_filter("rest_prepare_events", 'tlc_rest_prepare_post', 10, 3);
		add_filter("rest_prepare_page", 'tlc_rest_prepare_post', 10, 3);
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
			'show_in_rest' => true,
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
			'rest_base' => 'services',
			'rewrite' => [
				'slug' => 'service',
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
			'show_in_rest' => true,
			'supports' => [
				'title',
				'editor',
				'thumbnail',
				'post-formats',
				'revisions'
			],
			'hierarchical' => false,
			'has_archive' => true,
			'rest_base' => 'events',
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

	register_post_type('featured-sections',
		[
			'labels' => [
				'name' => __('Featured Sections'),
				'menu_name' => __('Home Page Manager'),
				'singular_name' => __('Featured Section'),
				'all_items' => __('All Featured Sections'),
				'add_new_item' => __('Add New Featured Section'),
			],
			'public' => false,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'menu_position' => 20,
			'show_in_nav_menus' => false,
			'supports' => [
				'title',
				'revisions',
			],
			'hierarchical' => false,
			'has_archive' => false,
		]
	);

	register_post_type('home-banner',
		[
			'labels' => [
				'name' => __('Home Banners'),
				'menu_name' => __('Banner Manager'),
				'singular_name' => __('Home Banner'),
				'all_items' => __('All Banners'),
				'add_new_item' => __('Add New Banner'),
			],
			'public' => false,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'menu_position' => 20,
			'show_in_nav_menus' => false,
			'supports' => [
				'title',
				'thumbnail',
				'revisions',
			],
			'hierarchical' => false,
			'has_archive' => false,
		]
	);

	register_post_type('testimonials',
		[
			'labels' => [
				'name' => __('Testimonials'),
				'menu_name' => __('Testimonial Manager'),
				'singular_name' => __('Testimonial'),
				'all_items' => __('All Testimonials'),
				'add_new_item' => __('Add New Testimonial'),
			],
			'public' => false,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => false,
			'supports' => [
				'title',
				'editor',
				'thumbnail',
				'post-formats',
				'revisions',
				'page-attributes'
			],
			'hierarchical' => false,
			'has_archive' => true,
		]
	);

	register_post_type('notification',
		[
			'labels' => [
				'name' => __('Notifications'),
				'menu_name' => __('Notification Manager'),
				'singular_name' => __('Notification'),
				'all_items' => __('All Notifications'),
				'add_new_item' => __('Add New Notification'),
			],
			'public' => false,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => false,
			'supports' => [
				'title',
				'post-formats',
				'revisions',
			],
			'hierarchical' => false,
			'has_archive' => true,
		]
	);

	register_taxonomy('course', ['lessons'],
		[
			'labels' => [
				'name' => __('Course'),
				'menu_name' => __('Courses'),
				'singular_name' => __('Course'),
				'all_items' => __('All Courses'),
			],
			'public' => true,
			'hierarchical' => true,
			'show_ui' => true,
			'rewrite' => [
				'slug' => 'course',
				'hierarchical' => true,
				'with_front' => false,
			],
		]
	);

	register_post_type('lessons',
		[
			'labels' => [
				'name' => __('Lessons'),
				'menu_name' => __('Course Manager'),
				'singular_name' => __('Lesson'),
				'all_items' => __('All Lessons'),
				'add_new_item' => __('Add New Lesson'),
			],
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => true,
			'show_in_rest' => true,
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
			'taxonomies' => ['course'],
			'rest_base' => 'lessons',
			'rewrite' => [
				'slug' => 'lesson',
				'hierarchical' => true,
				'with_front' => false,
			],
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

function tlc_rest_prepare_post($data, $post, $request) {
	$_data = $data->data;
	$fields = get_fields($post->ID);
	foreach ($fields as $key => $value){
		$_data[$key] = get_field($key, $post->ID);
	}

	$data->data = $_data;
	return $data;
}

$TLC_Post_Types = new TLC_Post_Types();
