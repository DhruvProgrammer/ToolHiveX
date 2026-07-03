<?php
/**
 * Template Name: Categories Overview
 * @package AI_News
 */
get_header();

$categories = get_categories(array(
    'orderby' => 'count',
    'order'   => 'DESC',
    'hide_empty' => false,
));

$cat_icons = array(
    'default' => 'M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5',
    'hardware' => 'M9 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-4M9 3v18M15 3v18',
    'research' => 'M21 21l-4.35-4.35M11 19a8 8 0 1 0-8-8M19 11a8 8 0 0 1-16 0',
    'governance' => 'M12 2L3 7v6c0 5.5 3.8 10.7 9 12 5.2-1.3 9-6.5 9-12V7l-9-5z',
    'ethics' => 'M12 2a10 10 0 0 1 0 20 10 10 0 0 1 0-20zM12 8v4M12 16h.01',
    'open-source' => 'M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18',
    'tools' => 'M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z',
    'education' => 'M22 10v6M2 10l10-5 10 5-10 5z M6 12v5c3 3 9 3 12 0v-5',
    'business' => 'M3 3h18v18H3zM9 9h6v6H9z',
);
?>

<main class="site-main page-categories">
  <section class="section page-hero">
    <div class="container">
      <h1>Explore AI Topics & Categories</h1>
      <p>Dive into the areas of artificial intelligence that matter most. From breakthrough research to hands-on tools, our categories help you find exactly what you're looking for.</p>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <?php if (!empty($categories)) : ?>
        <div class="categories-grid">
          <?php foreach ($categories as $cat) :
            $slug = strtolower($cat->slug);
            $icon_path = isset($cat_icons[$slug]) ? $cat_icons[$slug] : $cat_icons['default'];
          ?>
            <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="category-card">
              <div class="category-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="<?php echo esc_attr($icon_path); ?>"/></svg>
              </div>
              <span class="category-card-name"><?php echo esc_html($cat->name); ?></span>
              <span class="category-card-count"><?php echo intval($cat->count); ?> <?php echo $cat->count === 1 ? 'article' : 'articles'; ?></span>
            </a>
          <?php endforeach; ?>
        </div>
      <?php else : ?>
        <p class="no-results">No categories found yet.</p>
      <?php endif; ?>
    </div>
  </section>

  <section class="section">
    <div class="container legal-content">
      <h2>Find What You're Looking For</h2>
      <p>AI is a vast and rapidly evolving field, which can feel overwhelming. That's why we organize our content into clear, focused categories. Whether you're tracking the latest foundation models, hunting for productivity tools, exploring ethical debates, or comparing open-source frameworks, you'll find dedicated coverage here.</p>

      <h3>Why Browse by Category?</h3>
      <ul>
        <li><strong>Stay focused</strong> on the topics that matter to your work</li>
        <li><strong>Discover patterns</strong> across stories in the same domain</li>
        <li><strong>Save time</strong> by skipping what doesn't apply to you</li>
        <li><strong>Track trends</strong> with category-specific updates</li>
      </ul>

      <p>Each category page aggregates every article, prompt, and tool related to that topic. You can subscribe to a category RSS feed or simply check back weekly &mdash; we publish around the latest developments in every area.</p>
    </div>
  </section>
</main>

<?php get_footer(); ?>
