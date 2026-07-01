<?php
/**
 * Theme Header v2
 * @package AI_News
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#020617">
<?php wp_head(); ?>
</head>
<body <?php body_class('ai-news-theme'); ?>>
<div id="page" class="site">
<a href="#primary-content" class="skip-link">Skip to content</a>

<header class="site-header" id="masthead">
  <div class="container">
    <div class="header-inner">
      <div class="header-left">
        <button type="button" class="menu-toggle" aria-label="Toggle menu" aria-controls="primary-menu" aria-expanded="false">
          <span></span><span></span><span></span>
        </button>
        <div class="site-branding">
          <a href="<?php echo esc_url(home_url('/')); ?>" class="site-title-link">
            <span class="site-title-icon">AI</span>
            <span class="site-title-text"><span class="title-bold">AI</span>News<span class="title-dot">.</span></span>
          </a>
        </div>
      </div>

      <nav class="main-navigation" aria-label="Primary Menu">
        <?php
        if (has_nav_menu('primary')) {
          wp_nav_menu(array(
            'theme_location' => 'primary',
            'menu_id'        => 'primary-menu',
            'container'      => false,
            'fallback_cb'    => false,
            'depth'          => 2,
          ));
        } else { ?>
          <ul id="primary-menu" class="menu">
            <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
            <li><a href="<?php echo esc_url(home_url('/category/news')); ?>">News</a></li>
            <li><a href="<?php echo esc_url(home_url('/prompts')); ?>">Prompts</a></li>
            <li><a href="<?php echo esc_url(home_url('/tools')); ?>">Tools</a></li>
            <li><a href="<?php echo esc_url(home_url('/categories')); ?>">Categories</a></li>
            <li><a href="<?php echo esc_url(home_url('/contact')); ?>">Contact</a></li>
          </ul>
        <?php } ?>
      </nav>

      <div class="header-actions">
        <button type="button" class="search-toggle" aria-label="Toggle search" aria-controls="header-search" aria-expanded="false">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        </button>
        <button type="button" class="dark-mode-toggle" aria-label="Toggle dark mode" aria-pressed="false">
          <svg class="icon-moon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
          <svg class="icon-sun" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
        </button>
      </div>
    </div>

    <!-- Search bar (hidden by default) -->
    <div class="header-search" id="header-search">
      <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="header-search-form">
        <input type="search" name="s" placeholder="Search AI news, tools, prompts..." aria-label="Search" required>
        <button type="submit">Search</button>
        <button type="button" class="search-close" aria-label="Close search">&times;</button>
      </form>
    </div>
  </div>
</header>

<div class="search-overlay"></div>

<main id="primary-content" class="site-main">
