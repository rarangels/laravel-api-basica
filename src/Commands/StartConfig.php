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
                $this-$this->info(Artisan::call('queue:table'));
                $this->info('Se ha publicado la migración CreateJobsTable.');
            }
        } else {
            $this->info('Warning: Todas las migraciones necesarias no se han efectuado.');
        }
        Artisan::call('vendor:publish --provider="Rarangels\ApiBasica\ApiBasicaServiceProvider"');
        $this->info('Se han los archivos necesarios en: Config y Migrations. Por favor ejecuta [php artisan migrate] para terminar la instalación de las tablas.');
    }
}
