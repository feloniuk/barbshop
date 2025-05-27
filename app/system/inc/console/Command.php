<?php

include_once (_SYSDIR_ . 'system/inc/console/src/BaseCommand.php');
include_once (_SYSDIR_ . 'system/inc/console/src/classes/ConsoleColor.php');
include_once (_SYSDIR_ . 'system/inc/console/src/classes/BuildModule.php');
include_once (_SYSDIR_ . 'system/inc/console/src/classes/ConsoleCommandException.php');
include_once (_SYSDIR_ . 'system/inc/console/src/classes/ListCommands.php');

/**
 * Console command processing class.
 */
class Command extends BaseCommand
{
    public function __construct(array $argv = null)
    {
        $argv = $argv ?? $_SERVER['argv'] ?? [];

        // strip the application name
        array_shift($argv);

        parent::__construct($argv);
    }

    /**
     * @throws ConsoleCommandException
     */
    protected function parse()
    {
        if (!$this->arguments) {
            echo $this->printListCommands();

            return;
        }

        if (strpos($this->arguments[0], ':') !== false) {
            list($this->action, $this->build) = explode(':', $this->arguments[0]);
        } else {
            $this->action = $this->arguments[0];
        }

//        $this->action = stristr($this->arguments[0], ':', true);
//        $this->build = ltrim(stristr($this->arguments[0], ':'), ':');

        if (!$this->action) {
            throw new ConsoleCommandException('Incorrect input method. Command not found.');
        }

        switch ($this->action) {
            case 'create':
                $this->runCreateAction();
                break;
            default:
                throw new ConsoleCommandException('Incorrect input method. Command not found.');
        }
    }

    /**
     * @throws ConsoleCommandException
     */
    protected function runCreateAction()
    {
        if (!$this->build) {
            throw new ConsoleCommandException('Incorrect input method. Build argument not found.');
        }

        switch ($this->build) {
            case 'module':
                $this->validateBuildModuleArguments();

                $module = new BuildModule($this->arguments, $this->defaultPath . strtolower($this->arguments[1]));
                echo $module->status;

                break;
            case 'content_module':
                $this->validateBuildModuleArguments();

                $module = new BuildModule($this->arguments, $this->defaultPath . strtolower($this->arguments[1]), 'contentmodule');
                echo $module->status;

                break;
            case 'full_module':
                $this->validateBuildModuleArguments();

                $module = new BuildModule($this->arguments, $this->defaultPath . strtolower($this->arguments[1]), 'fullmodule');
                echo $module->status;

                break;
            default:
                throw new ConsoleCommandException('Incorrect input method. Build argument not exist.');
        }
    }

    private function validateBuildModuleArguments()
    {
        if (!isset($this->arguments[1])) {
            throw new ConsoleCommandException('Please enter the name of the module.');
        }

        if (isset($this->arguments[3])) {
            $path = $this->defaultPath . $this->arguments[3];

            if (!is_dir($path)) {
                throw new ConsoleCommandException('Wrong path. Please enter a valid path.');
            }
        }
    }
}
