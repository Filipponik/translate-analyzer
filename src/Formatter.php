<?php

declare(strict_types=1);

namespace Filipponik\TranslateAnalyzer;

class Formatter
{
    public static int $spacesPerTabCount = 4;

    public static function createTranslationFiles(string $directoryName, array $keys, array $unsupportedKeys): void
    {
        foreach ($keys as $filename => $key) {
            $customVarExport = self::customVarExport($key);
            $info = "<?php\n\nreturn $customVarExport;\n";

            Helper::saveToFile($directoryName, $filename . '.php', $info);
        }

        if (!empty($unsupportedKeys)) {
            $customVarExport = self::customVarExport($unsupportedKeys, 0, false);
            $info = "<?php\n\nreturn $customVarExport;\n";
            Helper::saveToFile($directoryName, 'UNSUPPORTED.php', $info);
        }
    }

    public static function customVarExport($inputValue, int $spacesCount = 0, bool $withKey = true): string
    {
        if (is_array($inputValue)) {
            $spaces = str_repeat(' ', $spacesCount);
            $summary = "[\n";
            $innerSpacesCount = $spacesCount + self::$spacesPerTabCount;
            $innerSpaces = str_repeat(' ', $innerSpacesCount);

            foreach ($inputValue as $key => $value) {
                $exportedVar  = self::customVarExport($value, $innerSpacesCount);
                $summary .= $withKey
                    ? "$innerSpaces'$key' => $exportedVar,\n"
                    : "$innerSpaces$exportedVar,\n";
            }
            $summary .= $spaces . ']';

            return $summary;
        } else {
            return "'$inputValue'";
        }
    }
}
