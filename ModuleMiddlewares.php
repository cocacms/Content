<?php
namespace Module\Content;

use App\Http\Middleware\ModuleMiddlewareBase;
use Module\Content\Middlewares\PagerActiveMiddleware;

class ModuleMiddlewares
{
    use ModuleMiddlewareBase;
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [

    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web'=>[
            PagerActiveMiddleware::class
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [

    ];

}