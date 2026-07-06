/**
 * Single Post Template Features
 * @package AI_News
 */

(function () {
  'use strict';

  // =============================================
  // READING PROGRESS BAR
  // =============================================
  var readingProgress = document.getElementById('reading-progress');
  if (readingProgress) {
    window.addEventListener('scroll', function () {
      var docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
      var scrolled = (window.scrollY / docHeight) * 100;
      readingProgress.style.width = scrolled + '%';
    });
  }

  // =============================================
  // BACK TO TOP BUTTON
  // =============================================
  var backToTop = document.getElementById('back-to-top');
  if (backToTop) {
    window.addEventListener('scroll', function () {
      if (window.scrollY > 300) {
        backToTop.classList.add('visible');
      } else {
        backToTop.classList.remove('visible');
      }
    });
    backToTop.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  // =============================================
  // COPY LINK BUTTON
  // =============================================
  var copyBtn = document.querySelector('.share-copy');
  if (copyBtn) {
    copyBtn.addEventListener('click', function () {
      var url = copyBtn.getAttribute('data-url');
      if (navigator.clipboard && url) {
        navigator.clipboard.writeText(url).then(function () {
          var originalHTML = copyBtn.innerHTML;
          copyBtn.classList.add('clicked');
          copyBtn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>';
          setTimeout(function () {
            copyBtn.classList.remove('clicked');
            copyBtn.innerHTML = originalHTML;
          }, 2000);
        });
      }
    });
  }
})();
