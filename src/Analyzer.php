<?php

declare(strict_types=1);

namespace Filipponik\TranslateAnalyzer;

class Analyzer
{
    private array $foundKeys = [];

    private array $incorrectKeys = [];

    // TODO Add optional suffix for file extensions
    private string $suffix = '';

    /**
     * Analyze some directory
     */
    public function analyze(string $path): void
    {
        $keys = array_unique(DirectoryAnalyzer::getKeysFromDirectory($path, []));
        sort($keys);
        $this->createCorrectKeysArray(array_map(fn ($key) => mb_substr($key, 4, -1), $keys));
    }

    /**
     * Create array from dot notation keys array
     */
    private function createCorrectKeysArray(array $inputKeys): void
    {
        foreach ($inputKeys as $inputKey) {
            $currentKeys = [];
            if (mb_strpos($inputKey, '.')) {
                Helper::fillArrayWithDotNotation($currentKeys, $inputKey, $inputKey);
                $this->foundKeys = array_merge_recursive($this->foundKeys, $currentKeys);
            } else {
                $this->incorrectKeys[] = $inputKey;
            }
        }
    }

    public function writeResultsToFiles(string $directoryName = 'analyze_results'): void
    {
        Formatter::createTranslationFiles($directoryName, $this->foundKeys, $this->incorrectKeys);
    }

    public function getFoundKeys(): array
    {
        return $this->foundKeys;
    }

    public function getIncorrectKeys(): array
    {
        return $this->incorrectKeys;
    }
}
