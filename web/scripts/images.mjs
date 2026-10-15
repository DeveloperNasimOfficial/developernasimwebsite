// Scans public/work/ for real project screenshots and writes src/data/images.json.
// Name files after the project slug: public/work/<slug>.jpg (or .png / .webp / .avif).
// Extra gallery shots for a case study: <slug>-2.jpg, <slug>-3.jpg …
import { readdirSync, writeFileSync, existsSync } from "node:fs";

const dir = new URL("../public/work/", import.meta.url);
const out = new URL("../src/data/images.json", import.meta.url);
const files = existsSync(dir) ? readdirSync(dir).filter((f) => /\.(jpe?g|png|webp|avif)$/i.test(f)).sort() : [];

const map = {};
for (const file of files) {
  const base = file.replace(/\.[^.]+$/, "");
  const m = base.match(/^(.*?)(?:-(\d+))?$/);
  const slug = m[1];
  (map[slug] ||= []).push({ src: `/work/${file}`, order: m[2] ? Number(m[2]) : 1 });
}
for (const slug of Object.keys(map)) map[slug] = map[slug].sort((a, b) => a.order - b.order).map((x) => x.src);

writeFileSync(out, JSON.stringify(map, null, 2) + "\n");
console.log(`images: ${files.length} file(s) for ${Object.keys(map).length} project(s)`);
