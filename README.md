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

## Free website audit page

The page at **`/free-website-audit/`** is created automatically when you activate the theme. It has a full request form: name, email, website, goals, business type, builder, the problem and a timeline.

- **Where requests go:** each one is saved under **Audit requests** in wp-admin and emailed to you. Set the address in **Customize → Developer Nasim → Offer & call to action → Send audit requests to**. If that's empty it uses your Contact email, then the site admin email.
- **The client** gets an automatic confirmation email. Change the promised delivery time ("2 business days") in the same Customizer section.
- **Spam protection** is built in: a hidden honeypot field, a minimum time to fill the form, a security token and a limit of 5 requests per hour per visitor. No plugin is needed.
- **Email delivery:** many hosts send WordPress mail poorly. Install an SMTP plugin (e.g. *WP Mail SMTP*) so notifications reach your inbox. Requests are always saved in wp-admin either way.
- The homepage "Get a free Loom audit" buttons and the nav's "Free audit" link point to this page.
- If you build a custom menu under Appearance → Menus, add the "Free Website Audit" page to it.
- **The link never 404s:** the theme serves the audit page even if the WordPress page is missing, in the Trash or saved as a draft. With "Plain" permalinks the links switch to `/?dn_audit=1` automatically.
- **Still seeing a 404?** Clear your caching plugin / Cloudflare cache, and go to **Settings → Permalinks** and click **Save** once.

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
