<?php

namespace App\Response;


class ApiResponse
{
    private static $success;
    private static $message;
    private static $data;
    private static $errors;
    private static $meta;

    // ... (setters and getters)

    public static function getResponse(bool $success, string $message = null, $data = null, array $errors = []): array
    {
        self::$success = $success;
        self::$message = $message;
        self::$data = $data;

        $out = [
            'success' => self::$success,
            'message' => self::$message,
            'data' => self::$data,
        ];

        if (!empty(self::$errors)) {
            $out['errors'] = self::$errors;
        }

        if (!empty(self::$meta)) {
            $out['meta'] = self::$meta;
        }

        return $out;
    }
}
