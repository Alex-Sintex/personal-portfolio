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

            if (($constraints['required'] ?? false) && ($value === null || $this->isEmpty($value))) {
                $this->errors[$field][] = ucfirst($field) . ' es requerido';
                continue;
            }

            if (!$constraints['required'] && ($value === null || $this->isEmpty($value))) {
                continue;
            }

            if (isset($constraints['type'])) {
                $type = $constraints['type'];

                if (!$this->checkType($value, $type)) {
                    $this->errors[$field][] = ucfirst($field) . " debe ser $type";
                    continue;
                }

                // Extra rule: allowed email domains
                if ($type === 'email' && !$this->isAllowedEmailDomain($value)) {
                    $this->errors[$field][] = "Only Gmail, Hotmail, Outlook, or iCloud addresses are allowed";
                }

                // Extra rule: password strength
                if ($type === 'password' && !$this->isStrongPassword($value)) {
                    $this->errors[$field][] = "La contraseña debe ser de al menos 8 caracteres de largo e incluir mayúscula, minúscula, número y carácter especial";
                }
            }

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
            'int' => is_int($value) || (is_string($value) && ctype_digit($value)),
            'float' => is_float($value) || is_numeric($value),
            'bool' => is_bool($value),
            'decimal' => is_numeric($value),
            'date' => $this->validateDate($value),
            'password' => is_string($value),
            'email' => filter_var($value, FILTER_VALIDATE_EMAIL) !== false,
            default => false,
        };
    }

    // Helper: validate date format (Y/m/d) like (2025/06/19)
    protected function validateDate(string $date): bool
    {
        // Accept both Y-m-d and Y/m/d formats
        foreach (['Y-m-d', 'Y/m/d'] as $format) {
            $d = \DateTime::createFromFormat($format, $date);
            if ($d && $d->format($format) === $date) {
                return true;
            }
        }
        return false;
    }

    protected function isAllowedEmailDomain(string $email): bool
    {
        $allowed = ['gmail.com', 'hotmail.com', 'outlook.com', 'icloud.com'];
        $parts = explode('@', $email);
        return count($parts) === 2 && in_array(strtolower($parts[1]), $allowed);
    }

    protected function isStrongPassword(string $password): bool
    {
        return strlen($password) >= 8 &&
            preg_match('/[A-Z]/', $password) &&     // at least 1 uppercase
            preg_match('/[a-z]/', $password) &&     // at least 1 lowercase
            preg_match('/[0-9]/', $password) &&     // at least 1 digit
            preg_match('/[\W_]/', $password);       // at least 1 special char
    }

    /**
     * Casts input values to their expected data types based on validation rules.
     * 
     * This ensures that values like 'decimal', 'int', or 'bool' are correctly converted
     * to their native PHP types (e.g., string "12.50" → float 12.5), matching what the database expects.
     *
     * @param array $data  Input data to be cast.
     * @param array $rules Validation rules with type definitions.
     * @return array Casted data.
     */
    public function cast(array $data, array $rules): array
    {
        foreach ($rules as $field => $constraints) {
            if (!isset($data[$field])) continue;

            $type = $constraints['type'] ?? null;
            switch ($type) {
                case 'decimal':
                case 'float':
                    $data[$field] = (float)$data[$field];
                    break;
                case 'int':
                    $data[$field] = (int)$data[$field];
                    break;
                case 'bool':
                    $data[$field] = (bool)$data[$field];
                    break;
                case 'date':
                    // Convert formats like 2025/06/12 or other to 2025-06-12
                    $data[$field] = date('Y-m-d', strtotime($data[$field]));
                    break;
            }
        }

        return $data;
    }

    /**
     * Sanitize and cast input data in one step for cleaner usage.
     * 
     * @param array $data  Input data.
     * @param array $rules Validation rules.
     * @return array Sanitized and casted data.
     */
    public function sanitizeAndCast(array $data, array $rules): array
    {
        $cleanData = $this->sanitize($data);
        return $this->cast($cleanData, $rules);
    }
}
