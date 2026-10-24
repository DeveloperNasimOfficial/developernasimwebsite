# QA Group homepage: concept round 2 (editorial direction)

Feedback: "I like it but don't love the look yet… match closer to the example sites. This may be a good start: bossdesign.com/product/arthur."

## What changed from round 1

The direction moves from a generic corporate template toward an **editorial, catalog-style look** (Boss Design / NBBJ / Stitchroom):

- **Brand guide applied (from the Project Brief).**
  - Deep Brown `#534132` with Golden Mustard `#D4B858` accents.
  - Brandon Grotesque headings.
  - **Garamond serif body text.** EB Garamond stands in for Adobe Garamond Pro; once the Adobe Fonts kit is added to the site it takes over automatically.
- **Quieter, more confident styling.**
  - Lots of white space and thin hairline rules.
  - Small, widely spaced uppercase labels.
  - Text links with an underline instead of boxed buttons. Solid buttons are kept only for "Get An Estimate" and "Contact Us".
- **Header.** Transparent over the hero, then **solid white** after scrolling. Dropdowns are **full-width panels** listing the pages (brief: "cleaner dropdown navigation").

## Page flow

1. **Hero:** the same 3 slideshow images and the same text at the bottom left, plus a 01 / 03 slide counter.
2. **What we do / who we do it for:** a new two-column index right under the hero. "Our Services" sits on one side and "Industries We Serve" on the other, each listing its existing pages as links. This answers the brief's request that visitors immediately understand QA Group's services and audiences. It uses only the existing menu labels.
3. **Intro:** the heading, then the 3 stories as three columns, each with its photo on top.
4. **Video:** a full-width band. The player loads on click.
5. **Who We Serve:** a numbered list of the 8 industries on the left. On hover, the large photo on the right changes to that industry's image. On phones, each row shows a small thumbnail instead.
6. **Our Valued Clients:** the logos in a ruled grid, grayscale until hover.
7. **Why Choose QA Group?:** the heading and lead stay pinned on the left while the photo, body text and the 3 points (laid out like a spec sheet) scroll on the right.
8. **Chances are, you've seen our work.:** a **project photo mosaic with a lightbox** (brief: "more project photography" and "lightbox galleries"), then the 20 project names in four columns. Right-click and drag are turned off on gallery images (brief: "image download protection", as a basic deterrent).
9. **CTA:** the two existing panels, in cream and brown.
10. **Footer:** the existing content, plus a **Contact Us column with the Kent, WA address and phone number** (brief: "footer that clearly shows the Kent, WA location and contact details").

## Please confirm

1. **Footer address and phone:** "19615 Russell Road, Kent, WA 98032" comes from a public business listing. "1 (833) 570-2170" is the phone number the site's own call-tracking code uses. Neither appears on the current homepage, so both need confirming.
2. **Mosaic photos:** these are QA Group photos already on the staging site but not visible on the homepage today: Delta-7, Mio-Oh-Mio-9898, 190708_NSAT_lounge_061, 1738868323617, hero-1-D, hero-3-C. Swap in any others you'd like featured.
3. **Repeated labels:** the "Industries We Serve" label above "Who We Serve", and the "Our Services" / "Industries We Serve" index headings, reuse the existing menu labels. No new wording was written.
4. **Adobe Garamond Pro:** needs the brand's Adobe Fonts (Typekit) kit added to the site.
5. The link issues listed in round 1 still apply. "Resource Hub" stays named as is for now; the rename to "Library" is part of the brief's later scope.

The page is about 8,000px tall at desktop width, compared with about 6,500px in round 1. The extra length comes from two brief requirements: the services/audience index and the project photo mosaic. The other sections were tightened to offset them.

## Notes

- I couldn't open bossdesign.com or the other reference sites from my build environment (blocked by its network). The direction is based on the brief and on how those sites are known to present products: big photography, thin rules, small caps labels, mosaic galleries and spec-sheet rows.
- Once this direction is approved, I'll produce the matching Elementor JSON, as in round 1.
