"""Build an importable Elementor (Flexbox container) template from the QA Group layout concept.

Every heading, paragraph, button, image and spacing value is a native Elementor setting,
so it can be edited in the panel. Text widgets carry Elementor's own Entrance Animation
(fadeInUp with staggered delays); the global CSS block below smooths those keyframes.
"""
import json, random, sys

random.seed(7)
_used = set()
def eid():
    while True:
        v = '%07x' % random.randrange(16**7)
        if v not in _used:
            _used.add(v); return v

UP = 'https://qagroup.us/mystaging01/wp-content/uploads/'
S = 'https://qagroup.us/mystaging01/'

BROWN, BROWN_LIGHT, DEEP, GOLD, CREAM, PAPER, INK, MUTED = '#534132', '#6D5542', '#2B221B', '#B28B4C', '#E9DDD0', '#F7F3EE', '#1C1915', '#6B635B'
DISPLAY, BODY = 'Brandon Grotesque', 'Inter'

def px(v, unit='px'): return {'unit': unit, 'size': v, 'sizes': []}
def box(t, r, b, l, unit='px'):
    return {'unit': unit, 'top': str(t), 'right': str(r), 'bottom': str(b), 'left': str(l), 'isLinked': False}
def gap(v): return {'unit': 'px', 'size': v, 'column': str(v), 'row': str(v), 'isLinked': True}
def link(url): return {'url': url, 'is_external': '', 'nofollow': '', 'custom_attributes': ''}
def img(url): return {'url': url, 'id': '', 'size': '', 'alt': '', 'source': 'library'}

# ---------- element factories ----------
def con(title, children, **st):
    base = {'_title': title, 'content_width': 'full', 'flex_direction': 'column',
            'padding': box(0, 0, 0, 0), 'margin': box(0, 0, 0, 0)}
    base.update(st)
    return {'id': eid(), 'elType': 'container', 'isInner': False, 'settings': base, 'elements': children}

def inner(title, children, **st):
    c = con(title, children, **st); c['isInner'] = True; return c

def anim(st, kind, delay):
    if kind:
        st['_animation'] = kind
        st['_animation_delay'] = delay
    return st

def typo(prefix, family, size, size_t=None, size_m=None, weight='400', lh=None, ls=None, transform=None):
    p = prefix
    d = {p + 'typography_typography': 'custom', p + 'typography_font_family': family,
         p + 'typography_font_size': px(size), p + 'typography_font_weight': weight}
    if size_t: d[p + 'typography_font_size_tablet'] = px(size_t)
    if size_m: d[p + 'typography_font_size_mobile'] = px(size_m)
    if lh: d[p + 'typography_line_height'] = px(lh, 'em')
    if ls is not None: d[p + 'typography_letter_spacing'] = px(ls)
    if transform: d[p + 'typography_text_transform'] = transform
    return d

def heading(text, tag='h2', size=52, size_t=40, size_m=32, color=INK, lh=1.1, a='fadeInUp', delay=0, align=None, family=DISPLAY, weight='400', ls=None, transform=None, title=None, classes=''):
    st = {'title': text, 'header_size': tag, 'title_color': color, '_margin': box(0, 0, 0, 0)}
    st.update(typo('', family, size, size_t, size_m, weight, lh, ls, transform))
    if align: st['align'] = align
    if classes: st['_css_classes'] = classes
    if title: st['_title'] = title
    return {'id': eid(), 'elType': 'widget', 'widgetType': 'heading', 'settings': anim(st, a, delay), 'elements': []}

def text(html, color=MUTED, size=16, size_m=15, lh=1.65, a='fadeInUp', delay=100, title=None, classes='', margin=None):
    st = {'editor': html, 'text_color': color, '_margin': margin or box(0, 0, 0, 0)}
    st.update(typo('', BODY, size, None, size_m, '400', lh))
    if title: st['_title'] = title
    if classes: st['_css_classes'] = classes
    return {'id': eid(), 'elType': 'widget', 'widgetType': 'text-editor', 'settings': anim(st, a, delay), 'elements': []}

def button(label, url, style='light', a='fadeInUp', delay=200):
    colors = {
        'light': dict(button_text_color='#FFFFFF', background_color='rgba(0,0,0,0)', border_color='#FFFFFF',
                      hover_color=INK, button_background_hover_color='#FFFFFF', button_hover_border_color='#FFFFFF'),
        'dark': dict(button_text_color=INK, background_color='rgba(0,0,0,0)', border_color=INK,
                     hover_color='#FFFFFF', button_background_hover_color=INK, button_hover_border_color=INK),
        'solid': dict(button_text_color='#FFFFFF', background_color=BROWN, border_color=BROWN,
                      hover_color='#FFFFFF', button_background_hover_color=DEEP, button_hover_border_color=DEEP),
    }[style]
    st = {'text': label, 'link': link(url), 'size': 'md',
          'selected_icon': {'value': 'fas fa-arrow-right', 'library': 'fa-solid'},
          'icon_align': 'right', 'icon_indent': px(10),
          'border_border': 'solid', 'border_width': box(1, 1, 1, 1), 'border_radius': box(0, 0, 0, 0),
          'text_padding': box(16, 28, 16, 28), 'hover_animation': '', '_margin': box(0, 0, 0, 0)}
    st.update(typo('', BODY, 13, None, 12, '500', 1, 1.6, 'uppercase'))
    st.update(colors)
    return {'id': eid(), 'elType': 'widget', 'widgetType': 'button', 'settings': anim(st, a, delay), 'elements': []}

def image(url, alt_title='', a='fadeIn', delay=0, height=None, classes='', title=None, width=None):
    st = {'image': img(url), 'image_size': 'full', '_margin': box(0, 0, 0, 0)}
    if height:
        st['height'] = px(height); st['object-fit'] = 'cover'
        st['width'] = px(100, '%')
    if width: st['width'] = width
    if classes: st['_css_classes'] = classes
    if title: st['_title'] = title
    return {'id': eid(), 'elType': 'widget', 'widgetType': 'image', 'settings': anim(st, a, delay), 'elements': []}

def html_widget(code, title):
    return {'id': eid(), 'elType': 'widget', 'widgetType': 'html',
            'settings': {'html': code, '_title': title, '_margin': box(0, 0, 0, 0)}, 'elements': []}

SEC_PAD = box(110, 40, 110, 40)
SEC_PAD_T = box(80, 32, 80, 32)
SEC_PAD_M = box(64, 20, 64, 20)
BOXED = dict(content_width='boxed', boxed_width=px(1320))

def section(title, children, **st):
    base = dict(BOXED, padding=SEC_PAD, padding_tablet=SEC_PAD_T, padding_mobile=SEC_PAD_M)
    base.update(st)
    return con(title, children, **base)

# ---------- global CSS / JS (one HTML widget, kept at the top) ----------
GLOBAL = r"""<style>
/* QA Group homepage: smoother Elementor entrance animations */
@keyframes qagFadeUp{from{opacity:0;transform:translate3d(0,40px,0)}to{opacity:1;transform:none}}
@keyframes qagFade{from{opacity:0;transform:scale(1.03)}to{opacity:1;transform:none}}
.elementor-element.animated.fadeInUp{animation-name:qagFadeUp;animation-duration:1.1s;animation-timing-function:cubic-bezier(.22,1,.36,1)}
.elementor-element.animated.fadeIn{animation-name:qagFade;animation-duration:1.4s;animation-timing-function:cubic-bezier(.22,1,.36,1)}
@media (prefers-reduced-motion:reduce){.elementor-element.animated{animation:none!important}}

/* hero: content sits bottom-left over the slideshow */
.qag-hero .elementor-background-slideshow::after{content:"";position:absolute;inset:0;z-index:1;background:linear-gradient(180deg,rgba(0,0,0,.45) 0%,rgba(0,0,0,0) 28%,rgba(0,0,0,0) 45%,rgba(0,0,0,.7) 100%),linear-gradient(90deg,rgba(0,0,0,.35) 0%,rgba(0,0,0,0) 60%)}

/* client logos: grayscale until hover */
.qag-client img{filter:grayscale(1);opacity:.7;transition:filter .4s,opacity .4s}
.qag-client img:hover{filter:none;opacity:1}

/* intro: photo on the left follows the open accordion item */
.qag-intro-media{position:relative;min-height:460px}
.qag-intro-media>.elementor-widget-image{position:absolute!important;inset:0;width:100%!important;opacity:0;transition:opacity .8s cubic-bezier(.22,1,.36,1)}
.qag-intro-media>.elementor-widget-image.is-active{opacity:1}
.qag-intro-media>.elementor-widget-image img{width:100%;height:100%!important;object-fit:cover}
.qag-intro-media>.elementor-widget-image .elementor-widget-container{height:100%}
body.elementor-editor-active .qag-intro-media>.elementor-widget-image{position:relative!important;opacity:1;height:200px;margin-bottom:10px}
@media (max-width:767px){.qag-intro-media{min-height:260px}}
.qag-intro-acc .e-n-accordion-item{border-bottom:1px solid rgba(28,25,21,.12)}
.qag-intro-acc .e-n-accordion-item:first-child{border-top:1px solid rgba(28,25,21,.12)}
.qag-intro-acc{counter-reset:qi}
.qag-intro-acc .e-n-accordion-item-title-text::before{counter-increment:qi;content:counter(qi,decimal-leading-zero);display:inline-block;width:44px;font:500 12px/1 Inter,sans-serif;letter-spacing:.12em;color:#b28b4c;vertical-align:middle}
.qag-intro-acc a{color:#534132;border-bottom:1px solid #b28b4c}

/* industry tiles: zoom the photo, keep the label on top */
.qag-tile{position:relative;overflow:hidden;isolation:isolate}
.qag-tile::after{content:"";position:absolute;inset:0;z-index:0;background:linear-gradient(180deg,rgba(0,0,0,0) 35%,rgba(0,0,0,.72) 100%);transition:background .5s}
.qag-tile:hover::after{background:linear-gradient(180deg,rgba(83,65,50,.15) 0%,rgba(43,34,27,.85) 100%)}
.qag-tile>.elementor-element{position:relative;z-index:1}
.qag-tile{transition:background-size .9s cubic-bezier(.22,1,.36,1)}
.qag-tile:hover{background-size:112%!important}

/* why-choose: thin rules between the three points */
.qag-feat{border-top:1px solid rgba(28,25,21,.12)}
@media (min-width:1025px){.qag-feat+.qag-feat{border-left:1px solid rgba(28,25,21,.12)}}

/* project list: numbered two-column list */
.qag-work-list .elementor-icon-list-items{column-count:2;column-gap:40px;counter-reset:w}
@media (max-width:767px){.qag-work-list .elementor-icon-list-items{column-count:1}}
.qag-work-list .elementor-icon-list-item{break-inside:avoid;counter-increment:w;padding:15px 10px!important;border-bottom:1px solid rgba(255,255,255,.12);transition:background .35s,padding .35s}
.qag-work-list .elementor-icon-list-item::before{content:counter(w,decimal-leading-zero);font:500 11px/1 Inter,sans-serif;letter-spacing:.1em;color:#b28b4c;width:34px;flex:none;align-self:center}
.qag-work-list .elementor-icon-list-item:hover{background:rgba(178,139,76,.08);padding-left:16px!important}
.qag-work-list .elementor-icon-list-icon{display:none}
.qag-work-illo img{filter:invert(1) brightness(1.6) sepia(.25);mix-blend-mode:screen;opacity:.9}
</style>
<script>
document.addEventListener('DOMContentLoaded',function(){
  var media=document.querySelectorAll('.qag-intro-media>.elementor-widget-image');
  var acc=document.querySelector('.qag-intro-acc');
  if(!media.length||!acc)return;
  function sync(){
    var items=acc.querySelectorAll('details.e-n-accordion-item'),open=0;
    items.forEach(function(d,i){if(d.open)open=i});
    media.forEach(function(m,i){m.classList.toggle('is-active',i===open)});
  }
  acc.addEventListener('toggle',function(){setTimeout(sync,20)},true);
  acc.addEventListener('click',function(){setTimeout(sync,60)});
  sync();
});
</script>"""

content = []
content.append(con('QAG Global Styles (CSS + JS)', [html_widget(GLOBAL, 'QAG Global CSS & JS')], content_width='full'))

# ---------- 1. HERO ----------
hero_text = inner('Hero Text', [
    heading('Could custom furniture be designed to meet society’s changing standards?', 'h1', 68, 52, 36, '#FFFFFF', 1.04, 'fadeInUp', 200),
    text('<p>Architectural upholstery has the power to unite and inspire. Can we measure comfort and quality per square foot?</p>',
         'rgba(255,255,255,0.9)', 18, 15, 1.6, 'fadeInUp', 400, margin=box(22, 0, 30, 0)),
    button('View Our Portfolio', S + 'services/portfolio/', 'light', 'fadeInUp', 600),
], width=px(720), width_mobile=px(100, '%'), z_index=2)
content.append(con('1. Hero', [hero_text],
    content_width='boxed', boxed_width=px(1480), css_classes='qag-hero',
    min_height=px(100, 'vh'), min_height_mobile=px(88, 'vh'),
    flex_direction='column', flex_justify_content='flex-end', flex_align_items='flex-start',
    padding=box(140, 40, 80, 40), padding_tablet=box(120, 32, 64, 32), padding_mobile=box(110, 20, 48, 20),
    background_background='slideshow',
    background_slideshow_gallery=[{'id': '', 'url': UP + '2024/05/homepage-slideshow-1-min.webp'},
                                  {'id': '', 'url': UP + '2024/05/homepage-slideshow-4-min.webp'},
                                  {'id': '', 'url': UP + '2024/05/homepage-slideshow-3-min.webp'}],
    background_slideshow_loop='yes', background_slideshow_slide_duration=5000,
    background_slideshow_slide_transition='fade', background_slideshow_transition_duration=1200,
    background_slideshow_background_size='cover', background_slideshow_background_position='center center',
    background_slideshow_ken_burns='yes', background_slideshow_ken_burns_zoom_direction='in',
    background_color=DEEP))

# ---------- 2. CLIENTS ----------
logos = []
for i, n in enumerate(['Apple', 'Alaska', 'ACA', 'Amazon', 'Starbucks']):
    logos.append(image('', a='fadeIn', delay=100 * i, classes='qag-client', title='Client Logo – ' + n,
                       width=px(140)))
    logos[-1]['settings']['image_size'] = 'full'
content.append(con('2. Our Valued Clients', [
    heading('Our Valued Clients', 'h2', 12, 12, 12, MUTED, 1.4, 'fadeIn', 0, family=BODY, weight='500', ls=2.2, transform='uppercase'),
    inner('Client Logos', logos, flex_direction='row', flex_wrap='wrap', flex_align_items='center',
          flex_justify_content='space-between', flex_gap=gap(40), width=px(100, '%'), flex_grow=1),
], content_width='boxed', boxed_width=px(1480), flex_direction='row', flex_direction_mobile='column',
   flex_align_items='center', flex_align_items_mobile='flex-start', flex_gap=gap(48),
   padding=box(26, 40, 26, 40), padding_mobile=box(24, 20, 24, 20),
   border_border='solid', border_width=box(0, 0, 1, 0), border_color='rgba(28,25,21,0.12)'))

# ---------- 3. INTRO ----------
intro_items = [
    ('90 Years of Craftsmanship and Trust',
     '<p>QA Group is a nationally trusted commercial furniture manufacturer and upholstery company headquartered in Washington State. With 90 years of experience, we proudly serve upholstery and furniture solutions to restaurants, hospitality groups, and commercial spaces across the United States. What sets us apart is simple – craftsmanship that lasts, precision you can rely on, and service that makes complex projects easier to manage.</p>'),
    ('Simplifying Projects, Bringing Visions to Life',
     '<p>We believe that every project begins with partnership. Whether you’re designing a new space or refreshing an existing one, our role is to simplify the process and bring your vision to life through customizable furniture and upholstery solutions. From <a href="' + S + 'services/">made-to-order seating to custom upholstery</a>, we offer solutions that protect your investment and keep every space looking its best.</p>'),
    ('Complete Solutions, Built to Last',
     '<p>With engineered drawings, accurate quotes, and a wide range of finishes and upholstery selections, we make it easy to bring your furniture project together. Our custom furniture capabilities include booths, banquettes, lounge seating, and other furniture built to meet each project’s specifications. And with our warranties and unwavering support, you can count on QA Group to deliver quality, durability, and peace of mind every time.</p>'),
]
acc_items, acc_children = [], []
for t, body in intro_items:
    acc_items.append({'item_title': t, '_id': eid(), 'element_css_id': ''})
    acc_children.append(inner('Item: ' + t, [text(body, MUTED, 15.5, 15, 1.65, None)],
                              padding=box(0, 0, 26, 0)))
accordion = {'id': eid(), 'elType': 'widget', 'widgetType': 'nested-accordion', 'settings': {
    '_title': 'Intro Accordion', '_css_classes': 'qag-intro-acc', 'items': acc_items,
    'default_state': 'expanded', 'max_items_expended': 'one', 'n_accordion_animation_duration': px(500, 'ms'),
    'accordion_item_title_icon': {'value': 'fas fa-plus', 'library': 'fa-solid'},
    'accordion_item_title_icon_active': {'value': 'fas fa-minus', 'library': 'fa-solid'},
    'accordion_item_title_position_horizontal': 'stretch', 'accordion_item_title_icon_position': 'end',
    'accordion_item_title_space_between': px(0), 'accordion_item_title_distance_from_content': px(0),
    'accordion_background_normal_background': 'classic', 'accordion_background_normal_color': 'rgba(0,0,0,0)',
    'accordion_border_normal_border': 'none',
    'accordion_padding': box(24, 0, 24, 0),
    'title_typography_typography': 'custom', 'title_typography_font_family': DISPLAY,
    'title_typography_font_size': px(26), 'title_typography_font_size_tablet': px(22), 'title_typography_font_size_mobile': px(20),
    'title_typography_font_weight': '400',
    'normal_title_color': INK, 'hover_title_color': BROWN, 'active_title_color': INK,
    'icon_size': px(14), 'icon_color': INK, 'icon_active_color': GOLD,
    'content_background_background': 'classic', 'content_background_color': 'rgba(0,0,0,0)',
    'content_border_border': 'none', 'content_padding': box(0, 0, 0, 0),
    '_animation': 'fadeInUp', '_animation_delay': 150,
}, 'elements': acc_children}
content.append(section('3. Intro', [
    heading('Your one-stop commercial furniture manufacturer and upholstery partner.', 'h2', 52, 40, 30, INK, 1.12, 'fadeInUp', 0),
    inner('Intro Columns', [
        inner('Intro Photos (follow the open item)', [
            image(UP + '2024/06/who-we-serve-2.webp', title='Photo 1 – 90 Years', a='fadeIn', delay=100),
            image(UP + '2024/06/our-work-min-1024x683.webp', title='Photo 2 – Simplifying Projects', a=None),
            image(UP + '2025/09/1758647308724-1024x768.jpg', title='Photo 3 – Complete Solutions', a=None),
        ], css_classes='qag-intro-media', width=px(52, '%'), width_mobile=px(100, '%'), background_background='classic', background_color='#D9D6D2'),
        inner('Intro Accordion Column', [accordion], width=px(48, '%'), width_mobile=px(100, '%')),
    ], flex_direction='row', flex_direction_mobile='column', flex_gap=gap(72), flex_align_items='stretch',
       width=px(100, '%'), margin=box(56, 0, 0, 0), margin_mobile=box(36, 0, 0, 0)),
]))

# ---------- 4. VIDEO ----------
video = {'id': eid(), 'elType': 'widget', 'widgetType': 'video', 'settings': {
    '_title': 'QA Group Video', 'video_type': 'youtube', 'youtube_url': 'https://youtu.be/spQsJei93c4',
    'aspect_ratio': '219', 'aspect_ratio_mobile': '169', 'yt_privacy': 'yes', 'rel': '', 'controls': 'yes',
    'show_image_overlay': 'yes', 'image_overlay': img('https://img.youtube.com/vi/spQsJei93c4/maxresdefault.jpg'),
    'show_play_icon': 'yes', 'play_icon_color': '#FFFFFF', 'play_icon_size': px(72),
    'lazy_load': 'yes', '_animation': 'fadeIn', '_animation_delay': 0}, 'elements': []}
content.append(section('4. Video', [video], padding=box(0, 40, 110, 40), padding_tablet=box(0, 32, 80, 32), padding_mobile=box(0, 20, 64, 20)))

# ---------- 5. WHO WE SERVE ----------
tiles_data = [
    ('Millwork Shops', 'industries/millwork-casework/', '2024/06/who-we-serve-1.webp'),
    ('Foodservice Dealers', 'industries/foodservice-dealers/', '2024/06/DanielsBroiler-009-min.webp'),
    ('Architects & Designers', 'industries/architects-designers/', '2024/06/who-we-serve-1-scaled.webp'),
    ('Restaurants', 'industries/restaurant-chains/', '2024/10/DanielsBroiler-003.webp'),
    ('Property Developers', 'industries/property-developers/', '2024/06/who-we-serve-3-scaled.webp'),
    ('Hospitality', 'industries/hospitality/', '2024/06/47-DSC05619-min-scaled.webp'),
    ('Corporate', 'industries/corporate/', '2024/06/IMG_7122-edited-min-scaled.webp'),
    ('Aviation', 'industries/aviation/', '2026/05/deltaden_centrallounge3-scaled.jpg'),
]
tiles = []
for i, (name, path, im) in enumerate(tiles_data):
    t = inner('Tile – ' + name, [heading(name, 'h3', 24, 21, 17, '#FFFFFF', 1.2, 'fadeInUp', 150 + 80 * (i % 4))],
              html_tag='a', link=link(S + path), css_classes='qag-tile',
              min_height=px(300), min_height_tablet=px(260), min_height_mobile=px(190),
              flex_justify_content='flex-end', padding=box(22, 22, 20, 22), padding_mobile=box(14, 14, 14, 14),
              background_background='classic', background_image=img(UP + im),
              background_position='center center', background_size='cover', background_repeat='no-repeat',
              background_color='#D9D6D2')
    t['settings'].update({'animation': 'fadeIn', 'animation_delay': 80 * (i % 4)})
    tiles.append(t)
content.append(section('5. Who We Serve', [
    inner('Who We Serve – Header', [
        heading('Who We Serve', 'h2', 54, 42, 32, INK, 1.1, 'fadeInUp', 0),
        text('<p>QA Group partners with commercial operators, project teams, and trade professionals across the United States. From independent restaurants to national chains, corporate offices to airport lounges, we deliver seating and upholstery solutions built to your spec, on your schedule, and backed by 90 years of U.S. manufacturing.</p>',
             MUTED, 16, 15, 1.65, 'fadeInUp', 150, classes=''),
    ], flex_direction='row', flex_direction_tablet='column', flex_align_items='flex-end', flex_align_items_tablet='flex-start',
       flex_justify_content='space-between', flex_gap=gap(80), flex_gap_tablet=gap(20), width=px(100, '%'),
       margin=box(0, 0, 52, 0), margin_mobile=box(0, 0, 32, 0)),
    inner('Industry Tiles', tiles, container_type='grid',
          grid_columns_grid=px(4, 'fr'), grid_columns_grid_tablet=px(2, 'fr'), grid_columns_grid_mobile=px(2, 'fr'),
          grid_rows_grid=px(2, 'fr'), grid_rows_grid_tablet=px(4, 'fr'), grid_rows_grid_mobile=px(4, 'fr'),
          grid_gaps={'unit': 'px', 'column': '12', 'row': '12', 'isLinked': True},
          grid_gaps_mobile={'unit': 'px', 'column': '8', 'row': '8', 'isLinked': True}, width=px(100, '%')),
], background_background='classic', background_color=PAPER))
# header text: keep the paragraph to ~60ch
content[-1]['elements'][0]['elements'][1]['settings']['_element_width'] = 'initial'
content[-1]['elements'][0]['elements'][1]['settings']['_element_custom_width'] = px(56, '%')
content[-1]['elements'][0]['elements'][1]['settings']['_element_custom_width_tablet'] = px(100, '%')

# ---------- 6. WHY CHOOSE ----------
def feat(num, title, body_html, d):
    return inner('Point ' + num + ' – ' + title, [
        heading(num, 'div', 12, 12, 12, GOLD, 1, 'fadeInUp', d, family=BODY, weight='500', ls=1.4),
        heading(title, 'h3', 26, 22, 21, INK, 1.2, 'fadeInUp', d + 100),
        text(body_html, MUTED, 15, 15, 1.65, 'fadeInUp', d + 200),
    ], css_classes='qag-feat', flex_gap=gap(14), padding=box(32, 32, 8, 32), padding_mobile=box(28, 0, 20, 0))

content.append(section('6. Why Choose QA Group', [
    inner('Why – Top', [
        inner('Why – Copy', [
            heading('Why Choose QA Group?', 'div', 12, 12, 12, GOLD, 1, 'fadeInUp', 0, family=BODY, weight='500', ls=2.2, transform='uppercase'),
            heading('Leave it to the upholstery specialists.', 'h2', 54, 42, 32, INK, 1.1, 'fadeInUp', 100),
            text('<p>QA Group is uniquely positioned to help you complete your next project on time, on budget, and on design – done correctly the first time.</p>',
                 INK, 20, 17, 1.55, 'fadeInUp', 200),
            text('<p>Our team and facilities can handle any job scope, from one piece to dozens. We operate specialized departments staffed by experts in frame building, woodworking, sewing, upholstery, wood staining and finishing, as well as product assembly and installation.</p>'
                 '<p>We are problem solvers; clients trust and rely on us to turn their ideas into beautiful yet functional realities. Additionally, our reputation as the pinnacle of quality has made us a top choice for leading design firms and architects. Serving clients nationwide, we offer unparalleled custom upholstery of the highest caliber.</p>'
                 '<p>Clients of QA Group can rely on unmatched attention to detail throughout our extensive range of custom upholstery services. And because our commercial-grade furniture is manufactured right here in the USA, we make sure the job is perfect in every detail from beginning to end.</p>',
                 MUTED, 15.5, 15, 1.65, 'fadeInUp', 300),
        ], width=px(50, '%'), width_mobile=px(100, '%'), flex_gap=gap(20)),
        inner('Why – Photo', [image(UP + '2023/01/qagroup-imagebooth-1024x605.webp', a='fadeIn', delay=200)],
              width=px(50, '%'), width_mobile=px(100, '%')),
    ], flex_direction='row', flex_direction_mobile='column', flex_gap=gap(80), flex_gap_mobile=gap(36), width=px(100, '%')),
    inner('Why – Three Points', [
        feat('01', 'Reliable Turnaround Times',
             '<p><strong>Standard lead time is 6 to 10 weeks</strong>, depending on project size. This timeline begins once we have final drawing approvals or all required materials – whichever is later.</p><p>Production begins only after we’ve received the deposit (if required), confirmed all materials, and obtained customer approval on dimensions and engineering.</p>', 0),
        feat('02', 'Premium Quality Craftsmanship',
             '<p>Attention to detail is ingrained in our ethos. Furthermore, we leave no stone unturned in our commitment to quality upholstery services. Every project undergoes meticulous inspection to prevent any inaccuracies before construction.</p>', 120),
        feat('03', 'Exceptional Customer Service',
             '<p>Your satisfaction is our priority. With a dedicated quality control team and a commitment to transparent, honest practices, we stand behind our work. Make us your trusted partner; our adaptable, flexible solutions are here to support your goals.</p>', 240),
    ], container_type='grid', grid_columns_grid=px(3, 'fr'), grid_columns_grid_tablet=px(1, 'fr'), grid_columns_grid_mobile=px(1, 'fr'),
       grid_rows_grid=px(1, 'fr'), grid_rows_grid_tablet=px(3, 'fr'), grid_rows_grid_mobile=px(3, 'fr'),
       grid_gaps={'unit': 'px', 'column': '0', 'row': '0', 'isLinked': True},
       width=px(100, '%'), margin=box(64, 0, 0, 0), margin_mobile=box(40, 0, 0, 0)),
]))
# first point: no left padding on desktop so it lines up with the copy above
content[-1]['elements'][1]['elements'][0]['settings']['padding'] = box(32, 32, 8, 0)

# ---------- 7. SEEN OUR WORK ----------
projects = ['Academy Museum of Motion Pictures', 'Alaska Airlines Lounges', 'Amazon Headquarters',
            'Bill and Melinda Gates Foundation', 'Brooks Running Headquarters', 'Climate Pledge Arena',
            'Columbia Center', 'Facebook Headquarters', 'Federal Reserve', 'Golden State Warriors',
            'Google Headquarters', 'Microsoft Headquarters', 'Nordstrom Marketplace', 'Publicis Sapient',
            'Space Needle', 'Starbucks Headquarters', 'Texas A&M', 'Top Golf', 'University of California',
            'University of Washington']
work_list = {'id': eid(), 'elType': 'widget', 'widgetType': 'icon-list', 'settings': {
    '_title': 'Project List (20)', '_css_classes': 'qag-work-list', 'view': 'traditional',
    'icon_list': [{'text': p, 'selected_icon': {'value': '', 'library': ''}, '_id': eid()} for p in projects],
    'space_between': px(0), 'text_color': '#FFFFFF', 'text_indent': px(0),
    'icon_typography_typography': 'custom', 'icon_typography_font_family': DISPLAY,
    'icon_typography_font_size': px(20), 'icon_typography_font_size_tablet': px(18), 'icon_typography_font_size_mobile': px(17),
    'icon_typography_font_weight': '400', 'icon_typography_line_height': px(1.3, 'em'),
    '_animation': 'fadeInUp', '_animation_delay': 200}, 'elements': []}
content.append(section('7. Chances Are, You\'ve Seen Our Work', [
    inner('Work – Intro', [
        heading("Chances are, you've seen our work.", 'h2', 54, 42, 32, '#FFFFFF', 1.1, 'fadeInUp', 0),
        text('<p>We have spent nearly a century building our quality reputation in the Pacific Northwest and across the country.</p>',
             'rgba(255,255,255,0.72)', 16, 15, 1.65, 'fadeInUp', 150),
        image(UP + '2025/05/Brand-Guide-Illustation-Drawing-Icon-Sketches-08-1-1024x512.png', a='fadeIn', delay=300,
              classes='qag-work-illo', width=px(340)),
    ], width=px(33, '%'), width_mobile=px(100, '%'), flex_gap=gap(24)),
    inner('Work – List', [work_list], width=px(67, '%'), width_mobile=px(100, '%')),
], flex_direction='row', flex_direction_mobile='column', flex_gap=gap(96), flex_gap_mobile=gap(40),
   background_background='classic', background_color=DEEP))

# ---------- 8. CTA ----------
def cta_panel(title, h, p, label, url, bg, color, style, pad, d):
    return inner(title, [
        heading(h, 'h2', 42, 34, 28, color, 1.15, 'fadeInUp', d),
        text('<p>' + p + '</p>', color, 16, 15, 1.6, 'fadeInUp', d + 100, margin=box(0, 0, 14, 0)),
        button(label, url, style, 'fadeInUp', d + 200),
    ], width=px(50, '%'), width_mobile=px(100, '%'), flex_gap=gap(14), flex_align_items='flex-start',
       padding=pad, padding_tablet=box(72, 32, 72, 32), padding_mobile=box(56, 20, 56, 20),
       background_background='classic', background_color=bg)
content.append(con('8. CTA', [
    cta_panel('CTA – Estimate', 'Ready to kick off a project?', 'Begin your estimate here.', 'Get An Estimate',
              S + 'contact/estimate/', BROWN, '#FFFFFF', 'light', box(104, 56, 104, 80), 0),
    cta_panel('CTA – Contact', 'We love meeting new people.', 'If you would like to work with us, get started here.', 'Contact Us',
              S + 'contact/', CREAM, INK, 'dark', box(104, 80, 104, 56), 150),
], flex_direction='row', flex_direction_mobile='column', flex_gap=gap(0)))

template = {
    'title': 'QA Group – Homepage (Layout Concept R1)',
    'type': 'page',
    'version': '0.4',
    'page_settings': {'hide_title': 'yes', 'template': 'elementor_header_footer'},
    'content': content,
}
out = sys.argv[1]
with open(out, 'w', encoding='utf-8') as f:
    json.dump(template, f, ensure_ascii=False, indent=1)

def count(els):
    n = 0
    for e in els: n += 1 + count(e['elements'])
    return n
print('elements:', count(content), 'ids unique:', len(_used))
