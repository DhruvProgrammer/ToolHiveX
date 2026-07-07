<?php
/**
 * Single AI News (Custom Post Type)
 * @package AI_News
 */
get_header(); ?>

<main class="site-main">
  <?php while (have_posts()) : the_post(); ?>
    <article class="single-article">
      <div class="container">
        <div class="entry-meta">
          <span class="article-card-category"><?php echo esc_html(get_post_meta(get_the_ID(), '_news_category', true) ?: 'AI News'); ?></span>
          <span class="sep">/</span>
          <span class="entry-date"><?php echo get_the_date(); ?></span>
          <span class="sep">/</span>
          <span class="entry-readtime"><?php echo esc_html(get_post_meta(get_the_ID(), '_read_time', true) ?: '5 min'); ?> read</span>
        </div>

        <h1 class="entry-title"><?php the_title(); ?></h1>

        <?php
          $ain_summary = get_post_meta(get_the_ID(), '_article_excerpt', true);
          if (!$ain_summary) $ain_summary = wp_strip_all_tags(get_the_excerpt());
          if ($ain_summary) :
        ?>
          <div class="single-summary">
            <span class="single-summary-label">Summary:</span>
            <p class="single-summary-text"><?php echo esc_html(wp_trim_words($ain_summary, 30)); ?></p>
          </div>
        <?php endif; ?>

        <div class="hero-meta" style="margin-bottom:2rem;">
          <div class="hero-meta-item">
            <span class="author-avatar"><?php echo get_avatar(get_the_author_meta('ID'), 32); ?></span>
            <span><?php the_author(); ?></span>
          </div>
        </div>

        <?php if (has_post_thumbnail()) : ?>
          <div class="post-thumbnail"><?php the_post_thumbnail('article-single'); ?></div>
        <?php endif; ?>

        <div class="entry-content"><?php the_content(); ?></div>

        <?php
        $tags = get_the_tags();
        if ($tags) : ?>
          <div class="entry-tags" style="display:flex;flex-wrap:wrap;gap:0.5rem;margin-top:3rem;">
            <?php foreach ($tags as $t) : ?>
              <a href="<?php echo get_tag_link($t->term_id); ?>" style="font-family:var(--font-mono);font-size:0.75rem;color:var(--color-muted);padding:0.25rem 0.75rem;border:1px solid var(--color-border);border-radius:var(--radius-sm);">#<?php echo $t->name; ?></a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <div class="post-navigation" style="display:flex;justify-content:space-between;margin-top:4rem;padding-top:2rem;border-top:1px solid var(--color-border);font-family:var(--font-mono);font-size:0.875rem;">
          <div class="nav-previous"><?php previous_post_link('%link', '&#8592; %title'); ?></div>
          <div class="nav-next"><?php next_post_link('%link', '%title &#8594;'); ?></div>
        </div>

        <?php if (comments_open() || get_comments_number()) comments_template(); ?>
      </div>
    </article>
  <?php endwhile; ?>
</main>

<?php get_footer(); ?>
