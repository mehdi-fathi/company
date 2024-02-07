<?php

namespace App\Response;


class ApiResponse
{
    // ... (setters and getters)

    public static function getResponse(bool $success, string $message = null, $data = null, string $error = null): array
    {

        $out['success'] = $success;

        if (!empty($error)) {
            $out['errors'] = $error;
        }
        if (!empty($message)) {
            $out['message'] = $message;
        }
        if (!empty($data)) {
            $out['data'] = $data;
        }

        return $out;
    }
}
