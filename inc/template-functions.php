<?php
/**
 * Template functions and helpers
 * @package AI_News
 */

if (!defined('ABSPATH')) exit;

/**
 * Get estimated read time for a post
 */
function ai_news_estimated_read_time($post_id = null) {
    if (!$post_id) $post_id = get_the_ID();
    $content = get_post_field('post_content', $post_id);
    $words = str_word_count(wp_strip_all_tags($content));
    $minutes = ceil($words / 200);
    return $minutes < 1 ? 1 : $minutes;
}

/**
 * Output post meta strip
 */
function ai_news_post_meta($post_id = null) {
    if (!$post_id) $post_id = get_the_ID();
    $cats = get_the_category($post_id);
    $read_time = get_post_meta($post_id, '_read_time', true) ?: ai_news_estimated_read_time($post_id);
    ?>
    <span class="article-card-category"><?php echo $cats ? $cats[0]->name : 'General'; ?></span>
    <span class="article-card-readtime"><?php echo esc_html($read_time); ?> min</span>
    <?php
}

/**
 * Paginated query for custom post types
 */
function ai_news_query($post_type, $count = 10, $args = array()) {
    $defaults = array(
        'post_type' => $post_type,
        'posts_per_page' => $count,
        'paged' => get_query_var('paged') ?: 1,
    );
    return new WP_Query(array_merge($defaults, $args));
}
