<?php

declare(strict_types=1);

namespace Filipponik\TranslateAnalyzer;

class Helper
{
    /**
     * data_set from illuminate/collections
     *
     * @param $target
     * @param $key
     * @param $value
     * @param bool $overwrite
     * @return mixed
     */
    public static function fillArrayWithDotNotation(&$target, $key, $value, bool $overwrite = true): void
    {
        $segments = is_array($key) ? $key : explode('.', $key);
        $segment = array_shift($segments);

        if (is_array($target)) {
            if ($segments) {
                if (!array_key_exists($segment, $target)) {
                    $target[$segment] = [];
                }

                self::fillArrayWithDotNotation($target[$segment], $segments, $value, $overwrite);
            } elseif ($overwrite || !array_key_exists($segment, $target)) {
                $target[$segment] = $value;
            }
        }
    }

    public static function saveToFile(string $directoryName, string $fileName, string $data)
    {
        if (!is_dir($directoryName)) {
            mkdir($directoryName, 0755, true);
        }
        $file = fopen($directoryName . '/' . $fileName, 'w');
        fputs($file, $data);
        fclose($file);
    }
}
