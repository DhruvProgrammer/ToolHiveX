<?php
/**
 * Search + Results Template
 * @package AI_News
 */
get_header();

$search_query = get_search_query();
$paged = get_query_var('paged') ?: 1;
$results = new WP_Query(array(
    's' => $search_query,
    'posts_per_page' => 10,
    'paged' => $paged,
));
?>

<main class="site-main">
  <section class="section page-hero">
    <div class="container">
      <h1>Search<?php echo $search_query ? ': ' . esc_html($search_query) : ''; ?></h1>
      <p><?php echo $search_query ? 'Results for your search' : 'Find articles, tools, prompts, and more'; ?></p>
    </div>
  </section>

  <section class="section">
    <div class="container container-narrow">
      <form role="search" method="get" class="search-form-page" action="<?php echo esc_url(home_url('/')); ?>">
        <div class="search-form-inner">
          <input type="search" name="s" placeholder="Search AI news, tools, prompts..." value="<?php echo esc_attr($search_query); ?>" required>
          <button type="submit">Search</button>
        </div>
      </form>

      <?php if ($search_query) : ?>
        <?php if ($results->have_posts()) : ?>
          <div class="search-results-count">
            Found <?php echo $results->found_posts; ?> result<?php echo $results->found_posts > 1 ? 's' : ''; ?> for "<?php echo esc_html($search_query); ?>"
          </div>

          <div class="search-results-list">
            <?php while ($results->have_posts()) : $results->the_post(); ?>
              <article class="search-result-item">
                <a href="<?php the_permalink(); ?>" class="search-result-link">
                  <div class="search-result-content">
                    <div class="search-result-meta">
                      <span class="search-result-type"><?php echo get_post_type_object(get_post_type())->labels->singular_name; ?></span>
                      <span class="search-result-date"><?php echo get_the_date('M j, Y'); ?></span>
                    </div>
                    <h3 class="search-result-title"><?php the_title(); ?></h3>
                    <p class="search-result-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 25); ?></p>
                  </div>
                  <?php if (has_post_thumbnail()) : ?>
                    <div class="search-result-thumb">
                      <?php the_post_thumbnail('thumbnail'); ?>
                    </div>
                  <?php endif; ?>
                </a>
              </article>
            <?php endwhile; wp_reset_postdata(); ?>
          </div>

          <div class="pagination">
            <?php echo paginate_links(array(
              'total' => $results->max_num_pages,
              'current' => $paged,
              'mid_size' => 2,
            )); ?>
          </div>

        <?php else : ?>
          <div class="no-results">
            <h2>No results found</h2>
            <p>We couldn't find anything matching "<?php echo esc_html($search_query); ?>". Try different keywords or browse our categories.</p>
            <div class="no-results-actions">
              <a href="<?php echo esc_url(home_url('/')); ?>" class="button">Go Home</a>
              <a href="<?php echo esc_url(home_url('/categories')); ?>" class="button button-outline">Browse Categories</a>
            </div>
          </div>
        <?php endif; ?>
      <?php else : ?>
        <div class="no-results">
          <h2>Enter a search term</h2>
          <p>Type something above to search through our articles, tools, prompts, and pages.</p>
        </div>
      <?php endif; ?>
    </div>
  </section>
</main>

<?php get_footer(); ?>
