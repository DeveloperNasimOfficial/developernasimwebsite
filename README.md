# Developer Nasim: personal brand website

A modern, minimal, Framer-style WordPress theme for **MD Nasim**, a WordPress developer and web designer (Top Rated Plus · Top 3% on Upwork).

It's hand-coded with no page builder and no plugin dependencies. Every word, color and link can be edited from the WordPress admin.

## Install

1. Download `dist/developernasim.zip`.
2. In WordPress, go to **Appearance → Themes → Add New → Upload Theme**, upload the zip and click **Activate**.
3. Open **Appearance → Customize → Developer Nasim** and set:
   - **Brand & identity**: brand color, portrait photo, name, location
   - **Contact & socials**: LinkedIn URL, email, booking link (Calendly / Cal.com)
   - **Hero / Story & stats / Offer**: all homepage copy
4. *(Optional)* In **Settings → Permalinks**, click **Save** so `/work/` URLs work.

The homepage renders automatically, whether WordPress shows "latest posts" or a static page.

## Add your real work

**Projects → Add new** creates a case study:

- **Title, excerpt, content**: the card text and the case-study story
- **Featured image**: the card and cover image (1600×1200 or larger looks best)
- **Details box**: industry label, client, year, services, live URL, headline result
- **Order** (Page attributes): controls the order on the homepage

Until you publish your first project, the homepage shows four designed **Concept** cards, clearly labelled as concepts. They disappear automatically once a real project is published.

**Testimonials → Add new** works the same way: the title is the client name and the content is the quote. Until you add some, the two quotes from your Upwork profile are shown.

## What's inside

| Section | Notes |
| --- | --- |
| Floating pill nav | Blurred glass effect, hides when you scroll down, full-screen mobile menu, dark-mode toggle |
| Hero | Word-by-word headline reveal, availability badge with the current month, proof card |
| Skills marquee | Infinite scroll, pauses on hover |
| Selected work | Project cards with hover zoom and a custom "View" cursor |
| About | Statement that lights up word by word as you scroll, portrait with a rotating badge, count-up stats |
| Services | Bento grid with a spotlight that follows the cursor, plus industries |
| Process | Sticky heading: Structure first → Design second → Build → Results always |
| Experience | Your 9 companies, with a brand-color fill on hover |
| Testimonials | Upwork reviews with a rating badge |
| Free Loom audit | Your signature offer, shown as an illustrated Loom card |
| FAQ | Animated accordion |
| Footer | Large CTA, live Dhaka clock, giant wordmark |

Also included: `/work/` archive with category filters, case-study template, blog, pages, 404, Person schema plus basic SEO and Open Graph tags (skipped automatically if Yoast or Rank Math is active), `prefers-reduced-motion` support and a light/dark theme that follows the visitor's system setting.

## Edit in code

- `developernasim/inc/defaults.php`: default copy for services, process steps, FAQ, experience, marquee and industries
- `developernasim/style.css`: design tokens at the top (colors, fonts, radius)
- `developernasim/assets/js/main.js`: all animations (vanilla JS, no libraries)

Rebuild the zip with `./build.sh`.
