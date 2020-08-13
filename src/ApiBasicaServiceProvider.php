<?php
/**
 * Created by PhpStorm.
 * User: rarangels
 * Date: 12/08/20
 * Time: 6:59 p. m.
 * Author: Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
 */
namespace Rarangels\ApiBasica;

use Illuminate\Support\ServiceProvider;

/**
 * Class RarangelsApiBasicaServiceProvider
 *
 * @package Rarangels\ApiBasica
 * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
 */
class ApiBasicaServiceProvider extends ServiceProvider
{
    /**
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    public function boot(){
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\Notifications\WorkerStart::class,
            ]);
        }
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}