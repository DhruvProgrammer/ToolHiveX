<?php
/**
 * Template Name: Newsletter
 * @package AI_News
 */
get_header();
?>

<main class="site-main page-privacy">
  <section class="section page-hero">
    <div class="container">
      <h1>Subscribe to Our Newsletter</h1>
      <p>Get the most important AI news, exclusive deals, and curated prompts delivered straight to your inbox every week &mdash; for free.</p>
    </div>
  </section>

  <section class="section">
    <div class="container legal-content">
      <h2>Stay in the Loop</h2>
      <p>AI News is read by thousands of developers, researchers, creators, marketers, entrepreneurs, and enthusiasts who want to stay ahead of artificial intelligence without spending hours curating sources themselves. Our weekly newsletter is the easiest way to get the highlights in one concise email.</p>

      <h3>What You'll Get</h3>
      <ul>
        <li><strong>Top 5 AI stories</strong> of the week with brief summaries and links</li>
        <li><strong>Exclusive deals</strong> on premium AI tools and platforms</li>
        <li><strong>3 new prompts</strong> you can copy and use immediately</li>
        <li><strong>1 trending AI tool</strong> with a short review and use case</li>
        <li><strong>Free resource</strong> of the week (course, paper, dataset)</li>
      </ul>

      <h3>Why Subscribe?</h3>
      <ul>
        <li>Free forever &mdash; no paywalls, no spam</li>
        <li>Curated by humans, not algorithms</li>
        <li>One email per week, every Sunday morning</li>
        <li>Easy one-click unsubscribe in every email</li>
        <li>We never share or sell your email</li>
      </ul>

      <h3>Sign Up Below</h3>
      <p>Subscribe using the form below. You'll receive a confirmation email to verify your address. After confirming, your first digest will arrive the following Sunday.</p>

      <form id="newsletter-form-page" class="newsletter-form-inline" style="max-width:480px;margin:var(--sp-8) auto;display:flex;gap:var(--sp-2);flex-wrap:wrap;">
        <input type="email" name="email" placeholder="your@email.com" required aria-label="Email address" style="flex:1;min-width:200px;padding:var(--sp-3) var(--sp-4);border:2px solid var(--clr-border);border-radius:var(--radius-md);background:var(--clr-bg);color:var(--clr-text);font-size:var(--fs-base);">
        <button type="submit" class="button" style="padding:var(--sp-3) var(--sp-6);">Subscribe</button>
      </form>
      <div id="newsletter-message-page" style="text-align:center;font-size:var(--fs-sm);min-height:1.5em;margin-top:var(--sp-3);"></div>

      <h3>Your Privacy</h3>
      <p>We respect your inbox. Your email address is stored securely and is never shared with third parties. You can review our full <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>">Privacy Policy</a> for details on how we handle data.</p>

      <h3>Already a Subscriber?</h3>
      <p>If you're already on the list, there's no need to sign up again &mdash; your subscription is active and you'll continue to receive our weekly digest. If for any reason you missed an issue, you can browse our <a href="<?php echo esc_url(home_url('/news')); ?>">news archive</a> for all past stories.</p>

      <h3>Questions?</h3>
      <p>If you have any questions about our newsletter or subscription process, please <a href="<?php echo esc_url(home_url('/contact')); ?>">contact us</a>. We're happy to help.</p>
    </div>
  </section>
</main>

<script>
// Simple inline handler — the page form reuses the same endpoint as the footer form
document.addEventListener('DOMContentLoaded', function () {
  var f = document.getElementById('newsletter-form-page');
  var m = document.getElementById('newsletter-message-page');
  if (!f) return;
  f.addEventListener('submit', function (e) {
    e.preventDefault();
    var email = f.querySelector('input[type="email"]').value.trim();
    if (!email) return;
    var btn = f.querySelector('button[type="submit"]');
    if (btn) { btn.disabled = true; btn.textContent = 'Subscribing…'; }
    if (m) { m.textContent = ''; m.className = ''; }
    var fd = new FormData();
    fd.append('action', 'ai_news_subscribe');
    fd.append('email', email);
    fd.append('nonce', (window.aiNewsData && aiNewsData.nonce) || '');
    fetch((window.aiNewsData && aiNewsData.ajaxUrl) || '/wp-admin/admin-ajax.php', { method: 'POST', body: fd })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (!m) return;
        var msg = (data && data.data && (data.data.message || data.data)) || (data.success ? 'Subscribed!' : 'Something went wrong.');
        m.textContent = typeof msg === 'string' ? msg : 'Done.';
        m.style.color = data.success ? 'var(--clr-primary)' : 'var(--clr-trend)';
        if (data.success) f.reset();
      })
      .catch(function () { if (m) { m.textContent = 'Network error.'; m.style.color = 'var(--clr-trend)'; } })
      .finally(function () { if (btn) { btn.disabled = false; btn.textContent = 'Subscribe'; } });
  });
});
</script>

<?php get_footer(); ?>
