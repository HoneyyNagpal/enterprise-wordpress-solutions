<?php
/* ===============================
   THEME SETUP
================================ */
function enterprise_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'enterprise_theme_setup');


/* ===============================
   ENQUEUE STYLES
================================ */
function enterprise_enqueue_assets() {
    wp_enqueue_style('enterprise-style', get_stylesheet_uri(), [], '1.0');
}
add_action('wp_enqueue_scripts', 'enterprise_enqueue_assets');


/* ===============================
   PERFORMANCE OPTIMIZATION
================================ */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');


/* ===============================
   CUSTOM POST TYPE: SERVICES
================================ */
function enterprise_register_services_cpt() {
    register_post_type('services', [
        'labels' => [
            'name' => 'Services',
            'singular_name' => 'Service'
        ],
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => ['title', 'editor', 'thumbnail'],
        'rewrite' => ['slug' => 'services']
    ]);
}
add_action('init', 'enterprise_register_services_cpt');


/* ===============================
   META BOX: SERVICE DETAILS
================================ */
function enterprise_add_service_meta_box() {
    add_meta_box(
        'enterprise_service_details',
        'Service Details',
        'enterprise_service_meta_box_html',
        'services',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'enterprise_add_service_meta_box');


function enterprise_service_meta_box_html($post) {
    wp_nonce_field('enterprise_save_service_meta', 'enterprise_service_nonce');

    $client_name = get_post_meta($post->ID, '_client_name', true);
    $tech_stack = get_post_meta($post->ID, '_tech_stack', true);
    $duration = get_post_meta($post->ID, '_project_duration', true);
    ?>
    <p>
        <label><strong>Client Name</strong></label><br>
        <input type="text" name="client_name" value="<?php echo esc_attr($client_name); ?>" style="width:100%;">
    </p>

    <p>
        <label><strong>Tech Stack</strong></label><br>
        <input type="text" name="tech_stack" value="<?php echo esc_attr($tech_stack); ?>" style="width:100%;">
    </p>

    <p>
        <label><strong>Project Duration</strong></label><br>
        <input type="text" name="project_duration" value="<?php echo esc_attr($duration); ?>" style="width:100%;">
    </p>
    <?php
}


/* ===============================
   SAVE META BOX DATA (SECURE)
================================ */
function enterprise_save_service_meta($post_id) {

    if (!isset($_POST['enterprise_service_nonce']) ||
        !wp_verify_nonce($_POST['enterprise_service_nonce'], 'enterprise_save_service_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['client_name'])) {
        update_post_meta($post_id, '_client_name', sanitize_text_field($_POST['client_name']));
    }

    if (isset($_POST['tech_stack'])) {
        update_post_meta($post_id, '_tech_stack', sanitize_text_field($_POST['tech_stack']));
    }

    if (isset($_POST['project_duration'])) {
        update_post_meta($post_id, '_project_duration', sanitize_text_field($_POST['project_duration']));
    }
}
add_action('save_post', 'enterprise_save_service_meta');


/* ===============================
   REST API (HEADLESS SUPPORT)
================================ */
add_action('rest_api_init', function () {
    register_rest_route('enterprise/v1', '/services', [
        'methods' => 'GET',
        'callback' => 'enterprise_get_services_api'
    ]);
});

function enterprise_get_services_api() {
    $posts = get_posts(['post_type' => 'services', 'numberposts' => -1]);
    $data = [];

    foreach ($posts as $post) {
        $data[] = [
            'title' => get_the_title($post->ID),
            'content' => apply_filters('the_content', $post->post_content),
            'client' => get_post_meta($post->ID, '_client_name', true),
            'tech_stack' => get_post_meta($post->ID, '_tech_stack', true),
            'duration' => get_post_meta($post->ID, '_project_duration', true),
        ];
    }
    return $data;
}

