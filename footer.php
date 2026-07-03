    </main>

<footer class="site-footer" id="colophon">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-col footer-about">
        <div class="footer-logo">
          <span class="site-title-icon">AI</span>
          <span class="site-title-text"><span class="title-bold">AI</span>News<span class="title-dot">.</span></span>
        </div>
        <p class="footer-desc">Your daily dose of artificial intelligence news, tools, prompts, and resources. Stay ahead of the curve.</p>
        <div class="footer-social">
          <a href="<?php echo esc_url(get_theme_mod('ai_news_telegram_url', 'https://t.me/your_channel')); ?>" target="_blank" rel="noopener" aria-label="Telegram">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.127.087.669.087.669l-1.345 6.34s-.103.367-.448.367a.563.563 0 0 1-.267-.07C14.34 14.21 11 12.343 9.623 11.555c-.142-.08-.212-.228-.148-.358.021-.037.052-.064.058-.07.006-.006.466-.546.466-.546l2.138-2.29c.156-.185.35-.28.544-.28z"/></svg>
          </a>
          <a href="https://twitter.com" target="_blank" rel="noopener" aria-label="Twitter/X">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
          </a>
          <a href="<?php echo esc_url(home_url('/feed')); ?>" aria-label="RSS Feed">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><circle cx="6.18" cy="17.82" r="2.18"/><path d="M4 4.44v2.83c7.03 0 12.73 5.7 12.73 12.73h2.83c0-8.59-6.97-15.56-15.56-15.56zm0 5.66v2.83c3.9 0 7.07 3.17 7.07 7.07h2.83c0-5.47-4.43-9.9-9.9-9.9z"/></svg>
          </a>
        </div>
      </div>

      <div class="footer-col">
        <h4 class="footer-heading">Quick Links</h4>
        <nav class="footer-nav" aria-label="Footer Menu">
          <?php if (has_nav_menu('footer')) {
            wp_nav_menu(array('theme_location' => 'footer', 'container' => false, 'fallback_cb' => false, 'depth' => 1));
          } else { ?>
            <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
            <a href="<?php echo esc_url(home_url('/aboutus')); ?>">About Us</a>
            <a href="<?php echo esc_url(home_url('/category/news')); ?>">News</a>
            <a href="<?php echo esc_url(home_url('/prompts')); ?>">Prompts</a>
            <a href="<?php echo esc_url(home_url('/tools')); ?>">AI Tools</a>
            <a href="<?php echo esc_url(home_url('/categories')); ?>">Categories</a>
            <a href="<?php echo esc_url(home_url('/contact')); ?>">Contact</a>
          <?php } ?>
        </nav>
      </div>

      <div class="footer-col">
        <h4 class="footer-heading">Categories</h4>
        <nav class="footer-nav footer-categories">
          <?php
          $cats = get_categories(array('number' => 6));
          foreach ($cats as $c) {
            echo '<a href="' . esc_url(get_category_link($c->term_id)) . '">' . esc_html($c->name) . '</a>';
          }
          ?>
        </nav>
      </div>

      <div class="footer-col">
        <h4 class="footer-heading">Legal</h4>
        <nav class="footer-nav">
          <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>">Privacy Policy</a>
          <a href="<?php echo esc_url(home_url('/terms-of-service')); ?>">Terms of Service</a>
          <a href="<?php echo esc_url(home_url('/disclaimer')); ?>">Disclaimer</a>
          <a href="<?php echo esc_url(home_url('/contact')); ?>">Contact Us</a>
        </nav>
      </div>
    </div>

    <div class="footer-bottom">
      <div class="footer-copy">&copy; <?php echo date('Y'); ?> <strong>AI News</strong>. All rights reserved.</div>
      <div class="footer-meta">Powered by <a href="https://wordpress.org" target="_blank" rel="noopener">WordPress</a></div>
    </div>
  </div>
</footer>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
