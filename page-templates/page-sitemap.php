<?php
/**
 * Template Name: Sitemap
 * @package AI_News
 */
get_header();

$pages = get_pages(array('sort_column' => 'menu_order, post_title', 'hierarchical' => 0));
$categories = get_categories(array('hide_empty' => false));
$recent_posts = new WP_Query(array('posts_per_page' => 20));
$tools = new WP_Query(array('post_type' => 'ai_tool', 'posts_per_page' => 20));
$prompts = new WP_Query(array('post_type' => 'ai_prompt', 'posts_per_page' => 20));
?>

<main class="site-main page-privacy">
  <section class="section page-hero">
    <div class="container">
      <h1>Sitemap</h1>
      <p>Find your way around AI News. This page lists every section, every page, every category, and every tool so you can navigate the site with ease.</p>
    </div>
  </section>

  <section class="section">
    <div class="container legal-content">

      <h2>Pages</h2>
      <ul>
        <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
        <?php if (!empty($pages)) : foreach ($pages as $p) : if (home_url('/') . '?p=' . $p->ID === $p->guid) continue; ?>
          <li><a href="<?php echo esc_url(get_permalink($p->ID)); ?>"><?php echo esc_html($p->post_title); ?></a></li>
        <?php endforeach; endif; ?>
        <li><a href="<?php echo esc_url(home_url('/news')); ?>">News</a></li>
        <li><a href="<?php echo esc_url(home_url('/tools')); ?>">AI Tools</a></li>
        <li><a href="<?php echo esc_url(home_url('/prompts')); ?>">Prompts</a></li>
        <li><a href="<?php echo esc_url(home_url('/aboutus')); ?>">About Us</a></li>
        <li><a href="<?php echo esc_url(home_url('/contact')); ?>">Contact</a></li>
        <li><a href="<?php echo esc_url(home_url('/categories')); ?>">Categories</a></li>
        <li><a href="<?php echo esc_url(home_url('/privacy-policy')); ?>">Privacy Policy</a></li>
        <li><a href="<?php echo esc_url(home_url('/terms-of-service')); ?>">Terms of Service</a></li>
        <li><a href="<?php echo esc_url(home_url('/disclaimer')); ?>">Disclaimer</a></li>
      </ul>

      <h2>Categories</h2>
      <?php if (!empty($categories)) : ?>
        <ul>
          <?php foreach ($categories as $cat) : ?>
            <li><a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"><?php echo esc_html($cat->name); ?></a> &mdash; <?php echo intval($cat->count); ?> articles</li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <h2>Recent Articles</h2>
      <?php if ($recent_posts->have_posts()) : ?>
        <ul>
          <?php while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> &mdash; <em><?php echo get_the_date('M j, Y'); ?></em></li>
          <?php endwhile; wp_reset_postdata(); ?>
        </ul>
      <?php endif; ?>

      <h2>AI Tools</h2>
      <?php if ($tools->have_posts()) : ?>
        <ul>
          <?php while ($tools->have_posts()) : $tools->the_post(); ?>
            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
          <?php endwhile; wp_reset_postdata(); ?>
        </ul>
      <?php endif; ?>

      <h2>Prompts</h2>
      <?php if ($prompts->have_posts()) : ?>
        <ul>
          <?php while ($prompts->have_posts()) : $prompts->the_post(); ?>
            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
          <?php endwhile; wp_reset_postdata(); ?>
        </ul>
      <?php endif; ?>

      <h2>RSS Feeds</h2>
      <ul>
        <li><a href="<?php echo esc_url(home_url('/feed')); ?>">All Content</a></li>
        <li><a href="<?php echo esc_url(home_url('/feed/?post_type=ai_news')); ?>">AI News</a></li>
        <li><a href="<?php echo esc_url(home_url('/feed/?post_type=ai_tool')); ?>">AI Tools</a></li>
        <li><a href="<?php echo esc_url(home_url('/feed/?post_type=ai_prompt')); ?>">Prompts</a></li>
      </ul>

    </div>
  </section>
</main>

<?php get_footer(); ?>
