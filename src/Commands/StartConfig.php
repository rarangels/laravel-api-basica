<?php

namespace Rarangels\ApiBasica\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

/**
 * Class StartWorker
 *
 * @package App\Console\Commands
 * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
 */
class StartConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rarangels:start-config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inicializador de todas las configuraciones';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (function_exists('database_path')) {
            foreach (glob(database_path('migrations/*.php')) as $file) {
                include_once($file);
            }
            if (! class_exists('CreateJobsTable')) {
                $exit_code = Artisan::call('queue:table');
                if ($exit_code == 0){
                    $this->info('Se ha publicado la migración CreateJobsTable.');
                }
            }
            if (! class_exists('CreateNotificationsTable')) {
                $exit_code = Artisan::call('notifications:table');
                if ($exit_code == 0){
                    $this->info('Se ha publicado la migración CreateNotificationsTable.');
                }
            }
        } else {
            $this->info('Warning: Todas las migraciones necesarias no se han efectuado.');
        }
        $exit_code = Artisan::call('vendor:publish', [
            '--provider' => "Rarangels\ApiBasica\ApiBasicaServiceProvider"
        ]);
        if ($exit_code == 0){
            $this->info('Se han publicado los archivos necesarios en: Config y Migrations. Por favor ejecuta [php artisan migrate] para terminar la instalación de las tablas.');
        }

        $exit_code = Artisan::call('vendor:publish', [
            '--tag' => "laravel-mail"
        ]);
        if ($exit_code == 0){
            $this->info('Se han publicado los archivos necesarios para personalizar el HMTL de los correos electrónicos en [resources/views/vendor/mail]');
        }

        $exit_code = Artisan::call('vendor:publish', [
            '--tag' => "laravel-notifications"
        ]);
        if ($exit_code == 0){
            $this->info('Se han publicado los archivos necesarios para personalizar las notificaciones en [resources/views/vendor/notifications]');
        }
    }
}
