"use client";

import { useMemo, useRef, useState } from "react";
import { gsap, ScrollTrigger } from "@/lib/gsap";
import { projects } from "@/data/projects";
import ProjectCard from "@/components/ProjectCard";

const FILTERS = ["All", "eCommerce", "Brand site", "Booking", "Education"];

export default function WorkGrid() {
  const [filter, setFilter] = useState("All");
  const grid = useRef<HTMLDivElement>(null);
  const list = useMemo(
    () => (filter === "All" ? projects : projects.filter((p) => `${p.category} ${p.stack.join(" ")}`.toLowerCase().includes(filter.toLowerCase().replace("ecommerce", "commerce")))),
    [filter]
  );

  const choose = (f: string) => {
    if (f === filter) return;
    gsap.to(grid.current, {
      opacity: 0, y: 20, duration: 0.3, ease: "power2.in",
      onComplete: () => {
        setFilter(f);
        requestAnimationFrame(() => {
          gsap.to(grid.current, { opacity: 1, y: 0, duration: 0.8, ease: "expo.out" });
          ScrollTrigger.refresh();
        });
      },
    });
  };

  return (
    <>
      <div className="filters" role="group" aria-label="Filter projects">
        {FILTERS.map((f) => (
          <button key={f} className={f === filter ? "is-active" : ""} onClick={() => choose(f)} aria-pressed={f === filter}>{f}</button>
        ))}
      </div>
      <div className="grid-work" ref={grid} style={{ marginTop: 56 }}>
        {list.map((p, i) => <ProjectCard key={p.slug} project={p} index={i} />)}
      </div>
    </>
  );
}
