<?php
// ---- Edit these for your server ----
define('DB_HOST', 'localhost');
define('DB_NAME', 'travelita');
define('DB_USER', 'root');
define('DB_PASS', '');

define('SITE_NAME', 'Travelita');
define('SITE_EMAIL', 'info@travelita.com');      // booking notifications go here
define('SITE_PHONE', '+1 000 000 0000');
define('SITE_WHATSAPP', '10000000000');          // digits only
define('CURRENCY', 'USD');

if (session_status() === PHP_SESSION_NONE) session_start();

function db(): PDO {
  static $pdo = null;
  if ($pdo === null) {
    $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4', DB_USER, DB_PASS, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES => false,
    ]);
  }
  return $pdo;
}
