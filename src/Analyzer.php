<?php

declare(strict_types=1);

namespace Filipponik\TranslateAnalyzer;

class Analyzer
{
    private array $foundKeys = [];

    private array $incorrectKeys = [];

    private string $suffix = '';

    /**
     * Analyze some directory
     */
    public function analyze(string $path): self
    {
        $keys = array_unique(DirectoryAnalyzer::getKeysFromDirectory($path, [], $this->suffix));
        sort($keys);
        $this->createCorrectKeysArray(array_map(fn ($key) => mb_substr($key, 4, -1), $keys));

        return $this;
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

    public function writeResultsToFiles(string $directoryName = 'analyze_results'): self
    {
        Formatter::createTranslationFiles($directoryName, $this->foundKeys, $this->incorrectKeys);

        return $this;
    }

    public function writeResultsToLaravelFiles(array $languages): self
    {
        foreach ($languages as $languageName) {
            Formatter::createTranslationFiles("../lang/$languageName", $this->foundKeys, $this->incorrectKeys);
        }

        return $this;
    }

    public function getFoundKeys(): array
    {
        return $this->foundKeys;
    }

    public function getIncorrectKeys(): array
    {
        return $this->incorrectKeys;
    }

    public function setSuffix(string $suffix): Analyzer
    {
        $this->suffix = $suffix;
        return $this;
    }
}
