<?php

function generate_file_structure($dir = '.', $prefix = '', &$output = [], $root = true) {
    $items = array_filter(scandir($dir), function($item) {
        return !in_array($item, ['.', '..', '.git', '.structure_count_cache', 'structure.txt']);
    });

    $lastItem = end($items);
    foreach ($items as $index => $item) {
        $path = $dir . DIRECTORY_SEPARATOR . $item;
        $isLast = ($item === $lastItem);
        $branch = $root ? '' : ($isLast ? '+-- ' : '+-- ');
        $nextPrefix = $root ? '' : ($isLast ? '    ' : '¦   ');

        if (is_dir($path)) {
            $output[] = $prefix . $branch . $item;
            generate_file_structure($path, $prefix . $nextPrefix, $output, false);
        } else {
            $output[] = $prefix . $branch . $item;
        }
    }
    return $output;
}

function count_all_files($dir = '.') {
    $count = 0;
    $items = scandir($dir);
    foreach ($items as $item) {
        if (in_array($item, ['.', '..', '.git', '.structure_count_cache', 'structure.txt'])) continue;
        $path = $dir . '/' . $item;
        if (is_dir($path)) {
            $count += count_all_files($path);
        } else {
            $count++;
        }
    }
    return $count;
}

function update_structure_file_if_changed() {
    $structurePath = __DIR__ . '/../structure.txt';
    $countCachePath = __DIR__ . '/../.structure_count_cache';

    $currentCount = count_all_files('.');
    $previousCount = file_exists($countCachePath) ? (int) file_get_contents($countCachePath) : -1;

    if ($currentCount !== $previousCount) {
        $structure = [];
        $structure[] = '/TASKMANAGER';
        generate_file_structure('.', '¦   ', $structure, true);
        file_put_contents($structurePath, implode(PHP_EOL, $structure));
        file_put_contents($countCachePath, $currentCount);
    }
}
