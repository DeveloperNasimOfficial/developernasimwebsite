/**
 * Developer Nasim — interactions.
 * No dependencies. Respects prefers-reduced-motion.
 */
(function () {
	'use strict';

	var root = document.documentElement;
	var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var finePointer = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

	/* Theme toggle --------------------------------------------------- */
	var toggle = document.querySelector('[data-theme-toggle]');
	if (toggle) {
		toggle.addEventListener('click', function () {
			var current = root.getAttribute('data-theme') ||
				(window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
			var next = current === 'dark' ? 'light' : 'dark';
			root.setAttribute('data-theme', next);
			try { localStorage.setItem('dn-theme', next); } catch (e) {}
		});
	}

	/* Header: hide on scroll down, show on scroll up ---------------- */
	var header = document.querySelector('[data-header]');
	var lastY = window.scrollY;
	var ticking = false;
	function onScroll() {
		var y = window.scrollY;
		if (header) {
			header.classList.toggle('is-hidden', y > lastY && y > 300 && !document.body.classList.contains('menu-open'));
		}
		lastY = y;
		highlightStatement();
		ticking = false;
	}
	window.addEventListener('scroll', function () {
		if (!ticking) {
			requestAnimationFrame(onScroll);
			ticking = true;
		}
	}, { passive: true });

	/* Mobile menu ---------------------------------------------------- */
	var burger = document.querySelector('[data-menu-toggle]');
	var menu = document.getElementById('mobile-menu');
	function setMenu(open) {
		burger.setAttribute('aria-expanded', String(open));
		document.body.classList.toggle('menu-open', open);
		document.body.style.overflow = open ? 'hidden' : '';
		if (open) {
			menu.hidden = false;
			requestAnimationFrame(function () { menu.classList.add('is-open'); });
		} else {
			menu.classList.remove('is-open');
			setTimeout(function () { if (!menu.classList.contains('is-open')) { menu.hidden = true; } }, 800);
		}
	}
	if (burger && menu) {
		burger.addEventListener('click', function () {
			setMenu(burger.getAttribute('aria-expanded') !== 'true');
		});
		menu.addEventListener('click', function (e) {
			if (e.target.closest('a')) { setMenu(false); }
		});
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && burger.getAttribute('aria-expanded') === 'true') { setMenu(false); }
		});
	}

	/* Reveal on scroll ---------------------------------------------- */
	var revealEls = document.querySelectorAll('[data-reveal], [data-split]');
	if ('IntersectionObserver' in window && !reduce) {
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('is-in');
					io.unobserve(entry.target);
				}
			});
		}, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });
		revealEls.forEach(function (el) { io.observe(el); });
	} else {
		revealEls.forEach(function (el) { el.classList.add('is-in'); });
	}

	/* Scroll-linked word highlight ---------------------------------- */
	var statement = document.querySelector('[data-highlight]');
	var words = statement ? statement.querySelectorAll('span') : [];
	function highlightStatement() {
		if (!statement || reduce) { return; }
		var rect = statement.getBoundingClientRect();
		var vh = window.innerHeight;
		var progress = (vh * 0.85 - rect.top) / (rect.height + vh * 0.35);
		progress = Math.max(0, Math.min(1, progress));
		var lit = Math.round(progress * words.length);
		for (var i = 0; i < words.length; i++) {
			words[i].classList.toggle('is-lit', i < lit);
		}
	}
	highlightStatement();

	/* Count-up numbers ---------------------------------------------- */
	var counters = document.querySelectorAll('[data-count]');
	if ('IntersectionObserver' in window && !reduce) {
		var cio = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (!entry.isIntersecting) { return; }
				var el = entry.target;
				var target = parseFloat(el.getAttribute('data-count')) || 0;
				var decimals = (String(target).split('.')[1] || '').length;
				var start = null;
				var duration = 1600;
				function step(ts) {
					if (!start) { start = ts; }
					var t = Math.min(1, (ts - start) / duration);
					var eased = 1 - Math.pow(1 - t, 4);
					el.textContent = (target * eased).toFixed(decimals);
					if (t < 1) { requestAnimationFrame(step); }
				}
				el.textContent = '0';
				requestAnimationFrame(step);
				cio.unobserve(el);
			});
		}, { threshold: 0.6 });
		counters.forEach(function (el) { cio.observe(el); });
	}

	/* Local time clock ---------------------------------------------- */
	var clocks = document.querySelectorAll('[data-clock]');
	var tz = (window.DN && window.DN.timezone) || 'Asia/Dhaka';
	function tick() {
		var text;
		try {
			text = new Intl.DateTimeFormat('en-US', { hour: 'numeric', minute: '2-digit', timeZone: tz }).format(new Date());
		} catch (e) {
			text = new Date().toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
		}
		clocks.forEach(function (c) { c.textContent = text; });
	}
	if (clocks.length) { tick(); setInterval(tick, 30000); }

	/* Pointer-only effects ------------------------------------------ */
	if (!finePointer || reduce) { return; }

	// Spotlight that follows the pointer on cards.
	document.querySelectorAll('[data-spotlight]').forEach(function (el) {
		el.addEventListener('pointermove', function (e) {
			var r = el.getBoundingClientRect();
			el.style.setProperty('--mx', (e.clientX - r.left) + 'px');
			el.style.setProperty('--my', (e.clientY - r.top) + 'px');
		});
	});

	// Magnetic buttons.
	document.querySelectorAll('[data-magnetic]').forEach(function (el) {
		el.addEventListener('pointermove', function (e) {
			var r = el.getBoundingClientRect();
			var x = (e.clientX - r.left - r.width / 2) * 0.25;
			var y = (e.clientY - r.top - r.height / 2) * 0.35;
			el.style.transform = 'translate(' + x + 'px,' + y + 'px)';
		});
		el.addEventListener('pointerleave', function () { el.style.transform = ''; });
	});

	// Subtle 3D tilt.
	document.querySelectorAll('[data-tilt]').forEach(function (el) {
		el.addEventListener('pointermove', function (e) {
			var r = el.getBoundingClientRect();
			var px = (e.clientX - r.left) / r.width - 0.5;
			var py = (e.clientY - r.top) / r.height - 0.5;
			el.style.transform = 'perspective(900px) rotateY(' + (px * 8) + 'deg) rotateX(' + (-py * 8) + 'deg)';
		});
		el.addEventListener('pointerleave', function () { el.style.transform = ''; });
	});

	// Custom cursor.
	var cursor = document.querySelector('.cursor');
	if (cursor) {
		var mx = 0, my = 0, cx = 0, cy = 0;
		window.addEventListener('pointermove', function (e) {
			mx = e.clientX; my = e.clientY;
			cursor.classList.add('is-visible');
			var view = e.target.closest('[data-cursor="view"]');
			var link = e.target.closest('a, button, summary');
			cursor.classList.toggle('is-view', !!view);
			cursor.classList.toggle('is-link', !view && !!link);
		}, { passive: true });
		document.addEventListener('pointerleave', function () { cursor.classList.remove('is-visible'); });
		(function loop() {
			cx += (mx - cx) * 0.2;
			cy += (my - cy) * 0.2;
			cursor.style.transform = 'translate3d(' + cx + 'px,' + cy + 'px,0)';
			requestAnimationFrame(loop);
		})();
	}
})();
