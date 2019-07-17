<?php

namespace App\Classes;

/**
 * Class CsvImporter
 *
 * @package App\Classes
 */
Class CsvImporter
{
    /**
     * Delimiter of the csv
     */
    private const DELIMITER = ';';

    /**
     * Import the csv file
     *
     * @param string $path
     *
     * @return array
     */
    public function import(string $path): array
    {
        $file = file($path);

        return $this->fileToArray($file);
    }

    /**
     * Transform the file into an array
     *
     * @param $file
     *
     * @return array
     */
    private function fileToArray($file): array
    {
        $data = array_map(static function ($file) {
            return str_getcsv($file, self::DELIMITER);
        }, $file);
        // Get the headers and rows separate
        $rows = array_splice($data, 1);
        $headers = array_shift($data);

        // Map the rows to the correct key value so that it can be used in the hydrator
        return array_map(static function ($rows) use ($headers) {
            return array_combine($headers, $rows);
        }, $rows);
    }
}
