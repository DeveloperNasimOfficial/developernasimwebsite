import Link from "next/link";
import Magnetic from "./Magnetic";

export default function Cta() {
  return (
    <section className="section cta">
      <div className="wrap">
        <p className="eyebrow" style={{ marginBottom: 32 }}>Available for new projects</p>
        <h2 className="cta__title" data-split>Let&apos;s build something that <span className="serif">works.</span></h2>
        <Magnetic strength={0.5}>
          <Link href="/free-website-audit/" className="cta__circle" data-cursor="link"><span>Get a free audit ↗</span></Link>
        </Magnetic>
      </div>
    </section>
  );
}
