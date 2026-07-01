<?php
/**
 * Template Name: AI Tools
 * @package AI_News
 */
get_header();

$paged = get_query_var('paged') ?: 1;
$tools = new WP_Query(array(
    'post_type' => 'ai_tool',
    'posts_per_page' => 12,
    'meta_key' => '_tool_rank',
    'orderby' => 'meta_value_num',
    'order' => 'ASC',
    'paged' => $paged,
));
?>

<main class="site-main page-tools">
  <section class="section page-hero">
    <div class="container">
      <h1>AI Tools Directory</h1>
      <p>Curated collection of the best artificial intelligence tools. Ranked by utility, popularity, and innovation.</p>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <?php if ($tools->have_posts()) : ?>
        <div class="tools-list">
          <?php while ($tools->have_posts()) : $tools->the_post();
            $rank = get_post_meta(get_the_ID(), '_tool_rank', true);
            $rating = get_post_meta(get_the_ID(), '_tool_rating', true);
            $pricing = get_post_meta(get_the_ID(), '_tool_pricing', true);
            $tagline = get_post_meta(get_the_ID(), '_tool_tagline', true);
            $url = get_post_meta(get_the_ID(), '_tool_url', true);
          ?>
            <div class="tool-item">
              <div class="tool-item-rank">#<?php echo esc_html($rank ?: '?'); ?></div>
              <div class="tool-item-content">
                <h3 class="tool-item-title"><?php the_title(); ?></h3>
                <?php if ($tagline) : ?><p class="tool-item-tagline"><?php echo esc_html($tagline); ?></p><?php endif; ?>
                <?php if (has_excerpt()) : ?><p class="tool-item-desc"><?php echo get_the_excerpt(); ?></p><?php endif; ?>
                <div class="tool-item-meta">
                  <?php if ($rating) : ?>
                    <span class="tool-item-rating"><?php echo str_repeat('★', intval($rating)); ?><?php echo str_repeat('☆', 5 - intval($rating)); ?> (<?php echo esc_html($rating); ?>/5)</span>
                  <?php endif; ?>
                  <?php if ($pricing) : ?><span class="tool-item-pricing"><?php echo esc_html($pricing); ?></span><?php endif; ?>
                </div>
              </div>
              <div class="tool-item-action">
                <?php if ($url) : ?><a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener" class="button">Visit &rarr;</a><?php endif; ?>
              </div>
            </div>
          <?php endwhile; wp_reset_postdata(); ?>
        </div>

        <div class="pagination">
          <?php echo paginate_links(array(
            'total' => $tools->max_num_pages,
            'current' => $paged,
            'mid_size' => 2,
          )); ?>
        </div>
      <?php else : ?>
        <p class="no-results">No tools listed yet. Check back soon!</p>
      <?php endif; ?>
    </div>
  </section>
</main>

<?php get_footer(); ?>
