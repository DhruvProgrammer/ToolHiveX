<?php
/**
 * Template Name: Article Layout
 * @package AI_News
 *
 * Reusable single-post-style layout for Pages.
 * Includes: reading progress bar, hero header, author bio,
 * featured image, share buttons, FAQ (via _faq_items meta),
 * comments, back-to-top.
 */
get_header();

while (have_posts()) : the_post();
  $featured    = get_post_meta(get_the_ID(), '_featured', true);
  $faq_items   = get_post_meta(get_the_ID(), '_faq_items', true) ?: array();

  $share_url   = urlencode(get_the_permalink());
  $share_title = urlencode(get_the_title());
  $wa_link     = "https://wa.me/?text={$share_title}%20{$share_url}";
  $fb_link     = "https://facebook.com/sharer/sharer.php?u={$share_url}";
  $tg_link     = "https://t.me/share/url?url={$share_url}&text={$share_title}";
  $li_link     = "https://linkedin.com/sharing/share-offsite/?url={$share_url}";

  $ist_date = get_the_date('F j, Y') . ' ' . get_the_date('g:i A T');
?>

<main class="site-main">
  <div class="reading-progress" id="reading-progress"></div>

  <article class="single-article">
    <div class="container container-narrow">

      <div class="single-header">
        <?php if ($featured) : ?>
          <div class="single-meta-top">
            <span class="single-featured-badge">Featured</span>
          </div>
        <?php endif; ?>

        <h1 class="single-title"><?php the_title(); ?></h1>

        <?php $excerpt = get_the_excerpt(); if ($excerpt) : ?>
          <p class="single-summary"><?php echo esc_html(wp_trim_words($excerpt, 30)); ?></p>
        <?php endif; ?>

        <div class="single-author-bio">
          <div class="author-avatar">
            <?php echo get_avatar(get_the_author_meta('ID'), 60, '', '', array('class' => 'author-avatar-img')); ?>
          </div>
          <div class="author-info">
            <span class="author-name"><?php the_author(); ?></span>
            <span class="author-date"><?php echo esc_html($ist_date); ?></span>
          </div>
        </div>
      </div>

      <?php if (has_post_thumbnail()) : ?>
        <div class="single-image">
          <?php the_post_thumbnail('article-single', array('class' => 'single-featured-image')); ?>
        </div>
      <?php endif; ?>

      <div class="single-content">
        <?php the_content(); ?>
      </div>

      <div class="share-section">
        <span class="share-label">Share:</span>
        <a href="<?php echo esc_url($wa_link); ?>" target="_blank" rel="noopener" aria-label="Share on WhatsApp" class="share-icon share-wa">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.149-.67.15-.197.298-.767.965-.934 1.164-.167.197-.334.223-.631.075-.299-.15-1.259-.463-2.399-1.475-.882-.788-1.479-1.766-1.653-2.064-.173-.298-.018-.459.13-.607.134-.134.298-.334.447-.5.15-.168.198-.298.298-.497.1-.198.05-.372-.025-.521-.075-.149-.67-1.612-.918-2.209-.245-.593-.491-.504-.67-.51l-.571-.01c-.198 0-.52.075-.793.372-.273.298-1.044 1.024-1.044 2.503 0 1.478 1.078 2.906 1.229 3.107.15.198 2.101 3.203 5.09 4.492.712.307 1.267.49 1.7.626.712.223 1.355.198 1.861.122.567-.085 1.758-.717 2.005-1.411.248-.693.248-1.286.174-1.411-.075-.124-.272-.199-.57-.348zM12.005 2.025c-5.523 0-10 4.477-10 10s4.477 10 10 10c5.523 0 10-4.477 10-10s-4.477-10-10-10z"/></svg>
        </a>
        <a href="<?php echo esc_url($fb_link); ?>" target="_blank" rel="noopener" aria-label="Share on Facebook" class="share-icon share-fb">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385h-3.047v-3.47h3.047v-2.642c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953h-1.515c-1.501 0-1.968.925-1.968 1.874v2.249h3.344l-.535 3.47h-2.809v8.385c5.737-.9 10.126-5.864 10.126-11.854z"/></svg>
        </a>
        <a href="<?php echo esc_url($tg_link); ?>" target="_blank" rel="noopener" aria-label="Share on Telegram" class="share-icon share-tg">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.127.087.669.087.669l-1.345 6.34s-.103.367-.448.367a.563.563 0 0 1-.267-.07C14.34 14.21 11 12.343 9.623 11.555c-.142-.08-.212-.228-.148-.358.021-.037.052-.064.058-.07.006-.006.466-.546.466-.546l2.138-2.29c.156-.185.35-.28.544-.28z"/></svg>
        </a>
        <a href="<?php echo esc_url($li_link); ?>" target="_blank" rel="noopener" aria-label="Share on LinkedIn" class="share-icon share-li">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
        </a>
        <button type="button" class="share-icon share-copy" aria-label="Copy link" data-url="<?php echo esc_url(get_the_permalink()); ?>">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
        </button>
      </div>

      <?php if (!empty($faq_items) && is_array($faq_items)) : ?>
        <div class="faq-section">
          <h2 class="faq-heading">Frequently Asked Questions</h2>
          <?php foreach ($faq_items as $faq) :
            $q = isset($faq['q']) ? $faq['q'] : '';
            $a = isset($faq['a']) ? $faq['a'] : '';
            if (!$q || !$a) continue;
          ?>
            <details class="faq-item">
              <summary class="faq-question"><?php echo esc_html($q); ?></summary>
              <div class="faq-answer"><?php echo wp_kses_post($a); ?></div>
            </details>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

    </div>
  </article>

  <?php if (comments_open() || get_comments_number()) : ?>
    <section class="section comments-section container container-narrow">
      <?php comments_template(); ?>
    </section>
  <?php endif; ?>

</main>

<button type="button" class="back-to-top" id="back-to-top" aria-label="Back to top" hidden>
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 15l-6-6-6 6"/></svg>
</button>

<?php
endwhile;
get_footer();
