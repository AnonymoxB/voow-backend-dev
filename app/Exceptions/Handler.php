<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {

        });


        $this->renderable(function (\Illuminate\Database\Eloquent\ModelNotFoundException $e, $request) {
            if ($request->is('api/*')) {
                return ResponseBuilder::asError(404)
                    ->withHttpCode(404)
                    ->withMessage($e)
                    ->build();
            }
        });

        $this->renderable(function (\Illuminate\Auth\Access\AuthorizationException $e, $request) {
            if ($request->is('api/*')) {
                return ResponseBuilder::asError(403)
                    ->withHttpCode(403)
                    ->withMessage("Forbidden")
                    ->build();
            }
        });


        $this->renderable(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
                return ResponseBuilder::asError(401)
                    ->withHttpCode(401)
                    ->withMessage("Unauthenticated")
                    ->build();
            }
        });


        $this->renderable(function (\Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException $e, $request) {
            if ($request->is('api/*')) {
                return ResponseBuilder::asError(405)
                    ->withHttpCode(405)
                    ->withMessage("Method Not Allowed")
                    ->build();
            }
        });

        $this->renderable(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return ResponseBuilder::asError(404)
                    ->withHttpCode(404)
                    ->withMessage($e->getMessage())
                    ->build();
            }
        });
    }
}
