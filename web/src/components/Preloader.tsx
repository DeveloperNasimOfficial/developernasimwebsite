"use client";

import { useRef, useState } from "react";
import { gsap, useGSAP, markReady, prefersReducedMotion } from "@/lib/gsap";
import { site } from "@/data/site";

/** Counter + curtain intro, shown once per browser session. */
export default function Preloader() {
  const root = useRef<HTMLDivElement>(null);
  const [done, setDone] = useState(false);

  useGSAP(
    () => {
      let seen = false;
      try { seen = sessionStorage.getItem("dn-intro") === "1"; } catch {}
      if (seen || prefersReducedMotion()) {
        setDone(true);
        markReady();
        return;
      }
      const counter = { v: 0 };
      const num = root.current!.querySelector(".preloader__count") as HTMLElement;
      const tl = gsap.timeline({
        onComplete: () => {
          try { sessionStorage.setItem("dn-intro", "1"); } catch {}
          setDone(true);
        },
      });
      tl.to(counter, {
        v: 100, duration: 2, ease: "power3.inOut",
        onUpdate: () => { num.textContent = String(Math.round(counter.v)).padStart(3, "0"); },
      })
        .to(".preloader__bar i", { scaleX: 1, duration: 2, ease: "power3.inOut" }, 0)
        .to(".preloader__count, .preloader__top, .preloader__bar", { yPercent: -40, opacity: 0, duration: 0.6, ease: "power3.in" })
        .add(markReady, "-=0.1")
        .to(root.current, { clipPath: "inset(0 0 100% 0)", duration: 1.1, ease: "expo.inOut" }, "-=0.2");
    },
    { scope: root }
  );

  if (done) return null;
  return (
    <div ref={root} className="preloader" style={{ clipPath: "inset(0 0 0% 0)" }} aria-hidden="true">
      <div className="preloader__top">
        <span>{site.name}</span>
        <span>{site.role}</span>
      </div>
      <div>
        <div className="preloader__count">000</div>
        <div className="preloader__bar"><i /></div>
      </div>
    </div>
  );
}
