<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Cicloescolar;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        //Se declara en este apartado para que la variable pueda ser accesible para todas las vistas del proyecto.
        $cicloescolars = Cicloescolar::all();
        View::share('sessionopcions',$cicloescolars);
    }
}
