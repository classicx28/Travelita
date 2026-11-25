<?php
// Newsletter signup. Returns JSON for AJAX requests, redirects otherwise.
require_once 'includes/functions.php';
$ajax = ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'fetch';
function done($ok, $msg) {
  global $ajax;
  if ($ajax) { header('Content-Type: application/json; charset=utf-8'); echo json_encode(['ok' => $ok, 'message' => $msg]); exit; }
  header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php') . '#contact'); exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') done(false, 'Method not allowed.');
if (!csrf_check($_POST['csrf'] ?? '')) done(false, 'Session expired. Please reload the page.');
$email = trim($_POST['email'] ?? '');
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 160) done(false, 'Please enter a valid email address.');
try {
  db()->prepare("INSERT IGNORE INTO newsletter (email) VALUES (?)")->execute([$email]);
  done(true, "You're subscribed! The next offers will arrive in your inbox.");
} catch (Throwable $e) { error_log($e->getMessage()); done(false, 'Something went wrong. Please try again.'); }
