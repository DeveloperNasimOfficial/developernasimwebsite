# Importing the QA Group homepage into Elementor

File: `qagroup-homepage-elementor.json` (Elementor Flexbox Container template)

## Import

1. WP Admin → **Templates → Saved Templates → Import Templates** → choose the JSON → **Import Now**.
2. Open the homepage (or a new test page) → **Edit with Elementor**.
3. Click the folder icon (**Add Template**) → **My Templates** → insert "QA Group – Homepage (Layout Concept R1)".
4. If Elementor asks to import the template's page settings, choose **Yes**. This hides the page title and sets the layout to Elementor Header & Footer.
5. Requirements: Flexbox Container and Nested Elements must be on (Elementor → Settings → Features). Both are on by default on current Elementor versions.

On import, Elementor downloads the images from the staging site into the Media Library.

## What you can edit

All of it is native Elementor, so it's edited in the left panel:

- **Text:** every heading, paragraph and button (Content tab).
- **Images:** the hero slideshow (container → Style → Background → Slideshow), the industry tiles (each tile container → Background), and the photos.
- **Spacing:** padding and margin on every section and element, with separate Desktop / Tablet / Mobile values (Advanced tab).
- **Colors and fonts:** every widget's Style tab.
- **Entrance animation:** each text widget → Advanced → Motion Effects → **Entrance Animation** (Fade In Up) and **Animation Delay**. Delays are staggered: heading 0ms, paragraph 100–150ms, button 200ms and up.

Sections appear in Navigator with clear names: `1. Hero` … `8. CTA`.

## Needs your input after import

1. **Client logos:** `2. Our Valued Clients` has 5 empty image widgets (Apple, Alaska, ACA, Amazon, Starbucks). Click each one and pick the logo already in the Media Library (`client-apple.webp` and so on). The saved page didn't contain their full URLs.
2. **Header and footer:** not included. The site's existing Theme Builder Header ("Blur Header") and Footer stay as they are. For the transparent header over the hero, the existing header just needs to stay sticky/overlay, as on staging.
3. **"Watch qa group" label:** Elementor's Video widget shows a play icon over the thumbnail but has no text field. If you want the label back, add a small Heading inside `4. Video`.

## The `QAG Global Styles (CSS + JS)` block (first container)

An HTML widget holding the shared CSS and JS:

- **Animations:** smooths Elementor's Fade In Up / Fade In entrance animations (longer and softer motion).
- **Intro photo sync:** in `3. Intro`, the photo on the left changes to match whichever accordion item is open.
- **Industry tiles:** gradient and hover zoom.
- **Client logos:** grayscale until hover.
- **Project list:** the 20 names shown as a numbered two-column list.

Don't delete it. If you have Elementor Pro, you can move the CSS into Site Settings → Custom CSS instead.
