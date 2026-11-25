<?php
// Shared booking form. Opened from any "Book now" button via data-package-id / data-package-title.
$allPk = $allPk ?? get_packages();
?>
<div class="modal fade" id="bookingModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content tv-modal">
      <div class="modal-header">
        <div>
          <div class="eyebrow">Booking request</div>
          <h5 class="modal-title" id="bookingTitle">Plan your trip</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <?php include __DIR__ . '/booking-form.php'; ?>
      </div>
    </div>
  </div>
</div>
