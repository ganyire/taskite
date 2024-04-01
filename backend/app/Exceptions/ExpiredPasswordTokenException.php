<?php

namespace App\Exceptions;

use App\Models\ReportedException;
use App\Services\HttpResponse;
use Exception;
use Illuminate\Http\JsonResponse;

class ExpiredPasswordTokenException extends Exception
{

    /**
     * Report the exception.
     */
    public function report(): void
    {
        ReportedException::create([
            'exception_message' => __('passwords.token_expired'),
            'file'              => $this->getFile(),
            'line'              => $this->getLine(),
            'exception_trace'   => $this->getTraceAsString(),
            'exception_class'   => get_class($this),
        ]);
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request): JsonResponse
    {
        return HttpResponse::error(
            data: __('passwords.token_expired'),
            httpCode: 422
        );
    }
}
