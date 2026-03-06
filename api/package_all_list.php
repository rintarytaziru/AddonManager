<?php
header('Content-Type: application/json; charset=utf-8');
require __DIR__ . '/../constant.php';

function projectPath($path) {
    if (!$path) return null;
    if (preg_match('/^(?:[A-Za-z]:[\\\\\\/]|\\\\\\\\|\\/)/', $path)) return $path;
    return dirname(__DIR__) . DIRECTORY_SEPARATOR . ltrim(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path), '.\\/');
}

function toWebPath($path, $projectRoot) {
    $normalizedPath = str_replace('\\', '/', $path);
    $normalizedRoot = rtrim(str_replace('\\', '/', $projectRoot), '/');
    if (strpos($normalizedPath, $normalizedRoot . '/') === 0) {
        return substr($normalizedPath, strlen($normalizedRoot) + 1);
    }
    return $normalizedPath;
}

function scanManifestsRecursive($dir, $type, &$packs = []) {
    if (!is_dir($dir)) return $packs;

    $items = @scandir($dir);
    if (!$items) return $packs;

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

                if ($header) {
                    $iconPath = $path . DIRECTORY_SEPARATOR . 'pack_icon.png';
                    $icon = file_exists($iconPath) ? toWebPath($iconPath, dirname(__DIR__)) : '';
                    $name = $header['name'] ?? 'Unknown';
                    $description = $header['description'] ?? '';
                    $uuid = $header['uuid'] ?? '';
                    $version = $header['version'] ?? [1, 0, 0];

                    if (!empty($uuid)) {
                        $packs[] = [
                            'name' => $name,
                            'description' => $description,
                            'uuid' => $uuid,
                            'version' => $version,
                            'icon' => $icon,
                            'type' => $type,
                            'path' => toWebPath($path, dirname(__DIR__))
                        ];
                    }
                }
            }
        }

        if (is_dir($path) && !in_array($item, ['__MACOSX'])) {
            scanManifestsRecursive($path, $type, $packs);
        }
    }

    return $packs;
}

$behaviorDir = projectPath($config['folders']['behavior_packs'] ?? 'behavior_packs');
$resourceDir = projectPath($config['folders']['resource_packs'] ?? 'resource_packs');

$behavior = scanManifestsRecursive($behaviorDir, 'behavior');
$resource = scanManifestsRecursive($resourceDir, 'resource');

echo json_encode([
    'behavior' => $behavior,
    'resource' => $resource,
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
