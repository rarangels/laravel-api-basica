<?php
/**
 * Created by PhpStorm.
 * User: rarangels
 * Date: 8/07/20
 * Time: 10:07 a. m.
 * Author: Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
 */

namespace Rarangels\ApiBasica\Commands\Notifications;

/**
 * Class ExecuteStartWorker
 *
 * @package App\Helpers\Classes
 * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
 */
class ExecuteStartWorker
{
    /**
     * @var
     */
    public $pid;

    /**
     * @var string
     */
    private $command;

    /**
     * @var string
     */
    private $command_complement;

    /**
     * ExecuteStartWorker constructor.
     */
    public function __construct()
    {
        $this->command = "php ".base_path()."/artisan queue:work";
        $this->command_complement = " >> ".storage_path()."/logs/jobs.log 2>&1 &";
        //$this->run();
    }

    /**
     * @param $command
     * @return string
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    private function new_process($command): string
    {
        $this->executeCommand($command);

        return $this->getPIDofCommand($this->command);
    }

    /**
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    public function run(): void
    {
        $output = $this->getPIDofCommand($this->command);
        if (is_null($output)) {
            $output = $this->new_process($this->command.$this->command_complement);
        }
        $this->pid = (int) $output;
    }

    /**
     * @param $command
     * @return string|null
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    private function executeCommand($command)
    {
        return shell_exec($command);
    }

    /**
     * @param $command
     * @return int|null
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    private function getPIDofCommand($command)
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return $this->getPIDoFCommandWindows($command);
        } else {
            return $this->getPIDoFCommandLinux($command);
        }
    }

    /**
     * @param $command
     * @return int|null
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    private function getPIDoFCommandLinux($command)
    {
        $result = $this->executeCommand('pgrep -af "'.$command.'"');

        $processes = explode(PHP_EOL, $result);
        foreach ($processes as $index => $process) {
            $pid = intval(preg_replace('/[^0-9]\s+/', '', $process));
            $comando = str_replace($pid.' ', '', $processes[$index]);
            if ($command === $comando) {
                return $pid;
            }
        };

        return null;
    }

    /**
     * @param $command
     * @return string
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    private function getPIDoFCommandWindows($command)
    {
        return '1';
    }
}
