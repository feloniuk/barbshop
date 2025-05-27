<?php


/**
 * Class ConsoleCommandException console command Exception.
 */
class ConsoleCommandException extends Exception
{
    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        $message = ConsoleColor::getColor('e', $message);

        parent::__construct($message, $code, $previous);
    }
}
