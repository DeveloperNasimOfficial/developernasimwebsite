"use client";

import { useRef } from "react";
import { gsap, ScrollTrigger, useGSAP, prefersReducedMotion } from "@/lib/gsap";

/** Infinite marquee that speeds up, reverses and skews with scroll velocity. */
export default function Marquee({ items }: { items: string[] }) {
  const root = useRef<HTMLDivElement>(null);

  useGSAP(
    () => {
      if (prefersReducedMotion()) return;
      const track = root.current!.querySelector(".marquee__track") as HTMLElement;
      let x = 0;
      let dir = -1;
      let boost = 0;
      const half = () => track.scrollWidth / 2;
      const skew = gsap.quickTo(track, "skewX", { duration: 0.5, ease: "power3" });

      const st = ScrollTrigger.create({
        trigger: root.current,
        start: "top bottom",
        end: "bottom top",
        onUpdate: (self) => {
          const v = self.getVelocity();
          dir = v > 0 ? -1 : v < 0 ? 1 : dir;
          boost = Math.min(Math.abs(v) / 120, 14);
          skew(gsap.utils.clamp(-8, 8, -v / 400));
        },
      });

      const tick = () => {
        x += dir * (0.6 + boost);
        boost *= 0.92;
        const w = half();
        if (x <= -w) x += w;
        if (x > 0) x -= w;
        gsap.set(track, { x });
        if (boost < 0.05) skew(0);
      };
      gsap.ticker.add(tick);
      return () => { gsap.ticker.remove(tick); st.kill(); };
    },
    { scope: root }
  );

  const row = [...items, ...items];
  return (
    <div className="marquee" ref={root} aria-label={items.join(", ")}>
      <div className="marquee__track" aria-hidden="true">
        {row.map((item, i) => (
          <span key={i} className="marquee__item">
            {item}
            <span className="marquee__star">✦</span>
          </span>
        ))}
      </div>
    </div>
  );
}
