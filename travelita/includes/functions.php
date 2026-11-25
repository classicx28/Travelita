<?php
require_once __DIR__ . '/../config/config.php';

function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function money($n) { return '$' . number_format((float)$n, 0); }
function lines($s) { return array_filter(array_map('trim', explode("\n", (string)$s))); }

function csrf_token() {
  if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
  return $_SESSION['csrf'];
}
function csrf_check($t) { return !empty($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], (string)$t); }

function get_packages(array $f = [], int $limit = 0) {
  $sql = "SELECT * FROM packages WHERE status='active'";
  $p = [];
  if (!empty($f['featured'])) $sql .= " AND is_featured=1";
  if (!empty($f['category'])) { $sql .= " AND category=?"; $p[] = $f['category']; }
  if (!empty($f['country'])) { $sql .= " AND country LIKE ?"; $p[] = '%'.$f['country'].'%'; }
  if (!empty($f['q'])) { $sql .= " AND (title LIKE ? OR destination LIKE ? OR country LIKE ?)"; $q = '%'.$f['q'].'%'; array_push($p, $q, $q, $q); }
  if (!empty($f['max']) && (float)$f['max'] < 5000) { $sql .= " AND price <= ?"; $p[] = (float)$f['max']; }
  $sql .= " ORDER BY is_featured DESC, created_at DESC";
  if ($limit) $sql .= " LIMIT " . (int)$limit;
  $st = db()->prepare($sql); $st->execute($p);
  return $st->fetchAll();
}
function get_package($slug) {
  $st = db()->prepare("SELECT * FROM packages WHERE slug=? AND status='active' LIMIT 1");
  $st->execute([$slug]); return $st->fetch();
}
function get_countries() {
  $rows = db()->query("SELECT DISTINCT country FROM packages WHERE status='active'")->fetchAll(PDO::FETCH_COLUMN);
  $list = [];
  foreach ($rows as $r) foreach (explode('/', $r) as $c) if (($c = trim($c)) !== '') $list[$c] = true;
  $list = array_keys($list); sort($list, SORT_NATURAL | SORT_FLAG_CASE);
  return $list;
}
function category_label($c) {
  return ['international'=>'International','national'=>'Domestic','cruise'=>'Cruise','honeymoon'=>'Honeymoon','group'=>'Group tour'][$c] ?? ucfirst($c);
}
