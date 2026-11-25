// Splash screen: hide once the page (incl. above-the-fold images) has loaded
document.documentElement.classList.add('js');
document.body && document.body.classList.add('loading');
(function () {
  const start = Date.now();
  const hide = () => {
    const s = document.getElementById('splash'); if (!s || s.classList.contains('hide')) return;
    setTimeout(() => { s.classList.add('hide'); document.body.classList.remove('loading'); setTimeout(() => s.remove(), 700); }, Math.max(0, 700 - (Date.now() - start)));
  };
  if (document.readyState === 'complete') hide(); else window.addEventListener('load', hide);
  setTimeout(hide, 4000); // never block longer than 4s
})();

// Lazy-load background images ([data-bg]) with a logo loader until each photo is ready
function makeLoader() {
  const d = document.createElement('div'); d.className = 'img-loader'; d.setAttribute('aria-hidden', 'true');
  d.innerHTML = '<div class="ring"><img src="assets/img/logo-white.png" alt=""></div>'; return d;
}
function doneLoader(el) { const l = el.querySelector(':scope > .img-loader'); if (l) { l.classList.add('done'); setTimeout(() => l.remove(), 650); } }
function lazyBackgrounds() {
  const apply = (el) => {
    const url = el.dataset.bg; const img = new Image();
    img.onload = img.onerror = () => {
      if (el.dataset.bgVar) el.style.setProperty('--img', "url('" + url + "')");
      else el.style.backgroundImage = "url('" + url + "')";
      el.classList.add('bg-loaded'); doneLoader(el);
    };
    img.src = url;
  };
  const els = document.querySelectorAll('[data-bg]');
  els.forEach(el => el.prepend(makeLoader()));
  // hero: photo lives in CSS ::before
  const hero = document.querySelector('.hero');
  if (hero) {
    hero.prepend(makeLoader());
    const m = getComputedStyle(hero, '::before').backgroundImage.match(/url\("?([^")]+)"?\)/);
    const hi = new Image(); hi.onload = hi.onerror = () => doneLoader(hero); hi.src = m ? m[1] : '';
  }
  if (!('IntersectionObserver' in window)) return els.forEach(apply);
  const io = new IntersectionObserver((es) => es.forEach(e => { if (e.isIntersecting) { io.unobserve(e.target); apply(e.target); } }), { rootMargin: '300px 0px' });
  els.forEach(el => io.observe(el));
}

document.addEventListener('DOMContentLoaded', () => {
  lazyBackgrounds();
  // Select2 searchable country pickers
  if (window.jQuery && jQuery.fn.select2) {
    jQuery('.js-select2').each(function () {
      jQuery(this).select2({ width: '100%', placeholder: this.dataset.placeholder, allowClear: false, dropdownCssClass: 'tv-s2-drop' });
    });
  }
  // Budget range sliders
  document.querySelectorAll('.budget-range').forEach(r => {
    const out = r.closest('.hs-range').querySelector('.budget-out');
    const upd = () => {
      const v = +r.value; out.textContent = v >= 5000 ? 'Any budget' : 'Up to 
  // Scroll reveal with stagger for siblings
  const io = new IntersectionObserver((entries) => entries.forEach(e => {
    if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }
  }), { threshold: 0.12 });
  const counts = new Map();
  document.querySelectorAll('.reveal').forEach(el => {
    const n = counts.get(el.parentElement) || 0; counts.set(el.parentElement, n + 1);
    el.style.transitionDelay = (n % 3) * 120 + 'ms';
    io.observe(el);
  });
  // Nav shadow on scroll
  const nav = document.querySelector('.tv-nav');
  const onScroll = () => nav && nav.classList.toggle('scrolled', window.scrollY > 10);
  window.addEventListener('scroll', onScroll, { passive: true }); onScroll();

  // Pre-select the package when a "Book now" button opens the modal
  const modal = document.getElementById('bookingModal');
  if (modal) {
    modal.addEventListener('show.bs.modal', (ev) => {
      const btn = ev.relatedTarget;
      const select = modal.querySelector('select[name="package_id"]');
      const title = modal.querySelector('#bookingTitle');
      const id = btn?.dataset.packageId || '';
      if (select) select.value = id;
      title.textContent = btn?.dataset.packageTitle || 'Plan your trip';
      const form = modal.querySelector('form');
      form.classList.remove('was-validated');
      form.querySelector('.form-alert').innerHTML = '';
    });
  }

  // No past dates
  const today = new Date().toISOString().split('T')[0];
  document.querySelectorAll('input[name="travel_date"]').forEach(i => i.min = today);

  // AJAX submit for every booking form
  document.querySelectorAll('.booking-form').forEach(form => {
    form.addEventListener('submit', async (ev) => {
      ev.preventDefault();
      const alertBox = form.querySelector('.form-alert');
      if (!form.checkValidity()) { form.classList.add('was-validated'); return; }
      const btn = form.querySelector('button[type="submit"]');
      btn.disabled = true; btn.querySelector('.spinner-border').classList.remove('d-none');
      try {
        const res = await fetch(form.action, { method: 'POST', body: new FormData(form) });
        const data = await res.json();
        if (data.ok) { showSuccess(form, data.reference); return; }
        alertBox.innerHTML = '<div class="alert alert-danger mb-0"></div>';
        alertBox.firstChild.textContent = data.message;
      } catch (e) {
        alertBox.innerHTML = '<div class="alert alert-danger mb-0">Connection error. Please try again.</div>';
      } finally {
        btn.disabled = false; btn.querySelector('.spinner-border').classList.add('d-none');
      }
    });
  });
});

// Replace the form with a confirmation panel
function showSuccess(form, ref) {
  const wa = (document.querySelector('.wa-float') || {}).href || '#';
  const panel = document.createElement('div');
  panel.className = 'booking-success';
  panel.innerHTML = `
    <div class="bs-icon"><span><i class="bi bi-check-lg"></i></span></div>
    <h3>Request received</h3>
    <p>Thank you. Our team will contact you within 24 hours to confirm availability and your final quote.</p>
    <div class="bs-ref"><small>Booking reference</small><strong></strong></div>
    <div class="bs-steps">
      <div><b>01</b><strong>We review</strong><span>Availability and prices for your dates</span></div>
      <div><b>02</b><strong>We contact you</strong><span>By email or WhatsApp within 24 hours</span></div>
      <div><b>03</b><strong>You confirm</strong><span>No payment until you approve the quote</span></div>
    </div>
    <div class="bs-actions">
      <a class="btn btn-wa" target="_blank"><i class="bi bi-whatsapp"></i> Chat on WhatsApp</a>
      <button type="button" class="btn btn-tv bs-close">Continue browsing</button>
    </div>`;
  panel.querySelector('.bs-ref strong').textContent = ref;
  panel.querySelector('.btn-wa').href = wa + (wa.includes('?') ? '&' : '?') + 'text=' + encodeURIComponent('Hello, my booking reference is ' + ref);
  form.style.display = 'none';
  form.after(panel);
  const reset = () => { panel.remove(); form.reset(); form.classList.remove('was-validated'); form.style.display = ''; form.querySelector('.form-alert').innerHTML = ''; };
  const modalEl = form.closest('.modal');
  panel.querySelector('.bs-close').addEventListener('click', () => {
    if (modalEl) bootstrap.Modal.getInstance(modalEl)?.hide(); else reset();
  });
  if (modalEl) modalEl.addEventListener('hidden.bs.modal', reset, { once: true });
}
 + v.toLocaleString('en-US');
      r.style.setProperty('--pct', ((v - r.min) / (r.max - r.min) * 100) + '%');
    };
    r.addEventListener('input', upd); upd();
  });
  // Scroll reveal with stagger for siblings
  const io = new IntersectionObserver((entries) => entries.forEach(e => {
    if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }
  }), { threshold: 0.12 });
  const counts = new Map();
  document.querySelectorAll('.reveal').forEach(el => {
    const n = counts.get(el.parentElement) || 0; counts.set(el.parentElement, n + 1);
    el.style.transitionDelay = (n % 3) * 120 + 'ms';
    io.observe(el);
  });
  // Nav shadow on scroll
  const nav = document.querySelector('.tv-nav');
  const onScroll = () => nav && nav.classList.toggle('scrolled', window.scrollY > 10);
  window.addEventListener('scroll', onScroll, { passive: true }); onScroll();

  // Pre-select the package when a "Book now" button opens the modal
  const modal = document.getElementById('bookingModal');
  if (modal) {
    modal.addEventListener('show.bs.modal', (ev) => {
      const btn = ev.relatedTarget;
      const select = modal.querySelector('select[name="package_id"]');
      const title = modal.querySelector('#bookingTitle');
      const id = btn?.dataset.packageId || '';
      if (select) select.value = id;
      title.textContent = btn?.dataset.packageTitle || 'Plan your trip';
      const form = modal.querySelector('form');
      form.classList.remove('was-validated');
      form.querySelector('.form-alert').innerHTML = '';
    });
  }

  // No past dates
  const today = new Date().toISOString().split('T')[0];
  document.querySelectorAll('input[name="travel_date"]').forEach(i => i.min = today);

  // AJAX submit for every booking form
  document.querySelectorAll('.booking-form').forEach(form => {
    form.addEventListener('submit', async (ev) => {
      ev.preventDefault();
      const alertBox = form.querySelector('.form-alert');
      if (!form.checkValidity()) { form.classList.add('was-validated'); return; }
      const btn = form.querySelector('button[type="submit"]');
      btn.disabled = true; btn.querySelector('.spinner-border').classList.remove('d-none');
      try {
        const res = await fetch(form.action, { method: 'POST', body: new FormData(form) });
        const data = await res.json();
        if (data.ok) { showSuccess(form, data.reference); return; }
        alertBox.innerHTML = '<div class="alert alert-danger mb-0"></div>';
        alertBox.firstChild.textContent = data.message;
      } catch (e) {
        alertBox.innerHTML = '<div class="alert alert-danger mb-0">Connection error. Please try again.</div>';
      } finally {
        btn.disabled = false; btn.querySelector('.spinner-border').classList.add('d-none');
      }
    });
  });
});

// Replace the form with a confirmation panel
function showSuccess(form, ref) {
  const wa = (document.querySelector('.wa-float') || {}).href || '#';
  const panel = document.createElement('div');
  panel.className = 'booking-success';
  panel.innerHTML = `
    <div class="bs-icon"><span><i class="bi bi-check-lg"></i></span></div>
    <h3>Request received</h3>
    <p>Thank you. Our team will contact you within 24 hours to confirm availability and your final quote.</p>
    <div class="bs-ref"><small>Booking reference</small><strong></strong></div>
    <div class="bs-steps">
      <div><b>01</b><strong>We review</strong><span>Availability and prices for your dates</span></div>
      <div><b>02</b><strong>We contact you</strong><span>By email or WhatsApp within 24 hours</span></div>
      <div><b>03</b><strong>You confirm</strong><span>No payment until you approve the quote</span></div>
    </div>
    <div class="bs-actions">
      <a class="btn btn-wa" target="_blank"><i class="bi bi-whatsapp"></i> Chat on WhatsApp</a>
      <button type="button" class="btn btn-tv bs-close">Continue browsing</button>
    </div>`;
  panel.querySelector('.bs-ref strong').textContent = ref;
  panel.querySelector('.btn-wa').href = wa + (wa.includes('?') ? '&' : '?') + 'text=' + encodeURIComponent('Hello, my booking reference is ' + ref);
  form.style.display = 'none';
  form.after(panel);
  const reset = () => { panel.remove(); form.reset(); form.classList.remove('was-validated'); form.style.display = ''; form.querySelector('.form-alert').innerHTML = ''; };
  const modalEl = form.closest('.modal');
  panel.querySelector('.bs-close').addEventListener('click', () => {
    if (modalEl) bootstrap.Modal.getInstance(modalEl)?.hide(); else reset();
  });
  if (modalEl) modalEl.addEventListener('hidden.bs.modal', reset, { once: true });
}

// Testimonials slider: arrows, dots, auto-scroll (pauses on hover/touch)
document.addEventListener('DOMContentLoaded', () => {
  const slider = document.querySelector('.t-slider'); if (!slider) return;
  const track = slider.querySelector('.t-track'), dotsBox = slider.querySelector('.t-dots');
  const info = () => { const step = track.children[0].getBoundingClientRect().width + 24; const visible = Math.max(1, Math.round((track.clientWidth + 24) / step)); return { step, max: Math.max(0, track.children.length - visible) }; };
  const cur = () => Math.round(track.scrollLeft / info().step);
  const go = (n) => { const i = info(); track.scrollTo({ left: Math.max(0, Math.min(n, i.max)) * i.step, behavior: 'smooth' }); };
  const step = (d) => { const i = info(); let n = cur() + d; if (n > i.max) n = 0; if (n < 0) n = i.max; go(n); };
  const renderDots = () => {
    const i = info(); dotsBox.innerHTML = '';
    for (let k = 0; k <= i.max; k++) { const b = document.createElement('button'); b.type = 'button'; b.setAttribute('aria-label', 'Go to review ' + (k + 1)); b.onclick = () => go(k); dotsBox.appendChild(b); }
    markDot();
  };
  const markDot = () => { const c = cur(); [...dotsBox.children].forEach((b, k) => b.classList.toggle('active', k === c)); };
  let t; track.addEventListener('scroll', () => { clearTimeout(t); t = setTimeout(markDot, 80); }, { passive: true });
  document.querySelector('.t-prev')?.addEventListener('click', () => step(-1));
  document.querySelector('.t-next')?.addEventListener('click', () => step(1));
  let paused = false;
  ['mouseenter', 'touchstart', 'focusin'].forEach(ev => slider.addEventListener(ev, () => paused = true, { passive: true }));
  ['mouseleave', 'touchend', 'focusout'].forEach(ev => slider.addEventListener(ev, () => paused = false, { passive: true }));
  setInterval(() => { if (!paused && !document.hidden) step(1); }, 4500);
  window.addEventListener('resize', renderDots); renderDots();
});

// Newsletter (AJAX)
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.newsletter-form').forEach(form => {
    form.addEventListener('submit', async (ev) => {
      ev.preventDefault();
      const msg = form.querySelector('.sub-msg'), input = form.querySelector('input[type=email]'), btn = form.querySelector('button');
      if (!input.checkValidity() || !input.value.trim()) { msg.textContent = 'Please enter a valid email address.'; msg.classList.add('err'); return; }
      btn.disabled = true; btn.querySelector('.spinner-border').classList.remove('d-none');
      try {
        const res = await fetch(form.action, { method: 'POST', body: new FormData(form), headers: { 'X-Requested-With': 'fetch' } });
        const data = await res.json();
        if (data.ok) {
          form.outerHTML = '<div class="sub-done"><span><i class="bi bi-check-lg"></i></span><div><strong>You\'re subscribed!</strong> The next offers will arrive in your inbox.</div></div>';
          return;
        }
        msg.textContent = data.message; msg.classList.add('err');
      } catch (e) { msg.textContent = 'Connection error. Please try again.'; msg.classList.add('err'); }
      btn.disabled = false; btn.querySelector('.spinner-border').classList.add('d-none');
    });
  });
});

// Package itinerary popup
document.addEventListener('DOMContentLoaded', () => {
  const el = document.getElementById('detailsModal'); if (!el) return;
  const modal = new bootstrap.Modal(el), box = el.querySelector('.modal-content'), loading = box.innerHTML;
  document.addEventListener('click', async (ev) => {
    const a = ev.target.closest('[data-details]'); if (!a) return;
    ev.preventDefault();
    box.innerHTML = loading; modal.show();
    try {
      const res = await fetch('package-details.php?slug=' + encodeURIComponent(a.dataset.details));
      box.innerHTML = await res.text();
    } catch (e) { box.innerHTML = '<div class="p-5 text-center">Could not load this package. <a href="' + a.href + '">Open the full page</a>.</div>'; }
  });
  box.addEventListener('click', (ev) => {
    const head = ev.target.closest('.pd-day-head'); if (head) head.parentElement.classList.toggle('open');
    const book = ev.target.closest('.pd-book');
    if (book) {
      el.addEventListener('hidden.bs.modal', () => {
        const bm = document.getElementById('bookingModal');
        bootstrap.Modal.getOrCreateInstance(bm).show(book);
      }, { once: true });
      modal.hide();
    }
  });
});
