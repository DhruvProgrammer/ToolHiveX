<?php get_header(); ?>

<main class="ai-news-main error-404">
    <div class="error-content">
        <h1 class="error-title">404</h1>
        <p class="error-message"><?php _e('Oops! That page can\'t be found.', 'ai-news'); ?></p>
        <p><?php _e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'ai-news'); ?></p>
        
        <div class="error-search">
            <?php get_search_form(); ?>
        </div>
        
        <a href="<?php echo esc_url(home_url('/')); ?>" class="button">
            <?php _e('Back to Home', 'ai-news'); ?>
        </a>
    </div>
</main>

<?php get_footer(); ?>
