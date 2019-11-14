<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(){
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->mapApiTramiteRoutes();
        $this->mapApiRoutesTre();
        $this->mapApiDocenteRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiTramiteRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
            //->middleware(['api', 'auth:api'])
             ->namespace($this->namespace)
             ->group(base_path('routes/tramite/api.php'));
    }

    protected function mapApiRoutesTre(){
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api_tre.php'));
    }

    /**
     * [$namespaceDocente namespace para routes
     * controller docente]
     *
     * @var [type]
     */
    //protected $namespaceDocente = 'App\Http\Controllers\Docente';
    /**
     * [mapApiDocenteRoutes routas para docente]
     *
     * @return  [type]  [return route]
     */
    protected function mapApiDocenteRoutes()
    {
        Route::middleware('api')
            ->namespace($this->namespace)
            ->prefix('api')
            ->group(base_path('routes/docente/route.php'));
    }
}
