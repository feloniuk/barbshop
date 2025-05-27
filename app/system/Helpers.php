<?php

/**
 * Calculate crop block ratio.
 *
 * @param $cropBlockW
 * @param $cropBlockH
 * @param $imgW
 * @param $imgH
 * @return array
 */
function cropImageRatio($cropBlockW, $cropBlockH, $imgW, $imgH) {
    if ($imgH <= $cropBlockH && $imgW <= $cropBlockW) {
        $targetHeight = $imgH;
        $targetWidth = $imgW;

    } else if ($imgH > $cropBlockH && $imgW <= $cropBlockW) {
        $targetHeight = $cropBlockH;
        $hw = round($imgW / $imgH, 6);
        $targetWidth = round($hw * $cropBlockH,0);

    } else if ($imgH <= $cropBlockH && $imgW > $cropBlockW) {
        $targetWidth = $cropBlockW;
        $hw = round($imgH / $imgW, 6);
        $targetHeight = round($hw * $cropBlockW, 0);

    } else if ($imgH > $cropBlockH && $imgW > $cropBlockW) {
        if ($imgH > $imgW) {
            $targetHeight = $cropBlockH;
            $hw = round($imgW / $imgH, 6);
            $targetWidth = round($hw * $cropBlockH,0);
        } else {
            $targetWidth = $cropBlockW;
            $hw = round($imgH / $imgW, 6);
            $targetHeight = round($hw * $cropBlockW, 0);
        }
    }

    return [$targetWidth, $targetHeight];
}

/**
 * The function displays the maximum allowable file size for uploading to the server.
 *
 * @return string
 */
function file_current_max_size(): string
{
    $serverMaxSize = file_upload_max_size();
    $siteMaxSize = FileBase::$allowedFileSize;

    if ($siteMaxSize > $serverMaxSize) {
        return format_bytes($serverMaxSize);
    }

    return format_bytes($siteMaxSize);
}

/**
 * Function is used to determine the maximum allowable file size to be uploaded to the server.
 *
 * https://stackoverflow.com/questions/13076480/php-get-actual-maximum-upload-size
 * @return int
 */
function file_upload_max_size()
{
    static $max_size = -1;

    if ($max_size < 0) {
        // Start with post_max_size.
        $post_max_size = parse_ini_size(ini_get('post_max_size'));

        if ($post_max_size > 0) {
            $max_size = $post_max_size;
        }

        // If upload_max_size is less, then reduce. Except if upload_max_size is zero, which indicates no limit.
        $upload_max = parse_ini_size(ini_get('upload_max_filesize'));

        if ($upload_max > 0 && $upload_max < $max_size) {
            $max_size = $upload_max;
        }
    }

    return $max_size;
}

/**
 * Function is used to parse a string representing the volume or size specified in the ini file.
 *
 * @param $size
 * @return float
 */
function parse_ini_size($size): float
{
    $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
    $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.

    if ($unit) {
        // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
        return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
    } else {
        return round($size);
    }
}

/**
 * Function is intended to format the byte size into a readable format.
 *
 * @param $size
 * @param int $precision
 * @return string
 */
function format_bytes($size, int $precision = 2): string
{
    $base = log($size, 1024);
    $suffixes = array('b', 'Kb', 'Mb', 'Gb', 'Tb');

    return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
}

/**
 * Returns the file format from its name.
 *
 * @param $fileName
 * @return string
 */
function format($fileName): string
{
    return FileBase::format($fileName);
}

/**
 * Helper function for writing content to a file.
 *
 * @param $path
 * @param $data
 * @return int|false
 */
function write($path, $data)
{
    return FileBase::write($path, $data);
}

/**
 * Helper function for writing content to a file.
 *
 * @param $filePath
 * @return false|string
 */
function read($filePath)
{
    return FileBase::read($filePath);
}

/**
 * Function create file.
 * @param $contents
 * @param $pathSystem
 */
function create($contents, $pathSystem)
{
    FileBase::create($contents, $pathSystem);
}

/**
 * Function is used to transliterate text from one alphabet to another.
 *
 * @param string $text
 * @param false|string $case
 * @return false|string|string[]
 */
function translit(string $text, $case = false)
{
    $search = [" ", "<", ">", "\"", "$", "&", "'", "Ё","Ж","Ч","Ш","Щ","Э","Ю","Я","ё","ж","ч","ш","щ","э","ю","я","А","Б","В","Г","Д","Е","З","И","Й","К","Л","М","Н","О","П","Р","С","Т","У","Ф","Х","Ц","Ь","Ы","а","б","в","г","д","е","з","и","й","к","л","м","н","о","п","р","с","т","у","ф","х","ц","ь","ы","Ґ","ґ","Ї","ї","І","і","Є","є"];
    $replace = ["_", "",  "",  "", "", "", "", "Jo","Zh","Ch","Sh","Sch","Je","Jy","Ja","jo","zh","ch","sh","sch","je","jy","ja","A","B","V","G","D","E","Z","I","J","K","L","M","N","O","P","R","S","T","U","F","H","C","","Y","a","b","v","g","d","e","z","i","j","k","l","m","n","o","p","r","s","t","u","f","h","c","","y","G","g","I","i","I","i","E","e"];

    if ($case == 'lower') {
        return mb_strtolower(str_replace($search, $replace, $text));
    } elseif ($case == 'upper') {
        return mb_strtoupper(str_replace($search, $replace, $text));
    } else {
        return str_replace($search, $replace, $text);
    }
}
