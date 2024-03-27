<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    // use CreatesApplication;

    public string $baseUrl = "api/v1";

    public string $apiValidationErrorsKey = "payload";
}
