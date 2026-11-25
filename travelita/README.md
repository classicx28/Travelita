# Travelita — Tour packages website

Stack: HTML, Bootstrap 5, vanilla JS, PHP 8+, MySQL.

## Setup
1. Copy the `travelita/` folder to your web root (XAMPP: `htdocs/travelita`).
2. Import `database.sql` in phpMyAdmin (creates the `travelita` database, tables and 6 sample packages).
3. Edit `config/config.php` (DB credentials, email, phone, WhatsApp number).
4. Add photos:
   - `assets/img/hero.jpg`, `assets/img/about.jpg`
   - `assets/img/packages/{paris,bali,istanbul,maldives,egypt,japan}.jpg`
   - `assets/img/dest/{europe,maldives,turkey,japan,egypt}.jpg`
   Missing images fall back to a navy block.
5. Open http://localhost/travelita

## Pages
- `index.php` — hero search, featured packages, destinations, about, testimonials, CTA
- `packages.php` — list with search / type / budget filters
- `package.php?slug=…` — details, itinerary, inclusions, booking form
- `book.php` — POST endpoint; validates, stores in `bookings` (status = pending), emails the agency, returns JSON
- `subscribe.php` — newsletter signup

## For the admin panel (later)
- `bookings` — read requests, update `status` (pending / contacted / confirmed / cancelled) and `admin_notes`
- `packages` — CRUD; `itinerary` is JSON, `highlights/includes/excludes` are one item per line
- `admins` — store `password_hash()` values for login
