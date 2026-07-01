<?php
/**
 * The main template file for the AI News theme.
 * Displays the hero section and latest posts grid.
 * 
 * @package AI_News
 */
get_header(); 

// Query for featured post (newest post marked as featured)
$featured_args = array(
    'posts_per_page' => 1,
    'meta_key'       => '_featured',
    'meta_value'     => '1',
);
$featured_query = new WP_Query($featured_args);

// Query for latest posts (excluding the featured one)
$latest_args = array(
    'posts_per_page' => 6,
    'post__not_in'   => $featured_query->posts ? array($featured_query->posts[0]->ID) : array(),
);
$latest_query = new WP_Query($latest_args);
?>

<main class="site-main">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <?php if ($featured_query->have_posts()) : while ($featured_query->have_posts()) : $featured_query->the_post(); ?>
                <div class="hero-grid">
                    <div class="hero-content">
                        <div class="hero-tag">
                            <span class="hero-tag-indicator"><span></span></span>
                            <?php _e('Breaking Analysis', 'ai-news'); ?>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="hero-title-link">
                            <h2 class="hero-title"><?php the_title(); ?></h2>
                        </a>
                        <p class="hero-excerpt"><?php echo get_the_excerpt(); ?></p>
                        <div class="hero-meta">
                            <div class="hero-meta-item">
                                <img src="<?php echo get_avatar_url(get_the_author_meta('ID')); ?>" alt="<?php the_author(); ?>" class="author-avatar">
                                <span><?php the_author(); ?></span>
                            </div>
                            <span class="sep">/</span>
                            <span class="hero-meta-item"><?php echo get_the_date(); ?></span>
                        </div>
                    </div>
                    <div class="hero-image">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('large'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; wp_reset_postdata(); endif; ?>
        </div>
    </section>

    <!-- Latest Intel Section -->
    <section class="latest-intel-section">
        <div class="container">
            <div class="section-header-bar">
                <h2><?php _e('Latest Intel', 'ai-news'); ?></h2>
                <div class="section-header-line"></div>
                <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="section-header-link">
                    <?php _e('Archive', 'ai-news'); ?>
                </a>
            </div>
            <div class="article-grid">
                <?php if ($latest_query->have_posts()) : while ($latest_query->have_posts()) : $latest_query->the_post(); ?>
                    <article class="article-card">
                        <a href="<?php the_permalink(); ?>" class="article-card-link">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="article-card-image-wrapper">
                                    <?php the_post_thumbnail('medium'); ?>
                                </div>
                            <?php endif; ?>
                            <div class="article-card-content">
                                <div class="article-card-meta">
                                    <span class="article-card-category"><?php echo get_the_category_list(', '); ?></span>
                                    <span class="article-card-readtime"><?php echo get_post_meta(get_the_ID(), '_read_time', true); ?></span>
                                </div>
                                <h3 class="article-card-title"><?php the_title(); ?></h3>
                                <p class="article-card-excerpt"><?php echo get_the_excerpt(); ?></p>
                                <div class="article-card-author">
                                    <img src="<?php echo get_avatar_url(get_the_author_meta('ID')); ?>" alt="<?php the_author(); ?>" class="author-avatar">
                                    <span class="article-card-author-name"><?php the_author(); ?></span>
                                </div>
                            </div>
                        </a>
                    </article>
                <?php endwhile; wp_reset_postdata(); endif; ?>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <div class="container">
            <div class="newsletter-box">
                <h2><?php _e('Signal, not noise.', 'ai-news'); ?></h2>
                <p><?php _e('Weekly deep dives into weights, patterns, and jailbreaks. No fluff.', 'ai-news'); ?></p>
                <form class="newsletter-form" id="newsletter-form">
                    <input type="email" id="newsletter-email" placeholder="<?php _e('your@email.com', 'ai-news'); ?>" required>
                    <button type="submit"><?php _e('Join the Node', 'ai-news'); ?></button>
                </form>
                <p class="newsletter-message" id="newsletter-message"></p>
                <p class="newsletter-subscribers">42,000+ <?php _e('operators subscribed', 'ai-news'); ?></p>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
