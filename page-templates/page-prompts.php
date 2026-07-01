<?php
/**
 * Template Name: AI Prompts
 * @package AI_News
 */
get_header();

$paged = get_query_var('paged') ?: 1;
$prompts = new WP_Query(array(
    'post_type' => 'ai_prompt',
    'posts_per_page' => 12,
    'paged' => $paged,
));
?>

<main class="site-main page-tools">
  <section class="section page-hero">
    <div class="container">
      <h1>AI Prompts</h1>
      <p>Ready-to-use prompts for ChatGPT, Claude, Gemini, and more. Copy, paste, and supercharge your AI interactions.</p>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <?php if ($prompts->have_posts()) : ?>
        <div class="prompts-grid page-prompts-grid">
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

        <div class="pagination">
          <?php echo paginate_links(array(
            'total' => $prompts->max_num_pages,
            'current' => $paged,
            'mid_size' => 2,
          )); ?>
        </div>
      <?php else : ?>
        <p class="no-results">No prompts found yet. Check back soon!</p>
      <?php endif; ?>
    </div>
  </section>

  <section class="section dark-section">
    <div class="container">
      <div class="cta-box">
        <h2>Have a Great Prompt to Share?</h2>
        <p>We're building the largest collection of AI prompts. Stay tuned for submissions!</p>
        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="cta-button">Contact Us</a>
      </div>
    </div>
  </section>
</main>

<?php get_footer(); ?>
