<?php
/**
 * Single Post Template
 * @package AI_News
 */
get_header();

while (have_posts()) : the_post();
  $read_time = get_post_meta(get_the_ID(), '_read_time', true);
  $featured = get_post_meta(get_the_ID(), '_featured', true);
  $categories = get_the_category();
  $tags = get_the_tags();
  $prev = get_previous_post();
  $next = get_next_post();
  $related = new WP_Query(array(
    'posts_per_page' => 3,
    'post__not_in' => array(get_the_ID()),
    'category__in' => $categories ? wp_list_pluck($categories, 'term_id') : array(),
    'orderby' => 'rand',
  ));
?>

<main class="site-main">
  <article class="single-article">
    <div class="container container-narrow">
      <div class="single-header">
        <div class="single-meta-top">
          <?php if ($categories) : ?><span class="single-category"><a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>"><?php echo $categories[0]->name; ?></a></span><?php endif; ?>
          <?php if ($featured) : ?><span class="single-featured-badge">Featured</span><?php endif; ?>
        </div>
        <h1 class="single-title"><?php the_title(); ?></h1>
        <div class="single-meta">
          <span class="single-author">By <?php the_author(); ?></span>
          <span class="single-date"><?php echo get_the_date('F j, Y'); ?></span>
          <?php if ($read_time) : ?><span class="single-readtime"><?php echo esc_html($read_time); ?> min read</span><?php endif; ?>
        </div>
      </div>

      <?php if (has_post_thumbnail()) : ?>
        <div class="single-image">
          <?php the_post_thumbnail('article-single', array('class' => 'single-featured-image')); ?>
        </div>
      <?php endif; ?>

      <div class="single-content">
        <?php the_content(); ?>
      </div>

      <?php if ($tags) : ?>
        <div class="single-tags">
          <span class="tags-label">Tags:</span>
          <?php foreach ($tags as $tag) : ?>
            <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="tag-link">#<?php echo $tag->name; ?></a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </article>

  <nav class="post-navigation container container-narrow">
    <div class="post-nav-inner">
      <div class="post-nav-prev">
        <?php if ($prev) : ?>
          <span class="post-nav-label">Previous</span>
          <a href="<?php echo get_permalink($prev); ?>" class="post-nav-link"><?php echo get_the_title($prev); ?></a>
        <?php endif; ?>
      </div>
      <div class="post-nav-next">
        <?php if ($next) : ?>
          <span class="post-nav-label">Next</span>
          <a href="<?php echo get_permalink($next); ?>" class="post-nav-link"><?php echo get_the_title($next); ?></a>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <?php if ($related->have_posts()) : ?>
    <section class="section related-posts">
      <div class="container">
        <div class="section-header">
          <h2>Related Articles</h2>
        </div>
        <div class="article-grid">
          <?php while ($related->have_posts()) : $related->the_post(); ?>
            <article class="article-card">
              <a href="<?php the_permalink(); ?>" class="article-card-link">
                <div class="article-card-image-wrapper">
                  <?php if (has_post_thumbnail()) : ?><?php the_post_thumbnail('article-card'); ?><?php else : ?><div class="article-card-image-placeholder"></div><?php endif; ?>
                </div>
                <div class="article-card-content">
                  <div class="article-card-meta">
                    <span class="article-card-category"><?php $c = get_the_category(); echo $c ? $c[0]->name : 'General'; ?></span>
                    <span class="article-card-readtime"><?php echo get_post_meta(get_the_ID(), '_read_time', true) ?: '5 min'; ?></span>
                  </div>
                  <h3 class="article-card-title"><?php the_title(); ?></h3>
                  <p class="article-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                </div>
              </a>
            </article>
          <?php endwhile; wp_reset_postdata(); ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <section class="section comments-section container container-narrow">
    <?php comments_template(); ?>
  </section>
</main>

<?php
endwhile;
get_footer();
?>
