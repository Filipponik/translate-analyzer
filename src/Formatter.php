<?php

declare(strict_types=1);

namespace Filipponik\TranslateAnalyzer;

class Formatter
{
    // TODO Save to Laravel default directory structure
    public static function createTransactionFiles(string $directoryName, array $keys, array $unsupportedKeys): void
    {
        foreach ($keys as $filename => $key) {
            $info = "<?php\n\nreturn " . var_export($key, true) . ";\n";
            Helper::saveToFile($directoryName, $filename . '.php', $info);
        }

        if (!empty($unsupportedKeys)) {
            $info = implode("\n", $unsupportedKeys);
            Helper::saveToFile($directoryName, 'UNSUPPORTED', $info);
        }
    }
}
