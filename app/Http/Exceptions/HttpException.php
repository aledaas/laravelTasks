<?php

namespace App\Http\Exceptions;

use Exception;
use Request;
use Str;
use Carbon\Carbon;

abstract class HttpException extends Exception
{
    protected $errCode;

    protected $statusCode;

    protected $identifier;

    protected $type;

    protected $errors;

    public function __construct()
    {
        parent::__construct();
        $this->identifier = $this->setIdentifier();
    }

    public function report()
    {
        \Log::error($this->generateLogMessage());
    }

    public function render($request)
    {
        return response()->json([
            'id'      => $this->identifier,
            'type'    => $this->type,
            'errors'  => $this->errors,
        ], $this->statusCode);
    }

    protected function generateLogMessage()
    {
        return "err_id: {$this->identifier} | err_status: {$this->statusCode} | err_user_id: {$this->getUserId()} | err_message: {$this->message} | err_url: {$this->getRequestMethod()} /{$this->getRequestEndpoint()}";
    }

    protected function getUserId()
    {
        return optional(\Auth::user())->id;
    }

    protected function setIdentifier()
    {
        $timestamp = Carbon::now()->timestamp;
        $random = strtolower(Str::random(32));

        return "{$timestamp}_{$random}";
    }

    protected function getRequestMethod()
    {
        return Request::method();
    }

    protected function getRequestEndpoint()
    {
        return Request::path();
    }
}
