<?php

/**
 * BaseCommand base class for console commands.
 */
abstract class BaseCommand
{
    protected array $arguments = [];
    protected string $action;
    protected string $build;
    protected string $defaultPath = _SYSDIR_ . 'modules/panel/modules/';

    public function __construct(array $arguments = [])
    {
        $this->action = '';
        $this->build = '';
        $this->arguments = $arguments;

        $this->parse();
    }

    abstract protected function parse();

//    public function bind()
//    {
//        $this->parse();
//    }


    /**
     * Returns the entire list of available commands if no command is entered.
     *
     * @return string
     */
    public function printListCommands(): string
    {
        return ListCommands::getList();
    }
}