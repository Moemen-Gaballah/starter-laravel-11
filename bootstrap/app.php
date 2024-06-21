<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
//        web: __DIR__.'/../routes/web.php',
        using: function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
            Route::middleware('api')
                ->prefix('api/admin')
                ->group(base_path('routes/admin.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        },
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
//        $exceptions->render(function (ModelNotFoundException $e, \Illuminate\Http\Request $request) {
//            $model = strtolower(class_basename($e->getModel()));
//            return response()->json([
//                'data' => null,
//                'status' => 404,
//                'message' => 'itemNotFound', ucfirst($model) . ' Not Found!', '404',
//            ], 404);
//
//        });

        $exceptions->render(function (NotFoundHttpException $e, \Illuminate\Http\Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'data' => null,
                    'status' => 404,
                    'message' => 'Record not found.',
                ], 404);
            }
        });

    })->create();
