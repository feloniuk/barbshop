<?php

include_once _SYSDIR_ . 'system/inc/editorjsBuilder/Builder.php';

/**
 * HTML markup builder class from JSON.
 *
 * Class EditorJsBuilder
 */
class EditorJsBuilder
{
    /**
     * @param string $json
     * @return string
     */
    public static function build(string $json): string
    {
        $builder = new Builder($json);

        try {
            $builder->processJson();

            return $builder->getBlocks();
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
}
