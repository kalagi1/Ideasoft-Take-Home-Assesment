<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
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
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                if ($e->getPrevious() instanceof NotFoundHttpException) {
                    return response()->json([
                        'status' => 204,
                        'message' => 'Data not found'
                    ], 200);
                }
                return response()->json([
                    'status' => 404,
                    'message' => 'Target not found'
                ], 404);
              }
        });

        $this->renderable(function (FormRequestException $e){
            return Response::json([
                "success" => false,
                "errors" => json_decode($e->getMessage())
            ]);
        });

        $this->renderable(function (RouteNotFoundException $e){
            return Response::json([
                "success" => false,
                "errors" => [
                    "unauthorized" => "Ge??ersiz yetki"
                ]
            ]);
        });
    }

}
