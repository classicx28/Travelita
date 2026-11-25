<?php
// Receives booking requests (AJAX or normal POST) and stores them for the admin panel.
require_once 'includes/functions.php';
header('Content-Type: application/json; charset=utf-8');

function out($ok, $msg, $extra = []) { echo json_encode(['ok' => $ok, 'message' => $msg] + $extra); exit; }

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); out(false, 'Method not allowed.'); }
if (!csrf_check($_POST['csrf'] ?? '')) out(false, 'Session expired. Please reload the page.');
if (!empty($_POST['website'])) out(true, 'Thank you.'); // bot

$name  = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$nat   = trim($_POST['nationality'] ?? '');
$date  = $_POST['travel_date'] ?? '';
$adults = max(1, min(50, (int)($_POST['adults'] ?? 1)));
$children = max(0, min(50, (int)($_POST['children'] ?? 0)));
$msg   = trim($_POST['message'] ?? '');
$pkgId = (int)($_POST['package_id'] ?? 0) ?: null;

$err = [];
if ($name === '' || mb_strlen($name) > 120) $err[] = 'Please enter your name.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $err[] = 'Please enter a valid email.';
if (!preg_match('/^[0-9+()\-\s]{6,40}$/', $phone)) $err[] = 'Please enter a valid phone number.';
if ($date !== '' && (!($d = DateTime::createFromFormat('Y-m-d', $date)) || $d < new DateTime('today'))) $err[] = 'Travel date must be in the future.';
if ($err) out(false, implode(' ', $err));

// simple rate limit: 5 requests / 10 min per session
$_SESSION['bk'] = array_filter($_SESSION['bk'] ?? [], fn($t) => $t > time() - 600);
if (count($_SESSION['bk']) >= 5) out(false, 'Too many requests. Please try again later.');

try {
  if ($pkgId) { $st = db()->prepare("SELECT id, title FROM packages WHERE id=?"); $st->execute([$pkgId]); $pkg = $st->fetch(); if (!$pkg) $pkgId = null; }
  $ref = 'TV' . date('ymd') . strtoupper(bin2hex(random_bytes(2)));
  $st = db()->prepare("INSERT INTO bookings (reference, package_id, full_name, email, phone, nationality, travel_date, adults, children, message, ip_address) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
  $st->execute([$ref, $pkgId, $name, $email, $phone, $nat ?: null, $date ?: null, $adults, $children, $msg ?: null, $_SERVER['REMOTE_ADDR'] ?? null]);
  $_SESSION['bk'][] = time();

  // Optional email notification to the agency (requires mail() configured on the server)
  @mail(SITE_EMAIL, "New booking request $ref", "Name: $name\nEmail: $email\nPhone: $phone\nPackage: " . ($pkg['title'] ?? 'Custom') . "\nDate: $date\nAdults: $adults  Children: $children\n\n$msg", "From: noreply@" . ($_SERVER['HTTP_HOST'] ?? 'localhost'));

  out(true, "Thank you, $name. Your request $ref was received — our team will contact you within 24 hours.", ['reference' => $ref]);
} catch (Throwable $ex) {
  error_log($ex->getMessage());
  out(false, 'Something went wrong. Please try again or contact us on WhatsApp.');
}
