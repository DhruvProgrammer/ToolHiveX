<?php
/**
 * Tag Archive
 * @package AI_News
 */
get_header(); ?>

<main class="site-main">
  <header class="archive-header">
    <h1 class="archive-title">
      <span style="font-family:var(--font-mono);color:var(--color-primary);font-size:0.875rem;">#</span>
      <?php single_tag_title(); ?>
    </h1>
    <?php if (tag_description()) : ?>
      <div class="archive-description"><?php echo tag_description(); ?></div>
    <?php endif; ?>
  </header>

  <div class="container">
    <?php if (have_posts()) : ?>
      <div class="article-grid">
        <?php while (have_posts()) : the_post(); ?>
          <article class="article-card">
            <a href="<?php the_permalink(); ?>" class="article-card-link">
              <?php if (has_post_thumbnail()) : ?>
                <div class="article-card-image-wrapper"><?php the_post_thumbnail('article-card'); ?></div>
              <?php endif; ?>
              <div class="article-card-content">
                <h3 class="article-card-title"><?php the_title(); ?></h3>
                <p class="article-card-excerpt"><?php echo get_the_excerpt(); ?></p>
                <div class="article-card-meta">
                  <span class="article-card-date"><?php echo get_the_date(); ?></span>
                </div>
              </div>
            </a>
          </article>
        <?php endwhile; ?>
      </div>
      <div class="pagination"><?php the_posts_pagination(); ?></div>
    <?php else : ?>
      <p style="text-align:center;padding:4rem 0;color:var(--color-muted);"><?php _e('No posts with this tag.', 'ai-news'); ?></p>
    <?php endif; ?>
  </div>
</main>

<?php get_footer(); ?>
