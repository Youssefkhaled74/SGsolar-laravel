<?php

/**
 * Compare translation keys used in Blade views with entries in
 * resources/lang/en/website.php and resources/lang/ar/website.php
 *
 * Usage: php scripts/compare_translations.php
 */

function flatten(array $arr, $prefix = '') {
    $res = [];
    foreach ($arr as $k => $v) {
        $key = $prefix === '' ? $k : $prefix . '.' . $k;
        // include parent key even if it's an array (so __('website.section') is detected)
        if (is_array($v)) {
            $res[$key] = '[array]';
            $res = array_merge($res, flatten($v, $key));
        } else {
            $res[$key] = $v;
        }
    }
    return $res;
}

$projectRoot = __DIR__ . '/../';
$viewsPath = $projectRoot . 'resources/views';
$langEn = $projectRoot . 'resources/lang/en/website.php';
$langAr = $projectRoot . 'resources/lang/ar/website.php';

if (!file_exists($langEn) || !file_exists($langAr)) {
    echo "Language files missing. Make sure both $langEn and $langAr exist\n";
    exit(1);
}

$en = include $langEn;
$ar = include $langAr;

$flatEn = flatten($en);
$flatAr = flatten($ar);

// find translation keys used in views: __('website.xxx') and @lang('website.xxx')
$usedKeys = [];
$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsPath));
foreach ($rii as $file) {
    if ($file->isDir()) continue;
    $ext = pathinfo($file->getFilename(), PATHINFO_EXTENSION);
    if (!in_array($ext, ['php', 'blade.php', 'blade'])) continue;
    $content = file_get_contents($file->getPathname());
    // match __('website.key.something') and @lang('website.key')
    if (preg_match_all("/__\(\s*'website\.([^)']+)'\s*\)/U", $content, $m1)) {
        foreach ($m1[1] as $k) $usedKeys['website.' . $k] = true;
    }
    if (preg_match_all('/__\(\s*"website\.([^"]+)"\s*\)/U', $content, $m2)) {
        foreach ($m2[1] as $k) $usedKeys['website.' . $k] = true;
    }
    if (preg_match_all("/@lang\(\s*'website\.([^)']+)'\s*\)/U", $content, $m3)) {
        foreach ($m3[1] as $k) $usedKeys['website.' . $k] = true;
    }
    if (preg_match_all('/@lang\(\s*"website\.([^"]+)"\s*\)/U', $content, $m4)) {
        foreach ($m4[1] as $k) $usedKeys['website.' . $k] = true;
    }
}

// flatten keys from arrays to dot notation prefixed with 'website.'
$enKeys = array_map(function($k){ return 'website.' . $k; }, array_keys($flatEn));
$arKeys = array_map(function($k){ return 'website.' . $k; }, array_keys($flatAr));

sort($enKeys);
sort($arKeys);

$used = array_keys($usedKeys);
sort($used);

echo "Summary:\n";
echo "- Views scanned: ";

// quick count files
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsPath));
$fileCount = 0; foreach ($it as $f) if ($f->isFile()) $fileCount++;
echo $fileCount . " files\n";

echo "- translation keys in English file: " . count($enKeys) . "\n";
echo "- translation keys in Arabic file: " . count($arKeys) . "\n";
echo "- translation keys used in views: " . count($used) . "\n\n";

// Missing keys in ar that exist in en
$missingInAr = array_diff($enKeys, $arKeys);
$missingInEn = array_diff($arKeys, $enKeys);

if (count($missingInAr)) {
    echo "Keys present in English but MISSING in Arabic (count: " . count($missingInAr) . "):\n";
    foreach ($missingInAr as $k) echo "  - $k\n";
    echo "\n";
} else {
    echo "No keys missing in Arabic compared to English.\n\n";
}

if (count($missingInEn)) {
    echo "Keys present in Arabic but MISSING in English (count: " . count($missingInEn) . "):\n";
    foreach ($missingInEn as $k) echo "  - $k\n";
    echo "\n";
} else {
    echo "No keys missing in English compared to Arabic.\n\n";
}

// Keys used in views but not present in either file
$usedMissingEn = array_filter($used, function($k) use ($enKeys){ return !in_array($k, $enKeys); });
$usedMissingAr = array_filter($used, function($k) use ($arKeys){ return !in_array($k, $arKeys); });

$usedMissing = array_unique(array_merge($usedMissingEn, $usedMissingAr));

if (count($usedMissing)) {
    echo "Translation keys used in views but missing in language files (count: " . count($usedMissing) . "):\n";
    foreach ($usedMissing as $k) echo "  - $k\n";
    echo "\n";
} else {
    echo "All translation keys used in views exist in language files.\n\n";
}

echo "Report complete.\n";

// Exit with 0
exit(0);
