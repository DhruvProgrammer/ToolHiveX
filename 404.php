<?php get_header(); ?>

<main class="site-main error-404">
  <div class="container">
    <div class="error-content">
      <h1 class="error-number">404</h1>
      <h2 class="error-subtitle">Oops! That page can't be found.</h2>
      <p class="error-desc">It looks like nothing was found at this location. Maybe try one of the links below or a search?</p>

      <div class="error-search">
        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="error-search-form">
          <input type="search" name="s" placeholder="Search ..." aria-label="Search" required>
          <button type="submit">Search</button>
        </form>
      </div>

      <a href="<?php echo esc_url(home_url('/')); ?>" class="error-home">
        Back to Home
      </a>
    </div>
  </div>
</main>

<?php get_footer(); ?>
