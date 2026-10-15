import Link from "next/link";
import { processSteps } from "@/data/site";
import { ArrowUR } from "./Icons";

export default function Process() {
  return (
    <section className="section process" id="process" data-nav="dark">
      <div className="wrap process__grid">
        <div className="process__head">
          <p className="eyebrow">How I work</p>
          <h2 className="h2" data-split>Structure first. Design second. <span className="serif" style={{ color: "var(--brand)" }}>Results always.</span></h2>
          <p className="muted" data-reveal style={{ maxWidth: 440 }}>I don&apos;t just open Elementor and start dragging blocks around. Every project follows the same proven process, so you always know what&apos;s next.</p>
          <Link href="/free-website-audit/" className="btn btn--brand" data-reveal>Start with a free audit <ArrowUR /></Link>
        </div>
        <ol>
          {processSteps.map((step, i) => (
            <li className="step" key={step.title} data-reveal>
              <span className="step__n">{String(i + 1).padStart(2, "0")}</span>
              <div>
                <div className="step__top">
                  <h3 className="step__title">{step.title}</h3>
                  <span className="step__meta">{step.meta}</span>
                </div>
                <p className="step__text">{step.text}</p>
              </div>
            </li>
          ))}
        </ol>
      </div>
    </section>
  );
}
