<?php

namespace App\Core;

class Sanitize
{
    public static function xss(array $data): ?array
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = self::xss($value);
            } else {
                $data[$key] = htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
            }
        }

        return $data;
    }

    public static function clean(array $data, array $rules): ?array
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                // Aplica a recursão
                $data[$key] = self::clean($value, $rules[$key] ?? null);
            } else {
                $rule = $rules[$key] ?? 'string';

                switch ($rule) {
                    case 'string':
                        $data[$key] = htmlspecialchars(trim((string)$value), ENT_QUOTES, 'UTF-8');
                        break;

                    case 'int':
                    case 'integer':
                        $data[$key] = filter_var($value, FILTER_VALIDATE_INT) !== false ? (int)$value : null;
                        break;

                    case 'email':
                        $data[$key] = filter_var($value, FILTER_VALIDATE_EMAIL) ?: null;
                        break;

                    case 'url':
                        $data[$key] = filter_var($value, FILTER_VALIDATE_URL) ?: null;
                        break;

                    case 'bool':
                    case 'boolean':
                        $data[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
                        break;

                    case 'float':
                        $data[$key] = filter_var($value, FILTER_VALIDATE_FLOAT) !== false ? (float)$value : null;
                        break;
                    
                    // Fallback seguro
                    default:
                        $data[$key] = htmlspecialchars(trim((string)$value), ENT_QUOTES, 'UTF-8');
                        break;
                }
            }
        }

        return $data;
    }
}
