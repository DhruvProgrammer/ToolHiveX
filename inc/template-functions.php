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

/**
 * Inject id="..." attributes on every <h2> in post content
 * for TOC anchor linking. Skips h2 that already have an id.
 */
add_filter('the_content', 'ai_news_inject_heading_ids', 20);
function ai_news_inject_heading_ids($content) {
    if (!is_singular() || empty($content)) return $content;
    if (false === stripos($content, '<h2')) return $content;

    // Match <h2 ...>...</h2> and add id if missing.
    return preg_replace_callback(
        '/<h2([^>]*)>(.*?)<\/h2>/is',
        function ($m) {
            $attrs = $m[1];
            $inner = $m[2];
            // Already has id? leave it.
            if (preg_match('/\bid\s*=\s*["\'][^"\']*["\']/i', $attrs)) return $m[0];
            // Build slug from plain-text version of inner.
            $text = wp_strip_all_tags($inner);
            $slug = sanitize_title($text);
            if ('' === $slug) $slug = 'section-' . substr(md5($text), 0, 6);
            return '<h2' . $attrs . ' id="' . esc_attr($slug) . '">' . $inner . '</h2>';
        },
        $content
    );
}

/**
 * Render the Table of Contents for the current post.
 * Scans the (already-id-injected) post content for H2s
 * and outputs an accessible TOC. Mobile uses <details>.
 * Call inside the single template, before .single-content.
 */
function ai_news_toc() {
    if (!is_singular()) return;
    $post = get_post();
    if (!$post) return;
    $content = get_post_field('post_content', $post);
    // Apply the same filter so IDs match what renders on the page.
    $content = apply_filters('the_content', $content);
    if (false === stripos($content, '<h2')) return;

    // Pull every <h2> with an id (id injected by ai_news_inject_heading_ids).
    if (!preg_match_all('/<h2[^>]*\bid\s*=\s*["\']([^"\']+)["\'][^>]*>(.*?)<\/h2>/is', $content, $m)) return;

    $items = array();
    foreach ($m[1] as $i => $id) {
        $text = wp_strip_all_tags($m[2][$i]);
        if ('' === trim($text)) continue;
        $items[] = array('id' => $id, 'text' => $text);
    }
    if (count($items) < 2) return; // No TOC for <2 sections.
    ?>
    <nav class="toc" aria-label="Table of Contents">
      <details class="toc-details">
        <summary class="toc-summary">On this page</summary>
        <ol class="toc-list">
          <?php foreach ($items as $it) : ?>
            <li><a href="#<?php echo esc_attr($it['id']); ?>"><?php echo esc_html($it['text']); ?></a></li>
          <?php endforeach; ?>
        </ol>
      </details>
    </nav>
    <?php
}

