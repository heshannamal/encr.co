<?php

namespace App\Services;

class CityCountyLookup
{
    private static $mappings = [];
    private $dataPath;

    public function __construct(?string $dataPath = null)
    {
        $this->dataPath = $dataPath ?? __DIR__.'/../../resources/data/city-counties-ca-wi.json';
    }

    public function lookup(string $city, string $state): ?string
    {
        $state = strtoupper(trim($state, " \t\n\r\0\x0B,"));
        $state = ['CALIFORNIA' => 'CA', 'WISCONSIN' => 'WI'][$state] ?? $state;
        if (!in_array($state, ['CA', 'WI'], true)) {
            return null;
        }
        $city = strtolower(trim(preg_replace('/\s+/', ' ', $city), " \t\n\r\0\x0B,"));
        if (!isset(self::$mappings[$this->dataPath])) {
            if (!is_file($this->dataPath)) {
                throw new \RuntimeException('City/county data file is missing or unreadable. Upload resources/data/city-counties-ca-wi.json and check its file permissions.', 7401);
            }
            $contents = @file_get_contents($this->dataPath);
            if ($contents === false) {
                throw new \RuntimeException('City/county data file is unreadable. Check permissions on resources/data/city-counties-ca-wi.json.', 7401);
            }
            $mapping = json_decode($contents, true);
            if (!is_array($mapping) || !isset($mapping['CA'], $mapping['WI'])) {
                throw new \RuntimeException('City/county data file is invalid. Upload the original resources/data/city-counties-ca-wi.json again.', 7401);
            }
            self::$mappings[$this->dataPath] = $mapping;
        }
        $counties = self::$mappings[$this->dataPath][$state][$city] ?? [];
        if (!is_array($counties)) {
            throw new \RuntimeException('City/county data contains an invalid county list. Upload the original resources/data/city-counties-ca-wi.json again.', 7401);
        }
        return count($counties) === 1 ? $counties[0] : null;
    }
}
