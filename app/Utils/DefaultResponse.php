<?php

namespace App\Utils;

class DefaultResponse
{
    public function isSuccess($message, $statusCode)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
        ], $statusCode);
    }

    public function successWithContent($message, $statusCode, $content)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $content,
        ], $statusCode);
    }
}