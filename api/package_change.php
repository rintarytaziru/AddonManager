<?php
header('Content-Type: text/plain; charset=utf-8');

$type = $_GET['type'] ?? '';
$current = intval($_GET['current'] ?? 0) - 1;
$newChange = intval($_GET['newChange'] ?? 0) - 1;

if (!$type || $current < 0 || $newChange < 0) {
    echo 'false';
    exit;
}

$file = $type === 'resource'
    ? dirname(__DIR__) . '/world_resource_packs.json'
    : dirname(__DIR__) . '/world_behavior_packs.json';

if (!file_exists($file)) { echo 'false'; exit; }

$data = json_decode(file_get_contents($file), true);
if (!$data || !is_array($data)) { echo 'false'; exit; }
if ($current >= count($data) || $newChange >= count($data)) { echo 'false'; exit; }

$item = $data[$current];
array_splice($data, $current, 1);
array_splice($data, $newChange, 0, [$item]);

$json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
$json = preg_replace_callback(
    '/"version":\s*\[([^\]]*)\]/',
    function ($m) {
        $clean = preg_replace('/\s+/', '', $m[1]);
        return '"version": [ ' . str_replace(',', ', ', $clean) . ' ]';
    },
    $json
);

file_put_contents($file, $json);
echo 'true';
