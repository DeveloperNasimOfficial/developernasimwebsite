"use client";

import dynamic from "next/dynamic";
import Link from "next/link";
import { useRef } from "react";
import { gsap, useGSAP, onReady, prefersReducedMotion } from "@/lib/gsap";
import { hero, site } from "@/data/site";
import { ArrowUR } from "./Icons";
import Magnetic from "./Magnetic";

const HeroScene = dynamic(() => import("./HeroScene"), { ssr: false });

export default function Hero() {
  const root = useRef<HTMLElement>(null);

  useGSAP(
    () => {
      if (prefersReducedMotion()) return;
      const el = root.current!;
      const q = gsap.utils.selector(el);
      const lines = q(".hero__title .line-mask > span");
      const fades = q("[data-hero-fade]");
      const canvas = q(".hero__canvas-wrap");
      const title = q(".hero__title");
      gsap.set(lines, { yPercent: 115, rotate: 3 });
      gsap.set(fades, { opacity: 0, y: 30 });
      gsap.set(canvas, { opacity: 0, scale: 1.08 });
      return onReady(() => {
        const tl = gsap.timeline({ defaults: { ease: "expo.out" } });
        tl.to(canvas, { opacity: 1, scale: 1, duration: 2.4 }, 0)
          .to(lines, { yPercent: 0, rotate: 0, duration: 1.6, stagger: 0.1 }, 0.1)
          .to(fades, { opacity: 1, y: 0, duration: 1.2, stagger: 0.08 }, 0.6);
        // Title drifts up and fades as you leave the hero.
        gsap.to(title, {
          yPercent: -18, opacity: 0.2, ease: "none",
          scrollTrigger: { trigger: el, start: "top top", end: "bottom top", scrub: true },
        });
      });
    },
    { scope: root }
  );

  return (
    <section className="hero" ref={root}>
      <div className="hero__canvas-wrap"><HeroScene /></div>
      <div className="hero__vignette" />
      <div className="wrap hero__inner">
        <p className="eyebrow hero__eyebrow" data-hero-fade>{hero.eyebrow} · {site.location}</p>
        <h1 className="display hero__title">
          {hero.lines.map((line, i) => (
            <span key={line} className="line-mask">
              <span className={i === hero.accentLine ? "serif" : undefined}>{line}</span>
            </span>
          ))}
        </h1>
        <div className="hero__row">
          <div data-hero-fade>
            <p className="lead">{hero.text}</p>
            <div className="hero__ctas" style={{ marginTop: 28 }}>
              <Magnetic>
                <Link href="/free-website-audit/" className="btn btn--brand">Get a free website audit <ArrowUR /></Link>
              </Magnetic>
              <Link href="/work/" className="btn btn--ghost">See real work <ArrowUR /></Link>
            </div>
          </div>
          <div className="hero__badges" data-hero-fade>
            <div><b>Top 3%</b>on Upwork</div>
            <div><b>35+</b>projects</div>
            <div><b>Top Rated</b>Plus</div>
          </div>
        </div>
        <div className="hero__scroll" data-hero-fade><i />Scroll to explore</div>
      </div>
    </section>
  );
}
