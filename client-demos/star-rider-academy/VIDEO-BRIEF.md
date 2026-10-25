# Star Rider Academy: hero video brief

The homepage concept (`index.html`) already animates everything in code: the starfield, colour blobs, flickering laptop screens and floating Microsoft-style buttons. The AI video is the extra layer Sonya asked for ("motion generative creating using AI", like davinci.ai). It goes into the **Learn in motion** frame and can also loop behind the hero.

## Tools (pick one)

| Tool | Best for | Notes |
| --- | --- | --- |
| Google Veo 3 (Gemini / Flow) | Most cinematic, 8s clips with camera moves | Paid Gemini plan |
| Runway Gen-4 | Image-to-video, consistent style across clips | Upload a Figma frame as the start image |
| Kling AI | Long, smooth motion, good value | |
| Luma Dream Machine | Fast tests, looping clips | |

No plugin is needed for the website. Export an MP4 (1920×1080, about 8 to 15 seconds, under 8 MB) and add it as described below.

## Colour and mood (from the brief)

Deep purple, blue and shocking pink lead. Use orange and yellow only as small accents. Keep it bright and balanced, never too dark or loud. The feel is American, high-energy and CES-style.

## Shot list and prompts

**Shot 1: Hero establishing (8s, loopable)**
> Cinematic slow dolly-in on three sleek laptops floating in a deep purple and blue nebula, screens flickering with glowing AI art, code and dashboards, shocking pink light trails orbiting around them, glossy glass app icons floating in the air, a bright shooting star crosses the frame, soft volumetric light, clean modern tech aesthetic, CES keynote style, 4K, seamless loop

**Shot 2: Generative creativity (6s)**
> Macro shot of a laptop screen where an AI prompt is typed and colourful abstract artwork blooms into existence, pink, violet and cyan fluid shapes, particles flowing out of the screen into the room, smooth camera orbit, vibrant but balanced colours, white highlights

**Shot 3: Student journey (6s)**
> Diverse young American students studying online at home with laptops, the screens cast pink and blue light on their faces, holographic Microsoft-style tiles (cloud, data chart, shield) float above the keyboard, optimistic and energetic, shallow depth of field

**Shot 4: Logo end card (4s)**
> A glowing star with a cyan-to-pink swoosh flies across a deep purple space and settles into the centre, light particles burst outward, clean white background reveal at the end

Negative prompt: dark horror mood, clutter, real brand logos, distorted text, low contrast.

Edit the four shots together in CapCut or DaVinci Resolve. Add a short upbeat electronic track and the line "Star Rider Academy: Ride the future".

## Putting the video on the page

1. Save the file next to `index.html` as `star-rider-hero.mp4`.
2. In `index.html`, find the comment inside `#reelFrame` and replace it with:
   ```html
   <video id="reelVideo" src="star-rider-hero.mp4" autoplay muted loop playsinline></video>
   ```
3. The play button will then restart the film with sound.
