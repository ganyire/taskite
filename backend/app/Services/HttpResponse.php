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
    public static function setApiVersion(string $apiVersion)
    {
        self::$apiVersion = $apiVersion;
        return new self;
    }

    /**
     * Success response
     * ------------
     */
    public static function success(
        string $message = null,
        mixed $data = null,
        int $httpCode = JsonResponse::HTTP_OK
    ) {
        return response()->json([
            'status'  => 'success',
            'message' => $message,
            'payload' => $data,
        ], $httpCode)->withHeaders([
            'X-API-Version' => self::$apiVersion,
        ]);
    }

    /**
     * Error response
     * ------------
     */
    public static function error(
        array | string $data = null,
        int $httpCode = JsonResponse::HTTP_INTERNAL_SERVER_ERROR
    ) {
        return response()->json([
            'status'  => 'error',
            'payload' => $data,
        ], $httpCode)->withHeaders([
            'X-API-Version' => self::$apiVersion,
        ]);
    }
}
