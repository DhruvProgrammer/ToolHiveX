<?php
/**
 * Front Page v2 — Carousel + 6 sections + Telegram banner + Newsletter
 * @package AI_News
 */
get_header();

// Featured posts for carousel (up to 5)
$carousel = new WP_Query(array(
    'posts_per_page' => 5,
    'meta_key' => '_featured', 'meta_value' => '1',
    'meta_compare' => '=',
));

if (!$carousel->have_posts()) {
    $carousel = new WP_Query(array('posts_per_page' => 5));
}

// Latest news
$latest = new WP_Query(array('posts_per_page' => 6, 'post__not_in' => $carousel->posts ? wp_list_pluck($carousel->posts, 'ID') : array()));

// Trending / popular (by comment count)
$trending = new WP_Query(array('posts_per_page' => 4, 'orderby' => 'comment_count', 'order' => 'DESC'));

// Categories showcase
$show_cats = get_categories(array('number' => 6, 'orderby' => 'count', 'order' => 'DESC'));

// Tools
$tools = new WP_Query(array('post_type' => 'ai_tool', 'posts_per_page' => 4, 'meta_key' => '_tool_rank', 'orderby' => 'meta_value_num', 'order' => 'ASC'));

// Prompts
$prompts = new WP_Query(array('post_type' => 'ai_prompt', 'posts_per_page' => 3));

$telegram_url = get_theme_mod('ai_news_telegram_url', 'https://t.me/your_channel');
?>

<main class="site-main">

  <!-- ====== 1. CAROUSEL ====== -->
  <section class="carousel-section">
    <div class="carousel-container">
      <div class="carousel-track" id="carousel-track">
        <?php if ($carousel->have_posts()) : $i = 0; while ($carousel->have_posts()) : $carousel->the_post(); $i++; ?>
          <div class="carousel-slide <?php echo $i === 1 ? 'active' : ''; ?>">
            <a href="<?php the_permalink(); ?>" class="carousel-link">
              <div class="carousel-bg">
                <?php if (has_post_thumbnail()) : ?>
                  <?php the_post_thumbnail('carousel-slide'); ?>
                <?php else : ?>
                  <div class="carousel-bg-placeholder"></div>
                <?php endif; ?>
                <div class="carousel-overlay"></div>
              </div>
              <div class="carousel-content">
                <div class="carousel-category"><?php $cats = get_the_category(); echo $cats ? $cats[0]->name : 'Featured'; ?></div>
                <h2 class="carousel-title"><?php the_title(); ?></h2>
                <p class="carousel-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                <div class="carousel-meta">
                  <span class="carousel-date"><?php echo get_the_date('M j, Y'); ?></span>
                  <span class="carousel-read"><?php echo get_post_meta(get_the_ID(), '_read_time', true) ?: '5 min'; ?> read</span>
                </div>
              </div>
            </a>
          </div>
        <?php endwhile; wp_reset_postdata(); endif; ?>
      </div>

      <button class="carousel-btn carousel-prev" aria-label="Previous slide">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
      </button>
      <button class="carousel-btn carousel-next" aria-label="Next slide">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
      </button>

      <div class="carousel-dots" id="carousel-dots"></div>
    </div>
  </section>

  <!-- ====== 2. CATEGORIES SHOWCASE ====== -->
  <?php if ($show_cats) : ?>
  <section class="section categories-showcase">
    <div class="container">
      <div class="section-header">
        <h2>Explore Topics</h2>
        <p>Dive into the categories that matter most in AI</p>
      </div>
      <div class="categories-grid">
        <?php foreach ($show_cats as $cat) : ?>
          <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="category-card">
            <div class="category-card-icon">
              <?php
              $icons = array('Hardware' => '⚡', 'Governance' => '⚖️', 'Open Source' => '🔓', 'Research' => '🔬', 'Ethics' => '🧭', 'AI' => '🤖');
              echo isset($icons[$cat->name]) ? $icons[$cat->name] : '📰';
              ?>
            </div>
            <h3 class="category-card-name"><?php echo esc_html($cat->name); ?></h3>
            <span class="category-card-count"><?php echo $cat->count; ?> articles</span>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- ====== 3. LATEST NEWS ====== -->
  <section class="section latest-news">
    <div class="container">
      <div class="section-header">
        <h2>Latest News</h2>
        <p>Stay updated with the newest developments in AI</p>
        <a href="<?php echo esc_url(home_url('/news')); ?>" class="section-cta">View All News &rarr;</a>
      </div>
      <div class="article-grid">
        <?php if ($latest->have_posts()) : while ($latest->have_posts()) : $latest->the_post(); ?>
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
                  <span class="article-card-category"><?php $cats = get_the_category(); echo $cats ? $cats[0]->name : 'General'; ?></span>
                  <span class="article-card-readtime"><?php echo get_post_meta(get_the_ID(), '_read_time', true) ?: '5 min'; ?></span>
                </div>
                <h3 class="article-card-title"><?php the_title(); ?></h3>
                <p class="article-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                <div class="article-card-footer">
                  <span class="article-card-date"><?php echo get_the_date('M j, Y'); ?></span>
                </div>
              </div>
            </a>
          </article>
        <?php endwhile; wp_reset_postdata(); endif; ?>
      </div>
    </div>
  </section>

  <!-- ====== 4. TRENDING / POPULAR ====== -->
  <?php if ($trending->have_posts()) : ?>
  <section class="section trending-news bg-surface">
    <div class="container">
      <div class="section-header">
        <h2>Trending Now</h2>
        <p>What everyone is reading right now</p>
      </div>
      <div class="trending-grid">
        <?php $rank = 1; while ($trending->have_posts()) : $trending->the_post(); ?>
          <a href="<?php the_permalink(); ?>" class="trending-card">
            <span class="trending-rank"><?php echo $rank++; ?></span>
            <div class="trending-content">
              <h3 class="trending-title"><?php the_title(); ?></h3>
              <span class="trending-meta"><?php echo get_comments_number(); ?> comments &middot; <?php echo get_the_date('M j'); ?></span>
            </div>
          </a>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- ====== 5. AI TOOLS ====== -->
  <?php if ($tools->have_posts()) : ?>
  <section class="section tools-section">
    <div class="container">
      <div class="section-header">
        <h2>Top AI Tools</h2>
        <p>Hand-picked tools to supercharge your workflow</p>
        <a href="<?php echo esc_url(home_url('/tools')); ?>" class="section-cta">View All Tools &rarr;</a>
      </div>
      <div class="tools-grid">
        <?php while ($tools->have_posts()) : $tools->the_post();
          $rank = get_post_meta(get_the_ID(), '_tool_rank', true);
          $rating = get_post_meta(get_the_ID(), '_tool_rating', true);
          $pricing = get_post_meta(get_the_ID(), '_tool_pricing', true);
          $tagline = get_post_meta(get_the_ID(), '_tool_tagline', true);
        ?>
          <div class="tool-card">
            <div class="tool-card-header">
              <span class="tool-rank">#<?php echo esc_html($rank ?: '?'); ?></span>
              <span class="tool-rating"><?php if ($rating) : ?><?php echo str_repeat('★', intval($rating)); ?><?php echo str_repeat('☆', 5 - intval($rating)); ?><?php endif; ?></span>
            </div>
            <h3 class="tool-card-title"><?php the_title(); ?></h3>
            <?php if ($tagline) : ?><p class="tool-card-tagline"><?php echo esc_html($tagline); ?></p><?php endif; ?>
            <div class="tool-card-footer">
              <?php if ($pricing) : ?><span class="tool-pricing"><?php echo esc_html($pricing); ?></span><?php endif; ?>
              <?php $url = get_post_meta(get_the_ID(), '_tool_url', true); if ($url) : ?><a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener" class="tool-visit">Visit &rarr;</a><?php endif; ?>
            </div>
          </div>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- ====== 6. PROMPTS ====== -->
  <?php if ($prompts->have_posts()) : ?>
  <section class="section prompts-section dark-section">
    <div class="container">
      <div class="section-header light">
        <h2>Featured Prompts</h2>
        <p>Ready-to-use prompts for your favorite AI models</p>
        <a href="<?php echo esc_url(home_url('/prompts')); ?>" class="section-cta light">Explore Prompts &rarr;</a>
      </div>
      <div class="prompts-grid">
        <?php while ($prompts->have_posts()) : $prompts->the_post();
          $model = get_post_meta(get_the_ID(), '_prompt_model', true);
          $type = get_post_meta(get_the_ID(), '_prompt_type', true);
          $content = get_post_meta(get_the_ID(), '_prompt_content', true);
        ?>
          <div class="prompt-card">
            <div class="prompt-card-header">
              <span class="prompt-type"><?php echo esc_html($type ?: 'general'); ?></span>
              <?php if ($model) : ?><span class="prompt-model"><?php echo esc_html($model); ?></span><?php endif; ?>
            </div>
            <h3 class="prompt-card-title"><?php the_title(); ?></h3>
            <?php if ($content) : ?>
              <pre class="prompt-code"><code><?php echo esc_html($content); ?></code></pre>
            <?php endif; ?>
            <button class="prompt-copy" data-content="<?php echo esc_attr($content); ?>">Copy Prompt</button>
          </div>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- ====== 7. TELEGRAM BANNER ====== -->
  <section class="telegram-banner-section">
    <div class="container">
      <div class="telegram-banner">
        <div class="telegram-banner-content">
          <div class="telegram-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="currentColor"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.127.087.669.087.669l-1.345 6.34s-.103.367-.448.367a.563.563 0 0 1-.267-.07C14.34 14.21 11 12.343 9.623 11.555c-.142-.08-.212-.228-.148-.358.021-.037.052-.064.058-.07.006-.006.466-.546.466-.546l2.138-2.29c.156-.185.35-.28.544-.28z"/></svg>
          </div>
          <h2>Join Our Telegram Channel</h2>
          <p>Get instant updates, exclusive content, and breaking AI news delivered straight to your Telegram.</p>
          <a href="<?php echo esc_url($telegram_url); ?>" target="_blank" rel="noopener" class="telegram-cta">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.127.087.669.087.669l-1.345 6.34s-.103.367-.448.367a.563.563 0 0 1-.267-.07C14.34 14.21 11 12.343 9.623 11.555c-.142-.08-.212-.228-.148-.358.021-.037.052-.064.058-.07.006-.006.466-.546.466-.546l2.138-2.29c.156-.185.35-.28.544-.28z"/></svg>
            Join @AINewsChannel
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- ====== 8. NEWSLETTER ====== -->
  <section class="newsletter-section">
    <div class="container">
      <div class="newsletter-box">
        <h2>Never Miss an Update</h2>
        <p>Subscribe to our newsletter and get the latest AI news, tools, and prompts delivered weekly.</p>
        <form class="newsletter-form" id="newsletter-form">
          <input type="email" id="newsletter-email" placeholder="your@email.com" required>
          <button type="submit">Subscribe</button>
        </form>
        <p class="newsletter-message" id="newsletter-message"></p>
        <p class="newsletter-subscribers">Join thousands of AI enthusiasts</p>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>
