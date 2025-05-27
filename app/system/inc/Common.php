<?php
function includeParcelFile(string $path): void
{
    if (strpos($_SERVER['HTTP_HOST'], '.loc') === false) {
        $html = file_get_contents($path);
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($html);
        foreach ($doc->getElementsByTagName('*') as $element) {
            if ($oldAttribute = $element->getAttribute('href')) {
                if (strpos($oldAttribute,_SITEDIR_) === false) {
                    $newAttribute = str_replace(['/app/'], _SITEDIR_, $oldAttribute);
                    $element->setAttribute('href', $newAttribute);
                }
            }

            if ($oldAttribute = $element->getAttribute('src')) {
                if (strpos($oldAttribute,_SITEDIR_) === false) {
                    $newAttribute = str_replace(['/app/'], _SITEDIR_, $oldAttribute);
                    $element->setAttribute('src', $newAttribute);
                }
            }
        }
        //remove tags
        $newContent = trim(str_replace([
            '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">',
            '</body>',
            '<html>',
            '<head>',
            '<body>',
            '</body>',
            '</head>',
            '</html>'], '', $doc->saveHTML()));

        echo $newContent;
    } else {
        include $path;
    }
}

/**
 * Function include
 * @param $path
 */
function incFile($path)
{
    include_once(_SYSDIR_ . $path);
}

/**
 * Function check file name
 * @param $name
 * @return bool
 */

function isFileName($name)
{
    if (preg_match("~^(.*)\.([a-z]{2,20})+$~i", $name))
        return true;

    return false;
}

/**
 * Function redirect
 * @param $url
 * @param int $status
 */
function redirect($url, $status = 302)
{
    header('Location: ' . $url, true, $status);
    exit;
}

/**
 * @param $url
 */
function redirectAny($url)
{
    if (Request::isAjax()) {
        Request::addResponse('redirect', false, $url);
        Request::endAjax();
    } else
        redirect($url);
}

/**
 * Function print_data (debug function)
 * @param $data
 */
function print_data($data, $var_dump = false)
{
    echo '<hr/><pre>';
    print_r($data);
    echo '<br>';
    if ($var_dump)
        var_dump($data);
    echo '</pre><hr/>';
}

/**
 * Function errors_control
 */
function errors_control() {
    if (ERRORS_CONTROL == 'all')
        error_reporting(E_ALL);
    else if (ERRORS_CONTROL == 'dev')
        error_reporting(E_ALL & ~E_NOTICE);
    else
        error_reporting(0);

    //ini_set('display_errors', 1);
}

/**
 * Function error404
 * @param null $message
 */
function error404($message = null)
{
    http_response_code(404);
    $template404 = _SYSDIR_ . 'modules/page/views/templates/404.php';

    if (Request::isAjax()) {
        http_response_code(200); // to process response
        Request::addResponse('func', 'alert', '404 - Page not found');
        Request::endAjax();
    }

    if (is_file($template404)) {
        ob_start("viewParser");
        include_once($template404);
        ob_end_flush();

        echo processTemplate(Request::getParam('buffer'));
    } else {
        echo '<div class="wrapper" style="text-align: center;">';
        echo '<h1>NOT FOUND</h1>';
        echo $message;
        echo '</div>';
    }
    exit;
}

/**
 * To display error. Call from Core -> ErrorHandler
 * @param $error
 */
function error_system($error)
{
    // TODO return some error

    echo '<hr>';
        echo '<div><strong style="font-size: 20px;">Error Exception</strong></div>';
        echo '<div><strong>Line:</strong> <span>'. $error['line'] .'</span></div>';
        echo '<div><strong>Message:</strong>'. str_replace(array(PHP_EOL, _BASEPATH_), array('<br>', '../'), $error['message']) .'</div>';
    echo '<hr>';
}

/**
 * To get module path
 * @param $controller
 * @return string|bool
 */
function modulePath($controller)
{
    $controllerArr = explode('/', trim($controller, '/'));
    $path = _SYSDIR_;

    foreach ($controllerArr as $cont)
        if ($cont)
            $path .= 'modules/' .$cont. '/';

    return $path;
}

/**
 * To get child module name
 * @param $controller
 * @return mixed
 */
function moduleName($controller)
{
    $controllerArr = explode('/', trim($controller, '/'));

    return $controllerArr[ count($controllerArr) - 1 ];
}

/**
 * Function filter
 * @param $data
 * @param bool|string $mode :: false|true|int|float|purify|string
 * @return array|int|mixed|string
 */
function filter($data, $mode = true)
{
    if ($mode === false) return $data;

    if (is_array($data)) {
        foreach ($data as $key => $value)
            $data[$key] = filter($value, $mode);

        return $data;
    }

    if ($mode === 'int') return intval($data);
    if ($mode === 'float') return floatval($data);
    if ($mode === 'purify') return HTMLPurifier::purify($data);
    if ($mode === 'json') return Mysqli_DB::$_db->real_escape_string($data);

    if ($mode OR $mode === 'string' OR $mode === true) {
        $data = trim($data, " \t\0\x0B"); // trim chars except \n\r
        $data = reFilter($data); // reFilter if it was filtered before

        if ($mode === true)
            $data = HTMLPurifier::purify($data); // purify HTML

        $search = array("\0");//, "`"
        $replace = array("");//, "\`"
        $data = str_replace($search, $replace, $data); // replace zero symbol

        $data = htmlentities($data, ENT_QUOTES, "UTF-8"); // htmlentities

        if (Mysqli_DB::$_db)
            $data = Mysqli_DB::$_db->real_escape_string($data); // save \n in table as it is(i.e. not replace to new row separator)

        if ($mode === true)
            $data = HTMLPurifier::postClean($data); // clean some elements

        return $data;
    }
}

function is_json($string)
{
    return !empty($string) && is_string($string) && is_array(json_decode($string, true)) && json_last_error() == 0;
}

/**
 * @param $data
 * @return string
 */
function reFilter($data)
{
    //$data = reverse_mysqli_real_escape_string($data);
    //$search = array("\`");
    //$replace = array("`");
    //$data = str_replace($search, $replace, $data);

    return html_entity_decode($data, ENT_QUOTES, 'UTF-8');
}

function reverse_mysqli_real_escape_string($str) {
    return strtr($str, [
        '\0'   => "\x00",
        '\n'   => "\n",
        '\r'   => "\r",
        '\\\\' => "\\",
        "\'"   => "'",
        '\"'   => '"',
        '\Z' => "\x1a"
    ]);
}

/**
 * @param $name
 * @param bool|string $mode
 * @param bool $default
 * @return array|bool|int|mixed|string
 */
function post($name, $mode = true, $default = false)
{
    if (isset($_POST[$name]) && $_POST[$name] === '')
        return '';

    if (isset($_POST[$name])) {
        $value = filter($_POST[$name], $mode);
        return $value ?: $default;
    }

    return $default;
}

/**
 * For int fields
 * @param $name
 * @param int $default
 * @return int
 */
function post_int($name, $default = 0)
{
    if ($_POST[$name] === 0)
        return 0;

    return intval($_POST[$name]) ?: $default;
}


/**
 * Function isPost
 * @return bool
 */
function isPost()
{
    if (count($_POST) > 0)
        return true;

    return false;
}

/**
 * Function allPost
 * @param bool|string $mode
 * @return array|int|mixed|string
 */
function allPost($mode = true)
{
    return filter($_POST, $mode);
}

/**
 * Function get
 * @param $name
 * @param bool $mode
 * @param bool $default
 * @return array|bool|int|mixed|string
 */
function get($name, $mode = true, $default = false, $clearHtml = false)
{
    if (isset($_GET[$name]) && $_GET[$name] === '')
        return '';

    if (isset($_GET[$name])) {
        $value = filter($_GET[$name], $mode);
        return $value ?: $default;
    }

    return $default;
}

/**
 * For int fields
 * @param $name
 * @param int $default
 * @return int
 */
function get_int($name, $default = 0)
{
    if ($_GET[$name] === 0)
        return 0;

    return intval($_GET[$name]) ?: $default;
}

/**
 * Function getSession
 * @param $name
 * @param bool|string $mode
 * @return array|bool|int|mixed|string
 */
function getSession($name, $mode = true)
{
    if (isset($_SESSION[$name]))
        return filter($_SESSION[$name], $mode);

    return false;
}

/**
 * Function setSession
 * @param $name
 * @param $value
 * @param bool|string $mode
 * @return array|int|mixed|string
 */
function setSession($name, $value, $mode = true)
{
    return $_SESSION[$name] = filter($value, $mode);
}

/**
 * Function unsetSession
 * @param $name
 * @return bool
 */
function unsetSession($name)
{
    unset($_SESSION[$name]);
    return true;
}

/**
 * Function getCookie
 * @param $name
 * @param $value
 * @param $time
 * @param bool|string $mode
 * @return bool
 */
function setMyCookie($name, $value, $time, $mode = true)
{
    return setCookie($name, filter($value, $mode), $time, '/');
}

/**
 * Function getCookie
 * @param $name
 * @param bool|string $mode
 * @return array|bool|int|mixed|string
 */
function getCookie($name, $mode = true)
{
    if (isset($_COOKIE[$name]))
        return filter($_COOKIE[$name], $mode);

    return false;
}

/**
 * Function unsetCookie
 * @param $name
 * @return mixed
 */
function unsetCookie($name)
{
    SetCookie($name, '', time() - 3600, '/');
    unset($_COOKIE[$name]);
    return $name;
}

/**
 * @param false $value
 * @param false $default
 * @return false|mixed
 */
function defaultValue($value = false, $default = false) {
    if (!$value)
        return $default;

    return $value;
}

/**
 * @param array $delimiters todo ???
 * @param $string
 * @return array
 */
function multiExplode($delimiters, $string) {

    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}

/**
 * Function checkEmail
 * @param $email
 * @return bool
 */
function checkEmail($email)
{
    if (!preg_match("~^([a-z0-9_\.\-]{1,100})@([a-z0-9\.\-]{1,80})\.([a-z\.]{2,16})+$~i", trim($email)))
        return false;

    return true;
}

/**
 * Function for validation Password Policy
 * @param $pwd
 * @return bool
 */
function checkPassword($pwd) {
    $res = preg_match('#^(?=.*[A-Z])(?=.*[0-9])(?=.*[a-z]).{8,32}$#', $pwd);

    if ($res)
        return true;

    return false;
}

/**
 * Function checkURL
 * @param string $url
 * @return bool
 */
function checkURL($url)
{
    $pattern = "~^(https?:\/\/)?([0-9a-z][0-9a-z\-]+\.[0-9a-z]+)+(.*?)$~i"; // all length
    if (preg_match($pattern, trim($url)))
        return true;

    return false;
}

/**
 * Function checkPhoneNumber
 * @param string $phone
 * @return bool
 */
function checkPhoneNumber($phone)
{
    // Example: Mobile phone format check
    // Here it is assumed that the phone number can start with +, can contain spaces, hyphens and brackets.
    // Format: +7 (123) 456-78-90 or 8-123-456-78-90, etc.
    $pattern = "/^38\\s0\\(?\\d{2}\\)?[\\s\\-]?\\d{3}[\\s\\-]?\\d{2}[\\s\\-]?\\d{2}$/";


    if (preg_match($pattern, trim($phone))) {
        return true;
    }

    return false;
}

/**
 * Function checkLength
 * @param $text
 * @param int $min
 * @param bool $max
 * @return bool
 */
function checkLength($text, $min = 0, $max = FALSE)
{
    $length = mb_strlen($text);

    if ($length >= $min) {
        if ($max != false AND $length > $max)
            return false;

        return true;
    }

    return false;
}

/**
 * @param $time
 * @return false|int
 */
function convertStringTimeToInt($time)
{
    if (!$time)
        return false;

    date_default_timezone_set('UTC');

    // Date
    $dateArr = explode('/', $time);
    if (count($dateArr) !== 3)
        $dateArr = array(0, 0, 0);

    return mktime(0, 0, 0, $dateArr[1], $dateArr[0], $dateArr[2]);
}

/**
 * isPlural - check if is plural return part of text
 * @param $int
 * @param string $text
 * @param string $default
 * @return string
 */
function isPlural($int, $text = 's', $default = '') {

    if (intval($int) > 1)
        return $text;

    return $default;
}

/**
 * Function printTime
 * @param $time
 * @param null $format
 * @return string
 */
function printTime($time, $format = null)
{
    if (is_null($format)) {
        $format = "d.m / H:i";
        return date($format, $time);
    }

    return date($format, $time);
}

/**
 * Function randomHash
 * @return string
 */
function randomHash()
{
    return md5(time().'_'.rand(1000000, 9999999));
}


/**
 * Function printError
 * @param $error
 * @param bool $prefix
 * @param string $separate
 * @return string
 */
function printError($error, $prefix = false, $separate = 'p')
{
    $data = '';
    if ($error) {
        if (is_array($error)) {
            foreach ($error as $value)
            {
                $data .= '<'.$separate.'>';
                $data .= Lang::translate($prefix.$value);
                $data .= '</'.$separate.'>';
            }
        } else {
            $data .= '<'.$separate.'>';
            $data .= Lang::translate($prefix.$error);
            $data .= '</'.$separate.'>';
        }
    }

    return $data;
}

/**
 * Function viewParser
 * @param $buffer
 */
function viewParser($buffer)
{
    // Replace {URL:page/support} to url('page','support')
    // and {LINK:about-us} to url(Route::getRouteByKey('about-us'))
    // and {L:HOME} to Lang::translate('HOME')
    $search = [];
    $replace = [];
    preg_match_all("~{([0-9A-Z_]{1,12}):([0-9A-Za-z_\-//#]+)}~", $buffer, $result);

    foreach ($result[1] as $key => $value) {
        if ($value == 'L') {
            $search[] = '{' . $value . ':' . $result[2][$key] . '}';
            $replace[] = Lang::translate($result[2][$key]);
        } else if ($value == 'URL') {
            $search[] = '{' . $value . ':' . $result[2][$key] . '}';
            $replace[] = url($result[2][$key]);
        } else if ($value == 'LINK') {
            $search[] = '{' . $value . ':' . $result[2][$key] . '}';
            $replace[] = url(rtrim(Route::getRouteByKey($result[2][$key]), '$'));
        }
    }

    // Cache salt
    $search[] = '?(cache)';
    $replace[] = Request::getParam('test_mode') == 'yes' ? '?' . Request::getCacheSalt() : '';

    $buffer = str_replace($search, $replace, $buffer);
    Request::setParam('buffer', $buffer);
}

/**
 * Process template for content pages system
 * @param $content
 * @return string|string[]
 */
function processTemplate($content) {
    // Replace <contentElement name="client-title" type="input"></contentElement>
    // to contentElement('filed-name-in-admin-content', 'type-input-textarea', 'Default text')

    $arrSearch  = []; // it will be replaced
    $arrReplace = []; // will be replaced on
    $arrOptions = []; // options
    $arrDefault = []; // default


    // looking for picture elements
    preg_match_all("~<(pictureElement) (.*?)>.*?<(img)[\n\r\s]+(.*?)>.*?</pictureElement>~s", $content, $pictureResult, PREG_OFFSET_CAPTURE);
    foreach ($pictureResult[1] as $key => $value) {
        $pos = $pictureResult[0][$key][1]; // position of substring
        $arrSearch[$pos] = $pictureResult[0][$key][0];
        $arrDefault[$pos] = '';

        if ($value[0] == 'pictureElement')
            $arrOptions[$pos] = 'type="picture" ' . $pictureResult[2][$key][0];
        else
            $arrOptions[$pos] = '';

        if ($pictureResult[4][$key][0])
            $arrOptions[$pos] .= " " . $pictureResult[4][$key][0];
    }

    // looking for image elements
    preg_match_all("~<(imageElement) (.*?)>~sm", $content, $res, PREG_OFFSET_CAPTURE); // PREG_OFFSET_CAPTURE
    foreach ($res[1] as $key => $value) {
        $pos = $res[0][$key][1]; // position of substring
        $arrSearch[$pos] = $res[0][$key][0];
        $arrDefault[$pos] = '';

        if ($value[0] == 'imageElement')
            $arrOptions[$pos] = 'type="image" ' . $res[2][$key][0];
        else
            $arrOptions[$pos] = '';
    }


    // looking for contentElement's
    preg_match_all("~<contentElement (.*?)>(.*?)</contentElement>~sm", $content, $result, PREG_OFFSET_CAPTURE);
    foreach ($result[1] as $key => $value) {
        $pos = $result[0][$key][1]; // position of substring
        $arrSearch[$pos] = $result[0][$key][0];
        $arrDefault[$pos] = $result[2][$key][0];
        $arrOptions[$pos] = $value[0];
    }

    ksort($arrSearch);

    $counter = 0;
    foreach ($arrSearch as $k => $v)
        $arrReplace[$k] = getContentElement($arrOptions[$k], $arrDefault[$k], $counter++);

    return str_replace($arrSearch, $arrReplace, $content);
}

/**
 * getContentElement - process template element for content pages system
 * @param $options
 * @param bool $defaultContent
 * @param int $position
 * @return bool|string
 */
function getContentElement($options, $defaultContent = false, $position = 0) {
    $properties = []; // properties of tag contentElement
    preg_match_all("~([0-9a-zA-Z_\-]{0,50})=\"([0-9a-zA-Z\/\._\-\| &]{0,250})\"~i", trim($options), $result); // parse options

    foreach ($result[1] as $key => $value)
        $properties[$value] = $result[2][$key];

    // Default type
    if (!isset($properties['type']))
        $properties['type'] = 'textarea';

    // Save default properties
    $propList = $properties;
    unset($propList['type']);
    unset($propList['name']);
    unset($propList['src']);
    unset($propList['height']);
    unset($propList['width']);
    unset($propList['alt']);

    $propRow = '';
    if ($propList)
        foreach ($propList as $k => $v)
            $propRow .= $k . '="' . $v . '" ';

    // Get element
    $contentElement = PageModel::checkContentPage($properties['name']);
    if (!$contentElement) {
        $elData = array(
            'module'        => CONTROLLER,
            'page'          => ACTION,
            'name'          => $properties['name'],
            'content'       => filter($defaultContent),
            'type'          => $properties['type'],
            'image_width'   => $properties['width'] ?: '',
            'image_height'  => $properties['height'] ?: '',
            'video_type'    => $properties['alt'] ?: '', // contain alt text if type = image
            'position'      => $position,
            'time'          => time()
        );

        // Set image content
        if ($properties['type'] == 'image') {
            $elData['content'] = $properties['src'] ?: $defaultContent;

            // Remove dev directory from path
            $pos = strpos($elData['content'], _SITEDIR_);
            if ($pos !== false) {
                $elData['content'] = filter(substr_replace($elData['content'], '/app/', $pos, mb_strlen(_SITEDIR_)));
            }

            $defaultContent = '<img ' . $propRow . ' src="' . rtrim(_DIR_, '/') . reFilter($elData['content']) . '" height="' . $elData['image_height'] . '" width="' . $elData['image_width'] . '" alt="' . $elData['video_type'] . '">';
        }

        // Set picture content
        if ($properties['type'] == 'picture') {
            $elData['content'] = $properties['src'] ?: $defaultContent;

            // Remove dev directory from path
            $pos = strpos($elData['content'], _SITEDIR_);

            if ($pos !== false) {
                $elData['content'] = filter(substr_replace($elData['content'], '/app/', $pos, mb_strlen(_SITEDIR_)));
            }

            $imgSrc = rtrim(_DIR_, '/') . reFilter($elData['content']);

            $pos = false;

            if (strpos($imgSrc, '.') !== false) {
                $pos = strpos($imgSrc, '.');
            }

            $webpSrc = $pos ? substr($imgSrc, 0, $pos) : $imgSrc;

            $defaultContent = '<picture>
                                 <source srcset="' . $webpSrc . '.webp" type="image/webp">
                                 <img src="' . $imgSrc . '" ' . $propRow . ' height="' . $elData['image_height'] . '" width="' . $elData['image_width'] . '" alt="' . $elData['video_type'] . '">
                               </picture>';
        }

        Model::insert('content_pages_tree', $elData);
    } else {
        $defaultContent = reFilter($contentElement->content);

        // Cut text by max-length
        if (in_array('maxlength', $properties))
            $defaultContent = mb_substr($defaultContent, 0, $properties['maxlength']);

        // Update position and type
        if ($contentElement->position != $position OR $contentElement->type != $properties['type'])
            Model::update('content_pages_tree', array('position' => $position, 'type' => $properties['type']), "`id` = '$contentElement->id'");

        // Set image content
        if ($properties['type'] == 'image')
            $defaultContent = '<img ' . $propRow . ' src="' . rtrim(_DIR_, '/') . $defaultContent . '" height="' . $contentElement->image_height . '" width="' . $contentElement->image_width . '" alt="' . $contentElement->video_type . '">';


        if ($properties['type'] == 'picture') {
            $imgSrc = rtrim(_DIR_, '/') . $defaultContent;

            $pos = false;
            if (strpos($imgSrc, '.') !== false)
                $pos = strpos($imgSrc, '.');

            $webpSrc = $pos ? substr($imgSrc, 0, $pos) : $imgSrc;

            $defaultContent = '<picture>
                                 <source srcset="' . $webpSrc . '.webp" type="image/webp">
                                 <img src="' . $imgSrc . '" ' . $propRow . ' height="' . $contentElement->image_height . '" width="' . $contentElement->image_width . '" alt="' . $contentElement->video_type . '">
                               </picture>';
        }
    }

    return $defaultContent;
}

function getImageElement($name, $path, $position = 0, $width = false, $height = false) {

    $imageElement = PageModel::checkContentPage($name);
    if (!$imageElement) {
        // Remove dev directory from path
        $pos = strpos($path, _DIR_ . 'app/');
        if ($pos !== false)
            $path = substr_replace($path, '/app/', $pos, mb_strlen(_DIR_ . 'app/'));

        $elData = array(
            'module'       => CONTROLLER,
            'page'         => ACTION,
            'name'         => $name,
            'content'      => filter($path),
            'type'         => 'image',
            'image_width'  => $width,
            'image_height' => $height,
            'position'     => $position,
            'time'         => time(),
        );

        Model::insert('content_pages_tree', $elData);
    } else {
        $defaultContent = reFilter($imageElement->content);

        // Return path with dev directory
        if (_DIR_ !== '/')
            $defaultContent = rtrim(_DIR_, '/') . $defaultContent;

        // Update position and type
        if ($imageElement->position != $position)
            Model::update('content_pages_tree', ['position' => $position], "`id` = '$imageElement->id'");
    }

    return $defaultContent;
}

function getVideoElement($name, $path, $position = 0, $video_type = 'youtube') {

    $videoElement = PageModel::checkContentPage($name);
    if (!$videoElement) {
        // Remove dev directory from path
        $pos = strpos($path, _DIR_ . 'app/');
        if ($pos !== false)
            $path = substr_replace($path, '/app/', $pos, mb_strlen(_DIR_ . 'app/'));

        $elData = array(
            'module'     => CONTROLLER,
            'page'       => ACTION,
            'name'       => $name,
            'content'    => filter($path),
            'type'       => 'video',
            'video_type' => $video_type,
            'position'   => $position,
            'time'       => time(),
        );

        Model::insert('content_pages_tree', $elData);
    } else {
        $defaultContent = reFilter($videoElement->content);

        // Return path with dev directory
        if ($videoElement->video_type != 'youtube' && _DIR_ !== '/')
            $defaultContent = rtrim(_DIR_, '/') . $defaultContent;

        // Update position and type
        if ($videoElement->position != $position)
            Model::update('content_pages_tree', ['position' => $position], "`id` = '$videoElement->id'");
    }

    return $defaultContent;
}

function getFileElement($name, $path, $position = 0) {

    $fileElement = PageModel::checkContentPage($name);
    if (!$fileElement) {
        // Remove dev directory from path
        $pos = strpos($path, _DIR_ . 'app/');
        if ($pos !== false)
            $path = substr_replace($path, '/app/', $pos, mb_strlen(_DIR_ . 'app/'));

        $elData = array(
            'module'     => CONTROLLER,
            'page'       => ACTION,
            'name'       => $name,
            'content'    => filter($path),
            'type'       => 'file',
            'position'   => $position,
            'time'       => time(),
        );

        Model::insert('content_pages_tree', $elData);
    } else {
        $defaultContent = reFilter($fileElement->content);

        // Return path with dev directory
        if (_DIR_ !== '/')
            $defaultContent = rtrim(_DIR_, '/') . $defaultContent;

        // Update position and type
        if ($fileElement->position != $position)
            Model::update('content_pages_tree', ['position' => $position], "`id` = '$fileElement->id'");
    }

    return $defaultContent;
}

/**
 * @param $url
 * @param null $get
 * @param null $post
 * @param false $headers
 * @param null $custom_method
 * @return bool|string
 */
function get_contents($url, $get = NULL, $post = NULL, $headers = FALSE, $custom_method = NULL)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url . ($get ? "?" . http_build_query($get) : ""));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64; rv:47.0) Gecko/20100101 Firefox/47.0');
    curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE);

    if ($headers && is_array($headers))
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    if ($post) {
        curl_setopt($ch, CURLOPT_POST, TRUE);
        if (is_array($post))
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        else
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }

    if ($custom_method)
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $custom_method);

    $output = curl_exec($ch);
    $info = curl_getinfo($ch);
    $headers = curl_getinfo($ch, CURLINFO_HEADER_OUT);
    if ($ch) curl_close($ch);

    if ($info['http_code'] == 301 || $info['http_code'] == 302) {
        $url = $info['redirect_url'];
        $url_parsed = parse_url($url);
        return (isset($url_parsed)) ? get_contents($url, $get, $post, $headers, $custom_method) : '';
    }

    return $output;
}

/**
 * Function getSiteOG
 * @param $html // receive get_contents() ot file_get_contents() return
 * @param int $specificTags
 * @return array
 */
function getSiteOG($html, $specificTags = 0)
{
    $doc = new DOMDocument();
    @$doc->loadHTML($html);
    $res['title'] = $doc->getElementsByTagName('title')->item(0)->nodeValue;

    foreach ($doc->getElementsByTagName('meta') as $m) {
        $tag = $m->getAttribute('name') ?: $m->getAttribute('property');
        if (in_array($tag, ['description', 'keywords']) || strpos($tag, 'og:') === 0)
            $res[str_replace('og:', '', $tag)] = $m->getAttribute('content');
    }
    return $specificTags ? array_intersect_key($res, array_flip($specificTags)) : $res;
}

/**
 * Function checkYouTubeURL
 * @param $url
 * @return bool
 */
function checkYouTubeURL($url)
{
    if (stripos($url, 'youtube.com') !== false) {
        preg_match('#v=([^\&]+)#is', $url, $m);
        $videoID = $m[1];
    } elseif (stripos($url, 'youtu.be') !== false) {
        preg_match('#/([^?\/]{11})#is', $url, $m);
        $videoID = $m[1];
    } else
        $videoID = false;

    if ($videoID)
        return $videoID;

    return false;
}

/**
 * Function generate random password
 * @param int $length
 * @param bool $alphabet
 * @return string
 */
function randomPassword($length = 6, $alphabet = false) {
    if (!$alphabet)
        $alphabet = '!$@$%;abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

    $pass = array();
    $alphaLength = mb_strlen($alphabet) - 1;

    for ($i = 0; $i < $length; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }

    return implode($pass);
}

/**
 * Function generate token
 * @return string
 */
function genToken() {
    return md5(randomPassword(8) . '__' . time());
}

function getIP() {
    return $_SERVER['REMOTE_ADDR'];
}

/**
 * Function createURL
 * @return string
 */
function url()
{
    $url = '';

    if (func_num_args() > 0)
        $url = implode('/', func_get_args());

    $url = ltrim($url, '/');

    return rtrim(SITE_URL, '/') . '/' . $url;
}

/**
 * @param string $part
 * @param array $get
 * @param array $mergeGet
 * @return string
 */
function buildUrl($part = '', $get = [], $mergeGet = []) {
    if (!is_array($get)) $get = [];
    if (!is_array($mergeGet)) $mergeGet = [];

    $part = trim($part, '/\\ ');
    $get = array_merge($get, $mergeGet);
    $getPart = is_array($get) && !empty($get) ? '?' . http_build_query($get) : '';

    return SITE_URL . $part . $getPart;
}

/**
 * @param string $part
 * @param array $post
 * @param array $mergeGet
 * @return string
 */
function buildAjax($part = '', $post = [], $mergeGet = []) {
    if (!is_array($post)) $post = [];
    if (!is_array($mergeGet)) $mergeGet = [];

    $part = trim($part, '/\\ ');
    $post = array_merge($post, $mergeGet);

    $postPart = "";
    foreach ($post as $k => $v)
        $postPart .= ", '$k=$v'";

    return "load('" . $part . "'" . $postPart . ")";
}


/**
 * Function clearFolder - to recursive clear folder
 * @param $dir
 */
function clearFolder($dir)
{
    foreach (glob($dir . '/*') as $file) {
        if (is_dir($file))
            clearFolder($file);
        else
            unlink($file);
    }
    @rmdir($dir);
}

///**
// * Function clearHtml - to purify HTML from CSS vulnerabilities
// * @param $dirtyHtml
// * @return string
// */
//function clearHtml($dirtyHtml)
//{
//    if (!$dirtyHtml)
//        return '';
//
//    require_once _SYSDIR_ . 'system/lib/htmlpurifier/library/HTMLPurifier.auto.php';
//
//    $config = HTMLPurifier_Config::createDefault();
////    print_data('HTML.Allowed');
////    $config->set('HTML.Allowed', 'p,b,a[href],i');
////    print_data($config->get('HTML.Allowed'));
//    //$config->set('URI.Base', 'http://www.example.com');
//    //$config->set('URI.MakeAbsolute', true)
//    $purifier = new HTMLPurifier($config);
//    return $purifier->purify($dirtyHtml);
//}

/**
 * Analog of JS load()
 * @return string
 */
function load()
{
    $numArgs = func_num_args();
    $argsList = func_get_args();
    $url = func_get_arg(0);

    $value = 'load(\''.$url.'\'';

    for ($i = 1; $i < $numArgs; $i++)
        $value .= ', \''.$argsList[$i].'\'';

    $value .= ');';

    return $value;
}


if (!function_exists('mb_ucfirst')) {
    /**
     * Function mb_ucfirst
     * @param $string
     * @return string
     */
    function mb_ucfirst($string)
    {
        return mb_strtoupper(mb_substr($string, 0, 1)) . mb_substr($string, 1, mb_strlen($string));
    }
}

if (!function_exists('array_key_last')) {
    /**
     * @param $array
     * @return int|string|null
     */
    function array_key_last($array) {
        return key(array_slice($array, -1, 1, true));
    }
}

/* End of file */
