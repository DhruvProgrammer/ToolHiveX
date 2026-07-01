<?php
/**
 * Category Archive
 * @package AI_News
 */
get_header(); ?>

<main class="site-main">
  <header class="archive-header">
    <h1 class="archive-title"><?php single_cat_title(); ?></h1>
    <?php if (category_description()) : ?>
      <div class="archive-description"><?php echo category_description(); ?></div>
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
                <div class="article-card-meta">
                  <span class="article-card-category"><?php single_cat_title('', false); ?></span>
                </div>
                <h3 class="article-card-title"><?php the_title(); ?></h3>
                <p class="article-card-excerpt"><?php echo get_the_excerpt(); ?></p>
                <div class="article-card-footer">
                  <div class="article-card-author">
                    <span class="author-avatar"><?php echo get_avatar(get_the_author_meta('ID'), 28); ?></span>
                    <span class="article-card-author-name"><?php the_author(); ?></span>
                  </div>
                  <span class="article-card-date"><?php echo get_the_date('M j'); ?></span>
                </div>
              </div>
            </a>
          </article>
        <?php endwhile; ?>
      </div>
      <div class="pagination"><?php the_posts_pagination(); ?></div>
    <?php else : ?>
      <p style="text-align:center;padding:4rem 0;color:var(--color-muted);"><?php _e('No posts in this category.', 'ai-news'); ?></p>
    <?php endif; ?>
  </div>
</main>

<?php get_footer(); ?>
