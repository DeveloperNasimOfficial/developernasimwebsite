import { certificates, experience } from "@/data/site";

export default function Experience() {
  return (
    <section className="section xp-section" id="experience" data-nav="dark">
      <div className="wrap">
        <p className="eyebrow" style={{ marginBottom: 24 }}>Experience</p>
        <h2 className="h2" data-split>9 companies. <span className="serif" style={{ color: "var(--brand)" }}>One focus.</span></h2>
        <ul className="xp">
          {experience.map((x, i) => (
            <li className="xp__row" key={x.company} data-reveal>
              <span className="xp__n">{String(i + 1).padStart(2, "0")}</span>
              <span className="xp__c">{x.company}</span>
              <span className="xp__r">{x.role}</span>
              <span aria-hidden="true">↗</span>
            </li>
          ))}
        </ul>
        <ul className="certs" data-reveal>
          {certificates.map((c) => <li key={c}>✦ {c}</li>)}
        </ul>
      </div>
    </section>
  );
}
