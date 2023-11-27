<?php

namespace Core;

class BaseValidator
{
    public static function make($data, $rules)
    {
        $errors = [];

        foreach ($rules as $key => $rule) {
            $rulesArray = explode('|', $rule);

            foreach ($rulesArray as $rule) {
                $error = self::validate($key, $data[$key], $rule, $data);

                if ($error) {
                    $errors[$key][] = $error;
                }
            }
        }

        return $errors;
    }

    public static function validate($key, $value, $rule, $data)
    {
        $ruleParts = explode(':', $rule);

        switch ($ruleParts[0]) {
            case 'required':
                if (empty($value)) {
                    return "The field $key is required.";
                }
                break;
            case 'email':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    return "The field $key must be a valid email address.";
                }
                break;
            case 'min':
                $minLength = isset($ruleParts[1]) ? (int) $ruleParts[1] : 0;
                if (strlen($value) < $minLength) {
                    return "The field $key must be at least $minLength characters.";
                }
                break;
            case 'max':
                $maxLength = isset($ruleParts[1]) ? (int) $ruleParts[1] : PHP_INT_MAX;
                if (strlen($value) > $maxLength) {
                    return "The field $key must be at most $maxLength characters.";
                }
                break;
            case 'unique':
                $model = 'App\\Models\\'.ucfirst($key);
                $instance = new $model();
                $result = $instance->getByField($key, $value);

                if ($result) {
                    return "The field $key must be unique.";
                }
                break;
            case 'exists':
                $model = 'App\\Models\\'.ucfirst($key);
                $instance = new $model();
                $result = $instance->getByField($key, $value);

                if (!$result) {
                    return "The selected $key is invalid.";
                }
                break;
            case 'confirmed':
                $confirmationKey = $key.'_confirmation';
                if (!isset($data[$confirmationKey]) || $value !== $data[$confirmationKey]) {
                    return "The $key confirmation does not match.";
                }
                break;
            default:
                break;
        }

        return null;
    }
}
