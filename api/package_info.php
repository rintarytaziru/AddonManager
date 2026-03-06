<?php
header('Content-Type: application/json; charset=utf-8');

if (!isset($_GET['uid'])) {
    echo json_encode(['error' => 'Thieu uid']);
    exit;
}

$uid = $_GET['uid'];
$folders = ['resource_packs', 'behavior_packs'];
$projectRoot = dirname(__DIR__);
$pack = null;

function getAllUUIDs($manifest) {
    $uuids = [];
    if (isset($manifest['header']['uuid'])) $uuids[] = $manifest['header']['uuid'];

    if (!empty($manifest['modules'])) {
        foreach ($manifest['modules'] as $mod) {
            if (isset($mod['uuid'])) $uuids[] = $mod['uuid'];
        }
    }

    if (!empty($manifest['dependencies'])) {
        foreach ($manifest['dependencies'] as $dep) {
            if (isset($dep['uuid'])) $uuids[] = $dep['uuid'];
        }
    }

    return $uuids;
}

function getVersion($manifest) {
    if (isset($manifest['header']['version']) && is_array($manifest['header']['version'])) {
        return implode('.', $manifest['header']['version']);
    }
    return 'Khong xac dinh';
}

function getDescription($manifest) {
    return $manifest['header']['description'] ?? '';
}

function loadJSON($path) {
    $content = file_get_contents($path);
    if (!$content) return null;

    if (substr($content, 0, 3) === "\xEF\xBB\xBF") $content = substr($content, 3);
    $content = preg_replace('/[\x00-\x1F\x7F-\x9F]/u', '', $content);

    $json = json_decode($content, true);
    if (json_last_error() !== JSON_ERROR_NONE) return null;
    return $json;
}

function findPackageByUUIDRecursive($dir, $uid, $projectRoot) {
    if (!is_dir($dir)) return null;

    $items = @scandir($dir);
    if (!$items) return null;

    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $dir . DIRECTORY_SEPARATOR . $item;

        $manifestPath = $path . DIRECTORY_SEPARATOR . 'manifest.json';
        if (file_exists($manifestPath)) {
            $manifest = loadJSON($manifestPath);
            if ($manifest && in_array($uid, getAllUUIDs($manifest), true)) {
                $relativePath = str_replace($projectRoot . DIRECTORY_SEPARATOR, '', $path);
                return [
                    'manifest' => $manifest,
                    'path' => str_replace('\\', '/', $path),
                    'relative_path' => str_replace('\\', '/', $relativePath)
                ];
            }
        }

        if (is_dir($path) && !in_array($item, ['__MACOSX', '.git', 'node_modules'])) {
            $result = findPackageByUUIDRecursive($path, $uid, $projectRoot);
            if ($result) return $result;
        }
    }

    return null;
}

foreach ($folders as $folder) {
    $dir = $projectRoot . DIRECTORY_SEPARATOR . $folder;
    if (!is_dir($dir)) continue;

    $found = findPackageByUUIDRecursive($dir, $uid, $projectRoot);
    if ($found) {
        $pack = $found['manifest'];
        $pack['type'] = $folder;
        $pack['version'] = getVersion($pack);
        $pack['description'] = getDescription($pack);
        $pack['path'] = $found['path'];

        $subDir = $found['path'];
        $relativeSubDir = $found['relative_path'];
        $pack['icon'] = false;

        foreach (['pack_icon.png', 'icon.png'] as $iconFile) {
            $iconPath = $subDir . '/' . $iconFile;
            if (file_exists($iconPath)) {
                $pack['icon'] = '/' . trim($relativeSubDir, '/') . '/' . $iconFile;
                break;
            }
        }
        break;
    }
}

if (!$pack) {
    echo json_encode(['error' => 'Khong tim thay pack']);
    exit;
}

echo json_encode($pack, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
