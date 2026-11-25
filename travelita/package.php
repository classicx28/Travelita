<?php
require_once 'includes/functions.php';
$p = get_package($_GET['slug'] ?? '');
if (!$p) { http_response_code(404); $pageTitle = 'Not found'; include 'includes/header.php'; echo '<div class="container section"><h2>Package not found</h2><a href="packages.php">Back to packages</a></div>'; include 'includes/footer.php'; exit; }
$pageTitle = $p['title'] . ' — Travelita';
$itinerary = json_decode($p['itinerary'] ?? '[]', true) ?: [];
$allPk = get_packages();
include 'includes/header.php';
?>
<section class="detail-hero" style="background-image:linear-gradient(transparent,rgba(15,39,56,.9)),url('<?= e($p['image']) ?>')">
  <div class="container">
    <div class="eyebrow light"><?= e(category_label($p['category'])) ?></div>
    <h1><?= e($p['title']) ?></h1>
    <div class="detail-meta"><span><i class="bi bi-geo-alt"></i> <?= e($p['destination']) ?>, <?= e($p['country']) ?></span><span><i class="bi bi-clock"></i> <?= (int)$p['duration_days'] ?> days / <?= (int)$p['duration_nights'] ?> nights</span></div>
  </div>
</section>
<section class="section">
  <div class="container"><div class="row g-5">
    <div class="col-lg-8">
      <h2 class="h4">Overview</h2><p class="text-secondary"><?= nl2br(e($p['description'])) ?></p>
      <?php if ($h = lines($p['highlights'])): ?><h2 class="h4 mt-5">Highlights</h2><ul class="check-list"><?php foreach ($h as $x): ?><li><?= e($x) ?></li><?php endforeach; ?></ul><?php endif; ?>
      <?php if ($itinerary): ?><h2 class="h4 mt-5">Day-by-day itinerary</h2>
        <div class="accordion itinerary" id="itin"><?php foreach ($itinerary as $i => $d): ?>
          <div class="accordion-item"><h3 class="accordion-header"><button class="accordion-button <?= $i?'collapsed':'' ?>" data-bs-toggle="collapse" data-bs-target="#d<?= $i ?>"><span class="day">Day <?= (int)$d['day'] ?></span> <?= e($d['title']) ?></button></h3>
          <div id="d<?= $i ?>" class="accordion-collapse collapse <?= $i?'':'show' ?>" data-bs-parent="#itin"><div class="accordion-body"><?= e($d['text']) ?></div></div></div>
        <?php endforeach; ?></div><?php endif; ?>
      <div class="row g-4 mt-4">
        <div class="col-md-6"><h2 class="h5">Included</h2><ul class="check-list"><?php foreach (lines($p['includes']) as $x): ?><li><?= e($x) ?></li><?php endforeach; ?></ul></div>
        <div class="col-md-6"><h2 class="h5">Not included</h2><ul class="x-list"><?php foreach (lines($p['excludes']) as $x): ?><li><?= e($x) ?></li><?php endforeach; ?></ul></div>
      </div>
    </div>
    <aside class="col-lg-4">
      <div class="book-box sticky-lg-top">
        <div class="pkg-price big"><small>From</small><?php if ($p['old_price']): ?><s><?= money($p['old_price']) ?></s><?php endif; ?><strong><?= money($p['price']) ?></strong><small>per person</small></div>
        <?php if ($p['departure_dates']): ?><p class="small text-secondary mb-3"><i class="bi bi-calendar3"></i> Departures: <?= e($p['departure_dates']) ?></p><?php endif; ?>
        <?php $fixedPackage = $p; include 'includes/booking-form.php'; $fixedPackage = null; ?>
      </div>
    </aside>
  </div></div>
</section>
<?php include 'includes/footer.php'; ?>
