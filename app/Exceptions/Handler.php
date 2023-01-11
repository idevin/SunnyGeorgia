<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param Exception $exception
     * @return void
     */
    public function report(\Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request $request
     * @param Exception $exception
     * @return Response
     */
    public function render($request, \Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            if (strpos(strtolower($request->server('HTTP_USER_AGENT')), 'bot') === false) {
                Log::warning('Http url not found', [
                    'path' => $request->path(),
                    'server' => $request->server(),
                    'ip' => $request->ip(),
                    'user' => $request->getUser()
                ]);
            }
            // ajax 404 json feedback
            if ($request->ajax()) {
                return response()->json(['error' => 'Not Found'], 404);
            }
            // normal 404 view page feedback
            return response()->view('errors.404', [], 404);
        }
        if ($exception instanceof ModelNotFoundException) {
            Log::warning('Model not found', [
                'path' => $request->path(),
                'server' => $request->server(),
                'ip' => $request->ip(),
                'user' => $request->getUser()

            ]);
            // ajax 404 json feedback
            if ($request->ajax()) {
                return response()->json(['error' => 'Not Found'], 404);
            }
            // normal 404 view page feedback
            return response()->view('errors.404', [], 404);
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into a response.
     *
     * @param  Request $request
     * @param AuthenticationException $exception
     * @return Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->expectsJson()
            ? response()->json(['message' => $exception->getMessage()], 401)
            : redirect()->guest(route('login'));
    }
}
