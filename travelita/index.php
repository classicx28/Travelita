<?php
require_once 'includes/functions.php';
$pageTitle = 'Travelita — Tour Packages & Travel Agency';
try { $featured = get_packages(['featured' => 1], 6); $allPk = get_packages(); $countries = get_countries(); }
catch (Throwable $ex) { $featured = []; $allPk = []; $countries = []; }
include 'includes/header.php';
?>
<section class="hero">
  <div class="container hero-inner">
    <div class="eyebrow light">Tours · Cruises · Honeymoons</div>
    <h1>Discover the world, <span class="hl">beautifully planned.</span></h1>
    <p class="lead">Handpicked journeys with flights, hotels and expert guides included. You pack your bags, we take care of everything else.</p>
    <form class="hero-search" action="packages.php" method="get">
      <div class="hs-field"><label><i class="bi bi-geo-alt"></i> Destination</label>
        <select name="country" class="js-select2" data-placeholder="All countries"><option value="">All countries</option><?php foreach ($countries as $c): ?><option value="<?= e($c) ?>"><?= e($c) ?></option><?php endforeach; ?></select></div>
      <div class="hs-field"><label><i class="bi bi-airplane"></i> Trip type</label>
        <select name="category"><option value="">Any</option><option value="international">International</option><option value="cruise">Cruise</option><option value="honeymoon">Honeymoon</option><option value="group">Group tour</option></select></div>
      <div class="hs-field hs-range"><label class="d-flex justify-content-between"><span><i class="bi bi-wallet2"></i> Budget</span><output class="budget-out">Any budget</output></label>
        <input type="range" class="budget-range" name="max" min="500" max="5000" step="100" value="5000" aria-label="Maximum budget per person">
        <div class="range-ends"><span>$500</span><span>$5,000+</span></div></div>
      <button class="btn btn-tv btn-lg"><i class="bi bi-search"></i> Search</button>
    </form>
  </div>
</section>

<section class="strip">
  <div class="container">
    <div class="strip-card">
      <div class="strip-item reveal"><span class="strip-ic"><i class="bi bi-shield-check"></i></span><div><strong>Secure booking</strong><span>Confirmed by our team</span></div></div>
      <div class="strip-item reveal"><span class="strip-ic"><i class="bi bi-airplane"></i></span><div><strong>Flights included</strong><span>On most packages</span></div></div>
      <div class="strip-item reveal"><span class="strip-ic"><i class="bi bi-headset"></i></span><div><strong>24/7 support</strong><span>Before and during travel</span></div></div>
      <div class="strip-item reveal"><span class="strip-ic"><i class="bi bi-credit-card"></i></span><div><strong>Flexible payment</strong><span>Pay in instalments</span></div></div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-head reveal">
      <div><div class="eyebrow eyebrow-ic"><span><i class="bi bi-suitcase2"></i></span>Featured packages</div><h2>Popular trips this season</h2></div>
      <a href="packages.php" class="link-arrow">View all packages <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="row g-4">
      <?php foreach ($featured as $p) include 'includes/package-card.php'; ?>
      <?php if (!$featured): ?><p class="text-muted">Import <code>database.sql</code> to see packages.</p><?php endif; ?>
    </div>
  </div>
</section>

<section class="section bg-tint">
  <div class="container">
    <div class="section-head reveal"><div><div class="eyebrow eyebrow-ic"><span><i class="bi bi-geo-alt"></i></span>Destinations</div><h2>Where we travel</h2></div></div>
    <div class="dest-grid">
      <a href="packages.php?q=France" class="dest dest-lg reveal" data-bg="https://images.unsplash.com/photo-1530122037265-a5f1f91d3b99?auto=format&fit=crop&w=1200&q=70"><span>Europe<small>Alps, cities &amp; rail journeys</small></span></a>
      <a href="packages.php?q=Maldives" class="dest reveal" data-bg="https://images.unsplash.com/photo-1514282401047-d79a71a590e8?auto=format&fit=crop&w=1200&q=70"><span>Maldives<small>Overwater villas &amp; lagoons</small></span></a>
      <a href="packages.php?q=Turkey" class="dest reveal" data-bg="https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?auto=format&fit=crop&w=1200&q=70"><span>Turkey<small>Istanbul &amp; Cappadocia</small></span></a>
      <a href="packages.php?q=Japan" class="dest reveal" data-bg="https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&w=1200&q=70"><span>Japan<small>Cherry blossom season</small></span></a>
      <a href="packages.php?q=Egypt" class="dest reveal" data-bg="https://images.unsplash.com/photo-1503177119275-0aa32b3a9368?auto=format&fit=crop&w=1200&q=70"><span>Egypt<small>Pyramids &amp; Nile cruises</small></span></a>
      <div class="dest-text reveal">
        <img src="assets/img/logo-splash.png" alt="" aria-hidden="true" class="dest-wm">
        <div class="eyebrow" style="color:var(--tv-gold-800)">Your next adventure</div>
        <h3>From alpine peaks to tropical lagoons, the world is closer than you think.</h3>
        <p>Every destination comes with flights, hotels and local guides arranged for you, so you can focus on the journey.</p>
        <div class="d-flex gap-3 align-items-center flex-wrap"><a href="packages.php" class="btn btn-tv">View all packages <i class="bi bi-arrow-right"></i></a><a href="#" class="dest-link" data-bs-toggle="modal" data-bs-target="#bookingModal">Plan a custom trip</a></div>
      </div>
    </div>
  </div>
</section>

<section class="section" id="about">
  <div class="container"><div class="row g-5 align-items-center">
    <div class="col-lg-6"><div class="about-img reveal" data-bg="https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&w=1200&q=70"></div></div>
    <div class="col-lg-6 reveal">
      <div class="eyebrow eyebrow-ic"><span><i class="bi bi-compass"></i></span>About Travelita</div>
      <h2>Travel planned by people who travel.</h2>
      <p class="text-secondary">We design every package around real itineraries: tested hotels, sensible travel times and local guides. Send us a booking request and a travel consultant will reply with availability and a final quote.</p>
      <ol class="steps">
        <li><strong>Choose a package</strong><span>Or ask for a custom trip.</span></li>
        <li><strong>Send a booking request</strong><span>No payment needed at this step.</span></li>
        <li><strong>Get your confirmation</strong><span>We contact you within 24 hours.</span></li>
      </ol>
    </div>
  </div></div>
</section>

<section class="section bg-tint">
  <div class="container">
    <div class="section-head reveal"><div><div class="eyebrow">Testimonials</div><h2>What travellers say</h2></div></div>
    <div class="row g-4">
      <div class="col-md-4 reveal"><blockquote class="quote"><div class="stars">★★★★★</div><p>Everything was organised perfectly, from the airport pickup to the last hotel.</p><footer>Sarah M. — Paris & Swiss Alps</footer></blockquote></div>
      <div class="col-md-4 reveal"><blockquote class="quote"><div class="stars">★★★★★</div><p>Our honeymoon in Bali was exactly what we asked for. Fast replies on WhatsApp.</p><footer>Omar & Lina — Bali</footer></blockquote></div>
      <div class="col-md-4 reveal"><blockquote class="quote"><div class="stars">★★★★★</div><p>Great group, great guide. The balloon flight in Cappadocia was unforgettable.</p><footer>David K. — Turkey Highlights</footer></blockquote></div>
    </div>
  </div>
</section>

<section class="cta-wrap">
  <div class="container">
    <div class="cta-card reveal">
      <div class="cta-deco"><span class="c1"></span><span class="c2"></span><span class="dots"></span><img class="cta-wm" src="assets/img/logo-white.png" alt=""></div>
      <div class="cta-text">
        <div class="eyebrow light eyebrow-ic cta-eb"><span><i class="bi bi-brush"></i></span>Tailor-made trips</div>
        <h2>Can't find the right trip? <span class="hl">We'll design it for you.</span></h2>
        <p>Tell us where and when. We'll build a custom package for you.</p>
        <div class="cta-actions">
          <button class="btn btn-gold btn-lg" data-bs-toggle="modal" data-bs-target="#bookingModal">Request a custom trip <i class="bi bi-arrow-right"></i></button>
          <a class="btn btn-wa btn-lg" href="https://wa.me/<?= e(SITE_WHATSAPP) ?>" target="_blank" rel="noopener"><i class="bi bi-whatsapp"></i> Chat on WhatsApp</a>
        </div>
      </div>
      <div class="cta-visual">
        <span class="cta-sun"></span>
        <div class="cta-badge" aria-hidden="true"><span class="ring"></span><span class="disc"><img src="assets/img/logo-splash.png" alt=""></span></div>
        <div class="cta-photo"><img src="https://images.unsplash.com/photo-1501555088652-021faa106b9b?auto=format&fit=crop&w=900&q=75" alt="Traveller enjoying the view" loading="lazy" decoding="async"></div>
        <div class="cta-chip chip-a"><span><i class="bi bi-map"></i></span>Custom itinerary</div>
        <div class="cta-chip chip-b"><span><i class="bi bi-clock"></i></span>Reply within 24h</div>
      </div>
    </div>
  </div>
</section>
<?php include 'includes/footer.php'; ?><section class="section bg-tint">
  <div class="container">
    <div class="section-head reveal">
      <div><div class="eyebrow eyebrow-ic"><span><i class="bi bi-chat-quote"></i></span>Testimonials</div><h2>What travellers say</h2></div>
      <div class="t-arrows"><button type="button" class="t-prev" aria-label="Previous review"><i class="bi bi-chevron-left"></i></button><button type="button" class="t-next" aria-label="Next review"><i class="bi bi-chevron-right"></i></button></div>
    </div>
    <div class="t-slider reveal">
      <div class="t-track">
      <figure class="tcard">
        <div class="tcard-top"><div class="stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div><span class="tcard-q"><i class="bi bi-quote"></i></span></div>
        <blockquote>“Everything was organised perfectly, from the airport pickup to the last hotel.”</blockquote>
        <figcaption><span class="tcard-av">SM</span><span><strong>Sarah M.</strong><small><i class="bi bi-geo-alt"></i> Paris & Swiss Alps</small></span></figcaption>
      </figure>
      <figure class="tcard tcard-dark">
        <div class="tcard-top"><div class="stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div><span class="tcard-q"><i class="bi bi-quote"></i></span></div>
        <blockquote>“Our honeymoon in Bali was exactly what we asked for. Fast replies on WhatsApp.”</blockquote>
        <figcaption><span class="tcard-av">OL</span><span><strong>Omar & Lina</strong><small><i class="bi bi-geo-alt"></i> Bali Island Escape</small></span></figcaption>
      </figure>
      <figure class="tcard">
        <div class="tcard-top"><div class="stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div><span class="tcard-q"><i class="bi bi-quote"></i></span></div>
        <blockquote>“Great group, great guide. The balloon flight in Cappadocia was unforgettable.”</blockquote>
        <figcaption><span class="tcard-av">DK</span><span><strong>David K.</strong><small><i class="bi bi-geo-alt"></i> Turkey Highlights</small></span></figcaption>
      </figure>
      <figure class="tcard">
        <div class="tcard-top"><div class="stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div><span class="tcard-q"><i class="bi bi-quote"></i></span></div>
        <blockquote>“The overwater villa was even better than the photos. Every transfer ran on time.”</blockquote>
        <figcaption><span class="tcard-av">NR</span><span><strong>Nadia R.</strong><small><i class="bi bi-geo-alt"></i> Maldives Overwater Retreat</small></span></figcaption>
      </figure>
      <figure class="tcard tcard-dark">
        <div class="tcard-top"><div class="stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div><span class="tcard-q"><i class="bi bi-quote"></i></span></div>
        <blockquote>“Our Egyptologist made the temples come alive. The Nile cruise was the highlight.”</blockquote>
        <figcaption><span class="tcard-av">JP</span><span><strong>James & Priya</strong><small><i class="bi bi-geo-alt"></i> Egypt: Cairo & Nile Cruise</small></span></figcaption>
      </figure>
      <figure class="tcard">
        <div class="tcard-top"><div class="stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div><span class="tcard-q"><i class="bi bi-quote"></i></span></div>
        <blockquote>“Perfect timing for the cherry blossom. The rail passes made Japan so easy.”</blockquote>
        <figcaption><span class="tcard-av">ML</span><span><strong>Mei L.</strong><small><i class="bi bi-geo-alt"></i> Japan Cherry Blossom</small></span></figcaption>
      </figure>
      </div>
      <div class="t-dots"></div>
    </div>
  </div>
</section>

<section class="strip">
  <div class="container">
    <div class="strip-card">
      <div class="strip-item reveal"><span class="strip-ic"><i class="bi bi-shield-check"></i></span><div><strong>Secure booking</strong><span>Confirmed by our team</span></div></div>
      <div class="strip-item reveal"><span class="strip-ic"><i class="bi bi-airplane"></i></span><div><strong>Flights included</strong><span>On most packages</span></div></div>
      <div class="strip-item reveal"><span class="strip-ic"><i class="bi bi-headset"></i></span><div><strong>24/7 support</strong><span>Before and during travel</span></div></div>
      <div class="strip-item reveal"><span class="strip-ic"><i class="bi bi-credit-card"></i></span><div><strong>Flexible payment</strong><span>Pay in instalments</span></div></div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-head reveal">
      <div><div class="eyebrow eyebrow-ic"><span><i class="bi bi-suitcase2"></i></span>Featured packages</div><h2>Popular trips this season</h2></div>
      <a href="packages.php" class="link-arrow">View all packages <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="row g-4">
      <?php foreach ($featured as $p) include 'includes/package-card.php'; ?>
      <?php if (!$featured): ?><p class="text-muted">Import <code>database.sql</code> to see packages.</p><?php endif; ?>
    </div>
  </div>
</section>

<section class="section bg-tint">
  <div class="container">
    <div class="section-head reveal"><div><div class="eyebrow eyebrow-ic"><span><i class="bi bi-geo-alt"></i></span>Destinations</div><h2>Where we travel</h2></div></div>
    <div class="dest-grid">
      <a href="packages.php?q=France" class="dest dest-lg reveal" data-bg="https://images.unsplash.com/photo-1530122037265-a5f1f91d3b99?auto=format&fit=crop&w=1200&q=70"><span>Europe</span></a>
      <a href="packages.php?q=Maldives" class="dest reveal" data-bg="https://images.unsplash.com/photo-1514282401047-d79a71a590e8?auto=format&fit=crop&w=1200&q=70"><span>Maldives</span></a>
      <a href="packages.php?q=Turkey" class="dest reveal" data-bg="https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?auto=format&fit=crop&w=1200&q=70"><span>Turkey</span></a>
      <a href="packages.php?q=Japan" class="dest reveal" data-bg="https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&w=1200&q=70"><span>Japan</span></a>
      <a href="packages.php?q=Egypt" class="dest reveal" data-bg="https://images.unsplash.com/photo-1503177119275-0aa32b3a9368?auto=format&fit=crop&w=1200&q=70"><span>Egypt</span></a>
    </div>
  </div>
</section>

<section class="section" id="about">
  <div class="container"><div class="row g-5 align-items-center">
    <div class="col-lg-6"><div class="about-img reveal" data-bg="https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&w=1200&q=70"></div></div>
    <div class="col-lg-6 reveal">
      <div class="eyebrow">About Travelita</div>
      <h2>Travel planned by people who travel.</h2>
      <p class="text-secondary">We design every package around real itineraries: tested hotels, sensible travel times and local guides. Send us a booking request and a travel consultant will reply with availability and a final quote.</p>
      <ol class="steps">
        <li><strong>Choose a package</strong><span>Or ask for a custom trip.</span></li>
        <li><strong>Send a booking request</strong><span>No payment needed at this step.</span></li>
        <li><strong>Get your confirmation</strong><span>We contact you within 24 hours.</span></li>
      </ol>
    </div>
  </div></div>
</section>

<section class="section bg-tint">
  <div class="container">
    <div class="section-head reveal"><div><div class="eyebrow">Testimonials</div><h2>What travellers say</h2></div></div>
    <div class="row g-4">
      <div class="col-md-4 reveal"><blockquote class="quote"><div class="stars">★★★★★</div><p>Everything was organised perfectly, from the airport pickup to the last hotel.</p><footer>Sarah M. — Paris & Swiss Alps</footer></blockquote></div>
      <div class="col-md-4 reveal"><blockquote class="quote"><div class="stars">★★★★★</div><p>Our honeymoon in Bali was exactly what we asked for. Fast replies on WhatsApp.</p><footer>Omar & Lina — Bali</footer></blockquote></div>
      <div class="col-md-4 reveal"><blockquote class="quote"><div class="stars">★★★★★</div><p>Great group, great guide. The balloon flight in Cappadocia was unforgettable.</p><footer>David K. — Turkey Highlights</footer></blockquote></div>
    </div>
  </div>
</section>

<section class="cta">
  <div class="container d-lg-flex justify-content-between align-items-center gap-4">
    <div><h2>Can't find the right trip?</h2><p class="mb-lg-0">Tell us where and when. We'll build a custom package for you.</p></div>
    <button class="btn btn-light btn-lg" data-bs-toggle="modal" data-bs-target="#bookingModal">Request a custom trip</button>
  </div>
</section>
<?php include 'includes/footer.php'; ?>
