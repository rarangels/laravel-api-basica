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
use Illuminate\View\Compilers\BladeCompiler;

/**
 * Class RarangelsApiBasicaServiceProvider
 *
 * @package Rarangels\ApiBasica
 * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
 */
class ApiBasicaServiceProvider extends ServiceProvider
{
    /**
     * @var string[]
     */
    private $migrations = [
        'create_applications_table.php',
        'create_applications_tokens_table.php',
        'create_configurations_table.php',
    ];

    /**
     * @var string[]
     */
    private $seeders = [
        'ApplicationsSeeder.php',
    ];


    /**
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    public function boot(Filesystem $filesystem)
    {
        if (function_exists('config_path')) {
            $this->publicConfigurations();
        }
        $this->publicMigrations($filesystem);

        $this->publicSeeders();

        $this->publicCommands();
    }

    /**
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    private function publicConfigurations()
    {
        $this->publishes([
            __DIR__.'/../config/api-basica.php' => config_path('api-basica.php'),
        ], 'config');
    }

    /**
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    private function publicSeeders()
    {
        foreach ($this->seeders as $seeder) {
            $this->publishes([
                __DIR__.'/../database/seeds/'.$seeder.'.stub' => $this->getSeederFileName($seeder),
            ], 'seeds');
        }
    }

    /**
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    private function publicMigrations(Filesystem $filesystem)
    {
        foreach ($this->migrations as $migration) {
            $this->publishes([
                __DIR__.'/../database/migrations/'.$migration.'.stub' => $this->getMigrationFileName($filesystem, $migration),
            ], 'migrations');
        }
    }

    /**
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    private function publicCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\Notifications\WorkerStart::class,
                Commands\StartConfig::class,
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

        $this->registerBladeExtensions();
    }

    /**
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     * @param $migration
     * @return string
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    protected function getMigrationFileName(Filesystem $filesystem, $migration): string
    {
        $timestamp = date('Y_m_d_His');

        return Collection::make($this->app->databasePath().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR)->flatMap(function (
            $path
        ) use ($filesystem, $migration) {
            return $filesystem->glob($path.'*_'.$migration);
        })->push($this->app->databasePath()."/migrations/{$timestamp}_{$migration}")->first();
    }

    /**
     * @param $seeder
     * @return string
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    protected function getSeederFileName($seeder): string
    {
        return $this->app->databasePath().DIRECTORY_SEPARATOR.'seeds'.DIRECTORY_SEPARATOR.$seeder;
    }

    /**
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    protected function registerBladeExtensions()
    {
        $this->app->afterResolving('blade.compiler', function (BladeCompiler $bladeCompiler) {
            $bladeCompiler->directive('money', function ($amount) {
                return "<?php echo money($amount); ?>";
            });
            $bladeCompiler->directive('percentage', function ($amount) {
                return "<?php echo percentage($amount); ?>";
            });
        });
    }
}