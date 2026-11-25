<?php require_once __DIR__ . '/functions.php'; $page = basename($_SERVER['PHP_SELF']); ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle ?? 'Travelita — Travel Agency') ?></title>
  <meta name="description" content="Travelita Travel Agency — curated tour packages worldwide.">
  <link rel="icon" href="assets/img/logo.jpeg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <link rel="preload" as="image" href="assets/img/logo-splash.png">
  <link rel="preconnect" href="https://images.unsplash.com">
</head>
<body>
<div id="splash" aria-hidden="true">
  <img src="assets/img/logo-splash.png" alt="Travelita">
  <div class="splash-bar"><span></span></div>
</div>
<div class="topbar d-none d-md-block">
  <div class="container d-flex justify-content-between">
    <div class="d-flex gap-4">
      <span><i class="bi bi-telephone"></i> <?= e(SITE_PHONE) ?></span>
      <span><i class="bi bi-envelope"></i> <?= e(SITE_EMAIL) ?></span>
    </div>
    <div class="d-flex gap-3">
      <a href="#"><i class="bi bi-instagram"></i></a><a href="#"><i class="bi bi-facebook"></i></a><a href="#"><i class="bi bi-youtube"></i></a>
    </div>
  </div>
</div>
<nav class="navbar navbar-expand-lg sticky-top tv-nav">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
      <img src="assets/img/logo-horizontal.png" alt="Travelita" class="brand-logo">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
        <li class="nav-item"><a class="nav-link <?= $page==='index.php'?'active':'' ?>" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link <?= $page==='packages.php'?'active':'' ?>" href="packages.php">Packages</a></li>
        <li class="nav-item"><a class="nav-link" href="packages.php?category=international">International</a></li>
        <li class="nav-item"><a class="nav-link" href="packages.php?category=cruise">Cruises</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php#about">About</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php#contact">Contact</a></li>
        <li class="nav-item ms-lg-2"><button class="btn btn-tv" data-bs-toggle="modal" data-bs-target="#bookingModal"><i class="bi bi-send me-1"></i> Request a quote</button></li>
      </ul>
    </div>
  </div>
</nav>
