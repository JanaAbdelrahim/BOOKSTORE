<?php

class Request
{

    public static function all(): array
    {
        $json = json_decode(file_get_contents('php://input'), true);

        $allData = array_merge(
            $_GET,
            $_POST,
            is_array($json) ? $json : []
        );

        unset($allData["url"]);
        return $allData;
    }

    
    public static function input(string $key, mixed $default = null): mixed
    {
        return self::all()[$key] ?? $default;
    }


public static function validate(array $rules): array
{
    $validator = new validation(self::all(), $rules);
    $errors = $validator->validate();

    $sensitiveFields = ['password'];
    $_SESSION["_old"] = array_diff_key(self::all(), array_flip($sensitiveFields));

    $_SESSION["_errors"] = $errors;
    return $errors;
}
    public static function isFile(string $fileName)
    {
        return isset($_FILES[$fileName]) && !empty($_FILES[$fileName]['tmp_name']);
    }

    public static function file(string $fileName)
    {
        return $_FILES[$fileName];
    }

    public static function page(string $key = 'page'): int
    {
        $page = (int) self::input($key, 1);
        if ($page < 1) {
            $page = 1;
        }
        return $page;
    }
}