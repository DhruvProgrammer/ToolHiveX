<?php
/**
 * Template Name: News Listing
 * @package AI_News
 */
get_header();

$paged = max(1, get_query_var('paged') ?: get_query_var('page') ?: 1);
$news_query = new WP_Query(array(
    'post_type' => 'ai_news',
    'posts_per_page' => 12,
    'paged' => $paged,
));

$categories = get_categories(array('number' => 8, 'orderby' => 'count', 'order' => 'DESC', 'hide_empty' => false));
?>

<main class="site-main page-news">
  <section class="section page-hero">
    <div class="container">
      <h1>Latest AI News & Updates</h1>
      <p>Daily coverage of the artificial intelligence industry &mdash; new models, product launches, research breakthroughs, policy changes, and more.</p>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <?php if (!empty($categories)) : ?>
        <nav class="news-filters" aria-label="Filter by category">
          <a href="<?php echo esc_url(home_url('/news')); ?>" class="news-filter active">All</a>
          <?php foreach ($categories as $cat) : ?>
            <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="news-filter"><?php echo esc_html($cat->name); ?></a>
          <?php endforeach; ?>
        </nav>
      <?php endif; ?>

      <?php if ($news_query->have_posts()) : ?>
        <div class="article-grid">
          <?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
            <article class="article-card">
              <a href="<?php the_permalink(); ?>" class="article-card-link">
                <div class="article-card-image-wrapper">
                  <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('article-card'); ?>
                  <?php else : ?>
                    <div class="article-card-image-placeholder"></div>
                  <?php endif; ?>
                </div>
                <div class="article-card-content">
                  <div class="article-card-meta">
                    <?php $cats = get_the_category(); if ($cats) : ?>
                      <span class="article-card-category"><?php echo esc_html($cats[0]->name); ?></span>
                    <?php endif; ?>
                    <span class="article-card-readtime"><?php echo get_post_meta(get_the_ID(), '_read_time', true) ?: '5'; ?> min read</span>
                  </div>
                  <h3 class="article-card-title"><?php the_title(); ?></h3>
                  <p class="article-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 18); ?></p>
                  <div class="article-card-footer">
                    <?php echo get_the_date('M j, Y'); ?>
                  </div>
                </div>
              </a>
            </article>
          <?php endwhile; wp_reset_postdata(); ?>
        </div>

        <div class="pagination">
          <?php echo paginate_links(array(
            'total' => $news_query->max_num_pages,
            'current' => $paged,
            'mid_size' => 2,
          )); ?>
        </div>
      <?php else : ?>
        <p class="no-results">No news articles published yet. Check back soon!</p>
      <?php endif; ?>
    </div>
  </section>

  <section class="section">
    <div class="container legal-content">
      <h2>Stay Ahead of the AI Curve</h2>
      <p>AI News publishes daily coverage of the artificial intelligence industry. Our editors monitor announcements from leading labs (OpenAI, Anthropic, Google DeepMind, Meta, Mistral, and more), product launches, open-source releases, and policy developments. Every story is summarized in clear, actionable language &mdash; no jargon, no fluff.</p>

      <h3>What You'll Find Here</h3>
      <ul>
        <li><strong>Model Releases</strong> &mdash; new versions, capabilities, benchmarks, and API changes</li>
        <li><strong>Product Launches</strong> &mdash; consumer and enterprise AI tools hitting the market</li>
        <li><strong>Research Breakthroughs</strong> &mdash; peer-reviewed papers, arXiv preprints, and key advances</li>
        <li><strong>Industry Moves</strong> &mdash; funding rounds, acquisitions, partnerships, and hires</li>
        <li><strong>Policy & Governance</strong> &mdash; regulations, safety standards, and ethics debates</li>
        <li><strong>Open Source</strong> &mdash; new libraries, model weights, and developer tooling</li>
      </ul>

      <p>Use the category buttons above to filter by topic, or browse the full feed below. Subscribe to our newsletter to get a curated digest delivered straight to your inbox.</p>
    </div>
  </section>
</main>

<?php get_footer(); ?>
