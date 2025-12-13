<?php
/**
 * Fill missing translation keys with empty placeholders in the opposite language file.
 * Usage: php scripts/fill_placeholders.php
 */

$projectRoot = __DIR__ . '/../';
$langEnFile = $projectRoot . 'resources/lang/en/website.php';
$langArFile = $projectRoot . 'resources/lang/ar/website.php';

if (!file_exists($langEnFile) || !file_exists($langArFile)) {
    echo "Language files not found.\n";
    exit(1);
}

$en = include $langEnFile;
$ar = include $langArFile;

function flatten(array $arr, $prefix = '') {
    $res = [];
    foreach ($arr as $k => $v) {
        $key = $prefix === '' ? $k : $prefix . '.' . $k;
        if (is_array($v)) {
            $res[$key] = '[array]';
            $res = array_merge($res, flatten($v, $key));
        } else {
            $res[$key] = $v;
        }
    }
    return $res;
}

$flatEn = flatten($en);
$flatAr = flatten($ar);

$enKeys = array_keys($flatEn);
$arKeys = array_keys($flatAr);

$missingInAr = array_diff($enKeys, $arKeys);
$missingInEn = array_diff($arKeys, $enKeys);

$changes = [];

// backup originals
copy($langEnFile, $langEnFile . '.bak');
copy($langArFile, $langArFile . '.bak');

// helper to insert a key path into array structure
function setByPath(array &$arr, $path, $value) {
    $parts = explode('.', $path);
    $cur =& $arr;
    foreach ($parts as $p) {
        if (!isset($cur[$p]) || !is_array($cur[$p])) {
            if ($p === end($parts)) {
                $cur[$p] = $value;
            } else {
                if (!isset($cur[$p])) $cur[$p] = [];
            }
        }
        $cur =& $cur[$p];
    }
}

// Add placeholders empty string for missing keys
foreach ($missingInAr as $fullKey) {
    // remove 'website.' prefix if present
    $key = preg_replace('#^website\.#', '', $fullKey);
    setByPath($ar, $key, '');
    $changes[] = "EN -> AR: $fullKey";
}
foreach ($missingInEn as $fullKey) {
    $key = preg_replace('#^website\.#', '', $fullKey);
    setByPath($en, $key, '');
    $changes[] = "AR -> EN: $fullKey";
}

if (empty($changes)) {
    echo "No missing keys; no placeholders added.\n";
    // remove backups since no changes made
    unlink($langEnFile . '.bak');
    unlink($langArFile . '.bak');
    exit(0);
}

// write back files with pretty formatting using var_export
function writePhpArrayFile($path, $array) {
    $export = var_export($array, true);
    $content = "<?php\n\nreturn " . $export . ";\n";
    // make arrays use short array syntax? var_export uses array() — acceptable.
    file_put_contents($path, $content);
}

writePhpArrayFile($langEnFile, $en);
writePhpArrayFile($langArFile, $ar);

echo "Placeholders added for missing keys:\n";
foreach ($changes as $c) echo " - $c\n";

echo "Backups created: $langEnFile.bak, $langArFile.bak\n";

exit(0);
