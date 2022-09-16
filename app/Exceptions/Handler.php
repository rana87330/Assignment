<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Exceptions\InvalidOrderException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (InvalidOrderException $e, $request) {
            //Could Send Email on any kind of Exception
            // Mail::raw($message, function ($mail) use ($user) {
            //     $mail->from('test@gmail.com');
            //     $mail->to('tech@computan.com')
            //         ->subject('Invalid Exception Triggered');
            // });
            return response()->view('errors.invalid', [], 201);
        });
        $this->renderable(function (NotFoundHttpException $e, $request) {
            //Could Send Email on any kind of Exception
            // Mail::raw($message, function ($mail) use ($user) {
            //     $mail->from('test@gmail.com');
            //     $mail->to('tech@computan.com')
            //         ->subject('Invalid Exception Triggered');
            // });
            return response()->view('errors.404', [], 404);
        });
        $this->renderable(function (ModelNotFoundException $e, $request) {
            //Could Send Email on any kind of Exception
            // Mail::raw($message, function ($mail) use ($user) {
            //     $mail->from('test@gmail.com');
            //     $mail->to('tech@computan.com')
            //         ->subject('Invalid Exception Triggered');
            // });
            return response()->view('errors.404', [], 404);
        });
    
    }

    
}
