"use client";

import { useRef } from "react";
import { gsap, useGSAP, prefersReducedMotion } from "@/lib/gsap";
import { services } from "@/data/site";

/** Sticky stacked cards: each one scales back as the next slides over it. */
export default function Services() {
  const root = useRef<HTMLElement>(null);
  useGSAP(
    () => {
      if (prefersReducedMotion()) return;
      const cards = gsap.utils.toArray<HTMLElement>(".scard");
      cards.forEach((card, i) => {
        const next = cards[i + 1];
        if (!next) return;
        // Covered cards shrink back and their content fades; the card itself stays
        // opaque so nothing shows through the card on top of it.
        const st = { trigger: next, start: "top 85%", end: "top 30%", scrub: true };
        gsap.to(card, { scale: 0.94 + i * 0.01, ease: "none", scrollTrigger: st });
        gsap.to(card.querySelectorAll(":scope > *"), { opacity: 0, ease: "none", scrollTrigger: { ...st } });
      });
    },
    { scope: root }
  );

  return (
    <section className="section" id="services" ref={root}>
      <div className="wrap">
        <div className="services__head">
          <div>
            <p className="eyebrow" style={{ marginBottom: 24 }}>Services</p>
            <h2 className="h2" data-split>Everything your website needs, <span className="serif accent">nothing it doesn&apos;t.</span></h2>
          </div>
          <p className="lead" data-reveal>From a single landing page to a full WooCommerce store: designed with intent, built to perform and easy for you to manage.</p>
        </div>
        <div className="stack">
          {services.map((s) => (
            <article className="scard" key={s.n}>
              <span className="scard__n">{s.n}</span>
              <h3 className="scard__title">{s.title}</h3>
              <div>
                <p className="scard__text">{s.text}</p>
                <ul className="scard__tags">{s.tags.map((t) => <li className="tag" key={t}>{t}</li>)}</ul>
              </div>
            </article>
          ))}
        </div>
      </div>
    </section>
  );
}
