import type { Metadata } from "next";
import AuditForm from "./AuditForm";
import Testimonials from "@/components/Testimonials";
import Faq from "@/components/Faq";
import { Check, Stars } from "@/components/Icons";

export const metadata: Metadata = {
  title: "Free Website Audit",
  description: "Send your website and get a personal Loom video audit with a clear, prioritised action plan. Free, no strings attached.",
};

const checks = [
  ["Structure & messaging", "Can visitors tell what you do in 5 seconds?"],
  ["Conversion flow", "CTAs, forms and the path to contact or checkout."],
  ["Speed & Core Web Vitals", "Mobile load time and what's slowing it down."],
  ["SEO & technical health", "Indexing, broken bits and security red flags."],
];

const faq = [
  { q: "Is the audit really free?", a: "Yes. It's how I show you how I think before we ever work together. There's no payment and no obligation." },
  { q: "Do you need access to my WordPress admin?", a: "No. I review your live website from the outside, exactly as visitors and Google see it. Just send the URL." },
  { q: "My site isn't built on WordPress. Can I still apply?", a: "Yes. Structure, messaging, speed and conversion issues look the same on any platform." },
  { q: "What happens after I get the video?", a: "Whatever you want. Fix things yourself with the action plan, or reply and I'll send a fixed quote to handle it for you." },
];

export default function AuditPage() {
  return (
    <>
      <section className="page-hero">
        <div className="wrap audit">
          <div className="audit__side">
            <p className="eyebrow">100% free · No strings attached</p>
            <h1 className="display" style={{ fontSize: "clamp(52px, 7.4vw, 124px)" }} data-split>
              Free website <span className="serif accent">audit</span> on video.
            </h1>
            <p className="lead" data-reveal>Send me your website. I&apos;ll review it the way your visitors do (cold, impatient, ready to leave) and record a personal Loom video covering what&apos;s holding it back and exactly how to fix it.</p>
            <ul className="checks" data-reveal>
              {checks.map(([b, t]) => <li key={b}><Check /><span><b>{b}.</b> {t}</span></li>)}
            </ul>
            <div style={{ display: "flex", alignItems: "center", gap: 14, fontSize: 14 }} data-reveal>
              <Stars /> <span className="muted">Top Rated Plus · Top 3% on Upwork · Recorded personally by Nasim</span>
            </div>
          </div>
          <AuditForm />
        </div>
      </section>
      <Testimonials />
      <Faq items={faq} title={<>Is it <span className="serif accent">really</span> free?</>} />
    </>
  );
}
