<?php
/**
 * Author Archive
 * @package AI_News
 */
get_header();

$author_id = get_query_var('author');
$author_name = get_the_author_meta('display_name', $author_id);
$author_desc = get_the_author_meta('description', $author_id);
$author_avatar = get_avatar_url($author_id, array('size' => 96));
?>

<main class="site-main">
  <header class="archive-header">
    <div style="display:flex;align-items:center;justify-content:center;gap:1.5rem;flex-wrap:wrap;margin-bottom:1.5rem;">
      <img src="<?php echo esc_url($author_avatar); ?>" alt="<?php echo esc_attr($author_name); ?>" style="width:72px;height:72px;border-radius:50%;">
      <div style="text-align:left;">
        <h1 class="archive-title" style="margin:0;"><?php echo esc_html($author_name); ?></h1>
        <?php if ($author_desc) : ?>
          <p class="archive-description" style="margin-top:0.5rem;"><?php echo esc_html($author_desc); ?></p>
        <?php endif; ?>
      </div>
    </div>
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
                <div class="article-card-footer">
                  <span class="article-card-date"><?php echo get_the_date('M j, Y'); ?></span>
                </div>
              </div>
            </a>
          </article>
        <?php endwhile; ?>
      </div>
      <div class="pagination"><?php the_posts_pagination(); ?></div>
    <?php else : ?>
      <p style="text-align:center;padding:4rem 0;color:var(--color-muted);"><?php _e('No posts by this author.', 'ai-news'); ?></p>
    <?php endif; ?>
  </div>
</main>

<?php get_footer(); ?>
