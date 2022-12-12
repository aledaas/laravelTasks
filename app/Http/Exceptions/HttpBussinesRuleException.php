<?php

namespace App\Http\Exceptions;

use App\Http\Exceptions\HttpException;
use App\Utils\StringFormatter;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Arr;

final class HttpBussinesRuleException extends HttpException
{
    public function __construct($errors, String $type = 'ERR_BUSSINES_LOGIC')
    {
        parent::__construct();

        $this->statusCode = 422;
        $this->type = $type;
        $this->errors = StringFormatter::arrayValuesToSnakeCase(Arr::flatten((array) $errors));
    }
}
