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
        add_action('add_meta_boxes', 'add_services_additional_fields_meta_box');
        add_action('save_post', 'save_services_additional_fields_meta');
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
            'supports' => ['title', 'editor', 'excerpt', 'thumbnail', 'post-formats', 'revisions'],
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

function add_services_additional_fields_meta_box()
{
    add_meta_box(
        'services_additional_fields_meta_box', // $id
        'Additional Fields', // $title
        'show_services_additional_fields_meta_box', // $callback
        'services', // $screen
        'normal', // $context
        'low' // $priority
    );
}

function show_services_additional_fields_meta_box()
{
    global $post;
    $meta = get_post_meta($post->ID, 'services_additional_fields', true);?>

  <input
    type="hidden"
    name="services_additional_fields_nonce"
    value="<?php echo wp_create_nonce(basename(__FILE__)); ?>">

    <?=generate_image_field(
        'services_additional_fields',
        'services_thumbnail_image',
        'Thumbnail',
        'meta-image regular-text',
        $meta);?>

  <?php
wp_enqueue_script('meta_image', plugin_dir_url(__FILE__) . '/src/js/meta_image.js');
}

function generate_input_field($field_arr, $field_name, $field_label, $class, $meta)
{
    $output =
        '<p>
      <label for="' . $field_arr . '[' . $field_name . ']">' . $field_label . '</label>
      <br>
      <input
        type="text"
        name="' . $field_arr . '[' . $field_name . ']"
        id="' . $field_arr . '[' . $field_name . ']"
        class="' . $class . '"
        value="' . (isset($meta[$field_name]) ? $meta[$field_name] : '') . '">
    </p>';
    return $output;
}

function generate_image_field($field_arr, $field_name, $field_label, $class, $meta)
{
    $output =
        '<div>
          <p>
            <label for="' . $field_arr . '[' . $field_name . ']">' . $field_label . '</label><br>
            <input
              type="text"
              name="' . $field_arr . '[' . $field_name . ']"
              id="' . $field_arr . '[' . $field_name . ']"
              class="' . $class . '"
              value="' . (isset($meta[$field_name]) ? $meta[$field_name] : '') . '">
            <input
              type="button"
              class="button image-upload"
              value="Browse">
          </p>

          <div class="image-preview">
            <img
              src="' . (isset($meta[$field_name]) ? $meta[$field_name] : '') . '"
              style="max-width: 250px;"
          ></div>
        </div>
        ';
    return $output;
}

function save_services_additional_fields_meta($post_id)
{
    // verify nonce
    if (isset($_POST['services_additional_fields_nonce']) && !wp_verify_nonce($_POST['services_additional_fields_nonce'], basename(__FILE__))) {
        return $post_id;
    }
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    // check permissions
    if (isset($_POST['post_type']) && 'page' === $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
    }

    $old = get_post_meta($post_id, 'services_additional_fields', true);
    $new = (isset($_POST['services_additional_fields']) ? $_POST['services_additional_fields'] : '');

    if ($new && $new !== $old) {
        update_post_meta($post_id, 'services_additional_fields', $new);
    } elseif ('' === $new && $old) {
        delete_post_meta($post_id, 'services_additional_fields', $old);
    }
}

$TLC_Post_Types = new TLC_Post_Types();
