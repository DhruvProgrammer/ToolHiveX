# MEMORY — AI News WordPress Theme

> Persistent memory of this project's structure, conventions, and known issues.
> Update this file whenever the architecture changes or a new fix is applied.

---

## 1. Project Snapshot

- **Theme Name:** AI News
- **Version:** 2.0.0
- **Type:** WordPress classic theme (PHP templates, no block theme / FSE)
- **Path:** `C:\Users\MR.PC\Desktop\wp-bot\Ai-news`
- **Requires:** WordPress 6.0+, PHP 7.4+
- **Text Domain:** `ai-news`
- **Style System:** Custom CSS design system in `assets/css/style.css` (CSS custom properties, no Tailwind / no Bootstrap)
- **Default Appearance:** Dark mode (Tiffany green `#21F1A8` + dark gray `#101820` palette)
- **JS:** Vanilla JS, no jQuery dependency (except WordPress-injected comment-reply if enabled)

---

## 2. Directory Layout

```
Ai-news/
├── style.css                    # Theme header only (11 lines) — real styles live in assets/css/
├── functions.php                # Theme bootstrap (enqueue, setup, meta boxes, AJAX, customizer)
├── front-page.php               # Home page (carousel + top posts + categories + trending + tools + prompts)
├── index.php                    # Fallback blog home (hero + latest posts + newsletter)
├── header.php                   # <head>, site header, nav, search, dark-mode toggle
├── footer.php                   # Footer grid (about / quick links / categories / legal) + wp_footer
├── single.php                   # Default single post (rich layout: share, FAQ, related, comments)
├── single-ai_news.php           # Single template for ai_news CPT (lighter layout)
├── page.php                     # Default page fallback (title + content)
├── archive.php                  # Generic archive fallback
├── archive-ai_news.php          # Archive for ai_news CPT
├── category.php                 # Category archive
├── tag.php                      # Tag archive
├── author.php                   # Author archive (with avatar + bio)
├── search.php                   # Search results (custom WP_Query, paginated)
├── 404.php                      # 404 page (search box + home link)
│
├── page-templates/              # Custom page templates (assigned via Page Attributes)
│   ├── page-article.php         # Article-style page (mirrors single.php with share/FAQ)
│   ├── page-tools.php           # AI Tools directory (queries ai_tool CPT)
│   ├── page-prompts.php         # AI Prompts listing (queries ai_prompt CPT)
│   ├── page-news.php            # News listing (queries ai_news CPT)
│   ├── page-categories.php      # Categories overview (icon grid)
│   ├── page-contact.php         # Contact form (AJAX -> admin_email)
│   ├── page-newsletter.php      # Newsletter landing
│   ├── page-sitemap.php         # HTML sitemap
│   ├── page-about.php           # About Us
│   ├── page-privacy.php         # Privacy Policy
│   ├── page-terms.php           # Terms of Service (largest, 12.9KB)
│   ├── page-disclaimer.php      # Disclaimer
│   └── page-article.php         # (article layout, dup of single)
│
├── inc/
│   ├── template-functions.php   # Helpers: ai_news_estimated_read_time(), ai_news_post_meta(), ai_news_query()
│   └── page-creator.php         # One-time default-page generator (visit ?ai_news_init_pages=1 as admin)
│
├── assets/
│   ├── css/style.css            # The REAL stylesheet (~2820 lines) — single source of truth for styling
│   └── js/
│       ├── main.js              # Global: dark mode, search, mobile menu, carousel, newsletter, contact
│       └── single-post.js       # Single-only: reading progress, back-to-top, copy-link
│
├── parts/                       # EMPTY (no reusable partials yet)
└── tempCodeRunnerFile.rust      # STRAY — "Hello World" Rust snippet, not part of theme. Safe to delete.
```

---

## 3. functions.php Anatomy

| Section | Lines | Purpose |
|---|---|---|
| 1. Enqueue Assets | 17–34 | Fonts (Inter, JetBrains Mono), main style, main.js, single-post.js (conditionally), comment-reply.js |
| 2. Nonce verification | 37–45 | AJAX nonce guard for `subscribe` & `contact` actions |
| 2. Theme Setup | 48–67 | title-tag, thumbnails, html5, menus, post-formats, 4 image sizes |
| 3. Page Templates | 70–84 | Registers 11 custom page templates |
| 4. CPT Registration | 86–166 | **DISABLED** (commented out) — ai_news, ai_tool, ai_prompt |
| 5. FAQ Meta Box | 169–245 | Repeater Q&A stored in `_faq_items` post meta (JS inline in admin) |
| 6. Meta Boxes | 248–318 | News details, tool details, prompt details (for disabled CPTs) |
| 6. Newsletter AJAX | 321–335 | `ai_news_subscribe` — stores emails in `ai_news_subscribers` option |
| 7. Contact AJAX | 338–355 | `ai_news_contact` — sends via `wp_mail()` to admin_email |
| 8. Includes | 358–359 | `inc/template-functions.php`, `inc/page-creator.php` |
| 9. Customizer | 362–383 | Telegram URL + dark-mode toggle setting |

### Registered Image Sizes
- `hero-feature` 800×608 (hard crop)
- `article-card` 768×512 (hard crop)
- `article-single` 1200×800 (hard crop)
- `carousel-slide` 1200×600 (hard crop)

### Registered Nav Menus
- `primary` — Primary Menu
- `footer` — Footer Menu (header has fallback `<ul>` if none assigned)

---

## 4. Template Hierarchy (what loads when)

- **Home:** `front-page.php` (when WP set to static front page) else `index.php`
- **Single post:** `single.php`
- **Single `ai_news`:** `single-ai_news.php` (only if CPT re-enabled)
- **Page:** `page.php`, overridden by Custom Page Template if assigned
- **Category:** `category.php`
- **Tag:** `tag.php`
- **Author:** `author.php`
- **Search:** `search.php`
- **Custom archive (`ai_news`):** `archive-ai_news.php`
- **Other archives:** `archive.php`
- **404:** `404.php`

---

## 5. AJAX Endpoints

| Action | Handler | Persist | Notes |
|---|---|---|---|
| `ai_news_subscribe` | `ai_news_handle_subscribe()` | `ai_news_subscribers` option (array of emails) | Nonce `ai_news_ajax` |
| `ai_news_contact` | `ai_news_handle_contact()` | Sends `wp_mail()` to `admin_email` | Nonce `ai_news_ajax` |

Localized data via `wp_localize_script('ai-news-script', 'aiNewsData', ...)`:
- `ajaxUrl`, `homeUrl`, `nonce`

---

## 6. Post Meta Keys

| Meta Key | Used By | Stored By |
|---|---|---|
| `_faq_items` | single.php / page-article.php | FAQ meta box (serialized array of `{q, a}`) |
| `_news_category` | single-ai_news.php, archive-ai_news.php | News details meta box |
| `_read_time` | everywhere read-time is shown | News details meta box |
| `_featured` | front-page.php carousel, index.php hero | News details meta box (checkbox) |
| `_article_excerpt` | single-ai_news.php | (no meta box — orphan key) |
| `_tool_rank`, `_tool_url`, `_tool_rating`, `_tool_pricing`, `_tool_tagline` | front-page tools, page-tools.php | Tool details meta box |
| `_prompt_model`, `_prompt_type`, `_prompt_content` | front-page prompts, page-prompts.php | Prompt details meta box |

---

## 7. CSS Design System (`assets/css/style.css`)

- ~2820 lines, single file, organized with `/* --- section --- */` banners
- CSS custom properties in `:root` (palette, fonts, spacing, radius, transitions)
- Dark mode only — `data-theme="dark"` on `<html>` set by `header.php` and toggled by `main.js`
- Color tokens: `--clr-bg`, `--clr-surface`, `--clr-text`, `--clr-primary` (`#21F1A8`), `--clr-accent`, `--clr-border`, etc.
- Fonts: Inter (body), JetBrains Mono (mono / code / meta)
- Responsive breakpoints: `1024px`, `768px`, `480px`
- Components: `.article-card`, `.carousel-*`, `.trending-*`, `.tool-card`, `.prompt-card`, `.share-icon`, `.faq-*`, `.related-*`, `.back-to-top`

---

## 8. JavaScript (`assets/js/`)

### main.js (global, IIFE)
- Dark mode toggle (persists in `localStorage` key `ai-news-theme`, defaults to dark)
- Search dropdown toggle + overlay
- Mobile menu toggle
- Carousel prev/next + dots (front-page)
- Newsletter form submit (`ai_news_subscribe` AJAX)
- Contact form submit (`ai_news_contact` AJAX)
- Prompt copy button (front-page)

### single-post.js (loaded on `is_single()` / `is_page()`)
- Reading progress bar (`#reading-progress` width %)
- Back-to-top button (`#back-to-top`, appears after 300px scroll)
- Copy-link button (`.share-copy` — uses `navigator.clipboard`, swaps icon to checkmark for 2s)

---

## 9. Known Issues & Conventions

### Critical / Architectural
- **CPTs disabled:** `ai_news`, `ai_tool`, `ai_prompt` registration is commented out in `functions.php:86–166`. However `front-page.php`, `page-templates/page-tools.php`, `page-prompts.php`, `page-news.php`, `page-sitemap.php`, `archive-ai_news.php`, `single-ai_news.php` all query these post types — they return empty until CPTs are re-enabled.
- **Meta boxes for disabled CPTs:** `functions.php:249–253` registers meta boxes for `ai_news`, `ai_tool`, `ai_prompt`. While CPTs are disabled these calls produce "no such screen" notices.
- **`comment-reply.js` enqueued but missing:** `functions.php:27` enqueues `assets/js/comment-reply.js` which does not exist in the repo. Either create the file or remove the enqueue line.
- **Header fallback URLs hardcode disabled CPT slugs:** `header.php:46–49` links to `/prompts` and `/tools`, but those CPT rewrites are disabled — links 404 unless matching pages exist.

### Status / Pagination
- `author.php`, `tag.php`, `category.php`, `archive-ai_news.php` use inline `var(--color-muted)` and `var(--color-primary)` (old token names) instead of the current `--clr-text-muted` / `--clr-primary` — these may render with default/fallback colors.

### Stray Files
- `tempCodeRunnerFile.rust` — "Hello World" Rust snippet, not theme code. Safe to delete.
- `README.md` — flagged as binary (BOM / encoding); cannot be read as text.

---

## 10. Conventions (follow when editing)

1. **Always add explicit `width` + `height` + `xmlns` to inline SVGs.** SVGs with only `viewBox` can render at the browser default (300×150) and blow out containers. All header/footer/carousel SVGs follow this rule.
2. **CSS for SVG sizing must include `max-width` / `max-height`** in addition to `width`/`height` so missing-attribute SVGs are still clamped.
3. **Real styles go in `assets/css/style.css`**, NOT the root `style.css` (that file is header-only).
4. **Conditional scripts:** single-post features are loaded only on `is_single() || is_page()` — see `functions.php:24`.
5. **AJAX handlers must verify nonce** via the shared `ai_news_verify_nonce()` hooked at priority 1.
6. **Sanitize all meta on save:** `sanitize_text_field`, `sanitize_email`, `wp_kses_post` are already used — keep using them.
7. **Custom queries use `WP_Query` + `wp_reset_postdata()`** — never modify the main query inline (except via `pre_get_posts` if added later).
8. **Page templates are registered twice:** once in `functions.php:70–84` (dropdown filter) and again via `Template Name:` headers in each `page-templates/*.php`.

---

## 11. Page-Creator Helper (`inc/page-creator.php`)

- One-time utility to scaffold the 11 default pages with correct templates assigned.
- **Trigger:** visit `/?ai_news_init_pages=1` while logged in as admin.
- **Recommendation in code:** delete this file after pages are created (security).
- Currently auto-runs on `init` if the query var is present — safe but easy to abuse; remove from production deployments.

---

## 12. Recent Fixes Applied

### 2026-07-06 — Share icons rendering oversized on single posts
**Symptom:** Share icons (WhatsApp / FB / Telegram / LinkedIn / Copy) on single posts displayed very large / weird.
**Root cause:** SVGs in `single.php` and `page-templates/page-article.php` had only `viewBox="0 0 24 24"` with no `width`/`height` attributes; browsers default inline SVG without dimensions to 300×150, and `.share-icon svg { width:18px }` alone did not always clamp it.
**Fix:**
- `assets/css/style.css` `.share-icon svg` — added `max-width/max-height:18px; display:block; flex:0 0 auto;`
- `assets/css/style.css` mobile `@media (max-width:768px)` `.share-icon svg` — added matching `max-width/max-height:16px`
- `assets/css/style.css` `.back-to-top svg` — added defensive `max-width/max-height:20px; display:block;`
- `single.php` — added `xmlns="http://www.w3.org/2000/svg" width="24" height="24"` to all 5 share SVGs + the back-to-top SVG
- `page-templates/page-article.php` — same fix on all 5 share SVGs + back-to-top SVG

**Lesson:** Any new inline SVG must include explicit `width`, `height`, and `xmlns` attributes.
