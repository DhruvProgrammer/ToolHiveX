<?php
/**
 * Template Name: Contact Us
 * @package AI_News
 */
get_header();
?>

<main class="site-main page-contact">
  <section class="section page-hero">
    <div class="container">
      <h1>Contact Us</h1>
      <p>Have a question, suggestion, or want to collaborate? We'd love to hear from you.</p>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="contact-grid">
        <div class="contact-form-wrap">
          <form class="contact-form" id="contact-form">
            <div class="form-group">
              <label for="contact-name">Name</label>
              <input type="text" id="contact-name" name="name" required placeholder="Your name">
            </div>
            <div class="form-group">
              <label for="contact-email">Email</label>
              <input type="email" id="contact-email" name="email" required placeholder="your@email.com">
            </div>
            <div class="form-group">
              <label for="contact-subject">Subject</label>
              <input type="text" id="contact-subject" name="subject" required placeholder="What's this about?">
            </div>
            <div class="form-group">
              <label for="contact-message">Message</label>
              <textarea id="contact-message" name="message" rows="6" required placeholder="Tell us more..."></textarea>
            </div>
            <button type="submit" class="button button-primary">Send Message</button>
            <p class="form-message" id="contact-message-status"></p>
          </form>
        </div>

        <div class="contact-info">
          <div class="contact-info-card">
            <h3>Get in Touch</h3>
            <ul class="contact-info-list">
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                <span>aronnnjones@gmail.com</span>
              </li>
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                <span>Telegram: @ainewschannel</span>
              </li>
            </ul>
          </div>

          <div class="contact-info-card">
            <h3>Follow Us</h3>
            <div class="footer-social">
              <a href="<?php echo esc_url(get_theme_mod('ai_news_telegram_url', 'https://t.me/your_channel')); ?>" target="_blank" rel="noopener" aria-label="Telegram">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.127.087.669.087.669l-1.345 6.34s-.103.367-.448.367a.563.563 0 0 1-.267-.07C14.34 14.21 11 12.343 9.623 11.555c-.142-.08-.212-.228-.148-.358.021-.037.052-.064.058-.07.006-.006.466-.546.466-.546l2.138-2.29c.156-.185.35-.28.544-.28z"/></svg>
              </a>
              <a href="https://twitter.com" target="_blank" rel="noopener" aria-label="Twitter/X">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?php get_footer(); ?>
