<?php
/**
 * REQUEST
 */

class Request
{
    static public $route        = [];
    static public $uri          = []; // Array of uri parts

    static public $title        = ''; // Title of page
    static public $keywords     = ''; // Keywords of page
    static public $description  = ''; // Description of page
    static public $canonical    = false; // Canonical of page
    static public $imageOG      = false; // OG image of page

    static public $param        = [];
    static public $ajaxParam    = false; // if true - not add responses like: url, title, content, scrollToEl
    static public $ajaxResponse = array(
        'error'     => [],
        'error_res' => [],
        'res'       => []
    );


    /**
     * @param $value
     */
    static public function setUri($value)
    {
        self::$uri = $value;
    }

    /**
     * @param bool $num
     * @return array
     */
    public static function getUri($num = false)
    {
        if ($num === false)
            return self::$uri;

        return self::$uri[$num] ?? null;
    }


    // Param

    /**
     * @param $key
     * @param $value
     */
    static public function setParam($key, $value)
    {
        self::$param[$key] = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    static public function getParam($name)
    {
        return self::$param[$name] ?? null;
    }


    // Title, Keywords, Description, Canonical

    /**
     * @param $title
     * @param bool $translate
     */
    static public function setTitle($title, $translate = true)
    {
        if ($translate !== false)
            $title = Lang::translate($title);

        self::$title = $title;
    }

    /**
     * @return mixed
     */
    static public function getTitle()
    {
        return self::$title;
    }

    /**
     * @param $keywords
     * @param bool $translate
     */
    static public function setKeywords($keywords, $translate = true)
    {
        if ($translate !== false)
            $keywords = Lang::translate($keywords);

        self::$keywords = $keywords;
    }

    /**
     * @return string
     */
    static public function getKeywords()
    {
        return self::$keywords;
    }

    /**
     * @param $description
     * @param bool $translate
     */
    static public function setDescription($description, $translate = true)
    {
        if ($translate !== false)
            $description = Lang::translate($description);

        self::$description = $description;
    }

    /**
     * @return string
     */
    static public function getDescription()
    {
        return self::$description;
    }

    /**
     * @param string $canonical
     * @param bool $is_route
     */
    static public function setCanonical(string $canonical, bool $is_route = false) : void
    {
        if ($is_route)
           $canonical = Route::getRouteByKey($canonical);

        self::$canonical = $canonical;
    }

    /**
     * @return string
     */
    static public function getCanonical()
    {
        return self::$canonical;
    }

    /**
     * @param $imagePath
     */
    static public function setImageOG($imagePath)
    {
        self::$imageOG = SITE_URL . trim($imagePath, '/');
    }

    /**
     * @return mixed
     */
    static public function getImageOG()
    {
        return self::$imageOG;
    }


    // AJAX

    /**
     * Function isAjax - use when you want check ajax request
     * @return bool
     */
    static public function isAjax()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
            return true;

        return false;
    }

    /**
     * @return bool
     */
    static public function isAjaxPart()
    {
        return self::$ajaxParam;
    }

    /**
     * ajaxPart - call it to not add responses like: url, title, content, scrollToEl
     * @param bool $status
     * @return bool
     */
    static public function ajaxPart($status = true)
    {
        if ($status !== true)
            $status = false;

        self::ajaxOnly();

        return self::$ajaxParam = $status;
    }

    /**
     * Function ajaxOnly - return error404 if not ajax request
     */
    static public function ajaxOnly()
    {
        if (!Request::isAjax())
            error404();
    }

    /**
     * function isError - check added through Request::addError('f_name', 'Name must be filled (max 30 chars)');
     * @return bool
     */
    static public function isError()
    {
        if (self::$ajaxResponse['error'])
            return true;

        return false;
    }

    /**
     * @param bool $key
     * @param bool $value
     */
    static public function addError($key = false, $value = false)
    {
        $error = array(
            'key' => $key,
            'value' => $value
        );

        array_push(self::$ajaxResponse['error'], $error);
    }

    /**
     * @param bool $action
     * @param bool $key
     * @param bool $value
     * @param bool $attrName
     */
    static public function addResponse($action = false, $key = false, $value = false, $attrName = false)
    {
        // $responseID = Request::addResponse('func', 'scrollToEl', false); // addResponse will return message id to we can remove it if need
        // todo Also, need ability to remove or change already added responses --> Controller --> ajaxProcessing

        $res = array(
            'action' => $action,
            'key' => $key,
            'value' => $value
        );
        if ($attrName)
            $res['attrName'] = $attrName;

        array_push(self::$ajaxResponse['res'], $res);
    }

    static public function addErrorResponse($action = false, $key = false, $value = false, $attrName = false)
    {
        // $responseID = Request::addErrorResponse('func', 'scrollToEl', false); // addResponse will return message id to we can remove it if need

        $res = array(
            'action' => $action,
            'key' => $key,
            'value' => $value
        );
        if ($attrName)
            $res['attrName'] = $attrName;

        array_push(self::$ajaxResponse['error_res'], $res);
    }

    // todo: removeRequest
    static public function removeResponse($action = false, $key = false)
    {
        // todo Also, need ability to remove or change already added responses --> Controller --> ajaxProcessing

        $res = array(
            'action' => $action,
            'key' => $key,
            'value' => false
        );

        array_push(self::$ajaxResponse['res'], $res);
    }

    /**
     * Function responseAjax
     * @param bool $response
     */
    static public function responseAjax($response = false)
    {
//        print_data('$response');
//        print_data($response);
//        print_data('Request::$ajaxResponse');
//        print_data(Request::$ajaxResponse);

        if (is_array($response)) {
            foreach ($response AS $key => $value) {
                if (is_array($value)) {
                    Request::$ajaxResponse[$key] = array();

                    foreach ($value AS $k => $v)
                        Request::$ajaxResponse[$key][$k] = $v;
                } else
                    Request::$ajaxResponse[$key] = $value;
            }
            //Request::$ajaxResponse = array_merge(Request::$ajaxResponse, $response);
        }
    }

    /**
     * Function endAjax
     * @param bool $response
     */
    static public function endAjax($response = false)
    {
        if ($response)
            Request::responseAjax($response);

        echo json_encode(Request::$ajaxResponse);
        exit;
    }

    /**
     * Adding error to response and exit from page processing
     * @param string|bool $error
     */
    static public function returnError($error = false, $formId = false, $fieldName = false)
    {
        if ($error) {
            $response['error'] = $error;
            $response['error_res'] = Request::$ajaxResponse['error_res'];

            if ($formId) {
                $response['error_validation']['form_id'] = $formId;
                $response['error_validation']['names'][$fieldName][] = $error;
            }

            Request::responseAjax($response);
        }

        echo json_encode(Request::$ajaxResponse);
        exit;
    }

    /**
     * Function returnErrors - to return list of errors
     * @param false $error
     * @param false $asText
     * @return string
     */
    static public function returnErrors($error = false, $asText = false, $formId = false)
    {
        if (is_array($error)) {
            $response['error'] = "";

            if ($formId) {
                $response['error_validation']['form_id'] = $formId;
            }

            foreach ($error as $key => $err) {
                $response['error'] .= "- " . $err . "<br>\n";
                $response['error_validation']['names'][$key][] = $err;
            }

            if ($asText === true) {
                return $response['error'];
            }

            $response['error_res'] = Request::$ajaxResponse['error_res'];

            Request::responseAjax($response);
        }

        echo json_encode(Request::$ajaxResponse);
        exit;
    }


    /**
     * Function getCacheSalt - return salt for cache
     * @return string
     */
    static public function getCacheSalt()
    {
        return date('YmdH');
    }

    /**
     * Function to get settings items from array
     * @param $array
     * @return void
     */
    static public function getSettings($array)
    {
        Model::import('panel/settings');

        $row = "";
        foreach ($array as $item)
            $row .= ",'$item'";
        $row = trim($row, ',');

        $list = SettingsModel::getList($row);

        foreach ($list as $key => $item)
            Request::setParam($key, $item->value);
    }

    static public function returnJson($data)
    {
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode($data);
        exit;
    }

//    static public function removeFirstUri() {}

}
/* End of file */