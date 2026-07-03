/**
 * AI News Theme — Main JavaScript
 */

(function () {
  'use strict';

  const html = document.documentElement;
  const body = document.body;

  // Shared overlay used for both search & mobile menu
  const overlay = document.querySelector('.search-overlay');

  // =============================================
  // DARK MODE
  // =============================================
  const darkToggle = document.querySelector('.dark-mode-toggle');

  function setTheme(theme) {
    if (theme === 'dark') {
      html.setAttribute('data-theme', 'dark');
      localStorage.setItem('ai-news-theme', 'dark');
      if (darkToggle) darkToggle.setAttribute('aria-pressed', 'true');
    } else {
      html.removeAttribute('data-theme');
      localStorage.setItem('ai-news-theme', 'light');
      if (darkToggle) darkToggle.setAttribute('aria-pressed', 'false');
    }
  }

  if (darkToggle) {
    const saved = localStorage.getItem('ai-news-theme');
    if (saved) {
      setTheme(saved);
    } else {
      setTheme('dark');
    }

    darkToggle.addEventListener('click', function () {
      const isDark = html.getAttribute('data-theme') === 'dark';
      setTheme(isDark ? 'light' : 'dark');
    });
  }

  // =============================================
  // SEARCH TOGGLE
  // =============================================
  const searchToggle = document.querySelector('.search-toggle');
  const searchBar = document.getElementById('header-search');
  const searchClose = document.querySelector('.search-close');

  // =============================================
  // MOBILE MENU
  // =============================================
  const menuToggle = document.querySelector('.menu-toggle');
  const mainNav = document.querySelector('.main-navigation');

  function setOverlay(show) {
    if (!overlay) return;
    overlay.classList.toggle('active', show);
  }

  function refreshOverlay() {
    const searchOpen = searchBar && searchBar.classList.contains('active');
    const menuOpen = mainNav && mainNav.classList.contains('active');
    setOverlay(searchOpen || menuOpen);
  }

  function closeSearch() {
    if (!searchBar) return;
    searchBar.classList.remove('active');
    if (searchToggle) searchToggle.setAttribute('aria-expanded', 'false');
    refreshOverlay();
  }

  function openSearch() {
    if (!searchBar) return;
    closeMenu(); // mutually exclusive
    searchBar.classList.add('active');
    if (searchToggle) searchToggle.setAttribute('aria-expanded', 'true');
    refreshOverlay();
    setTimeout(function () {
      const input = searchBar.querySelector('input');
      if (input) input.focus();
    }, 100);
  }

  function closeMenu() {
    if (!mainNav) return;
    mainNav.classList.remove('active');
    if (menuToggle) menuToggle.setAttribute('aria-expanded', 'false');
    body.classList.remove('nav-open');
    refreshOverlay();
  }

  function openMenu() {
    if (!mainNav) return;
    closeSearch(); // mutually exclusive
    mainNav.classList.add('active');
    if (menuToggle) menuToggle.setAttribute('aria-expanded', 'true');
    body.classList.add('nav-open');
    refreshOverlay();
  }

  if (searchToggle && searchBar) {
    searchToggle.addEventListener('click', function (e) {
      e.stopPropagation();
      if (searchBar.classList.contains('active')) {
        closeSearch();
      } else {
        openSearch();
      }
    });

    if (searchClose) {
      searchClose.addEventListener('click', closeSearch);
    }
  }

  if (menuToggle && mainNav) {
    menuToggle.addEventListener('click', function () {
      if (mainNav.classList.contains('active')) {
        closeMenu();
      } else {
        openMenu();
      }
    });

    // Close menu when a link is clicked
    document.querySelectorAll('.main-navigation .menu li a').forEach(function (link) {
      link.addEventListener('click', closeMenu);
    });
  }

  // Overlay click closes whichever is open
  if (overlay) {
    overlay.addEventListener('click', function () {
      closeSearch();
      closeMenu();
    });
  }

  // ESC key closes both
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      closeSearch();
      closeMenu();
    }
  });

  // Reset state when crossing the mobile breakpoint so a left-open menu
  // doesn't get stuck off-screen on desktop.
  let lastWide = window.matchMedia('(min-width: 769px)').matches;
  window.addEventListener('resize', function () {
    const wide = window.matchMedia('(min-width: 769px)').matches;
    if (wide !== lastWide) {
      lastWide = wide;
      closeMenu();
      closeSearch();
    }
  });

  // =============================================
  // CAROUSEL
  // =============================================
  const track = document.getElementById('carousel-track');
  const dotsContainer = document.getElementById('carousel-dots');
  const prevBtn = document.querySelector('.carousel-prev');
  const nextBtn = document.querySelector('.carousel-next');

  if (track && track.children.length > 0) {
    const slides = track.children;
    let current = 0;
    let autoPlay;

    function goTo(index) {
      if (index < 0) index = slides.length - 1;
      if (index >= slides.length) index = 0;
      current = index;

      track.style.transform = 'translateX(-' + (current * 100) + '%)';

      if (dotsContainer) {
        Array.from(dotsContainer.children).forEach(function (dot, i) {
          dot.classList.toggle('active', i === current);
        });
      }

      Array.from(slides).forEach(function (slide, i) {
        slide.classList.toggle('active', i === current);
      });
    }

    if (dotsContainer && slides.length > 1) {
      for (let i = 0; i < slides.length; i++) {
        const dot = document.createElement('button');
        dot.type = 'button';
        dot.setAttribute('aria-label', 'Go to slide ' + (i + 1));
        dot.classList.toggle('active', i === 0);
        dot.addEventListener('click', function () { goTo(i); resetAuto(); });
        dotsContainer.appendChild(dot);
      }
    }

    if (prevBtn) {
      prevBtn.addEventListener('click', function () { goTo(current - 1); resetAuto(); });
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', function () { goTo(current + 1); resetAuto(); });
    }

    // Hide arrows/dots when there's only one slide
    if (slides.length <= 1) {
      if (prevBtn) prevBtn.style.display = 'none';
      if (nextBtn) nextBtn.style.display = 'none';
      if (dotsContainer) dotsContainer.style.display = 'none';
    }

    function resetAuto() {
      clearInterval(autoPlay);
      if (slides.length > 1) {
        autoPlay = setInterval(function () { goTo(current + 1); }, 6000);
      }
    }

    // Touch support — only swipe horizontally; let vertical scroll pass through
    let startX = 0;
    let startY = 0;
    let isDragging = false;

    track.addEventListener('touchstart', function (e) {
      startX = e.touches[0].clientX;
      startY = e.touches[0].clientY;
      isDragging = true;
    }, { passive: true });

    track.addEventListener('touchend', function (e) {
      if (!isDragging) return;
      isDragging = false;
      const diffX = startX - e.changedTouches[0].clientX;
      const diffY = startY - e.changedTouches[0].clientY;
      // Only treat as swipe if horizontal motion dominates
      if (Math.abs(diffX) > 50 && Math.abs(diffX) > Math.abs(diffY)) {
        goTo(diffX > 0 ? current + 1 : current - 1);
        resetAuto();
      }
    }, { passive: true });

    if (slides.length > 1) {
      autoPlay = setInterval(function () { goTo(current + 1); }, 6000);
    }
  }

  // =============================================
  // PROMPT COPY
  // =============================================
  document.querySelectorAll('.prompt-copy').forEach(function (btn) {
    btn.setAttribute('type', 'button');
    btn.addEventListener('click', function () {
      const content = btn.getAttribute('data-content');
      if (!content) return;

      const showCopied = function () {
        const orig = btn.dataset.origText || btn.textContent;
        btn.dataset.origText = orig;
        btn.textContent = 'Copied!';
        btn.classList.add('copied');
        setTimeout(function () {
          btn.textContent = orig;
          btn.classList.remove('copied');
        }, 2000);
      };

      if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(content).then(showCopied).catch(fallbackCopy);
      } else {
        fallbackCopy();
      }

      function fallbackCopy() {
        const ta = document.createElement('textarea');
        ta.value = content;
        ta.setAttribute('readonly', '');
        ta.style.position = 'absolute';
        ta.style.left = '-9999px';
        document.body.appendChild(ta);
        ta.select();
        try { document.execCommand('copy'); showCopied(); }
        catch (e) { /* leave selected for manual copy */ }
        document.body.removeChild(ta);
      }
    });
  });

  // =============================================
  // NEWSLETTER FORM (AJAX)
  // =============================================
  const newsletterForm = document.getElementById('newsletter-form');
  const newsletterMsg = document.getElementById('newsletter-message');

  if (newsletterForm) {
    newsletterForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const emailInput = document.getElementById('newsletter-email')
        || newsletterForm.querySelector('input[type="email"]');
      const submitBtn = newsletterForm.querySelector('button[type="submit"]');
      const email = emailInput ? emailInput.value.trim() : '';

      if (!email) return;

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.dataset.origText = submitBtn.dataset.origText || submitBtn.textContent;
        submitBtn.textContent = 'Subscribing...';
      }

      if (newsletterMsg) {
        newsletterMsg.textContent = '';
        newsletterMsg.className = 'newsletter-message';
      }

      const formData = new FormData();
      formData.append('action', 'ai_news_subscribe');
      formData.append('email', email);
      formData.append('nonce', (window.aiNewsData && aiNewsData.nonce) || '');

      fetch((window.aiNewsData && aiNewsData.ajaxUrl) || '/wp-admin/admin-ajax.php', {
        method: 'POST',
        body: formData,
      })
        .then(function (r) { return r.json(); })
        .then(function (data) {
          if (newsletterMsg) {
            const text = (data && data.data && (data.data.message || data.data)) || (data.success ? 'Subscribed successfully!' : 'Something went wrong. Try again.');
            newsletterMsg.textContent = typeof text === 'string' ? text : 'Done.';
            newsletterMsg.className = 'newsletter-message ' + (data.success ? 'success' : 'error');
          }
          if (data.success && emailInput) emailInput.value = '';
        })
        .catch(function () {
          if (newsletterMsg) {
            newsletterMsg.textContent = 'Network error. Please try again.';
            newsletterMsg.className = 'newsletter-message error';
          }
        })
        .finally(function () {
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.textContent = submitBtn.dataset.origText;
          }
        });
    });
  }

  // =============================================
  // CONTACT FORM (AJAX)
  // =============================================
  const contactForm = document.getElementById('contact-form');
  const contactMsg = document.getElementById('contact-message-status');

  if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
      e.preventDefault();

      const nameEl = document.getElementById('contact-name');
      const emailEl = document.getElementById('contact-email');
      const subjectEl = document.getElementById('contact-subject');
      const messageEl = document.getElementById('contact-message');
      const submitBtn = contactForm.querySelector('button[type="submit"]');

      const name = nameEl ? nameEl.value.trim() : '';
      const email = emailEl ? emailEl.value.trim() : '';
      const subject = subjectEl ? subjectEl.value.trim() : '';
      const message = messageEl ? messageEl.value.trim() : '';

      if (!name || !email || !subject || !message) return;

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.dataset.origText = submitBtn.dataset.origText || submitBtn.textContent;
        submitBtn.textContent = 'Sending...';
      }

      if (contactMsg) {
        contactMsg.textContent = '';
        contactMsg.className = 'form-message';
      }

      const formData = new FormData();
      formData.append('action', 'ai_news_contact');
      formData.append('name', name);
      formData.append('email', email);
      formData.append('subject', subject);
      formData.append('message', message);
      formData.append('nonce', (window.aiNewsData && aiNewsData.nonce) || '');

      fetch((window.aiNewsData && aiNewsData.ajaxUrl) || '/wp-admin/admin-ajax.php', {
        method: 'POST',
        body: formData,
      })
        .then(function (r) { return r.json(); })
        .then(function (data) {
          if (contactMsg) {
            const text = (data && data.data && (data.data.message || data.data)) || (data.success ? "Message sent! We'll get back to you soon." : 'Something went wrong. Try again.');
            contactMsg.textContent = typeof text === 'string' ? text : 'Done.';
            contactMsg.className = 'form-message ' + (data.success ? 'success' : 'error');
          }
          if (data.success) {
            contactForm.querySelectorAll('input, textarea').forEach(function (el) { el.value = ''; });
          }
        })
        .catch(function () {
          if (contactMsg) {
            contactMsg.textContent = 'Network error. Please try again.';
            contactMsg.className = 'form-message error';
          }
        })
        .finally(function () {
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.textContent = submitBtn.dataset.origText;
          }
        });
    });
  }

  // =============================================
  // SCROLL ANIMATIONS
  // =============================================
  if ('IntersectionObserver' in window) {
    const animEls = document.querySelectorAll('.section:not(.carousel-section)');
    if (animEls.length > 0) {
      const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('fade-in');
            observer.unobserve(entry.target);
          }
        });
      }, { threshold: 0.1 });

      animEls.forEach(function (el) { observer.observe(el); });
    }
  }

})();
