<?php

namespace App\helpers;

class Validator
{
    protected $errors = [];

    // Validate data against rules
    public function validate(array $data, array $rules): bool
    {
        $this->errors = [];

        foreach ($rules as $field => $constraints) {
            $value = $data[$field] ?? null;

            // If field is required but missing or empty
            if (($constraints['required'] ?? false) && ($value === null || $this->isEmpty($value))) {
                $this->errors[$field][] = ucfirst($field) . ' is required';
                continue;
            }

            // Skip validation if field not required and empty or missing
            if (!$constraints['required'] && ($value === null || $this->isEmpty($value))) {
                continue;
            }

            // Type checks
            if (isset($constraints['type'])) {
                $type = $constraints['type'];
                if (!$this->checkType($value, $type)) {
                    $this->errors[$field][] = ucfirst($field) . " must be a $type";
                    continue;
                }
            }

            // Max length check (only for strings)
            if (isset($constraints['max']) && is_string($value)) {
                if (strlen((string)$value) > $constraints['max']) {
                    $this->errors[$field][] = ucfirst($field) . " must be at most {$constraints['max']} characters";
                }
            }
        }

        return empty($this->errors);
    }

    // Return errors
    public function errors(): array
    {
        return $this->errors;
    }

    // Sanitize all data fields (htmlspecialchars)
    public function sanitize(array $data): array
    {
        $clean = [];
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $clean[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            } else {
                $clean[$key] = $value;
            }
        }
        return $clean;
    }

    // Helper: check if value is empty (null, empty string, empty array)
    protected function isEmpty($value): bool
    {
        return $value === null || (is_string($value) && trim($value) === '') || (is_array($value) && empty($value));
    }

    // Helper: check type
    protected function checkType($value, string $type): bool
    {
        return match ($type) {
            'string' => is_string($value),
            'numeric' => is_numeric($value),
            'int' => is_int($value),
            'float' => is_float($value),
            'bool' => is_bool($value),
            default => false,
        };
    }
}
