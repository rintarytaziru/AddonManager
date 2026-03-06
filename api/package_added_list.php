<?php
header('Content-Type: application/json; charset=utf-8');
require __DIR__ . '/../constant.php';

function projectPath($path) {
    if (!$path) return null;
    if (preg_match('/^(?:[A-Za-z]:[\\\\\\/]|\\\\\\\\|\\/)/', $path)) return $path;
    return dirname(__DIR__) . DIRECTORY_SEPARATOR . ltrim(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path), '.\\/');
}

function findPackageByUUID($dir, $uuid) {
    if (!is_dir($dir)) return null;

    $items = @scandir($dir);
    if (!$items) return null;

    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $dir . DIRECTORY_SEPARATOR . $item;

        $manifestPath = $path . DIRECTORY_SEPARATOR . 'manifest.json';
        if (file_exists($manifestPath)) {
            $jsonContent = file_get_contents($manifestPath);
            $jsonContent = preg_replace('/^\x{FEFF}/u', '', mb_convert_encoding($jsonContent, 'UTF-8', 'UTF-8'));
            $json = json_decode($jsonContent, true);

            if ($json) {
                $header = $json['header'] ?? null;
                if (!$header && isset($json['modules'][0])) $header = $json['modules'][0];
                if ($header && ($header['uuid'] ?? '') === $uuid) {
                    return [
                        'path' => $path,
                        'manifest' => $json,
                        'header' => $header
                    ];
                }
            }
        }

        if (is_dir($path) && !in_array($item, ['__MACOSX', '.git', 'node_modules'])) {
            $result = findPackageByUUID($path, $uuid);
            if ($result) return $result;
        }
    }

    return null;
}

function loadList($file, $dir, $type) {
    if (!file_exists($file)) return [];
    $list = json_decode(file_get_contents($file), true);
    if (!is_array($list)) return [];

    $packs = [];
    $projectRoot = dirname(__DIR__) . DIRECTORY_SEPARATOR;

    foreach ($list as $p) {
        if (empty($p['pack_id'])) continue;

        $icon = '';
        $name = $p['pack_id'];
        $found = findPackageByUUID($dir, $p['pack_id']);

        if ($found) {
            $header = $found['header'];
            $folder = $found['path'];
            $iconPath = $folder . DIRECTORY_SEPARATOR . 'pack_icon.png';
            if (!file_exists($iconPath)) $iconPath = $folder . DIRECTORY_SEPARATOR . 'icon.png';

            if (file_exists($iconPath)) {
                $icon = str_replace($projectRoot, '', $iconPath);
                $icon = str_replace('\\', '/', $icon);
            }

            $name = $header['name'] ?? $p['pack_id'];
        }

        $packs[] = [
            'pack_id' => $p['pack_id'],
            'version' => $p['version'],
            'icon' => $icon,
            'name' => $name,
            'type' => $type,
            'uuid' => $p['pack_id']
        ];
    }

    return $packs;
}

$behaviorDir = projectPath($config['folders']['behavior_packs'] ?? 'behavior_packs');
$resourceDir = projectPath($config['folders']['resource_packs'] ?? 'resource_packs');

$behavior = loadList(dirname(__DIR__) . '/world_behavior_packs.json', $behaviorDir, 'behavior');
$resource = loadList(dirname(__DIR__) . '/world_resource_packs.json', $resourceDir, 'resource');

echo json_encode([
    'behavior' => $behavior,
    'resource' => $resource,
]);
