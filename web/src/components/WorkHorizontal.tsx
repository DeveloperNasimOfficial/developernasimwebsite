"use client";

import Link from "next/link";
import { useRef } from "react";
import { gsap, useGSAP, prefersReducedMotion } from "@/lib/gsap";
import { featured, projects } from "@/data/projects";
import ProjectCard from "./ProjectCard";
import { ArrowUR } from "./Icons";

export default function WorkHorizontal() {
  const root = useRef<HTMLElement>(null);

  useGSAP(
    () => {
      if (prefersReducedMotion()) return;
      const mm = gsap.matchMedia();
      mm.add("(min-width: 861px)", () => {
        const track = root.current!.querySelector(".work-h__track") as HTMLElement;
        const distance = () => track.scrollWidth - window.innerWidth;
        const tween = gsap.to(track, {
          x: () => -distance(),
          ease: "none",
          scrollTrigger: {
            trigger: ".work-h__pin",
            start: "top top",
            end: () => "+=" + distance(),
            pin: true,
            scrub: 1,
            invalidateOnRefresh: true,
            anticipatePin: 1,
          },
        });
        gsap.to(".work-h__progress i", {
          scaleX: 1, ease: "none",
          scrollTrigger: { trigger: ".work-h__pin", start: "top top", end: () => "+=" + distance(), scrub: true },
        });
        // Each card's image counter-moves for depth.
        gsap.utils.toArray<HTMLElement>(".work-h .pcard__media").forEach((media) => {
          const inner = media.querySelector("img, .pframe");
          if (!inner) return;
          gsap.fromTo(inner, { xPercent: 6 }, {
            xPercent: -6, ease: "none",
            scrollTrigger: { trigger: media, containerAnimation: tween, start: "left right", end: "right left", scrub: true },
          });
        });
      });
      return () => mm.revert();
    },
    { scope: root }
  );

  return (
    <section className="work-h" id="work" ref={root}>
      <div className="work-h__pin">
        <div className="work-h__track">
          <div className="work-h__intro">
            <p className="eyebrow">Selected work · {projects.length} projects</p>
            <h2 className="h2" data-split>Real sites for <span className="serif accent">real clients.</span></h2>
            <p className="lead">Brands, stores and businesses I&apos;ve designed and built in WordPress, Elementor and WooCommerce.</p>
            <Link href="/work/" className="btn btn--ghost" style={{ alignSelf: "flex-start" }}>All projects <ArrowUR /></Link>
          </div>
          {featured.map((p, i) => <ProjectCard key={p.slug} project={p} index={i} parallax={false} />)}
        </div>
        <div className="work-h__progress" aria-hidden="true"><i /></div>
      </div>
    </section>
  );
}
