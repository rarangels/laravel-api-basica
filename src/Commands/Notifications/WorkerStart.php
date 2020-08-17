<?php

namespace Rarangels\ApiBasica\Commands\Notifications;

use Carbon\Carbon;
use Illuminate\Console\Command;

/**
 * Class StartWorker
 *
 * @package App\Console\Commands
 * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
 */
class WorkerStart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rarangels:worker-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inicializador del worker de las Jobs';

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
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $this->info($this->getPIDoFCommandWindows("php ".base_path()."/artisan queue:work"));
            $process = new ExecuteStartWorker();
            $process->pid = null;
            //$process->run();
        } else {
            $process = new ExecuteStartWorker();
            $process->run();
        }
        if (is_null($process->pid)){
            $this->info(Carbon::now().': El worker de las Jobs se encuentra detenido.');
        }
        $this->info(Carbon::now().': El worker de las Jobs se encuentra en ejecución mediante el PID: '.$process->pid);
    }

    private function getPIDoFCommandWindows($command)
    {
        $this->info(Carbon::now().': soy windows');
        $this->info($command);

        return '1';
    }
}
