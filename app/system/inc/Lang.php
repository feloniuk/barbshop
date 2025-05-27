<?php
/**
 * LANG
 */

class Lang
{
    static public $array = array();
    static public $language = null;

    static public function setLanguage($lang = LANGUAGE)
    {
        if (!$lang)
            $lang = LANGUAGE;

        self::$language = $lang;

        $mainLang = array();
        if (file_exists($langPath = _SYSDIR_.'lang/'.$lang.'.php'))
            $mainLang = include_once($langPath);

        $moduleLang = array();
        if (file_exists($moduleLangPath = _SYSDIR_.'modules/'.CONTROLLER.'/lang/'.$lang.'.php'))
            $moduleLang = include_once($moduleLangPath);

        self::$array = @array_merge($mainLang, $moduleLang);
    }

    static public function translate($key)
    {
        if (array_key_exists($key, self::$array))
            return self::$array[$key];
        else
            return $key;
    }

    static public function translit($text, $case = false)
    {
        $search = array("$", "&", "'", "Ё","Ж","Ч","Ш","Щ","Э","Ю","Я","ё","ж","ч","ш","щ","э","ю","я","А","Б","В","Г","Д","Е","З","И","Й","К","Л","М","Н","О","П","Р","С","Т","У","Ф","Х","Ц","Ь","Ы","а","б","в","г","д","е","з","и","й","к","л","м","н","о","п","р","с","т","у","ф","х","ц","ь","ы","Ґ","ґ","Ї","ї","І","і","Є","є");
        $replace = array("", "", "", "Jo","Zh","Ch","Sh","Sch","Je","Jy","Ja","jo","zh","ch","sh","sch","je","jy","ja","A","B","V","G","D","E","Z","I","J","K","L","M","N","O","P","R","S","T","U","F","H","C","","Y","a","b","v","g","d","e","z","i","j","k","l","m","n","o","p","r","s","t","u","f","h","c","","y","G","g","I","i","I","i","E","e");

        if ($case == 'lower')
            return mb_strtolower(str_replace($search, $replace, $text));
        elseif ($case == 'upper')
            return mb_strtoupper(str_replace($search, $replace, $text));
        else
            return str_replace($search, $replace, $text);
    }

    static public function postTranslate($text)
    {
        $arr1 = array();
        $arr2 = array();

        preg_match_all("~{L:([0-9A-Za-z_//#]+)}~", $text, $array);

        if ($array[1]) {
            foreach ($array[1] as $key => $value) {
                $arr1[] = '{L:'.$array[1][$key].'}';
                $arr2[] = Lang::translate($array[1][$key]);
            }

            return str_replace($arr1, $arr2, $text);
        } else {
            return $text;
        }
    }

}
/* End of file */