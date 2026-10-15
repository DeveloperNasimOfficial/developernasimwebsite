import Link from "next/link";

export default function NotFound() {
  return (
    <section className="page-hero" style={{ minHeight: "80svh", display: "grid", placeItems: "center", textAlign: "center" }}>
      <div className="wrap">
        <p className="display" style={{ color: "var(--brand)" }}>404</p>
        <h1 className="h2" style={{ marginTop: 24 }}>This page took a <span className="serif accent">wrong turn.</span></h1>
        <Link href="/" className="btn btn--brand" style={{ marginTop: 40 }}>Back home ↗</Link>
      </div>
    </section>
  );
}
