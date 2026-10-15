import { site, statement, stats } from "@/data/site";

export default function About() {
  return (
    <section className="section" id="about">
      <div className="wrap">
        <div className="about__grid">
          <div className="about__side">
            <p className="eyebrow">About</p>
            <figure className="portrait" data-reveal>
              {/* Add your photo: public/nasim.jpg, then replace the <span> with
                  <img src="/nasim.jpg" alt="MD Nasim" /> */}
              <span aria-hidden="true">N</span>
              <figcaption><b>{site.name}</b><span>UTC+6</span></figcaption>
            </figure>
          </div>
          <p className="statement" data-words>{statement}</p>
        </div>
        <div className="stats">
          {stats.map((s, i) => (
            <div className="stat" key={s.label} data-reveal data-delay={String(i * 0.08)}>
              <p className="stat__v">{s.prefix}<span data-count={s.value}>{s.value}</span>{s.suffix}</p>
              <p className="stat__l">{s.label}</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
