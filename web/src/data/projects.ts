// Real projects from Nasim's Upwork portfolio.
//
// IMAGES: drop the real screenshot into /public/work/<slug>.jpg (or .png/.webp).
// Extra case-study shots: <slug>-2.jpg, <slug>-3.jpg … They are picked up
// automatically on the next `npm run dev` / `npm run build`.
// Until a screenshot exists, the card shows a clean branded frame instead.
//
// Edit `summary`, add `url` (live site) and `client` whenever you like.

import images from "./images.json";

export type Project = {
  slug: string;
  title: string; // short display name
  full: string; // original portfolio title
  category: string;
  stack: string[];
  summary: string;
  color: string; // accent used for the frame/hover before a screenshot exists
  featured?: boolean;
  url?: string;
  client?: string;
  year?: string;
};

const raw: Project[] = [
  { slug: "skincare-business", title: "Skincare Business", full: "WordPress Developer for Skincare Business Website | Elementor Pro", category: "Beauty · Brand site", stack: ["WordPress", "Elementor Pro"], summary: "A clean, trust-building brand website for a skincare business, built in Elementor Pro so the team can update it themselves.", color: "#E9C9B5", featured: true },
  { slug: "automotive-business", title: "Automotive Business", full: "WordPress Developer for Automotive Business Website | Elementor Pro", category: "Automotive · Lead generation", stack: ["WordPress", "Elementor Pro"], summary: "A bold, conversion-focused website for an automotive business that puts services and enquiries front and centre.", color: "#C8102E", featured: true },
  { slug: "photography-portfolio", title: "Photography Portfolio", full: "WordPress Website Design | Photography Portfolio & Booking Website", category: "Photography · Booking", stack: ["WordPress", "Booking"], summary: "An image-first portfolio with a booking flow, designed to let the photography do the selling.", color: "#2B2B2B", featured: true },
  { slug: "bakery-business", title: "Bakery Business", full: "WordPress Developer for Bakery Business Website Design | Elementor Pro", category: "Food · Local business", stack: ["WordPress", "Elementor Pro"], summary: "A warm, appetising website for a bakery that makes menus, ordering and visiting easy.", color: "#D9A066", featured: true },
  { slug: "fashion-ecommerce", title: "Fashion eCommerce", full: "Fashion E-commerce Website Developer | WordPress + Elementor", category: "Fashion · eCommerce", stack: ["WordPress", "Elementor", "WooCommerce"], summary: "An editorial fashion storefront with product pages and a checkout built to convert.", color: "#111111", featured: true },
  { slug: "digital-studio", title: "Digital Studio", full: "WordPress Digital Studio Website Design | Modern & Creative Agency", category: "Agency · Brand site", stack: ["WordPress", "Elementor"], summary: "A modern, creative agency website with motion, case studies and a clear path to contact.", color: "#5B5BF7", featured: true },
  { slug: "skincare-ecommerce", title: "Skin Care Store", full: "Skin Care E-commerce Website | WordPress + Elementor + WooCommerce", category: "Beauty · eCommerce", stack: ["WordPress", "Elementor", "WooCommerce"], summary: "A WooCommerce skincare store with rich product pages and a smooth path to checkout.", color: "#F2D7D0" },
  { slug: "premium-coffee", title: "Premium Coffee Brand", full: "Premium Coffee Brand Website Design | WordPress + Elementor", category: "Food & drink · Brand", stack: ["WordPress", "Elementor"], summary: "A premium, story-led coffee brand website with rich imagery and product highlights.", color: "#6F4E37" },
  { slug: "plant-gardening", title: "Plant & Gardening", full: "Plant & Gardening Website | WordPress + Elementor Design", category: "Lifestyle · Brand site", stack: ["WordPress", "Elementor"], summary: "A fresh, natural website for a plant and gardening brand.", color: "#3E7C4F" },
  { slug: "lms-platform", title: "LMS Platform", full: "LMS Website | WordPress + Elementor + Online Course Platform", category: "Education · Online courses", stack: ["WordPress", "Elementor", "LMS"], summary: "An online course platform with course catalogues, lessons and student accounts.", color: "#2F6BFF" },
  { slug: "premium-cap-brand", title: "Premium Cap Brand", full: "Premium Cap Brand Website | One-Page Design with Snap Scroll", category: "Fashion · One-page", stack: ["WordPress", "Snap scroll"], summary: "A one-page product experience with full-screen snap scrolling for a premium cap brand.", color: "#1D1D1F" },
  { slug: "electronics-ecommerce", title: "Electronics Store", full: "Electronics E-commerce Website | WordPress + Elementor + WooCommerce", category: "Electronics · eCommerce", stack: ["WordPress", "Elementor", "WooCommerce"], summary: "A WooCommerce electronics store with filtering, specs and a fast checkout.", color: "#0A84FF" },
  { slug: "electronics-product", title: "Electronics Product", full: "Electronics Product Website | WordPress + Elementor + E-commerce", category: "Electronics · Product site", stack: ["WordPress", "Elementor"], summary: "A focused product website that showcases features and drives purchases.", color: "#00C2A8" },
  { slug: "tshirt-wholesale", title: "T-Shirt Wholesale", full: "T-Shirt Wholesale E-commerce Website | WordPress + WooCommerce", category: "Apparel · B2B eCommerce", stack: ["WordPress", "WooCommerce"], summary: "A wholesale WooCommerce store built for bulk ordering.", color: "#E4572E" },
  { slug: "coffee-maker", title: "Coffee Maker Store", full: "Coffee Maker E-commerce Website | WordPress + Elementor + WooCommerce", category: "Home · eCommerce", stack: ["WordPress", "Elementor", "WooCommerce"], summary: "An eCommerce store for coffee makers with product storytelling and comparison.", color: "#8C5A3C" },
  { slug: "custom-web-development", title: "Custom Web Development", full: "Custom Web Development | WordPress + Elementor + Responsive Design", category: "Custom build", stack: ["WordPress", "Elementor", "Responsive"], summary: "A custom, fully responsive WordPress build tailored to the client's workflow.", color: "#7A5AF8" },
  { slug: "ecommerce-web-development", title: "eCommerce Development", full: "WordPress Developer | Website Designer | E-commerce Web Development", category: "eCommerce", stack: ["WordPress", "WooCommerce"], summary: "End-to-end WordPress eCommerce design and development.", color: "#FF8A00" },
];

const imageMap = images as Record<string, string[]>;

export const projects = raw.map((p) => ({ ...p, images: imageMap[p.slug] ?? [] }));
export type ProjectWithImages = (typeof projects)[number];
export const featured = projects.filter((p) => p.featured);
export const getProject = (slug: string) => projects.find((p) => p.slug === slug);
