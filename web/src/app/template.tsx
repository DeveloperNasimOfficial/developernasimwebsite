"use client";

import { useRef } from "react";
import { gsap, useGSAP, prefersReducedMotion } from "@/lib/gsap";

/** Curtain wipe on every route change. */
export default function Template({ children }: { children: React.ReactNode }) {
  const curtain = useRef<HTMLDivElement>(null);
  useGSAP(() => {
    window.scrollTo(0, 0);
    if (prefersReducedMotion()) { gsap.set(curtain.current, { display: "none" }); return; }
    gsap.fromTo(curtain.current, { scaleY: 1, transformOrigin: "top" }, { scaleY: 0, duration: 1, ease: "expo.inOut", delay: 0.05 });
  });
  return (
    <>
      <div ref={curtain} aria-hidden="true" style={{ position: "fixed", inset: 0, zIndex: 180, background: "var(--brand)", transform: "scaleY(0)", pointerEvents: "none" }} />
      {children}
    </>
  );
}
