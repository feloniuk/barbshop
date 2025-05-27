<?php

/**
 * Class ConsoleColor for processing the output in status colors in the console.
 */
class ConsoleColor
{
    /**
     * Returns a string in the given color.
     *
     * <p>
     *      <strong>List of statuses of the $status parameter:</strong></br>
     *      <ul>
     *          <li><strong>error</strong> = 'e'</li>
     *          <li><strong>success</strong> = 's'</li>
     *          <li><strong>warning</strong> = 'w'</li>
     *          <li><strong>info</strong> = 'i'</li>
     *      </ul>
     * </p>
     * @param $status
     * @param $str
     * @return string
     */
    static public function getColor($status, $str): string
    {
        return self::colorProcessing($status, $str);
    }

    /**
     * Color identification by status.
     *
     * @param $status
     * @param $str
     * @return string
     */
    static private function colorProcessing($status, $str): string
    {
        switch ($status) {
            case 'e':
                return "\033[31m$str \033[0m\n";
            case 's':
                return "\033[32m$str \033[0m\n";
            case 'w':
                return "\033[33m$str \033[0m\n";
            case 'i':
                return "\033[36m$str \033[0m\n";
        }
    }
}