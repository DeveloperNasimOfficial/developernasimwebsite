"use client";

import { useRef, useState, type FormEvent } from "react";
import { gsap } from "@/lib/gsap";
import { site } from "@/data/site";
import { ArrowUR } from "@/components/Icons";

const GOALS = ["More leads & calls", "More online sales", "Faster loading", "Modern redesign", "Better Google ranking", "Fix bugs or errors"];
const BUSINESS = ["Local service (HVAC, plumbing…)", "eCommerce / WooCommerce", "Real estate", "Healthcare / clinic", "Restaurant / food", "Agency / B2B", "Personal brand / coach", "Something else"];
const BUILDER = ["Elementor", "Divi", "Gutenberg", "Custom theme", "Not WordPress", "Not sure"];
const TIMELINE = ["Just the audit for now", "Ready to fix it ASAP", "Within 1–3 months", "Just exploring"];

type Errors = Partial<Record<"name" | "email" | "website" | "form", string>>;

export default function AuditForm() {
  const [errors, setErrors] = useState<Errors>({});
  const [state, setState] = useState<"idle" | "sending" | "sent">("idle");
  const started = useRef(Date.now());
  const success = useRef<HTMLDivElement>(null);

  const validate = (fd: FormData): Errors => {
    const e: Errors = {};
    if (String(fd.get("name") || "").trim().length < 2) e.name = "Please tell me your name.";
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(String(fd.get("email") || "").trim())) e.email = "Please enter a valid email address.";
    const site = String(fd.get("website") || "").trim().replace(/^https?:\/\//i, "");
    if (!/^[^\s/]+\.[^\s/]{2,}/.test(site)) e.website = "Please enter your website, e.g. yourbusiness.com";
    return e;
  };

  const onSubmit = async (ev: FormEvent<HTMLFormElement>) => {
    ev.preventDefault();
    const form = ev.currentTarget;
    const fd = new FormData(form);
    const e = validate(fd);
    setErrors(e);
    if (Object.keys(e).length) {
      (form.elements.namedItem(Object.keys(e)[0]) as HTMLElement | null)?.focus();
      return;
    }
    // Bots: hidden field filled, or form sent in under 3 seconds.
    if (fd.get("botcheck") || Date.now() - started.current < 3000) { setState("sent"); return; }

    const website = "https://" + String(fd.get("website")).trim().replace(/^https?:\/\//i, "").replace(/\/$/, "");
    const data = {
      name: String(fd.get("name")).trim(),
      email: String(fd.get("email")).trim(),
      website,
      goals: fd.getAll("goals").join(", "),
      business: String(fd.get("business") || ""),
      builder: String(fd.get("builder") || ""),
      timeline: String(fd.get("timeline") || ""),
      message: String(fd.get("message") || ""),
    };

    if (!site.web3formsKey) {
      // Not configured yet: open the visitor's email app with everything filled in.
      const body = Object.entries(data).map(([k, v]) => `${k}: ${v}`).join("\n");
      const to = site.email || "";
      if (to) {
        window.location.href = `mailto:${to}?subject=${encodeURIComponent("Free website audit: " + website)}&body=${encodeURIComponent(body)}`;
        setState("sent");
      } else {
        setErrors({ form: "The form isn't connected yet. Please message me on Upwork for now." });
      }
      return;
    }

    setState("sending");
    try {
      const res = await fetch("https://api.web3forms.com/submit", {
        method: "POST",
        headers: { "Content-Type": "application/json", Accept: "application/json" },
        body: JSON.stringify({
          access_key: site.web3formsKey,
          subject: `New audit request: ${website}`,
          from_name: "developernasim.com",
          replyto: data.email,
          ...data,
        }),
      });
      const json = await res.json().catch(() => ({}));
      if (!res.ok || !json.success) throw new Error(json.message || "Request failed");
      setState("sent");
      requestAnimationFrame(() => {
        if (!success.current) return;
        success.current.focus();
        gsap.from(success.current, { y: 30, opacity: 0, duration: 1, ease: "expo.out" });
        gsap.fromTo(success.current.querySelectorAll("circle, path"), { strokeDashoffset: 160 }, { strokeDashoffset: 0, duration: 1.2, stagger: 0.25, ease: "expo.out" });
      });
    } catch {
      setState("idle");
      setErrors({ form: "Something went wrong sending your request. Please try again, or message me on Upwork." });
    }
  };

  if (state === "sent") {
    return (
      <div className="success" ref={success} tabIndex={-1}>
        <svg viewBox="0 0 52 52" fill="none" stroke="var(--brand-2)" strokeWidth="2.4" strokeLinecap="round" strokeLinejoin="round" aria-hidden="true">
          <circle cx="26" cy="26" r="24" strokeDasharray="160" />
          <path d="m15 27 7 7 15-16" strokeDasharray="160" />
        </svg>
        <h2 className="h3">Request received!</h2>
        <p className="muted" style={{ maxWidth: 420 }}>Thanks! I&apos;ll review your website and send your personal Loom video audit within 2 business days.</p>
      </div>
    );
  }

  const err = (k: keyof Errors) => errors[k] && <small className="field__err">{errors[k]}</small>;

  return (
    <form className="form" onSubmit={onSubmit} noValidate data-reveal>
      <div>
        <h2>Request your audit</h2>
        <p className="muted" style={{ fontSize: 15 }}>Takes about 60 seconds. No logins needed.</p>
      </div>
      {errors.form && <p className="form__alert" role="alert">{errors.form} {!site.web3formsKey && <a href={site.socials.upwork} style={{ textDecoration: "underline" }}>Open Upwork ↗</a>}</p>}
      <input type="checkbox" name="botcheck" className="hp" tabIndex={-1} autoComplete="off" aria-hidden="true" />

      <div className="field-row">
        <div className={`field${errors.name ? " has-error" : ""}`}>
          <label htmlFor="f-name">Your name <b>*</b></label>
          <input id="f-name" name="name" type="text" autoComplete="name" placeholder="Jane Cooper" />
          {err("name")}
        </div>
        <div className={`field${errors.email ? " has-error" : ""}`}>
          <label htmlFor="f-email">Email <b>*</b></label>
          <input id="f-email" name="email" type="email" autoComplete="email" placeholder="jane@business.com" />
          {err("email")}
        </div>
      </div>

      <div className={`field${errors.website ? " has-error" : ""}`}>
        <label htmlFor="f-site">Website URL <b>*</b></label>
        <input id="f-site" name="website" type="text" inputMode="url" autoComplete="url" placeholder="yourbusiness.com" />
        {err("website")}
      </div>

      <fieldset className="field">
        <legend>What should your website do better?</legend>
        <div className="chips">
          {GOALS.map((g) => <label className="chip" key={g}><input type="checkbox" name="goals" value={g} /><span>{g}</span></label>)}
        </div>
      </fieldset>

      <div className="field-row">
        <div className="field">
          <label htmlFor="f-biz">Business type</label>
          <div className="select">
            <select id="f-biz" name="business" defaultValue="">
              <option value="">Choose one</option>
              {BUSINESS.map((b) => <option key={b}>{b}</option>)}
            </select>
          </div>
        </div>
        <div className="field">
          <label htmlFor="f-builder">Built with</label>
          <div className="select">
            <select id="f-builder" name="builder" defaultValue="">
              <option value="">Choose one</option>
              {BUILDER.map((b) => <option key={b}>{b}</option>)}
            </select>
          </div>
        </div>
      </div>

      <div className="field">
        <label htmlFor="f-msg">What&apos;s not working right now? <span className="muted" style={{ fontWeight: 400 }}>Optional</span></label>
        <textarea id="f-msg" name="message" maxLength={3000} placeholder="e.g. We get traffic but hardly any calls, and the site feels slow on mobile." />
      </div>

      <fieldset className="field">
        <legend>When do you plan to improve it?</legend>
        <div className="chips">
          {TIMELINE.map((t) => <label className="chip" key={t}><input type="radio" name="timeline" value={t} /><span>{t}</span></label>)}
        </div>
      </fieldset>

      <button type="submit" className="btn btn--brand" style={{ width: "100%", height: 60 }} disabled={state === "sending"}>
        {state === "sending" ? "Sending…" : <>Get my free audit <ArrowUR /></>}
      </button>
      <p className="form__note">No spam, no sales pressure. Your details are only used for your audit.</p>
    </form>
  );
}
