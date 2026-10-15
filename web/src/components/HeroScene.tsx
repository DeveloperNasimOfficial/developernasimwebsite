"use client";

import { useEffect, useRef, useState } from "react";
import * as THREE from "three";
import { ScrollTrigger } from "@/lib/gsap";

// Ashima 3D simplex noise (MIT).
const noise = /* glsl */ `
vec3 mod289(vec3 x){return x-floor(x*(1.0/289.0))*289.0;}
vec4 mod289(vec4 x){return x-floor(x*(1.0/289.0))*289.0;}
vec4 permute(vec4 x){return mod289(((x*34.0)+1.0)*x);}
vec4 taylorInvSqrt(vec4 r){return 1.79284291400159-0.85373472095314*r;}
float snoise(vec3 v){
  const vec2 C=vec2(1.0/6.0,1.0/3.0);const vec4 D=vec4(0.0,0.5,1.0,2.0);
  vec3 i=floor(v+dot(v,C.yyy));vec3 x0=v-i+dot(i,C.xxx);
  vec3 g=step(x0.yzx,x0.xyz);vec3 l=1.0-g;vec3 i1=min(g.xyz,l.zxy);vec3 i2=max(g.xyz,l.zxy);
  vec3 x1=x0-i1+C.xxx;vec3 x2=x0-i2+C.yyy;vec3 x3=x0-D.yyy;
  i=mod289(i);
  vec4 p=permute(permute(permute(i.z+vec4(0.0,i1.z,i2.z,1.0))+i.y+vec4(0.0,i1.y,i2.y,1.0))+i.x+vec4(0.0,i1.x,i2.x,1.0));
  float n_=0.142857142857;vec3 ns=n_*D.wyz-D.xzx;
  vec4 j=p-49.0*floor(p*ns.z*ns.z);vec4 x_=floor(j*ns.z);vec4 y_=floor(j-7.0*x_);
  vec4 x=x_*ns.x+ns.yyyy;vec4 y=y_*ns.x+ns.yyyy;vec4 h=1.0-abs(x)-abs(y);
  vec4 b0=vec4(x.xy,y.xy);vec4 b1=vec4(x.zw,y.zw);
  vec4 s0=floor(b0)*2.0+1.0;vec4 s1=floor(b1)*2.0+1.0;vec4 sh=-step(h,vec4(0.0));
  vec4 a0=b0.xzyw+s0.xzyw*sh.xxyy;vec4 a1=b1.xzyw+s1.xzyw*sh.zzww;
  vec3 p0=vec3(a0.xy,h.x);vec3 p1=vec3(a0.zw,h.y);vec3 p2=vec3(a1.xy,h.z);vec3 p3=vec3(a1.zw,h.w);
  vec4 norm=taylorInvSqrt(vec4(dot(p0,p0),dot(p1,p1),dot(p2,p2),dot(p3,p3)));
  p0*=norm.x;p1*=norm.y;p2*=norm.z;p3*=norm.w;
  vec4 m=max(0.6-vec4(dot(x0,x0),dot(x1,x1),dot(x2,x2),dot(x3,x3)),0.0);m=m*m;
  return 42.0*dot(m*m,vec4(dot(p0,x0),dot(p1,x1),dot(p2,x2),dot(p3,x3)));
}`;

const blobVertex = /* glsl */ `
uniform float uTime; uniform float uScroll; uniform vec2 uMouse;
varying vec3 vNormal; varying vec3 vView; varying float vNoise;
${noise}
float field(vec3 p){
  float t=uTime*0.22;
  float n=snoise(p*1.05+vec3(t,t*0.7,-t))*0.55;
  n+=snoise(p*2.4-vec3(t*1.3))*0.16;
  return n;
}
void main(){
  vec3 p=position;
  float amp=0.42+uScroll*0.5+length(uMouse)*0.12;
  float n=field(normalize(p));
  vNoise=n;
  vec3 displaced=p+normal*n*amp;
  // Recompute normal via neighbours for nice lighting.
  vec3 up=abs(normal.y)>0.99?vec3(1.0,0.0,0.0):vec3(0.0,1.0,0.0);
  vec3 tangent=normalize(cross(normal,up));
  vec3 bitangent=normalize(cross(normal,tangent));
  float e=0.01;
  vec3 pA=p+tangent*e; vec3 pB=p+bitangent*e;
  vec3 dA=pA+normal*field(normalize(pA))*amp;
  vec3 dB=pB+normal*field(normalize(pB))*amp;
  vec3 nrm=normalize(cross(dA-displaced,dB-displaced));
  vNormal=normalize(normalMatrix*nrm);
  vec4 mv=modelViewMatrix*vec4(displaced,1.0);
  vView=normalize(-mv.xyz);
  gl_Position=projectionMatrix*mv;
}`;

const blobFragment = /* glsl */ `
uniform vec3 uColorA; uniform vec3 uColorB; uniform vec3 uColorC; uniform float uTime;
varying vec3 vNormal; varying vec3 vView; varying float vNoise;
void main(){
  vec3 n=normalize(vNormal);
  float fres=pow(1.0-max(dot(n,vView),0.0),2.2);
  vec3 light=normalize(vec3(-0.4,0.8,0.6));
  float diff=max(dot(n,light),0.0);
  float spec=pow(max(dot(reflect(-light,n),vView),0.0),32.0);
  // Iridescent band driven by noise + view angle.
  float band=0.5+0.5*sin(vNoise*6.0+fres*5.0+uTime*0.4);
  vec3 base=mix(uColorA,uColorB,band);
  vec3 col=base*(0.18+diff*0.75);
  col+=uColorC*fres*1.15;
  col+=vec3(1.0)*spec*0.55;
  gl_FragColor=vec4(col,1.0);
}`;

const pointsVertex = /* glsl */ `
uniform float uTime; uniform float uPixel;
attribute float aScale;
varying float vAlpha;
void main(){
  vec3 p=position;
  p.y+=sin(uTime*0.3+position.x*0.8)*0.12;
  p.x+=cos(uTime*0.25+position.z)*0.1;
  vec4 mv=modelViewMatrix*vec4(p,1.0);
  gl_Position=projectionMatrix*mv;
  gl_PointSize=aScale*uPixel*(14.0/-mv.z);
  vAlpha=smoothstep(14.0,2.0,-mv.z);
}`;

const pointsFragment = /* glsl */ `
uniform vec3 uColor; varying float vAlpha;
void main(){
  float d=length(gl_PointCoord-0.5);
  float a=smoothstep(0.5,0.0,d);
  gl_FragColor=vec4(uColor,a*vAlpha*0.55);
}`;

function hasWebGL() {
  try {
    const c = document.createElement("canvas");
    return !!(c.getContext("webgl2") || c.getContext("webgl"));
  } catch {
    return false;
  }
}

export default function HeroScene() {
  const mount = useRef<HTMLDivElement>(null);
  const [fallback, setFallback] = useState(false);

  useEffect(() => {
    const el = mount.current!;
    if (!hasWebGL()) {
      setFallback(true);
      return;
    }
    const reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    const isSmall = window.innerWidth < 768;

    const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, powerPreference: "high-performance" });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, isSmall ? 1.5 : 1.75));
    renderer.setSize(el.clientWidth, el.clientHeight);
    el.appendChild(renderer.domElement);

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(35, el.clientWidth / el.clientHeight, 0.1, 100);
    camera.position.set(0, 0, 8);

    const brand = new THREE.Color("#3b5bff");
    const blobMat = new THREE.ShaderMaterial({
      vertexShader: blobVertex,
      fragmentShader: blobFragment,
      uniforms: {
        uTime: { value: 0 },
        uScroll: { value: 0 },
        uMouse: { value: new THREE.Vector2() },
        uColorA: { value: new THREE.Color("#0b1240") },
        uColorB: { value: brand },
        uColorC: { value: new THREE.Color("#9fb0ff") },
      },
    });
    const blob = new THREE.Mesh(new THREE.IcosahedronGeometry(1.55, isSmall ? 48 : 96), blobMat);
    const group = new THREE.Group();
    group.add(blob);
    scene.add(group);

    // Particles
    const count = isSmall ? 500 : 1400;
    const pos = new Float32Array(count * 3);
    const scale = new Float32Array(count);
    for (let i = 0; i < count; i++) {
      const r = 3 + Math.random() * 7;
      const th = Math.random() * Math.PI * 2;
      const ph = Math.acos(2 * Math.random() - 1);
      pos[i * 3] = r * Math.sin(ph) * Math.cos(th);
      pos[i * 3 + 1] = r * Math.sin(ph) * Math.sin(th) * 0.6;
      pos[i * 3 + 2] = r * Math.cos(ph) - 2;
      scale[i] = 0.4 + Math.random() * 1.2;
    }
    const pGeo = new THREE.BufferGeometry();
    pGeo.setAttribute("position", new THREE.BufferAttribute(pos, 3));
    pGeo.setAttribute("aScale", new THREE.BufferAttribute(scale, 1));
    const pMat = new THREE.ShaderMaterial({
      vertexShader: pointsVertex,
      fragmentShader: pointsFragment,
      transparent: true,
      depthWrite: false,
      uniforms: { uTime: { value: 0 }, uPixel: { value: renderer.getPixelRatio() }, uColor: { value: new THREE.Color("#3b5bff") } },
    });
    const points = new THREE.Points(pGeo, pMat);
    scene.add(points);

    const place = () => {
      const w = el.clientWidth;
      // Sit to the right on wide screens, centred behind the type on mobile.
      group.position.x = w > 900 ? 2.15 : 0;
      group.position.y = w > 900 ? 0.45 : 1.1;
      const s = w > 900 ? 0.82 : 0.72;
      group.scale.setScalar(s);
    };
    place();

    const mouse = new THREE.Vector2();
    const target = new THREE.Vector2();
    const onMove = (e: PointerEvent) => {
      target.set((e.clientX / window.innerWidth) * 2 - 1, -(e.clientY / window.innerHeight) * 2 + 1);
    };
    window.addEventListener("pointermove", onMove, { passive: true });

    const st = ScrollTrigger.create({
      trigger: el,
      start: "top top",
      end: "bottom top",
      onUpdate: (self) => { blobMat.uniforms.uScroll.value = self.progress; },
    });

    let visible = true;
    const io = new IntersectionObserver(([entry]) => { visible = entry.isIntersecting; }, { threshold: 0 });
    io.observe(el);

    const onResize = () => {
      camera.aspect = el.clientWidth / el.clientHeight;
      camera.updateProjectionMatrix();
      renderer.setSize(el.clientWidth, el.clientHeight);
      place();
    };
    window.addEventListener("resize", onResize);

    const start = performance.now();
    let raf = 0;
    const loop = () => {
      raf = requestAnimationFrame(loop);
      if (!visible) return;
      const t = reduce ? 0 : (performance.now() - start) / 1000;
      mouse.lerp(target, 0.05);
      blobMat.uniforms.uTime.value = t;
      blobMat.uniforms.uMouse.value.copy(mouse);
      pMat.uniforms.uTime.value = t;
      const sp = blobMat.uniforms.uScroll.value as number;
      group.rotation.y = t * 0.08 + mouse.x * 0.45 + sp * 1.6;
      group.rotation.x = -mouse.y * 0.3 + sp * 0.4;
      group.position.z = -sp * 2.5;
      points.rotation.y = t * 0.02 + mouse.x * 0.08;
      points.rotation.x = mouse.y * 0.05;
      renderer.render(scene, camera);
    };
    loop();

    return () => {
      cancelAnimationFrame(raf);
      window.removeEventListener("pointermove", onMove);
      window.removeEventListener("resize", onResize);
      io.disconnect();
      st.kill();
      blob.geometry.dispose();
      blobMat.dispose();
      pGeo.dispose();
      pMat.dispose();
      renderer.dispose();
      renderer.domElement.remove();
    };
  }, []);

  return (
    <div ref={mount} className="hero__canvas" aria-hidden="true">
      {fallback && <div className="hero__fallback" />}
    </div>
  );
}
