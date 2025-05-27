<?php
/**
 * Route
 */

class Route
{
    static private $_routeKey = 0;
    static private $_instance = null;

    static private $routesArray = array();
    static private $processedRoutesArray = array();


    /**
     * @return void
     */
    static public function processRoutes()
    {
        // Checking routes parameters
        foreach (self::$routesArray as $route) {
            // Find parameters
            preg_match_all("~{([a-z0-9\-_]{1,250})}~si", $route['route'], $result);

            $route['items'] = [];
            if ($result)
                foreach ($result[1] as $value)
                    $route['items'][$value] = in_array($value, $route['items']) ? $value : '[a-z0-9\+\-\.\,_%]{1,250}';

            // Pattern
            $pattern = $route['route'];
            if ($route['items'])
                foreach ($route['items'] as $key => $item)
                    $pattern = str_replace('{' . $key . '}', '(' . $item . ')', $pattern);

            $route['pattern'] = '~^' . $pattern . '/?$~si';

            // Set to $processedRoutesArray
            if ($route['name'])
                self::$processedRoutesArray[$route['name']] = $route;
            else
                self::$processedRoutesArray[] = $route;
        }
    }

    /**
     * @param $key
     * @return mixed
     */
    static public function getRouteByKey($key)
    {
        return self::$processedRoutesArray[$key]['route'] ?: $key;
    }

    /**
     * @param $key
     * @param $uri
     * @return false|mixed
     */
    static public function updateRouteByKey($key, $uri = false)
    {
        return self::$processedRoutesArray[$key]['route'] = $uri;
    }

    /**
     * @return array
     */
    static public function getList()
    {
        return self::$processedRoutesArray;
    }

    /**
     * @return string
     */
    static public function getCurrentName()
    {
        $routes = self::$processedRoutesArray;

        $name = '';
        foreach ($routes as $route) {
            if ($route['controller'] == CONTROLLER && $route['action'] == ACTION) {
                $name = $route['name'];
                return $name;
            }
        }

        return $name;
    }

    /**
     * @param $uri
     * @param $action
     * @return Route|null
     */
    static public function set($uri, $action = false)
    {
        self::$_routeKey++;

        if (self::$_instance === null)
            self::$_instance = new self;

        $m = explode('@', $action);
        self::$routesArray[self::$_routeKey] = array(
            'route' => trim($uri, '/'),
            'controller' => $m[0],
            'action' => $m[1],
        );

        return self::$_instance;
    }

    /**
     * @param $name
     * @return $this
     */
    public function name($name)
    {
        self::$routesArray[self::$_routeKey]['name'] = $name;

        return $this;
    }

    /**
     * @param $item
     * @param $value
     * @return $this
     */
    public function where($item, $value = false)
    {
        if (is_array($item)) {
            foreach ($item as $k => $v)
                self::$routesArray[self::$_routeKey]['items'][$k] = $v;
        } else
            self::$routesArray[self::$_routeKey]['items'][$item] = $value;

        return $this;
    }

}
/* End of file */