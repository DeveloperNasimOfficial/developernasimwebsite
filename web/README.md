# developernasim.com: Next.js + Three.js + GSAP

An immersive personal brand website for **MD Nasim**, built with:

- **Next.js 16** (App Router, static export, so it runs on any host)
- **Three.js**: a custom-shader 3D blob and particle field in the hero that react to your mouse and to scrolling
- **GSAP + ScrollTrigger + SplitText**: preloader, split-line headings, pinned horizontal work gallery, stacked service cards, scrubbed word reveal, scroll-speed marquee, page-transition curtain
- **Lenis** smooth scrolling, a custom cursor, magnetic buttons
- Self-hosted fonts (Inter Tight + Instrument Serif); no external requests except the form

Pages: `/` home · `/work/` all 17 projects with filters · `/work/<project>/` one case study per project · `/free-website-audit/` audit request form.

## 1. Add your REAL project screenshots (important)

The 17 projects come from your Upwork portfolio (`src/data/projects.ts`). Until a screenshot exists, each card shows a clean branded frame with the project name. Nothing fake or AI-generated is used.

1. Take a full-width screenshot of each live site (1600×1000 or larger). You can also export the images from your Upwork portfolio.
2. Save it in `public/work/` using the project's slug as the file name:

| Project | File name |
| --- | --- |
| Skincare Business | `skincare-business.jpg` |
| Automotive Business | `automotive-business.jpg` |
| Photography Portfolio | `photography-portfolio.jpg` |
| Bakery Business | `bakery-business.jpg` |
| Fashion eCommerce | `fashion-ecommerce.jpg` |
| Digital Studio | `digital-studio.jpg` |
| Skin Care Store | `skincare-ecommerce.jpg` |
| Premium Coffee Brand | `premium-coffee.jpg` |
| Plant & Gardening | `plant-gardening.jpg` |
| LMS Platform | `lms-platform.jpg` |
| Premium Cap Brand | `premium-cap-brand.jpg` |
| Electronics Store | `electronics-ecommerce.jpg` |
| Electronics Product | `electronics-product.jpg` |
| T-Shirt Wholesale | `tshirt-wholesale.jpg` |
| Coffee Maker Store | `coffee-maker.jpg` |
| Custom Web Development | `custom-web-development.jpg` |
| eCommerce Development | `ecommerce-web-development.jpg` |

3. For extra case-study images, add `bakery-business-2.jpg`, `bakery-business-3.jpg` and so on.
4. Run `npm run build`. The images are detected automatically.

In `src/data/projects.ts` you can also add each project's live `url`, `client` name and `year`, and edit the summary. Projects with `featured: true` appear in the homepage gallery.

**Your photo:** save it as `public/nasim.jpg` and follow the comment in `src/components/About.tsx`.

## 2. Connect the audit form

1. Go to https://web3forms.com, enter the email where requests should arrive, and copy the access key.
2. Paste it into `web3formsKey` in `src/data/site.ts`, then rebuild.

Until a key is set, the form tells visitors to contact you on Upwork. (If you also set `email` in `site.ts`, it opens their email app instead.)

## 3. Edit your content

All the text lives in `src/data/site.ts`: hero, story, stats, services, process, testimonials, experience, certificates, FAQ, socials and email. The brand color is `--brand` at the top of `src/app/globals.css`.

## 4. Run & publish

```bash
npm install
npm run dev      # http://localhost:3000
npm run build    # outputs the static site to /out
```

**Option A, Hostinger (or any cPanel / hPanel hosting):**
1. Back up the current site in hPanel: **Websites → Manage → Files → Backups**, or download `public_html` and the database.
2. Open **File Manager → public_html** and remove the old WordPress files, *including* WordPress's `.htaccess`.
3. Upload `dist/developernasim-nextjs-upload.zip` into `public_html`, right-click it → **Extract** → extract straight into `public_html`. `index.html` must sit directly in `public_html`, not in a subfolder. Then delete the zip.
4. hPanel → **Performance → Cache Manager → Purge all**, then open your domain.

The included `.htaccess` (from `public/.htaccess`) forces HTTPS, shows the custom 404 page, sets browser caching and gzip, and redirects old WordPress URLs to the homepage.
To update the site later: run `npm run build` and upload the new `out/` contents the same way.

**Option B, Vercel (free, recommended):** import the GitHub repo at vercel.com, set **Root Directory** to `web`, and deploy. Then point your domain at Vercel.

## Performance & accessibility

- The 3D scene loads after the page, pauses when it's off screen, uses fewer particles and a lower resolution on phones, and falls back to a gradient when WebGL isn't available.
- `prefers-reduced-motion` turns off smooth scrolling, the preloader and all motion.
- The preloader plays once per visit.
