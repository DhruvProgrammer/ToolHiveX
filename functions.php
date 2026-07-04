<?php
/**
 * Theme Name: AI News
 * Author: AI News Theme
 * Description: A modern WordPress theme for AI news, tools, prompts, and technology content.
 * License: GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: ai-news
 * Version: 2.0.0
 * Requires at least: 6.0
 * Requires PHP: 7.4
 */

if (!defined('ABSPATH')) exit;

// 1. Enqueue Assets
add_action('wp_enqueue_scripts', 'ai_news_enqueue_assets');
function ai_news_enqueue_assets() {
    wp_enqueue_style('ai-news-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap', array(), '2.0.0');
    wp_enqueue_style('ai-news-style', get_stylesheet_uri(), array(), '2.0.0');
    wp_enqueue_style('ai-news-main', get_template_directory_uri() . '/assets/css/style.css', array(), '2.0.0');
    wp_enqueue_script('ai-news-script', get_template_directory_uri() . '/assets/js/main.js', array(), '2.0.0', true);
    wp_enqueue_script('ai-news-comment-reply', get_template_directory_uri() . '/assets/js/comment-reply.js', array(), '2.0.0', true);
    
    wp_localize_script('ai-news-script', 'aiNewsData', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'homeUrl' => home_url('/'),
        'nonce'   => wp_create_nonce('ai_news_ajax'),
    ));
}

// 2. Nonce verification
add_action('wp_ajax_nopriv_ai_news_subscribe', 'ai_news_verify_nonce', 1);
add_action('wp_ajax_nopriv_ai_news_contact', 'ai_news_verify_nonce', 1);
add_action('wp_ajax_ai_news_subscribe', 'ai_news_verify_nonce', 1);
add_action('wp_ajax_ai_news_contact', 'ai_news_verify_nonce', 1);
function ai_news_verify_nonce() {
    if (!wp_verify_nonce($_POST['nonce'] ?? '', 'ai_news_ajax')) {
        wp_send_json_error(array('message' => 'Security check failed'));
    }
}

// 2. Theme Setup
add_action('after_setup_theme', 'ai_news_setup');
function ai_news_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('menus');
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('editor-styles');
    add_theme_support('post-formats', array('gallery', 'link', 'quote'));

    register_nav_menus(array(
        'primary' => __('Primary Menu', 'ai-news'),
        'footer'  => __('Footer Menu', 'ai-news'),
    ));

    add_image_size('hero-feature', 800, 608, true);
    add_image_size('article-card', 768, 512, true);
    add_image_size('article-single', 1200, 800, true);
    add_image_size('carousel-slide', 1200, 600, true);
}

// 3. Page Template support
add_filter('theme_page_templates', 'ai_news_page_templates');
function ai_news_page_templates($templates) {
    $templates['page-templates/page-tools.php']  = __('Top AI Tools', 'ai-news');
    $templates['page-templates/page-prompts.php'] = __('Prompts', 'ai-news');
    $templates['page-templates/page-contact.php'] = __('Contact Us', 'ai-news');
    $templates['page-templates/page-privacy.php'] = __('Privacy Policy', 'ai-news');
    $templates['page-templates/page-about.php'] = __('About Us', 'ai-news');
    $templates['page-templates/page-disclaimer.php'] = __('Disclaimer', 'ai-news');
    $templates['page-templates/page-terms.php'] = __('Terms of Service', 'ai-news');
    $templates['page-templates/page-categories.php'] = __('Categories Overview', 'ai-news');
    $templates['page-templates/page-news.php'] = __('News Listing', 'ai-news');
    $templates['page-templates/page-sitemap.php'] = __('Sitemap', 'ai-news');
    $templates['page-templates/page-newsletter.php'] = __('Newsletter', 'ai-news');
    return $templates;
}

// 4. Custom Post Type: AI News
// NOTE: AI News, AI Tools, and Prompts CPTs have been disabled.
// Uncomment the block below to re-enable them.
/*
add_action('init', 'ai_news_register_post_type');
function ai_news_register_post_type() {
    register_post_type('ai_news', array(
        'labels' => array(
            'name'          => __('AI News', 'ai-news'),
            'singular_name' => __('AI News', 'ai-news'),
            'add_new'       => __('Add New', 'ai-news'),
            'add_new_item'  => __('Add New AI News', 'ai-news'),
            'edit_item'     => __('Edit AI News', 'ai-news'),
            'view_item'     => __('View AI News', 'ai-news'),
            'search_items'  => __('Search AI News', 'ai-news'),
            'not_found'     => __('No AI News found', 'ai-news'),
            'menu_name'     => __('AI News', 'ai-news'),
        ),
        'public'         => true,
        'publicly_queryable' => true,
        'show_ui'        => true,
        'show_in_menu'   => true,
        'query_var'      => true,
        'rewrite'        => array('slug' => 'news'),
        'capability_type'=> 'post',
        'has_archive'    => true,
        'menu_icon'      => 'dashicons-admin-site',
        'supports'       => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
        'taxonomies'     => array('category', 'post_tag'),
    ));

    // Custom Post Type: AI Tools
    register_post_type('ai_tool', array(
        'labels' => array(
            'name'          => __('AI Tools', 'ai-news'),
            'singular_name' => __('AI Tool', 'ai-news'),
            'add_new'       => __('Add New Tool', 'ai-news'),
            'add_new_item'  => __('Add New AI Tool', 'ai-news'),
            'edit_item'     => __('Edit Tool', 'ai-news'),
            'view_item'     => __('View Tool', 'ai-news'),
            'search_items'  => __('Search Tools', 'ai-news'),
            'not_found'     => __('No tools found', 'ai-news'),
            'menu_name'     => __('AI Tools', 'ai-news'),
        ),
        'public'         => true,
        'show_ui'        => true,
        'show_in_menu'   => true,
        'query_var'      => true,
        'rewrite'        => array('slug' => 'tools'),
        'capability_type'=> 'post',
        'has_archive'    => true,
        'menu_icon'      => 'dashicons-admin-generic',
        'supports'       => array('title', 'editor', 'thumbnail', 'excerpt'),
    ));

    // Custom Post Type: Prompts
    register_post_type('ai_prompt', array(
        'labels' => array(
            'name'          => __('Prompts', 'ai-news'),
            'singular_name' => __('Prompt', 'ai-news'),
            'add_new'       => __('Add New Prompt', 'ai-news'),
            'add_new_item'  => __('Add New Prompt', 'ai-news'),
            'edit_item'     => __('Edit Prompt', 'ai-news'),
            'view_item'     => __('View Prompt', 'ai-news'),
            'search_items'  => __('Search Prompts', 'ai-news'),
            'not_found'     => __('No prompts found', 'ai-news'),
            'menu_name'     => __('Prompts', 'ai-news'),
        ),
        'public'         => true,
        'show_ui'        => true,
        'show_in_menu'   => true,
        'query_var'      => true,
        'rewrite'        => array('slug' => 'prompts'),
        'capability_type'=> 'post',
        'has_archive'    => true,
        'menu_icon'      => 'dashicons-editor-code',
        'supports'       => array('title', 'editor', 'thumbnail', 'excerpt'),
    ));
}
*/
// END CPT BLOCK

// 5. Custom Meta Boxes
add_action('add_meta_boxes', 'ai_news_add_meta_boxes');
function ai_news_add_meta_boxes() {
    add_meta_box('ai_news_meta', __('News Details', 'ai-news'), 'ai_news_meta_cb', 'ai_news', 'normal', 'high');
    add_meta_box('ai_tool_meta', __('Tool Details', 'ai-news'), 'ai_tool_meta_cb', 'ai_tool', 'normal', 'high');
    add_meta_box('ai_prompt_meta', __('Prompt Details', 'ai-news'), 'ai_prompt_meta_cb', 'ai_prompt', 'normal', 'high');
}

function ai_news_meta_cb($post) {
    wp_nonce_field('ai_news_meta', 'ai_news_meta_nonce');
    ?>
    <p><label>Category:</label><br>
    <select name="news_category">
        <option value="Hardware" <?php selected(get_post_meta($post->ID, '_news_category', true), 'Hardware'); ?>>Hardware</option>
        <option value="Governance" <?php selected(get_post_meta($post->ID, '_news_category', true), 'Governance'); ?>>Governance</option>
        <option value="Open Source" <?php selected(get_post_meta($post->ID, '_news_category', true), 'Open Source'); ?>>Open Source</option>
        <option value="Research" <?php selected(get_post_meta($post->ID, '_news_category', true), 'Research'); ?>>Research</option>
        <option value="Ethics" <?php selected(get_post_meta($post->ID, '_news_category', true), 'Ethics'); ?>>Ethics</option>
    </select></p>
    <p><label>Read Time:</label> <input type="text" name="read_time" value="<?php echo esc_attr(get_post_meta($post->ID, '_read_time', true)); ?>" style="width:100px;"></p>
    <p><label><input type="checkbox" name="featured" value="1" <?php checked(get_post_meta($post->ID, '_featured', true), '1'); ?>> Featured Post</label></p>
    <?php
}

function ai_tool_meta_cb($post) {
    wp_nonce_field('ai_tool_meta', 'ai_tool_meta_nonce');
    $fields = array(
        '_tool_rank'      => 'Rank (1-10)',
        '_tool_url'       => 'Website URL',
        '_tool_rating'    => 'Rating (1-5)',
        '_tool_pricing'   => 'Pricing (Free/Paid/Freemium)',
        '_tool_tagline'   => 'Tagline',
    );
    foreach ($fields as $key => $label) {
        $val = get_post_meta($post->ID, $key, true);
        echo "<p><label>{$label}:</label><br><input type='text' name='{$key}' value='" . esc_attr($val) . "' style='width:100%;'></p>";
    }
}

function ai_prompt_meta_cb($post) {
    wp_nonce_field('ai_prompt_meta', 'ai_prompt_meta_nonce');
    ?>
    <p><label>Model:</label> <input type="text" name="prompt_model" value="<?php echo esc_attr(get_post_meta($post->ID, '_prompt_model', true)); ?>" style="width:200px;"></p>
    <p><label>Prompt Type:</label>
    <select name="prompt_type">
        <option value="chat" <?php selected(get_post_meta($post->ID, '_prompt_type', true), 'chat'); ?>>Chat</option>
        <option value="image" <?php selected(get_post_meta($post->ID, '_prompt_type', true), 'image'); ?>>Image Generation</option>
        <option value="code" <?php selected(get_post_meta($post->ID, '_prompt_type', true), 'code'); ?>>Code</option>
        <option value="writing" <?php selected(get_post_meta($post->ID, '_prompt_type', true), 'writing'); ?>>Writing</option>
        <option value="analysis" <?php selected(get_post_meta($post->ID, '_prompt_type', true), 'analysis'); ?>>Analysis</option>
    </select></p>
    <p><label>Prompt Content:</label><br>
    <textarea name="prompt_content" rows="6" style="width:100%;font-family:monospace;"><?php echo esc_textarea(get_post_meta($post->ID, '_prompt_content', true)); ?></textarea></p>
    <?php
}

add_action('save_post', 'ai_news_save_metas');
function ai_news_save_metas($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['news_category'])) update_post_meta($post_id, '_news_category', sanitize_text_field($_POST['news_category']));
    if (isset($_POST['read_time'])) update_post_meta($post_id, '_read_time', sanitize_text_field($_POST['read_time']));
    update_post_meta($post_id, '_featured', isset($_POST['featured']) ? '1' : '0');

    foreach (array('_tool_rank', '_tool_url', '_tool_rating', '_tool_pricing', '_tool_tagline') as $k) {
        if (isset($_POST[$k])) update_post_meta($post_id, $k, sanitize_text_field($_POST[$k]));
    }
    if (isset($_POST['prompt_model'])) update_post_meta($post_id, '_prompt_model', sanitize_text_field($_POST['prompt_model']));
    if (isset($_POST['prompt_type'])) update_post_meta($post_id, '_prompt_type', sanitize_text_field($_POST['prompt_type']));
    if (isset($_POST['prompt_content'])) update_post_meta($post_id, '_prompt_content', wp_kses_post($_POST['prompt_content']));
}

// 6. Newsletter subscription handler
add_action('wp_ajax_nopriv_ai_news_subscribe', 'ai_news_handle_subscribe');
add_action('wp_ajax_ai_news_subscribe', 'ai_news_handle_subscribe');
function ai_news_handle_subscribe() {
    $email = sanitize_email($_POST['email']);
    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Invalid email'));
    }
    $subs = get_option('ai_news_subscribers', array());
    if (in_array($email, $subs)) {
        wp_send_json_success(array('message' => 'Already subscribed!'));
    }
    $subs[] = $email;
    update_option('ai_news_subscribers', $subs);
    wp_send_json_success(array('message' => 'Thanks for subscribing!'));
}

// 7. Contact form handler
add_action('wp_ajax_nopriv_ai_news_contact', 'ai_news_handle_contact');
add_action('wp_ajax_ai_news_contact', 'ai_news_handle_contact');
function ai_news_handle_contact() {
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $subj = sanitize_text_field($_POST['subject']);
    $msg = sanitize_textarea_field($_POST['message']);
    
    if (!$name || !$email || !$msg) {
        wp_send_json_error(array('message' => 'All fields required'));
    }

    $to = get_option('admin_email');
    $subject = sprintf('[AI News] %s — from %s', $subj ?: 'Contact', $name);
    $body = "Name: $name\nEmail: $email\nSubject: $subj\n\nMessage:\n$msg";
    wp_mail($to, $subject, $body);
    wp_send_json_success(array('message' => 'Message sent! We\'ll get back to you soon.'));
}

// 8. Include template functions
require_once get_template_directory() . '/inc/template-functions.php';
require_once get_template_directory() . '/inc/page-creator.php';

// 9. Customizer
add_action('customize_register', 'ai_news_customizer');
function ai_news_customizer($wp_customize) {
    $wp_customize->add_section('ai_news_theme', array(
        'title' => __('AI News Settings', 'ai-news'),
        'priority' => 160,
    ));
    $wp_customize->add_setting('ai_news_telegram_url', array(
        'default' => 'https://t.me/your_channel',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('ai_news_telegram_url', array(
        'label' => __('Telegram Channel URL', 'ai-news'),
        'section' => 'ai_news_theme',
        'type' => 'url',
    ));
    $wp_customize->add_setting('ai_news_dark_mode', array('default' => true, 'sanitize_callback' => 'wp_validate_boolean'));
    $wp_customize->add_control('ai_news_dark_mode', array(
        'label' => __('Enable Dark Mode Toggle', 'ai-news'),
        'section' => 'ai_news_theme',
        'type' => 'checkbox',
    ));
}
