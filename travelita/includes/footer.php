<footer class="tv-footer" id="contact">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-4">
        <img src="assets/img/logo-white.png" alt="Travelita" class="footer-logo" loading="lazy" decoding="async">
        
      </div>
      <div class="col-lg-8"><div class="row g-5">
      <div class="col-6 col-lg-3"><h6 class="f-head"><span><i class="bi bi-compass"></i></span>Explore</h6><ul class="list-unstyled"><li><a href="packages.php">All packages</a></li><li><a href="packages.php?category=international">International</a></li><li><a href="packages.php?category=cruise">Cruises</a></li><li><a href="packages.php?category=honeymoon">Honeymoon</a></li></ul></div>
      <div class="col-6 col-lg-3"><h6 class="f-head"><span><i class="bi bi-building"></i></span>Company</h6><ul class="list-unstyled"><li><a href="index.php#about">About us</a></li><li><a href="#">Terms</a></li><li><a href="#">Privacy</a></li></ul></div>
      <div class="col-lg-6"><h6 class="f-head"><span><i class="bi bi-telephone"></i></span>Contact</h6>
        <ul class="list-unstyled contact-list">
          <li><i class="bi bi-telephone"></i> <?= e(SITE_PHONE) ?></li>
          <li><i class="bi bi-envelope"></i> <?= e(SITE_EMAIL) ?></li>
          <li><i class="bi bi-geo-alt"></i> Your office address</li>
          <li><i class="bi bi-clock"></i> Mon–Sat, 9:00–18:00</li>
        </ul>
      </div>
      </div></div>
    </div>
    <div class="row g-4 align-items-center mt-1">
      <div class="col-lg-4"><p class="opacity-75 mb-0" style="max-width:300px">Handpicked tours, cruises and honeymoons, planned with care from your first enquiry until you are safely back home.</p></div>
      <div class="col-lg-8">
        <div class="sub-band reveal">
          <div class="sub-info">
            <span class="sub-ic"><i class="bi bi-envelope-paper"></i></span>
            <div><h4>Get the latest offers</h4><p>Exclusive deals, new packages and early-bird prices, straight to your inbox.</p></div>
          </div>
          <div class="sub-box">
            <form class="newsletter-form" action="subscribe.php" method="post" novalidate>
              <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
              <div class="sub-field">
                <input type="email" name="email" placeholder="Your email address" aria-label="Email address" required>
                <button class="btn btn-gold" type="submit"><span class="label">Subscribe</span><span class="spinner-border spinner-border-sm d-none"></span></button>
              </div>
              <div class="sub-msg">No spam. Unsubscribe at any time.</div>
            </form>
          </div>
        </div>
          </div>
    </div>
    <div class="footer-bottom">© <?= date('Y') ?> Travelita Travel Agency. All rights reserved.</div>
  </div>
</footer>
<a class="wa-float" href="https://wa.me/<?= e(SITE_WHATSAPP) ?>" target="_blank" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
<?php include __DIR__ . '/booking-modal.php'; ?>
<div class="modal fade" id="detailsModal" tabindex="-1" aria-label="Package details" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">
    <div class="modal-content pd-modal"><div class="pd-loading"><div class="ring"><img src="assets/img/logo.jpeg" alt=""></div></div></div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
