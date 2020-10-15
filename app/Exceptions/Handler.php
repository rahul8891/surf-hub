<?php

namespace App\Exceptions;
use App\Exceptions\Handler;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Exceptions\CustomException;
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
        'email',
        'user_type',
        'status',
        'account_type'
    ];
    
    
    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {       
                
    }
}
