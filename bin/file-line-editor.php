<?php
function editFileLines(array $fileLineMap) {
    foreach ($fileLineMap as $file => $lineChanges) {
        $lines = file($file);

        foreach ($lineChanges as $lineNumber => $newContent) {
            if (isset($lines[$lineNumber - 1])) {
                $lines[$lineNumber - 1] = $newContent . PHP_EOL;
            } else {
                echo "Line {$lineNumber} does not exist in file {$file}.\n";
            }
        }

        file_put_contents($file, implode('', $lines));
        echo "File {$file} modified successfully!\n";
    }
}

$fileLineMap = [
    (__DIR__ . '/../vendor/cycle/entity-behavior/src/Hook.php') => [
        26 => '#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_CLASS), NamedArgumentConstructor]'
    ],
];

editFileLines($fileLineMap);
