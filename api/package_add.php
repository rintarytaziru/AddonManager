<?php
header('Content-Type: text/plain; charset=utf-8');
require __DIR__ . '/../constant.php';

if (!isset($_GET['data'])) { echo 'false'; exit; }

$data = json_decode(urldecode($_GET['data']), true);
if (!$data || empty($data['uuid']) || empty($data['version'])) { echo 'false'; exit; }

$pack = [
    'pack_id' => $data['uuid'],
    'version' => $data['version']
];

function projectPath($path) {
    if (!$path) return null;
    if (preg_match('/^(?:[A-Za-z]:[\\\\\\/]|\\\\\\\\|\\/)/', $path)) return $path;
    return dirname(__DIR__) . DIRECTORY_SEPARATOR . ltrim(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path), '.\\/');
}

function searchManifestRecursive($dir, $uuid) {
    if (!is_dir($dir)) return false;

    $items = @scandir($dir);
    if (!$items) return false;

    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $dir . DIRECTORY_SEPARATOR . $item;

        $manifestPath = $path . DIRECTORY_SEPARATOR . 'manifest.json';
        if (file_exists($manifestPath)) {
            $manifestContent = file_get_contents($manifestPath);
            $manifestContent = preg_replace('/^\x{FEFF}/u', '', mb_convert_encoding($manifestContent, 'UTF-8', 'UTF-8'));
            $manifest = json_decode($manifestContent, true);

            if ($manifest) {
                $header = $manifest['header'] ?? null;
                if (!$header && isset($manifest['modules'][0])) $header = $manifest['modules'][0];
                if ($header && ($header['uuid'] ?? '') === $uuid) return true;
            }
        }

        if (is_dir($path) && !in_array($item, ['__MACOSX', '.git', 'node_modules'])) {
            if (searchManifestRecursive($path, $uuid)) return true;
        }
    }

    return false;
}

function findPackageType($uuid, $config) {
    $behaviorPath = $config['folders']['behavior_packs'] ?? $config['behavior_packs'] ?? 'behavior_packs';
    $resourcePath = $config['folders']['resource_packs'] ?? $config['resource_packs'] ?? 'resource_packs';
    $dirs = [projectPath($behaviorPath), projectPath($resourcePath)];

    foreach ($dirs as $typeDir) {
        if (!$typeDir || !is_dir($typeDir)) continue;
        $type = (strpos($typeDir, 'behavior') !== false) ? 'behavior' : 'resource';
        if (searchManifestRecursive($typeDir, $uuid)) return $type;
    }

    return null;
}

$target = dirname(__DIR__) . '/world_resource_packs.json';
$packageType = findPackageType($data['uuid'], $config);
if ($packageType === 'behavior') $target = dirname(__DIR__) . '/world_behavior_packs.json';

$list = [];
if (file_exists($target)) {
    $existing = json_decode(file_get_contents($target), true);
    if (is_array($existing)) $list = $existing;
}

foreach ($list as $p) {
    if (isset($p['pack_id']) && $p['pack_id'] === $pack['pack_id']) {
        echo 'duplicated';
        exit;
    }
}

$list[] = $pack;
$json = json_encode($list, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
$json = preg_replace_callback(
    '/"version":\s*\[(.*?)\]/s',
    function ($m) {
        $clean = preg_replace('/\s+/', '', $m[1]);
        return '"version": [ ' . str_replace(',', ', ', $clean) . ' ]';
    },
    $json
);

echo file_put_contents($target, $json) !== false ? 'true' : 'false';
