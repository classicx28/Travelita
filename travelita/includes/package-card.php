<?php /* expects $p */ ?>
<div class="col-md-6 col-lg-4 reveal">
  <article class="pkg-card h-100">
    <a href="package.php?slug=<?= e($p['slug']) ?>" data-details="<?= e($p['slug']) ?>" class="pkg-img" data-bg="<?= e($p['image']) ?>" data-bg-var="1">
      <span class="pkg-badge"><?= e(category_label($p['category'])) ?></span>
      <?php if ($p['old_price']): ?><span class="pkg-sale">-<?= round(100 - $p['price'] / $p['old_price'] * 100) ?>%</span><?php endif; ?>
    </a>
    <div class="pkg-body">
      <div class="pkg-loc"><i class="bi bi-geo-alt"></i> <?= e($p['destination']) ?>, <?= e($p['country']) ?></div>
      <h3 class="pkg-title"><a href="package.php?slug=<?= e($p['slug']) ?>" data-details="<?= e($p['slug']) ?>"><?= e($p['title']) ?></a></h3>
      <p class="pkg-summary"><?= e($p['summary']) ?></p>
      <div class="pkg-meta d-flex justify-content-between align-items-center"><span><i class="bi bi-clock"></i> <?= (int)$p['duration_days'] ?> days / <?= (int)$p['duration_nights'] ?> nights</span><a href="package.php?slug=<?= e($p['slug']) ?>" data-details="<?= e($p['slug']) ?>" class="pkg-more">View itinerary <i class="bi bi-arrow-right"></i></a></div>
      <div class="pkg-foot">
        <div class="pkg-price">
          <small>From</small>
          <?php if ($p['old_price']): ?><s><?= money($p['old_price']) ?></s><?php endif; ?>
          <strong><?= money($p['price']) ?></strong><small>per person</small>
        </div>
        <button class="btn btn-tv btn-sm" data-bs-toggle="modal" data-bs-target="#bookingModal" data-package-id="<?= (int)$p['id'] ?>" data-package-title="<?= e($p['title']) ?>">Book now</button>
      </div>
    </div>
  </article>
</div>
