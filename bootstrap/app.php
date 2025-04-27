<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Database\QueryException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) 
            {
                return response()->json([
                    'message' => 'Route does not exist.'
                ], 404);
            }
        });

        $exceptions->render(function (QueryException $e, Request $request) {
            if ($request->is('api/*')) 
            {
                return response()->json([
                    "success" => false,
                    "message" => $e->getMessage()
                ], 500);
            }
        });
        
        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($request->is('api/*')) 
            {
                return response()->json([
                    "success" => false,
                    "message" => $e->getMessage()
                ], 405);
            }
        });
        
        $exceptions->render(function (ErrorException $e, Request $request) {
            if ($request->is('api/*')) 
            {
                return response()->json([
                    "success" => false,
                    "message" => $e->getMessage()
                ], 500);
            }
        });
    })->create();
