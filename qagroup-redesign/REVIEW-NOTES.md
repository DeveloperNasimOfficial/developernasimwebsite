# QA Group homepage: layout concept, round 1

Source: the staging homepage (https://qagroup.us/mystaging01/), saved as HTML.
Open `index.html` in a browser to view the concept.

## Ground rules followed

- **Copy:** every heading, paragraph, button label, link and list item comes word for word from the sections visible on staging. Nothing was reworded.
- **Images:** only images already on the staging homepage are used, linked to the same `wp-content/uploads` files. If an image fails to load, its frame stays as a gray placeholder box.
- **What changed:** order, grouping, spacing, hierarchy and motion.

## New page flow (top to bottom)

| # | Section | What changed in the layout |
|---|---------|----------------------------|
| 1 | **Hero** | A full-screen slideshow of the three existing hero images with a slow zoom (Sechrist / CCS). The existing H1, line and "View Our Portfolio" button sit at the bottom left. Thin progress bars show which slide is playing. |
| 2 | **Our Valued Clients** | Moved up to a slim logo strip directly under the hero, so credibility (Apple, Alaska, Amazon, Starbucks, ACA) shows within the first screen (NBBJ / AWI). Logos are grayscale and turn to color on hover. |
| 3 | **Intro** | "Your one-stop…" heading, then the three stories (90 Years / Simplifying Projects / Complete Solutions) combined into **one** block: a numbered accordion on the right with a matching photo on the left that swaps as each story opens. This replaces three full-height alternating rows. |
| 4 | **Video** | The existing YouTube video ("Watch qa group") as a wide cinematic band. The player loads only on click, which keeps the page fast. |
| 5 | **Who We Serve** | The heading and paragraph sit side by side, followed by a compact 4×2 grid of the 8 industry cards (same images and links). The photo zooms and an arrow appears on hover. |
| 6 | **Why Choose QA Group?** | Two columns: the copy on the left with the first sentence set as a lead, and the booth photo on the right (sticky while you read). The three points (Turnaround / Craftsmanship / Customer Service) follow as one numbered row instead of stacked blocks. |
| 7 | **Chances are, you've seen our work.** | A dark brand band: the heading, line and sewing illustration on the left, and the 20 project names on the right as a numbered two-column list (previously one long column). |
| 8 | **CTA** | "Ready to kick off a project?" and "We love meeting new people." shown as two side-by-side panels in brand brown and cream. |
| 9 | **Footer** | Logo and blurb, social icons, Quick Links in two columns, the subscribe line with the newsletter form, and the copyright line. |

The page is about 6,500px tall at desktop width. The biggest savings come from the intro (3 rows → 1 block), Why Choose (stacked → row) and the 20-name list (1 column → 2).

Visual direction: brand brown `#534132` and gold accent `#b28b4c` (both already used on staging), Brandon Grotesque headings (the site font), Inter for body text, and generous but tight spacing (Stitchroom, compressed). The header is transparent over the hero and turns to dark glass on scroll. Services and Industries drop-down menus are in the header (AWI-style).

## Please review / decide

1. **Small labels added by the design (not copy changes):**
   - "Slide 1 / 2 / 3" exists only as screen-reader labels on the hero progress bars. Nothing is visible.
   - "NEWSLETTER FORM (EXISTING EMBED)" marks a placeholder only. The real newsletter form embed drops in there unchanged.
2. **Casing:** "Our Valued Clients" and "Quick Links" are styled in uppercase with CSS. The text itself is unchanged.
3. **Not used on purpose:** the staging page also contains hidden duplicate sections (mobile variants, an older slider, and alternate "Why Choose" cards with the Delta-7 / Mio-Oh-Mio / 1738868323617 photos). They are hidden on staging today, so they are left out. They can be brought in if you'd like those photos used, for example in the Why Choose row.
4. **Existing link issues spotted on staging (left as is, for your call):**
   - Header "Upholstered Acoustic Wall Panels" points to the live site (`qagroup.us/services/...`), not `/mystaging01/`.
   - "Restaurants" and "Restaurant Chains" both go to `/industries/restaurant-chains/`.
   - The footer "Project Timeline" link has the URL pasted twice in the `href`. The concept uses the single correct URL.
   - The bottom CTA "Get An Estimate" goes to `/contact/estimate/`, while the header button goes to `/contact/estimate-request/`.

## Assets

The site logo and the five client logos were not linked by absolute URL in the saved page. Copy them from the saved page's `_files` folder into `assets/` (see `assets/README.md`). Until then, the logo shows as text and the client logos show as gray boxes.
