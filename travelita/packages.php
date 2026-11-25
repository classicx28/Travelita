<?php
require_once 'includes/functions.php';
$f = ['q' => trim($_GET['q'] ?? ''), 'country' => trim($_GET['country'] ?? ''), 'category' => $_GET['category'] ?? '', 'max' => $_GET['max'] ?? ''];
$packages = get_packages($f); $allPk = get_packages(); $countries = get_countries();
$pageTitle = 'Tour Packages — Travelita';
include 'includes/header.php';
?>
<section class="page-hero"><div class="container"><div class="eyebrow light">Packages</div><h1><?= $f['category'] ? e(category_label($f['category'])) . ' packages' : 'All tour packages' ?></h1></div></section>
<section class="section pt-4">
  <div class="container">
    <form class="filter-bar row g-2 mb-4" method="get">
      <div class="col-md-5"><select class="form-select js-select2" name="country" data-placeholder="All countries"><option value="">All countries</option><?php foreach ($countries as $c): ?><option value="<?= e($c) ?>" <?= $f['country']===$c?'selected':'' ?>><?= e($c) ?></option><?php endforeach; ?></select></div>
      <div class="col-md-3"><select class="form-select" name="category"><option value="">All types</option>
        <?php foreach (['international','national','cruise','honeymoon','group'] as $c): ?><option value="<?= $c ?>" <?= $f['category']===$c?'selected':'' ?>><?= category_label($c) ?></option><?php endforeach; ?></select></div>
      <div class="col-md-2 hs-range"><label class="d-flex justify-content-between small fw-bold"><span>Budget</span><output class="budget-out"></output></label><input type="range" class="budget-range" name="max" min="500" max="5000" step="100" value="<?= (int)($f['max'] ?: 5000) ?>" aria-label="Maximum budget per person"></div>
      <div class="col-md-2 d-grid"><button class="btn btn-tv">Filter</button></div>
    </form>
    <p class="text-secondary small"><?= count($packages) ?> package(s) found</p>
    <div class="row g-4"><?php foreach ($packages as $p) include 'includes/package-card.php'; ?></div>
  </div>
</section>
<?php include 'includes/footer.php'; ?>
