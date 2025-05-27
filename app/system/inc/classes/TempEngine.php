<?php

class TempEngine
{
    public static function processEmail(string $template, array $variables): string
    {
        //regex results
        $elements = self::getElements($template);

        if ($elements)
            $template = self::operatorIF($elements, $template, $variables);


        return str_replace(array_keys($variables), array_values($variables), $template);
    }

    public static function getElements(string $template): array
    {
        preg_match_all("~(@(\D*?)\((.*?)\)@)(.*?)(@\D*?@)~sm", $template, $result);

        return $result;
    }

    private static function operatorIF(array $elements, string $template, array $variables): string
    {
        $placeholders = array_keys($variables);
        /*
         * check if the regex results match the placeholders.
         * If it matches, then we check the value and replace the content
         */
        $arrSearch = [];
        $arrReplace = [];
        //remove tags with contents
        foreach ($elements[3] as $k => $placeholder) {
            if (in_array($placeholder, $placeholders)) {
                if (!$variables[$placeholder]) {
                    $arrSearch[] = $elements[0][$k];
                    $arrReplace[] = '';
                }
            }
        }

        //remove only tags
        foreach ($elements[3] as $k => $placeholder) {
            if (in_array($placeholder, $placeholders)) {
                if ($variables[$placeholder]) {
                    $arrSearch[] = $elements[1][$k];
                    $arrSearch[] = $elements[5][$k];
                    $arrReplace[] = '';
                    $arrReplace[] = '';
                }
            }
        }

        return str_replace($arrSearch, $arrReplace, $template);
    }

}
