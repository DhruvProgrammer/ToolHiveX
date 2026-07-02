<?php
/**
 * Front Page v3 — Top Posts + Category Strips Layout
 * @package AI_News
 */
get_header();

$carousel = new WP_Query(array(
    'posts_per_page' => 5,
    'meta_key' => '_featured', 'meta_value' => '1',
    'meta_compare' => '=',
));
if (!$carousel->have_posts()) {
    $carousel = new WP_Query(array('posts_per_page' => 5));
}
$carousel_ids = $carousel->posts ? wp_list_pluck($carousel->posts, 'ID') : array();

$top_posts = new WP_Query(array('posts_per_page' => 6, 'post__not_in' => $carousel_ids));

$show_cats = get_categories(array('number' => 6, 'orderby' => 'count', 'order' => 'DESC'));

$trending = new WP_Query(array('posts_per_page' => 4, 'orderby' => 'comment_count', 'order' => 'DESC'));

$tools = new WP_Query(array('post_type' => 'ai_tool', 'posts_per_page' => 4, 'meta_key' => '_tool_rank', 'orderby' => 'meta_value_num', 'order' => 'ASC'));

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

  <!-- ====== 2. TOP POSTS ====== -->
  <?php if ($top_posts->have_posts()) : ?>
  <section class="section top-posts">
    <div class="container">
      <div class="section-header">
        <h2>Top Posts</h2>
        <p>The latest from AI News</p>
        <a href="<?php echo esc_url(home_url('/news')); ?>" class="section-cta">View All &rarr;</a>
      </div>
      <div class="article-grid">
        <?php while ($top_posts->have_posts()) : $top_posts->the_post(); ?>
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
                </div>
                <h3 class="article-card-title"><?php the_title(); ?></h3>
              </div>
            </a>
          </article>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- ====== 3. CATEGORY STRIPS ====== -->
  <?php if (!empty($show_cats)) : ?>
  <section class="section category-strips">
    <div class="container">
      <div class="section-header">
        <h2>Explore Topics</h2>
        <p>Dive into the categories that matter most in AI</p>
      </div>
      <?php foreach ($show_cats as $cat) : ?>
        <?php
        $cat_query = new WP_Query(array(
          'cat' => $cat->term_id,
          'posts_per_page' => 4,
          'post__not_in' => $carousel_ids,
          'no_found_rows' => true,
        ));
        if ($cat_query->have_posts()) :
        ?>
        <div class="category-strip">
          <div class="category-strip-header">
            <h3 class="category-strip-title"><?php echo esc_html($cat->name); ?></h3>
            <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="section-cta">View All &rarr;</a></div>
          <div class="category-strip-posts">
            <?php while ($cat_query->have_posts()) : $cat_query->the_post(); ?>
              <article class="category-strip-card">
                <a href="<?php the_permalink(); ?>" class="category-strip-link">
                  <div class="category-strip-img-wrap">
                    <?php if (has_post_thumbnail()) : ?>
                      <?php the_post_thumbnail('article-card'); ?>
                    <?php else : ?>
                      <div class="article-card-image-placeholder"></div>
                    <?php endif; ?>
                  </div>
                  <h4 class="category-strip-card-title"><?php the_title(); ?></h4>
                  <div class="category-strip-card-meta">
                    <span><?php echo get_the_date('M j, Y'); ?></span>
                  </div>
                </a>
              </article>
            <?php endwhile; wp_reset_postdata(); ?>
          </div>
        </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </section>
  <?php endif; ?>

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
          $contentb = get_post_meta(get_the_ID(), '_prompt_content', true);
        ?>
          <div class="prompt-card">
            <div class="prompt-card-header">
              <span class="prompt-type"><?php echo esc_html($type ?: 'general'); ?></span>
              <?php if ($model) : ?><span class="prompt-model"><?php echo esc_html($model); ?></span><?php endif; ?>
            </div>
            <h3 class="prompt-card-title"><?php the_title(); ?></h3>
            <?php if ($contentb) : ?>
              <pre class="prompt-code"><code><?php echo esc_html($contentb); ?></code></pre>
            <?php endif; ?>
            <button class="prompt-copy" data-content="<?php echo esc_attr($contentb); ?>">Copy Prompt</button>
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
          <div class="telegram-banner-left">
            <div class="telegram-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4z"/><path d="M22 2 11 13"/></svg>
            </div>
            <div class="telegram-banner-text">
              <span class="telegram-banner-sub">Join our Telegram for instant AI news & tools</span>
            </div>
          </div>
          <a href="<?php echo esc_url($telegram_url); ?>" target="_blank" rel="noopener" class="telegram-cta">
            Join Channel
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
        </div>
      </div>
    </div>
  </section>
  <style>.telegram-banner-sub { color:#ffffff !important; }</style>

</main>

<?php get_footer(); ?>
