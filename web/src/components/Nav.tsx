"use client";

import Link from "next/link";
import { useEffect, useRef, useState } from "react";
import { usePathname } from "next/navigation";
import { gsap, ScrollTrigger } from "@/lib/gsap";
import { site } from "@/data/site";
import { ArrowUR } from "./Icons";

const links = [
  { href: "/work/", label: "Work" },
  { href: "/#services", label: "Services" },
  { href: "/#about", label: "About" },
  { href: "/free-website-audit/", label: "Free audit" },
];

function useClock(tz: string) {
  const [time, setTime] = useState("");
  useEffect(() => {
    const f = new Intl.DateTimeFormat("en-US", { hour: "numeric", minute: "2-digit", timeZone: tz });
    const tick = () => setTime(f.format(new Date()));
    tick();
    const id = setInterval(tick, 30000);
    return () => clearInterval(id);
  }, [tz]);
  return time;
}

export default function Nav() {
  const [open, setOpen] = useState(false);
  const menu = useRef<HTMLDivElement>(null);
  const tl = useRef<gsap.core.Timeline | null>(null);
  const pathname = usePathname();
  const time = useClock(site.timezone);

  useEffect(() => {
    tl.current = gsap
      .timeline({ paused: true })
      .set(menu.current, { visibility: "visible" })
      .to(menu.current, { clipPath: "inset(0 0 0% 0)", duration: 0.9, ease: "expo.inOut" })
      .from(".menu__link", { yPercent: 120, stagger: 0.06, duration: 1, ease: "expo.out" }, "-=0.4");
    return () => { tl.current?.kill(); };
  }, []);

  useEffect(() => {
    if (open) tl.current?.play();
    else tl.current?.reverse();
    document.documentElement.style.overflow = open ? "hidden" : "";
  }, [open]);

  useEffect(() => setOpen(false), [pathname]);

  // Light nav text while the bar sits over a dark section (marked data-nav="dark").
  const [onDark, setOnDark] = useState(false);
  useEffect(() => {
    const active = new Set<Element>();
    const triggers = Array.from(document.querySelectorAll('[data-nav="dark"]')).map((el) =>
      ScrollTrigger.create({
        trigger: el,
        start: "top 40px",
        end: "bottom 40px",
        onToggle: (self) => {
          if (self.isActive) active.add(el); else active.delete(el);
          setOnDark(active.size > 0);
        },
      })
    );
    return () => { triggers.forEach((t) => t.kill()); setOnDark(false); };
  }, [pathname]);

  return (
    <>
      <header className={`nav${onDark || open ? " is-on-dark" : ""}`}>
        <Link href="/" className="nav__brand" aria-label={site.name}>
          <span>{site.short.toLowerCase()}<i>.</i></span>
        </Link>
        <nav className="nav__links" aria-label="Primary">
          {links.map((l) => <Link key={l.href} href={l.href}>{l.label}</Link>)}
        </nav>
        <div className="nav__right">
          <span className="nav__time">Dhaka {time}</span>
          <button className="nav__menu-btn" onClick={() => setOpen((o) => !o)} aria-expanded={open} aria-controls="menu">
            {open ? "Close" : "Menu"}
            <b aria-hidden="true">
              <i style={{ transform: open ? "translateY(3.25px) rotate(45deg)" : "none" }} />
              <i style={{ transform: open ? "translateY(-3.25px) rotate(-45deg)" : "none" }} />
            </b>
          </button>
        </div>
      </header>
      <Link href="/free-website-audit/" className="btn btn--brand btn--sm nav__cta">Let&apos;s talk <ArrowUR /></Link>
      <div className="menu" id="menu" ref={menu} aria-hidden={!open}>
        <nav aria-label="Mobile">
          {[{ href: "/", label: "Home" }, ...links].map((l) => (
            <div key={l.href} style={{ overflow: "hidden" }}>
              <Link href={l.href} className="menu__link" onClick={() => setOpen(false)} tabIndex={open ? 0 : -1}>{l.label}</Link>
            </div>
          ))}
        </nav>
        <div className="menu__foot">
          <span>{site.location} · {time}</span>
          <a href={site.socials.upwork} target="_blank" rel="noopener noreferrer" tabIndex={open ? 0 : -1}>Upwork ↗</a>
        </div>
      </div>
    </>
  );
}
