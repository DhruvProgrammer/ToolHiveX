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
    var toggleTopBtn = function () {
      var show = window.scrollY > 300;
      backToTop.classList.toggle('visible', show);
      backToTop.setAttribute('aria-hidden', show ? 'false' : 'true');
    };
    window.addEventListener('scroll', toggleTopBtn, { passive: true });
    toggleTopBtn();
    backToTop.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  // =============================================
  // TOAST NOTIFICATIONS
  // =============================================
  window.aiNewsToast = function (message, type) {
    type = type || 'success';
    var existing = document.querySelector('.toast');
    if (existing) existing.remove();

    var toast = document.createElement('div');
    toast.className = 'toast toast-' + type;
    toast.setAttribute('role', 'status');
    toast.setAttribute('aria-live', 'polite');

    var iconPath = type === 'error'
      ? 'M12 9v2m0 4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z'
      : 'M20 6L9 17l-5-5';
    toast.innerHTML =
      '<span class="toast-icon">' +
        '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">' +
          '<path d="' + iconPath + '"/>' +
        '</svg>' +
      '</span>' +
      '<span class="toast-message">' + message + '</span>';

    document.body.appendChild(toast);
    void toast.offsetWidth; // force reflow for transition
    toast.classList.add('is-visible');
    clearTimeout(toast._timer);
    toast._timer = setTimeout(function () {
      toast.classList.remove('is-visible');
      setTimeout(function () { toast.remove(); }, 260);
    }, 2800);
  };

  // =============================================
  // COPY LINK BUTTON
  // =============================================
  var copyBtn = document.querySelector('.share-copy');
  if (copyBtn) {
    copyBtn.addEventListener('click', function () {
      var url = copyBtn.getAttribute('data-url');
      var notify = function () {
        window.aiNewsToast('Your link has been copied successfully!', 'success');
      };
      if (!url) return;
      if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(url).then(notify).catch(function () {
          fallbackCopy(url, notify);
        });
      } else {
        fallbackCopy(url, notify);
      }
    });

    function fallbackCopy(text, cb) {
      var ta = document.createElement('textarea');
      ta.value = text;
      ta.style.position = 'fixed';
      ta.style.opacity = '0';
      document.body.appendChild(ta);
      ta.select();
      try {
        var ok = document.execCommand('copy');
        if (ok) cb();
        else window.aiNewsToast('Failed to copy link', 'error');
      } catch (e) {
        window.aiNewsToast('Failed to copy link', 'error');
      } finally {
        ta.remove();
      }
    }
  }
})();
