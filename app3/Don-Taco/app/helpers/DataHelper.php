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
}
