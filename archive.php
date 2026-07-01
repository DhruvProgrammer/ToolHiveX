<?php get_header(); ?>

<main class="site-main">
    <header class="archive-header">
        <h1 class="archive-title"><?php the_archive_title(); ?></h1>
        <?php if (get_the_archive_description()) : ?>
            <div class="archive-description"><?php the_archive_description(); ?></div>
        <?php endif; ?>
    </header>

    <?php if (have_posts()) : ?>
        <div class="container">
            <div class="article-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <article class="article-card">
                        <a href="<?php the_permalink(); ?>" class="article-card-link">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="article-card-image-wrapper">
                                    <?php the_post_thumbnail('medium'); ?>
                                </div>
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
            <div class="pagination">
                <?php the_posts_pagination(); ?>
            </div>
        </div>
    <?php else : ?>
        <div class="container"><p><?php _e('No posts found.', 'ai-news'); ?></p></div>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
