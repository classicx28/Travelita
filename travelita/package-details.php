<?php
// Returns the itinerary popup content for one package (loaded via AJAX).
require_once 'includes/functions.php';
$p = get_package($_GET['slug'] ?? '');
if (!$p) { http_response_code(404); echo '<div class="p-5 text-center">Package not found.</div>'; exit; }
$days = json_decode($p['itinerary'] ?? '[]', true) ?: [];
?>
<div class="pd-hero" style="background-image:url('<?= e($p['image']) ?>')">
  <button type="button" class="pd-close" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
  <div class="pd-hero-text">
    <span class="pd-cat"><?= e(category_label($p['category'])) ?></span>
    <h3><?= e($p['title']) ?></h3>
    <div class="pd-meta"><span><i class="bi bi-geo-alt"></i> <?= e($p['destination']) ?>, <?= e($p['country']) ?></span><span><i class="bi bi-clock"></i> <?= (int)$p['duration_days'] ?> days / <?= (int)$p['duration_nights'] ?> nights</span></div>
  </div>
</div>
<div class="pd-body">
  <p class="pd-overview"><?= nl2br(e($p['description'])) ?></p>
  <?php if ($h = lines($p['highlights'])): ?>
  <div><h4 class="pd-h">Highlights</h4><div class="pd-chips"><?php foreach ($h as $x): ?><span><i class="bi bi-star-fill"></i><?= e($x) ?></span><?php endforeach; ?></div></div>
  <?php endif; ?>
  <?php if ($days): ?>
  <div><h4 class="pd-h">Day-by-day itinerary</h4>
    <div class="pd-days">
      <?php foreach ($days as $i => $d): ?>
      <div class="pd-day<?= $i === 0 ? ' open' : '' ?>">
        <span class="pd-dot"><small>DAY</small><strong><?= (int)($d['day'] ?? $i + 1) ?></strong></span>
        <button type="button" class="pd-day-head"><strong><?= e($d['title'] ?? '') ?></strong><i class="bi bi-chevron-down"></i></button>
        <p><?= e($d['text'] ?? '') ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endif; ?>
  <div class="row g-3">
    <div class="col-md-6"><div class="pd-box inc"><h4 class="pd-h">Included</h4><ul class="check-list mb-0"><?php foreach (lines($p['includes']) as $x): ?><li><?= e($x) ?></li><?php endforeach; ?></ul></div></div>
    <div class="col-md-6"><div class="pd-box exc"><h4 class="pd-h">Not included</h4><ul class="x-list mb-0"><?php foreach (lines($p['excludes']) as $x): ?><li><?= e($x) ?></li><?php endforeach; ?></ul></div></div>
  </div>
  <?php if ($p['departure_dates']): ?><div class="pd-dates"><i class="bi bi-calendar3"></i><span><strong>Departures:</strong> <?= e($p['departure_dates']) ?></span></div><?php endif; ?>
</div>
<div class="pd-foot">
  <div class="pd-price"><small>From</small><?php if ($p['old_price']): ?><s><?= money($p['old_price']) ?></s><?php endif; ?><strong><?= money($p['price']) ?></strong><small>per person</small></div>
  <div class="d-flex gap-2 flex-wrap">
    <a class="btn btn-outline-secondary rounded-pill px-3" href="package.php?slug=<?= e($p['slug']) ?>">Full page</a>
    <button type="button" class="btn btn-gold rounded-pill px-4 pd-book" data-package-id="<?= (int)$p['id'] ?>" data-package-title="<?= e($p['title']) ?>">Book this trip <i class="bi bi-arrow-right"></i></button>
  </div>
</div>
