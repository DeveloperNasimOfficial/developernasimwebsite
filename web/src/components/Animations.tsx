"use client";

import { usePathname } from "next/navigation";
import { gsap, ScrollTrigger, SplitText, useGSAP, onReady, prefersReducedMotion } from "@/lib/gsap";

/**
 * Declarative scroll animations, re-initialised on every route:
 *  data-reveal          fade + rise when scrolled into view (data-delay="0.1")
 *  data-split           headline lines slide up from a mask
 *  data-words           words light up as you scroll (scrubbed)
 *  data-parallax="0.2"  element drifts against the scroll
 *  data-count="35"      number counts up
 */
export default function Animations() {
  const pathname = usePathname();

  useGSAP(
    () => {
      if (prefersReducedMotion()) return;
      const ctx = gsap.context(() => {});
      const off = onReady(() => {
        ctx.add(() => {
          gsap.utils.toArray<HTMLElement>("[data-reveal]").forEach((el) => {
            gsap.from(el, {
              y: 60, opacity: 0, duration: 1.4, delay: Number(el.dataset.delay || 0),
              scrollTrigger: { trigger: el, start: "top 88%", once: true },
            });
          });

          gsap.utils.toArray<HTMLElement>("[data-split]").forEach((el) => {
            SplitText.create(el, {
              type: "lines", mask: "lines", autoSplit: true, linesClass: "split-line",
              onSplit: (self) =>
                gsap.from(self.lines, {
                  yPercent: 110, duration: 1.4, stagger: 0.09, ease: "expo.out",
                  scrollTrigger: { trigger: el, start: "top 86%", once: true },
                }),
            });
          });

          gsap.utils.toArray<HTMLElement>("[data-words]").forEach((el) => {
            const split = SplitText.create(el, { type: "words", wordsClass: "w" });
            gsap.to(split.words, {
              opacity: 1, stagger: 0.08, ease: "none",
              scrollTrigger: { trigger: el, start: "top 80%", end: "bottom 45%", scrub: true },
            });
          });

          gsap.utils.toArray<HTMLElement>("[data-parallax]").forEach((el) => {
            const amt = Number(el.dataset.parallax || 0.15);
            gsap.fromTo(el, { yPercent: -amt * 50 }, {
              yPercent: amt * 50, ease: "none",
              scrollTrigger: { trigger: el.parentElement || el, start: "top bottom", end: "bottom top", scrub: true },
            });
          });

          gsap.utils.toArray<HTMLElement>("[data-count]").forEach((el) => {
            const end = Number(el.dataset.count);
            const o = { v: 0 };
            gsap.to(o, {
              v: end, duration: 2, ease: "power3.out",
              scrollTrigger: { trigger: el, start: "top 90%", once: true },
              onUpdate: () => { el.textContent = String(Math.round(o.v)); },
            });
          });

          ScrollTrigger.refresh();
        });
      });
      return () => { off(); ctx.revert(); };
    },
    { dependencies: [pathname], revertOnUpdate: true }
  );

  return null;
}
