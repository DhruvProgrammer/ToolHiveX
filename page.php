<?php get_header(); ?>

<main class="ai-news-main page-template">
    <?php while (have_posts()) : the_post(); ?>
        <article class="page-article">
            <header class="page-header">
                <h1 class="page-title"><?php the_title(); ?></h1>
            </header>
            <div class="page-content">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
