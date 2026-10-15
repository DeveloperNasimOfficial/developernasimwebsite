"use client";

import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { SplitText } from "gsap/SplitText";
import { useGSAP } from "@gsap/react";

if (typeof window !== "undefined") {
  gsap.registerPlugin(ScrollTrigger, SplitText, useGSAP);
  gsap.defaults({ ease: "expo.out", duration: 1.2 });
}

export const prefersReducedMotion = () =>
  typeof window !== "undefined" && window.matchMedia("(prefers-reduced-motion: reduce)").matches;

/** Fires once the preloader has finished (or immediately on repeat visits). */
export const READY_EVENT = "dn:ready";
export const onReady = (fn: () => void) => {
  if (typeof window === "undefined") return () => {};
  if ((window as unknown as { __dnReady?: boolean }).__dnReady) {
    fn();
    return () => {};
  }
  window.addEventListener(READY_EVENT, fn, { once: true });
  return () => window.removeEventListener(READY_EVENT, fn);
};
export const markReady = () => {
  (window as unknown as { __dnReady?: boolean }).__dnReady = true;
  // Dispatch on a fresh task so listeners don't run inside the caller's gsap.context
  // (GSAP re-enters a context for timeline callbacks, which would scope selectors wrongly).
  setTimeout(() => window.dispatchEvent(new Event(READY_EVENT)), 0);
};

export { gsap, ScrollTrigger, SplitText, useGSAP };
