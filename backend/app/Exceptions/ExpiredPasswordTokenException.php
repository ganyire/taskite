<?php

namespace App\Exceptions;

use App\Services\HttpResponse;
use Exception;
use Illuminate\Http\JsonResponse;

class ExpiredPasswordTokenException extends Exception
{
    public function render($request): JsonResponse
    {
        return HttpResponse::error(
            data: __('passwords.token_expired'),
            httpCode: 422
        );
    }
}
