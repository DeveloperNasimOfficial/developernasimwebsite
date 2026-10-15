"use client";

import type { ReactNode } from "react";

import { useRef, useState } from "react";
import { gsap } from "@/lib/gsap";

export default function Faq({ items, title }: { items: { q: string; a: string }[]; title: ReactNode }) {
  const [open, setOpen] = useState<number | null>(0);
  const refs = useRef<(HTMLDivElement | null)[]>([]);

  const toggle = (i: number) => {
    const next = open === i ? null : i;
    refs.current.forEach((el, j) => {
      if (!el) return;
      gsap.to(el, { height: j === next ? "auto" : 0, duration: 0.7, ease: "expo.out" });
    });
    setOpen(next);
  };

  return (
    <section className="section" id="faq">
      <div className="wrap faq__grid">
        <div>
          <p className="eyebrow" style={{ marginBottom: 24 }}>FAQ</p>
          <h2 className="h2" data-split>{title}</h2>
        </div>
        <div>
          {items.map((item, i) => (
            <div className={`faq__item${open === i ? " is-open" : ""}`} key={item.q}>
              <button className="faq__q" onClick={() => toggle(i)} aria-expanded={open === i}>
                {item.q}
                <span className="faq__icon" aria-hidden="true" />
              </button>
              <div className="faq__a" ref={(el) => { refs.current[i] = el; }} style={{ height: i === 0 ? "auto" : 0 }}>
                <p>{item.a}</p>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
