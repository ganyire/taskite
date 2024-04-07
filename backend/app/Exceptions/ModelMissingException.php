<?php

namespace App\Exceptions;

use App\Services\HttpResponse;
use Exception;

class ModelMissingException extends Exception
{
    public function __construct(
        public int $httpCode = 404,
        public string $model = 'Model'
    ) {
        parent::__construct();
    }

    public function render($request)
    {
        return HttpResponse::error(
            data: __('app.model_missing', ['model' => $this->model]),
            httpCode: $this->httpCode
        );

    }
}
