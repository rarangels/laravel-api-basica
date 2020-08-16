<?php
/**
 * Created by PhpStorm.
 * User: rarangels
 * Date: 12/08/20
 * Time: 6:59 p. m.
 * Author: Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
 */

namespace Rarangels\ApiBasica;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
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
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    public function boot(Filesystem $filesystem)
    {
        if (function_exists('config_path')) {
            $this->publishes([
                __DIR__.'/../config/api-basica.php' => config_path('api-basica.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../database/migrations/create_applications_table.php.stub' => $this->getMigrationFileName($filesystem),
            ], 'migrations');

            $this->publishes([
                __DIR__.'/../database/migrations/create_configurations_table.php.stub' => $this->getMigrationFileName($filesystem),
            ], 'migrations');
        }

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
        $this->mergeConfigFrom(__DIR__.'/../config/api-basica.php', 'api-basica');
    }

    protected function getMigrationFileName(Filesystem $filesystem): string
    {
        $timestamp = date('Y_m_d_His');

        return Collection::make($this->app->databasePath().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR)->flatMap(function (
                $path
            ) use ($filesystem) {
                return $filesystem->glob($path.'*_create_applications_table.php');
            })->push($this->app->databasePath()."/migrations/{$timestamp}_create_applications_table.php")->first();
    }
}