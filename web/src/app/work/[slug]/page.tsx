import type { Metadata } from "next";
import Link from "next/link";
import { notFound } from "next/navigation";
import { getProject, projects } from "@/data/projects";
import ProjectMedia from "@/components/ProjectMedia";
import { ArrowUR } from "@/components/Icons";

export const dynamicParams = false;
export const generateStaticParams = () => projects.map((p) => ({ slug: p.slug }));

export async function generateMetadata({ params }: { params: Promise<{ slug: string }> }): Promise<Metadata> {
  const p = getProject((await params).slug);
  return p ? { title: p.title, description: p.summary } : {};
}

export default async function CaseStudy({ params }: { params: Promise<{ slug: string }> }) {
  const { slug } = await params;
  const p = getProject(slug);
  if (!p) notFound();
  const i = projects.indexOf(p);
  const next = projects[(i + 1) % projects.length];
  const meta = [
    ["Category", p.category],
    ["Built with", p.stack.join(", ")],
    ["Client", p.client || "Private client"],
    ["Year", p.year || "—"],
  ];

  return (
    <article>
      <section className="page-hero">
        <div className="wrap">
          <Link href="/work/" className="eyebrow" style={{ marginBottom: 28 }}>Back to all work</Link>
          <h1 className="display" data-split>{p.title}</h1>
          <dl className="case__meta" data-reveal>
            {meta.map(([k, v]) => <div key={k}><dt>{k}</dt><dd>{v}</dd></div>)}
          </dl>
        </div>
      </section>

      <div className="wrap">
        <div className="case__cover" data-reveal>
          <ProjectMedia project={p} priority />
        </div>

        <div className="case__body">
          <div>
            <p className="eyebrow">Overview</p>
          </div>
          <div>
            <p className="statement" style={{ fontSize: "clamp(26px, 3vw, 44px)" }} data-reveal>{p.summary}</p>
            <div style={{ display: "flex", gap: 12, flexWrap: "wrap", marginTop: 40 }} data-reveal>
              {p.url && <a className="btn btn--brand" href={p.url} target="_blank" rel="noopener noreferrer">Visit live site <ArrowUR /></a>}
              <Link className="btn btn--ghost" href="/free-website-audit/">Want results like this? <ArrowUR /></Link>
            </div>
          </div>
        </div>

        {p.images.length > 1 && (
          <div className="case__gallery">
            {p.images.slice(1).map((src) => (
              // eslint-disable-next-line @next/next/no-img-element
              <img key={src} src={src} alt={`${p.title} screenshot`} loading="lazy" data-reveal />
            ))}
          </div>
        )}
      </div>

      <Link href={`/work/${next.slug}/`} className="next-case" data-cursor="view">
        <div className="wrap">
          <small>Next project</small>
          <strong>{next.title} →</strong>
        </div>
      </Link>
    </article>
  );
}
