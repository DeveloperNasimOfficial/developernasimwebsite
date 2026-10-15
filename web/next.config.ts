import type { NextConfig } from "next";

// Static export: `npm run build` produces /out — upload it to any host
// (cPanel public_html, Netlify, Vercel, Cloudflare Pages). No Node server needed.
const nextConfig: NextConfig = {
  output: "export",
  trailingSlash: true,
  images: { unoptimized: true },
  reactStrictMode: true,
};

export default nextConfig;
