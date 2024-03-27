<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

class HttpResponse
{
    public static string $apiVersion = "1.0";

    /**
     * Set API version
     * ------------
     */
    public static function setApiVersion(string $apiVersion): static
    {
        static::$apiVersion = $apiVersion;
        return new static;
    }

    /**
     * Success response
     * ------------
     */
    public static function success(
        string $message = null,
        mixed $data = null,
        int $httpCode = JsonResponse::HTTP_OK
    ): JsonResponse {
        return response()->json([
            'status'  => 'success',
            'message' => $message,
            'payload' => $data,
        ], $httpCode)->withHeaders([
            'X-API-Version' => static::$apiVersion,
        ]);
    }

    /**
     * Error response
     * ------------
     */
    public static function error(
        array | string $data = null,
        int $httpCode = JsonResponse::HTTP_INTERNAL_SERVER_ERROR
    ): JsonResponse {
        return response()->json([
            'status'  => 'error',
            'payload' => $data,
        ], $httpCode)->withHeaders([
            'X-API-Version' => static::$apiVersion,
        ]);
    }
}
