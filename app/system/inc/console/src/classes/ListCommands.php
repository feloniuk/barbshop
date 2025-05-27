<?php


class ListCommands
{
    private static string $path = _SYSDIR_ . 'system/inc/console/templates/list_commands.json';

    public static function getList(): string
    {
        $lists = read(self::$path);

        if (!$lists) {
            return '';
        }

        $result = '';
        $lists = json_decode($lists);

        foreach ($lists as $value) {
            $result .= "\n\033[32m$value->name\033[0m     $value->description\n";

            if ($value->example) {
                $result .= "\033[36m\tUsage example:\033[0m \tphp command create:module <name module> <panel/modules/>\n";
            }

            if ($value->options) {
                $result .= "\033[36m\tOptions:\033[0m\n";

                foreach ($value->options as $option) {
                    $result .= "\t\t\033[33m$option->name\033[0m$option->description\n";
                }
            }
        }

        return $result;
    }
}