<?php

namespace App\Helpers;

class DataHelper
{
    /**
     * Sets default 0.00 for all decimal fields that are empty or non-numeric.
     * @param array $data  Incoming data
     * @param array $rules Validation rules (with type info)
     * @return array
     */
    public static function setDecimalDefaults(array $data, array $rules): array
    {
        foreach ($rules as $field => $rule) {
            if (($rule['type'] ?? null) === 'decimal') {
                if (empty($data[$field]) || !is_numeric($data[$field])) {
                    $data[$field] = 0.00;
                }
            }
        }
        return $data;
    }

    /**
     * Compares a cleaned/formatted input array with a DB record object.
     * Returns true if any value is different (after applying normalization).
     *
     * @param array $input Cleaned user input
     * @param object $record DB record (as stdClass or object)
     * @param array $map Keys: input → DB field
     * @return bool
     */
    public static function hasChanges(array $input, object $record, array $map): bool
    {
        foreach ($map as $inputKey => $dbKey) {
            $inputVal = $input[$inputKey] ?? null;
            $dbVal    = $record->$dbKey ?? null;

            // Normalize both
            if (is_numeric($inputVal)) $inputVal = (float)$inputVal;
            if (is_numeric($dbVal))    $dbVal    = (float)$dbVal;

            if ($inputVal !== $dbVal) {
                return true;
            }
        }

        return false;
    }
}
