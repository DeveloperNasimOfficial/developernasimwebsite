import Hero from "@/components/Hero";
import Marquee from "@/components/Marquee";
import WorkHorizontal from "@/components/WorkHorizontal";
import About from "@/components/About";
import Services from "@/components/Services";
import Process from "@/components/Process";
import Experience from "@/components/Experience";
import Testimonials from "@/components/Testimonials";
import Faq from "@/components/Faq";
import Cta from "@/components/Cta";
import { faq, marquee } from "@/data/site";

export default function Home() {
  return (
    <>
      <Hero />
      <Marquee items={marquee} />
      <WorkHorizontal />
      <About />
      <Services />
      <Process />
      <Experience />
      <Testimonials />
      <Faq items={faq} title={<>Questions, <span className="serif accent">answered.</span></>} />
      <Cta />
    </>
  );
}
