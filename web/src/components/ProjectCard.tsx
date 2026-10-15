import Link from "next/link";
import type { ProjectWithImages } from "@/data/projects";
import ProjectMedia from "./ProjectMedia";

export default function ProjectCard({ project, index, reveal = false, parallax = true }: { project: ProjectWithImages; index: number; reveal?: boolean; parallax?: boolean }) {
  return (
    <Link href={`/work/${project.slug}/`} className="pcard" data-cursor="view" data-reveal={reveal ? "" : undefined}>
      <div className="pcard__media">
        <span className="pcard__index">{String(index + 1).padStart(2, "0")}</span>
        <ProjectMedia project={project} parallax={parallax} />
      </div>
      <div className="pcard__meta">
        <h3 className="pcard__title">{project.title}</h3>
        <span className="pcard__cat">{project.category}</span>
      </div>
    </Link>
  );
}
