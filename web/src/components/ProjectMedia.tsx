import type { ProjectWithImages } from "@/data/projects";

/**
 * Real screenshot when one exists in /public/work, otherwise a clean branded
 * frame with the project name (never a fake/AI image).
 */
export default function ProjectMedia({ project, parallax = true, priority = false }: { project: ProjectWithImages; parallax?: boolean; priority?: boolean }) {
  const src = project.images[0];
  if (src) {
    return (
      // eslint-disable-next-line @next/next/no-img-element
      <img
        src={src}
        alt={`${project.title} website by Nasim`}
        loading={priority ? "eager" : "lazy"}
        decoding="async"
        data-parallax={parallax ? "0.12" : undefined}
      />
    );
  }
  return (
    <div className="pframe" style={{ ["--c" as string]: project.color }}>
      <p className="pframe__name">
        {project.title}
        <small>{project.category}</small>
      </p>
    </div>
  );
}
