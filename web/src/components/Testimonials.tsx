import { site, testimonials } from "@/data/site";
import { Stars } from "./Icons";

export default function Testimonials() {
  return (
    <section className="section" id="reviews">
      <div className="wrap" style={{ textAlign: "center" }}>
        <p className="eyebrow" style={{ marginBottom: 24 }}>Client love</p>
        <h2 className="h2" data-split>Don&apos;t take my word for it, <span className="serif accent">take theirs.</span></h2>
        <a className="rating" href={site.socials.upwork} target="_blank" rel="noopener noreferrer" data-reveal>
          <Stars /> Top Rated Plus on Upwork · 21 reviews ↗
        </a>
        <div className="quotes" style={{ textAlign: "left" }}>
          {testimonials.map((t, i) => (
            <figure className="quote" key={i} data-reveal data-delay={String(i * 0.1)}>
              <Stars />
              <blockquote><p>&ldquo;{t.quote}&rdquo;</p></blockquote>
              <figcaption className="quote__by">
                <span className="quote__av">{t.name[0]}</span>
                <span><b>{t.name}</b><small>{t.role}</small></span>
              </figcaption>
            </figure>
          ))}
        </div>
      </div>
    </section>
  );
}
