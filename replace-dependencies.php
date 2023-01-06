<?php
set_error_handler(function ($severity, $message, $file, $line) {
    throw new \ErrorException($message, $severity, $severity, $file, $line);
});

$directory = $argv[1];
echo "replace-dependencies.php - START - modify composer.json in $directory" . PHP_EOL;

$dependenciesToReplace = [
    'magento/composer-dependency-version-audit-plugin'
];

$contents = \json_decode(file_get_contents($directory . '/composer.json'), true);

if (!isset($contents['replace'])) {
    $contents['replace'] = [];
}

foreach ($dependenciesToReplace as $dep) {
    $contents['replace'][$dep] = '*';
}

$newContents = \json_encode($contents, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL;
file_put_contents($directory . '/composer.json', $newContents);

echo $newContents;

echo "replace-dependencies.php - DONE" . PHP_EOL;
