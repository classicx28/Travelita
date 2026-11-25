<?php $fixedPackage = $fixedPackage ?? null; $allPk = $allPk ?? get_packages(); ?>
<form class="booking-form needs-validation" novalidate action="book.php" method="post">
  <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
  <input type="text" name="website" class="d-none" tabindex="-1" autocomplete="off"><!-- honeypot -->
  <div class="row g-3">
    <div class="col-12">
      <label class="form-label">Package</label>
      <?php if ($fixedPackage): ?>
        <input type="hidden" name="package_id" value="<?= (int)$fixedPackage['id'] ?>">
        <input class="form-control" value="<?= e($fixedPackage['title']) ?>" disabled>
      <?php else: ?>
        <select class="form-select" name="package_id">
          <option value="">Custom trip / not sure yet</option>
          <?php foreach ($allPk as $p): ?><option value="<?= (int)$p['id'] ?>"><?= e($p['title']) ?> — <?= money($p['price']) ?></option><?php endforeach; ?>
        </select>
      <?php endif; ?>
    </div>
    <div class="col-md-6"><label class="form-label">Full name *</label><input class="form-control" name="full_name" required maxlength="120"><div class="invalid-feedback">Please enter your name.</div></div>
    <div class="col-md-6"><label class="form-label">Email *</label><input type="email" class="form-control" name="email" required maxlength="160"><div class="invalid-feedback">Enter a valid email.</div></div>
    <div class="col-md-6"><label class="form-label">Phone / WhatsApp *</label><input class="form-control" name="phone" required maxlength="40"><div class="invalid-feedback">Phone is required.</div></div>
    <div class="col-md-6"><label class="form-label">Nationality</label><input class="form-control" name="nationality" maxlength="80"></div>
    <div class="col-md-4"><label class="form-label">Preferred date</label><input type="date" class="form-control" name="travel_date"></div>
    <div class="col-md-4 col-6"><label class="form-label">Adults</label><input type="number" class="form-control" name="adults" min="1" max="50" value="2"></div>
    <div class="col-md-4 col-6"><label class="form-label">Children</label><input type="number" class="form-control" name="children" min="0" max="50" value="0"></div>
    <div class="col-12"><label class="form-label">Message</label><textarea class="form-control" name="message" rows="3" maxlength="2000" placeholder="Room type, special requests, questions…"></textarea></div>
    <div class="col-12 form-check ms-1"><input class="form-check-input" type="checkbox" id="agree" required><label class="form-check-label small" for="agree">I agree to be contacted by Travelita about this request.</label></div>
    <div class="col-12"><div class="form-alert"></div><button type="submit" class="btn btn-tv btn-lg w-100"><span class="label">Send booking request</span><span class="spinner-border spinner-border-sm d-none"></span></button></div>
  </div>
</form>
