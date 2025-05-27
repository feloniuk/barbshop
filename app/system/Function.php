<?php

function getFileName($file)
{
    return pathinfo($file)['filename'];
}


function cmpApplies($a, $b)
{
    $a = $a->applies;
    $b = $b->applies;

    if ($a == $b) {
        return 0;
    }

    return ($a < $b) ? -1 : 1;
}

function removeSiteName(string $url) : string
{
    //for dev server
    $url = str_replace(SITE_URL, '', $url);

    if (checkURL($url))
        $url = preg_replace("/^(?:\/\/|[^\/]+)*/", '', $url);

    return trim($url, '/');
}
/**
 * @param $jobId
 * @param $email
 * @return bool
 */
function checkApply($jobId, $email)
{
    if (Model::count('cv_library', "id",
        " `vacancy_id` = $jobId AND `email` = '$email' AND `deleted` = 'no'"))
        return false;
    return true;
}

/**
 * @param $message
 * @param string $file
 * @param string $dir
 */
function Logger($message, $file = 'log.txt', $dir = 'data/logs/')
{
    if (!is_dir(_SYSDIR_ . $dir))
        Storage::mkdir($dir);

    $fullPath = _SYSDIR_ . $dir . $file;
    $file = fopen($fullPath, 'a');
    fwrite($file,  '[' . date('d-m-Y / H:i:s') . ']' . $message . PHP_EOL);
    fclose($file);
}

/**
 * converts properties from objects in array to string
 * @param array $array
 * @param string $property
 * @param string $delimiter
 */
function propertiesToString($array, $property = 'name', $delimiter = ', ')
{
    return implode($delimiter, array_map(function ($item) use ($property) {
        return $item->$property;
    }, $array));
}

function checkCaptcha($secret, $captchaId) {

    try {
        include _SYSDIR_ . 'system/lib/vendor/autoload.php';

        $client = new GuzzleHttp\Client();

        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => $secret,
                'response' => $captchaId,
            ]]);

        $responseCaptcha = json_decode($response->getBody()->getContents());

        if (!$responseCaptcha->success || $responseCaptcha->score <= 0.3)
            return false;

        return true;
    } catch (Exception $e) {
        return false;
    }
}

/**
 * @return false|string
 */
function getReferrerURI() {
    $uri = false;

    $referrer = $_SERVER['HTTP_REFERER'];

    if ($referrer) {
        $length = strlen(SITE_URL);

        $uri = mb_substr($referrer, $length);
    }

    return $uri;
}

/**
 * @param $array
 * @return mixed|string
 */
function arrayToSqlFields($array)
{
    if (is_array($array)) {
        $sqlFields = '';
        foreach ($array as $field) {
            $sqlFields .= "`$field`,";
        }
        $array = rtrim($sqlFields, ',');
    }

    return $array;
}
/**
 * @param $word
 * @return string|string[]|null
 */
function singularize($word)
{
    $singular = array (
        '/(quiz)zes$/i' => '\1',
        '/(matr)ices$/i' => '\1ix',
        '/(vert|ind)ices$/i' => '\1ex',
        '/^(ox)en/i' => '\1',
        '/(alias|status)es$/i' => '\1',
        '/([octop|vir])i$/i' => '\1us',
        '/(cris|ax|test)es$/i' => '\1is',
        '/(shoe)s$/i' => '\1',
        '/(o)es$/i' => '\1',
        '/(bus)es$/i' => '\1',
        '/([m|l])ice$/i' => '\1ouse',
        '/(x|ch|ss|sh)es$/i' => '\1',
        '/(m)ovies$/i' => '\1ovie',
        '/(s)eries$/i' => '\1eries',
        '/([^aeiouy]|qu)ies$/i' => '\1y',
        '/([lr])ves$/i' => '\1f',
        '/(tive)s$/i' => '\1',
        '/(hive)s$/i' => '\1',
        '/([^f])ves$/i' => '\1fe',
        '/(^analy)ses$/i' => '\1sis',
        '/((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$/i' => '\1\2sis',
        '/([ti])a$/i' => '\1um',
        '/(n)ews$/i' => '\1ews',
        '/s$/i' => '',
    );

    $uncountable = array('equipment', 'information', 'rice', 'money', 'species', 'series', 'fish', 'sheep');

    $irregular = array(
        'person' => 'people',
        'man' => 'men',
        'child' => 'children',
        'sex' => 'sexes',
        'move' => 'moves');

    $lowercased_word = strtolower($word);
    foreach ($uncountable as $_uncountable){
        if(substr($lowercased_word,(-1*strlen($_uncountable))) == $_uncountable){
            return $word;
        }
    }

    foreach ($irregular as $_plural=> $_singular){
        if (preg_match('/('.$_singular.')$/i', $word, $arr)) {
            return preg_replace('/('.$_singular.')$/i', substr($arr[0],0,1).substr($_plural,1), $word);
        }
    }

    foreach ($singular as $rule => $replacement) {
        if (preg_match($rule, $word)) {
            return preg_replace($rule, $replacement, $word);
        }
    }

    return $word;
}

/**
 * @param $type
 * @return string
 */
function landingImage($type)
{
    switch ($type) {
        case 'home':
            $img = "home.png";
            break;
        case '2_blocks':
            $img = "2_blocks.png";
            break;
        case '3_blocks':
            $img = "3_blocks.png";
            break;
        case '4_blocks':
            $img = "4_blocks.png";
            break;
        case 'contact_us':
            $img = "contact_us.png";
            break;
        case 'how_it_work':
            $img = "how_it_work.png";
            break;
        case 'map':
            $img = "map.png";
            break;
        case 'picture_text':
            $img = "picture_text.png";
            break;
        case 'testimonials':
            $img = "testimonials.png";
            break;
        case 'text':
            $img = "text.png";
            break;
        case 'video':
            $img = "video.png";
            break;
        case 'video_text':
            $img = "video_text.png";
            break;
        default:
            $img = '';
    }

    return $img;
}


/**
 * Function applicationStatus - for a job application status
 * @param $key
 * @param false $display
 * @return string|string[]
 */
function applicationStatus($key, $display = false)
{
    switch ($key) {
        case 'reviewed':
            $title = "Reviewed";
            $class = "var-1";
            break;
        case 'rejected':
            $title = "Rejected";
            $class = "var-2";
            break;
        case 'interviewed':
            $title = "Interviewed";
            $class = "var-4";
            break;
        case 'spoken':
            $title = "Spoken to Candidate";
            $class = "var-5";
            break;
        case 'shortlisted':
            $title = "Short-listed";
            $class = "var-6";
            break;
        default:
            $title = "Not Reviewed";
            $class = "var-0";
    }

    if ($display){
        return '<div class="fs-item ' . $class . '">' . $title . '</div>';
    } else {
        return [
            'title' => $title,
            'class' => $class
        ];
    }
}

/**
 * @param $row
 * @return string
 */
function landingEditor($row)
{
    switch ($row->type) {
        case 'home':
        case 'video':
        case 'contact_us':
        case 'map':
            break;
        case '2_blocks':
            $id = "setTextareaValue('" . $row->id . "_1');";
            $id .= "setTextareaValue('" . $row->id . "_2');";
            break;
        case '3_blocks':
        case 'how_it_work':
            $id = "setTextareaValue('" . $row->id . "_1');";
            $id .= "setTextareaValue('" . $row->id . "_2');";
            $id .= "setTextareaValue('" . $row->id . "_3');";
            break;
        case '4_blocks':
            $id = "setTextareaValue('" . $row->id . "_1');";
            $id .= "setTextareaValue('" . $row->id . "_2');";
            $id .= "setTextareaValue('" . $row->id . "_3');";
            $id .= "setTextareaValue('" . $row->id . "_4');";
            break;
        case 'testimonials':
            $id = "testimonials.png";
            break;
        case 'text':
        case 'picture_text':
        case 'video_text':
            $id = "setTextareaValue(" . $row->id . ");";
            break;
        default:
            $id = '';
    }

    return $id;
}

function servicesMode($time)
{
    switch ($time) {
        case '0.5':
            return '30 мин';
        case '1':
            return '1 час';
        case '1.5':
            return '1 час 30 мин';
        case '2':
            return '2 часа';
        default:
            return '';
    }

}

/**
 * @param $φA
 * @param $λA
 * @param $φB
 * @param $λB
 * @return float
 */
function calculateTheDistance($φA, $λA, $φB, $λB)
{
    $EARTH_RADIUS = 6372795;

    // перевести координаты в радианы
    $lat1 = $φA * M_PI / 180;
    $lat2 = $φB * M_PI / 180;
    $long1 = $λA * M_PI / 180;
    $long2 = $λB * M_PI / 180;

    // косинусы и синусы широт и разницы долгот
    $cl1 = cos($lat1);
    $cl2 = cos($lat2);
    $sl1 = sin($lat1);
    $sl2 = sin($lat2);
    $delta = $long2 - $long1;
    $cdelta = cos($delta);
    $sdelta = sin($delta);

    // вычисления длины большого круга
    $y = sqrt(pow($cl2 * $sdelta, 2) + pow($cl1 * $sl2 - $sl1 * $cl2 * $cdelta, 2));
    $x = $sl1 * $sl2 + $cl1 * $cl2 * $cdelta;

    $ad = atan2($y, $x);
    $dist = $ad * $EARTH_RADIUS;

    return round($dist, 0);
}

function SalaryJoin($annual_currency, $min_annual_salary, $currency, $min_daily_salary, $hourly_currency, $min_hourly_salary)
{
    $salary = '';
    if ($min_annual_salary)
        $salary .= numberFormatInStr($annual_currency . $min_annual_salary ) . ' per annum' . '</br>';
    if ($min_daily_salary)
        $salary .= numberFormatInStr($currency . $min_daily_salary) . ' per day' . '</br>';
    if ($min_hourly_salary)
        $salary .= numberFormatInStr($hourly_currency . $min_hourly_salary) . ' per hour' . '</br>';

    return $salary;
}

function numberFormatInStr($str) {
    if (preg_match_all('/\d{4,}/', $str, $m)) {

        $arrSearch = [];
        $arrReplace = [];

        foreach ($m[0] as $val) {
            $arrSearch[] = $val;
            $arrReplace[] = number_format($val);
        }

        $str = str_replace($arrSearch, $arrReplace, $str);
    }

    return $str;
}

function activeIF($module, $page = 'index', $return = 'active', $also = true) {
    $isModule = is_array($module) ? in_array(CONTROLLER_SHORT, $module) : CONTROLLER_SHORT === $module;
    $isPage = $page === false ? true : ( is_array($page) ? in_array(ACTION, $page) : ACTION === $page );

//    if ($page === false) {
//        $isPage = true;
//    } else {
//        if (is_array($page)) {
//            $isPage = in_array(ACTION, $page);
//        } else {
//            $isPage = ACTION === $page;
//        }
//    }

    return ($isModule && $isPage && $also) ? $return : false;

//    if (is_array($page)) {
//        if (CONTROLLER === $module && in_array(ACTION, $page))
//            return $return;
//    } else if (CONTROLLER === $module && ACTION === $page) {
//        return $return;
//    }
//
//    return '';
}

/**
 * Use for <select>...</select>
 * ex:
 * <option value="admin" <.?.= checkOptionValue(post('role'), 'admin', User::get('role'); ?.> >Admin</option>
 * @param $field
 * @param $optionValue
 * @param bool $defaultField
 * @param string $default
 * @return string
 */
function checkOptionValue($field, $optionValue, $defaultField = false, $default = '') {

    return (($field && $field === $optionValue) OR (is_array($field) && in_array($optionValue, $field)))
        ? 'selected'
        : ( (($defaultField && $defaultField === $optionValue) OR (is_array($defaultField) && in_array($optionValue, $defaultField)))
            ? 'selected'
            : $default
        );
}

/**
 * Use for checkboxes
 * @param $field
 * @param $optionValue
 * @param false $defaultField
 * @param string $default
 * @return mixed|string
 */
function checkCheckboxValue($field, $optionValue, $defaultField = false, $default = '') {

    return $field && is_array($field) && in_array($optionValue, $field)
        ? 'checked'
        : ($defaultField && is_array($defaultField) && in_array($optionValue, $defaultField)
            ? 'checked'
            : $default
        );
}

/**
 * Function getAvatar
 * @param $id
 * @param null $size
 * @param string $isAvatar
 * @return string
 */
function getAvatar($id, $check = false)
{
    if ($check === false)
        return _SITEDIR_ . 'data/users/' . $id . '/logo.png';

    if (file_exists(_SYSDIR_ . 'data/users/' . $id . '/logo.png'))
        return _SITEDIR_ . 'data/users/' . $id . '/logo.png';

    return false;
}

/**
 * Make slug from row
 * @param $str
 * @return string|string[]|null
 */
function makeSlug($str){
    return (preg_replace('/[^a-z0-9-]+/', '-', strtolower(transliterateIfCyrillic(trim($str)))));
}

function transliterateIfCyrillic(string $text): string {
    // Проверяем, есть ли в строке кириллические символы
    if (preg_match('/[\p{Cyrillic}]/u', $text)) {
        // Таблица транслитерации
        $translitTable = [
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D',
            'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I',
            'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
            'У' => 'U', 'Ф' => 'F', 'Х' => 'Kh', 'Ц' => 'Ts', 'Ч' => 'Ch',
            'Ш' => 'Sh', 'Щ' => 'Shch', 'Ы' => 'Y', 'Э' => 'E', 'Ю' => 'Yu',
            'Я' => 'Ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
            'е' => 'e', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
            'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
            'у' => 'u', 'ф' => 'f', 'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch',
            'ш' => 'sh', 'щ' => 'shch', 'ы' => 'y', 'э' => 'e', 'ю' => 'yu',
            'я' => 'ya'
        ];

        // Выполняем замену символов
        return strtr($text, $translitTable);
    }

    // Если кириллицы нет, возвращаем исходную строку
    return $text;
}

/**
 * @param $url
 * @return string
 */
function processUrl($url) {
    if (!trim($url))
        return '';

    return 'https://' . str_ireplace(['http://', 'https://'], ['', ''], $url);
}

/**
 * Pre-process function of tool url from name
 * @param $name
 * @return string
 */
function processUrlName($name) {
    return urlencode(trim($name));
}

/**
 * Pre-process function of description for blogs, events, jobs, etc
 * @param $desc
 * @param false $lenght
 * @param false $stripTags
 * @param false $reFilter
 * @param false $removeNonCyrillic
 * @return array|mixed|string|string[]|null
 */
function processDesc($desc, $lenght = false, $stripTags = true, $reFilter = true, $removeNonCyrillic = false) {
    if ($reFilter)
        $desc = reFilter($desc);

    if ($stripTags)
        $desc = strip_tags($desc);

    if ($removeNonCyrillic) {
        if ($removeNonCyrillic === true)
            $removeNonCyrillic = "/[^0-9a-z\.,\-_ ]/iu";
        $desc = preg_replace($removeNonCyrillic, '', $desc);
    }

    if ($lenght)
        $desc = mb_substr($desc, 0, $lenght);

    return $desc;
}


/**
 * @param $arr
 * @param string $delimiter
 * @return string
 */
function arrayToString($arr, $delimiter = '|') {
    return $delimiter . implode($delimiter . $delimiter, $arr) . $delimiter;
}

/**
 * @param $str
 * @param string $delimiter
 * @return false|string[]
 */
function stringToArray($str, $delimiter = '|') {
    return explodeString($delimiter . $delimiter, trim($str, $delimiter));
}


function sortArrayByDate($array) {
    usort($array, function($a, $b) {
        return $b['date'] - $a['date'];
    });

    return $array;
}

/**
 * @param $str
 * @param string $separator
 * @return string
 */
function implodeStrArray($str, $separator = ', ', $ucfirst = true) {
    $arr = stringToArray($str);
    if ($ucfirst)
        foreach ($arr as $key => $value)
            $arr[$key] = ucfirst($value);

    return implode($separator, $arr);
}


function removeGetParams($string)
{
    if (mb_strpos($string, '?') !== false) {
        $string = mb_substr($string, 0, mb_strpos($string, '?'));
    }

    return $string;
}

/**
 * Explode string, remove empty elements, trim array elements
 * @param $delimiter
 * @param $str
 * @return false|string[]
 */
function explodeString($delimiter, $str) {
    $array = explode($delimiter, $str);

    foreach ($array as $key => $value) {
        if (empty($value))
            unset($array[$key]);
        else
            $array[$key] = trim($value);
    }

    return $array;
}

/**
 * Return buffer of $fn function
 * @param $fn
 * @return false|string
 */
function ob($fn){
    ob_start();
    $fn();
    return ob_get_clean();
}

/**
 * Birthday in seconds
 * @param $yyyy
 * @param int $mm
 * @param int $dd
 * @return false|int
 */
function getBirthTime($yyyy, $mm = 0, $dd = 0) {
    return mktime(0, 0, 0, $mm, $dd, $yyyy);
}

/**
 * setViewStat - set view statistics
 * @param $prefix
 * @param $entityID
 * @param $table
 * @return bool
 */
function setViewStat($prefix, $entityID, $table): bool
{
    // Add view if no record(viewed_resources[]) in cookies
    if (!($_COOKIE['viewed_resources'][$prefix . $entityID])) {
        setcookie('viewed_resources[' . $prefix . $entityID . ']', 'true', false, '/');

        $data = [
            'entity_id'  => $entityID,
            'user_id'    => User::get('id') ?: 0,
            'referrer'   => mb_substr(getenv("HTTP_REFERER"), 0, 100),
            'ref'        => get('ref') ?: '',
            'ip'         => getenv("REMOTE_ADDR"),
            'time'       => time()
        ];
        Model::insert($table, $data);

        return true;
    }

    return false;
}

/**
 * To make site map of links
 */
function sitemapProcess()
{
    $routesArray = Route::getList();
    $url = trim($_SERVER['REQUEST_URI'], '/');

    // remove get params from url
    if (mb_strpos($url, '?') !== false) {
        $urlArray = explode('?', $url);
        $url = $urlArray[0];
    }

    // check routes and get pattern-name
    foreach ($routesArray as $route) {
        if ($route['controller'] == CONTROLLER && $route['action'] == ACTION) {
            $url = preg_replace("~\(.*?\)~", '{slug}', $route['pattern']);
            $url = str_replace(["/?$~si", "~", "^", "$"], ["", "", "", ""], $url);
        }
    }

    // remove dev directory from path
    if (_DIR_ !== '/')
        $url = str_replace(ltrim(_DIR_, '/'), '', $url);

    // check url exist
    $checkUrl = Model::fetch(Model::select("sitemap", " `link` = '$url'"));
    if (mb_strpos(CONTROLLER, 'panel/') !== false || CONTROLLER == 'panel' || (CONTROLLER == 'page' && ACTION == 'index'))
        $checkUrl = true;

    if (!$checkUrl)
        Model::insert("sitemap", ["link" => $url]);
}

function generateRandomString($length = 16) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getResourceType($type)
{
    switch ($type) {
        case 'seekers':
            return 'Job Seekers';
        case 'employers':
            return 'Employers';
    }
}

/**
 * Get an item from an array using "dot" notation.
 *
 * @param array $array
 * @param string $key
 * @return mixed
 */
function array_get($array, $key)
{
    if (!is_array($array)) {
        return false;
    }

    if (is_null($key) || empty(trim($key))) {
        return false;
    }

    if (array_key_exists($key, $array)) {
        return $array[$key];
    }

    $keys = explode('.', $key);

    $result = $array;

    while ($k = array_shift($keys)) {
        if (empty($result[$k])) {
            $result = '';
        } else {
            $result = $result[$k];
        }
    }

    return $result;
}

/**
 * Determine if a given string starts with a given substring.
 *
 * @param  string  $haystack
 * @param  string|string[]  $needles
 * @return bool
 */
function startsWith($haystack, $needles)
{
    foreach ((array) $needles as $needle) {
        if ($needle !== '' && substr($haystack, 0, strlen($needle)) === (string) $needle) {
            return true;
        }
    }

    return false;
}

/**
 * Determine if a given string ends with a given substring.
 *
 * @param  string  $haystack
 * @param  string|string[]  $needles
 * @return bool
 */
function endsWith($haystack, $needles)
{
    foreach ((array) $needles as $needle) {
        if (substr($haystack, -strlen($needle)) === (string) $needle) {
            return true;
        }
    }

    return false;
}

/* End of file */