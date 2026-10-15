import Link from "next/link";
import { site } from "@/data/site";

export default function Footer() {
  const socials = Object.entries(site.socials).filter(([, url]) => url);
  return (
    <footer className="footer">
      <div className="wrap">
        <div className="footer__cols">
          <div>
            <p className="footer__h">Get in touch</p>
            <Link href="/free-website-audit/" className="h3" style={{ display: "inline-block", borderBottom: "1px solid var(--line-2)" }}>Request a free website audit ↗</Link>
            {site.email && <p style={{ marginTop: 16 }}><a href={`mailto:${site.email}`}>{site.email}</a></p>}
          </div>
          <div>
            <p className="footer__h">Pages</p>
            <ul className="footer__list">
              <li><Link href="/">Home</Link></li>
              <li><Link href="/work/">Work</Link></li>
              <li><Link href="/free-website-audit/">Free audit</Link></li>
            </ul>
          </div>
          <div>
            <p className="footer__h">Elsewhere</p>
            <ul className="footer__list">
              {socials.map(([name, url]) => (
                <li key={name}><a href={url} target="_blank" rel="noopener noreferrer" style={{ textTransform: "capitalize" }}>{name} ↗</a></li>
              ))}
            </ul>
          </div>
          <div>
            <p className="footer__h">Based in</p>
            <p>{site.location}<br /><span className="muted">Working worldwide</span></p>
          </div>
        </div>
        <p className="footer__giant" aria-hidden="true">{site.short}<i>.</i></p>
        <div className="footer__bottom">
          <span>© {new Date().getFullYear()} {site.name}. Structure first. Design second. Results always.</span>
          <span>Built with Next.js, Three.js & GSAP</span>
        </div>
      </div>
    </footer>
  );
}
