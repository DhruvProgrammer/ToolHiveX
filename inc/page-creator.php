<?php
/**
 * ONE-TIME: Create all default pages if they don't exist.
 * Activate by visiting: /?ai_news_init_pages=1 (logged in as admin).
 * Delete this file afterwards (recommended for safety).
 * @package AI_News
 */

add_action('init', 'ai_news_maybe_create_default_pages');

function ai_news_maybe_create_default_pages() {
    if (!isset($_GET['ai_news_init_pages'])) return;
    if (!is_user_logged_in() || !current_user_can('manage_options')) {
        wp_die('You must be logged in as an admin to run this.');
    }

    // Map: slug => [title, template filename]
    $pages = array(
        // ['title', 'template-file'], 'slug' => title-derived
        'aboutus'             => array('About Us',                'page-templates/page-about.php'),
        'contact'             => array('Contact Us',              'page-templates/page-contact.php'),
        'privacy-policy'      => array('Privacy Policy',          'page-templates/page-privacy.php'),
        'terms-of-service'    => array('Terms of Service',        'page-templates/page-terms.php'),
        'disclaimer'          => array('Disclaimer',              'page-templates/page-disclaimer.php'),
        'news'                => array('News',                    'page-templates/page-news.php'),
        'tools'               => array('AI Tools',                'page-templates/page-tools.php'),
        'prompts'             => array('AI Prompts',              'page-templates/page-prompts.php'),
        'categories'          => array('Categories',              'page-templates/page-categories.php'),
        'sitemap'             => array('Sitemap',                 'page-templates/page-sitemap.php'),
        'newsletter'          => array('Newsletter',              'page-templates/page-newsletter.php'),
    );

    $created = array();
    $skipped = array();

    foreach ($pages as $slug => $row) {
        list($title, $template) = $row;
        $existing = get_page_by_path($slug);
        if ($existing) {
            $skipped[] = $slug;
            continue;
        }
        $page_id = wp_insert_post(array(
            'post_title'     => $title,
            'post_name'      => $slug,
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'post_content'   => '',
            'post_author'    => get_current_user_id(),
            'comment_status' => 'closed',
        ));
        if ($page_id && !is_wp_error($page_id)) {
            update_post_meta($page_id, '_wp_page_template', $template);
            $created[] = $slug . ' (' . $title . ')';
        }
    }

    wp_die(
        '<h2>Page creation complete.</h2>' .
        '<p><strong>Created:</strong></p><ul><li>' . implode('</li><li>', $created) . '</li></ul>' .
        '<p><strong>Already existed:</strong></p><ul><li>' . (empty($skipped) ? '—' : implode('</li><li>', $skipped)) . '</li></ul>' .
        '<p><em>Please delete <code>inc/page-creator.php</code> from the theme now that the pages have been created.</em></p>',
        'AI News — Page Init'
    );
}
