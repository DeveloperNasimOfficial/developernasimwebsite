import type { Metadata } from "next";
import { projects } from "@/data/projects";
import WorkGrid from "./WorkGrid";
import Cta from "@/components/Cta";

export const metadata: Metadata = {
  title: "Work",
  description: `${projects.length} WordPress, Elementor and WooCommerce websites designed and built by Nasim.`,
};

export default function WorkPage() {
  return (
    <>
      <section className="page-hero">
        <div className="wrap">
          <p className="eyebrow" style={{ marginBottom: 28 }}>Work · {projects.length} projects</p>
          <h1 className="display" data-split>Selected <span className="serif accent">work.</span></h1>
          <WorkGrid />
        </div>
      </section>
      <Cta />
    </>
  );
}
