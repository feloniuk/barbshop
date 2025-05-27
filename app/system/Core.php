<?php

/**
 * CORE
 */
final class Core
{
    private $router = array();
    private $current_uri;

    /**
     * Core constructor.
     */
    public function __construct()
    {
        include_once(_SYSDIR_ . 'system/inc/Common.php');
        include_once(_SYSDIR_ . 'system/inc/ErrorHandler.php');

        errors_control();
        date_default_timezone_set(TIMEZONE);

        // Call Error Handler
        new ErrorHandler();

        // Include files
        $this->includeFiles();

        // Settings
        $this->setSettings();

        // Processing routes
        $this->getRoute();

        // Run the module
        $this->dispatch();
    }

    /**
     * Include system helpers
     */
    private function includeFiles()
    {
        include_once(_SYSDIR_ . 'system/Function.php');
        include_once(_SYSDIR_ . 'system/Helpers.php');
        include_once(_SYSDIR_ . 'system/inc/Lang.php'); // Languages
        include_once(_SYSDIR_ . 'system/inc/Request.php');
        include_once(_SYSDIR_ . 'system/inc/User.php');
        include_once(_SYSDIR_ . 'system/inc/Mail.php');
        include_once(_SYSDIR_ . 'system/inc/Pagination.php');
        include_once(_SYSDIR_ . 'system/db/Mysqli.php'); // MySQLi adapter
        include_once(_SYSDIR_ . 'system/inc/Controller.php'); // Parent controller
        include_once(_SYSDIR_ . 'system/inc/Model.php'); // Parent model
        include_once(_SYSDIR_ . 'system/inc/View.php'); // Parent view
        include_once(_SYSDIR_ . 'system/inc/HTMLPurifier.php');

        // Custom Classes
        include_once(_SYSDIR_ . 'system/inc/classes/TempEngine.php');
        include_once(_SYSDIR_ . 'system/inc/classes/ImageAlts.php');
        include_once(_SYSDIR_ . 'system/inc/classes/FileBase.php');
        include_once(_SYSDIR_ . 'system/inc/googleStructure/GoogleStructure.php');

        // Facades
        include_once(_SYSDIR_ . 'system/inc/facades/Storage.php');
        include_once(_SYSDIR_ . 'system/inc/facades/File.php'); // Work with files
        include_once(_SYSDIR_ . 'system/inc/facades/Image.php');
        include_once(_SYSDIR_ . 'system/inc/facades/Doc.php');
        include_once(_SYSDIR_ . 'system/inc/facades/Video.php');

        // Traits
        include_once(_SYSDIR_ . 'system/inc/traits/Validator.php'); // Form validator
        include_once(_SYSDIR_ . 'system/inc/traits/RecordVersion.php'); // DB record versions

        // Routes
        include_once(_SYSDIR_ . 'system/inc/Route.php'); // Router
        include_once(_SYSDIR_ . 'system/Routes.php'); // Routes declaration
    }

    /**
     * Settings
     */
    private function setSettings()
    {
        // Session
        if (SESSION_SWITCH === true) {
            session_set_cookie_params(3600 * 24 * 2);
            session_start();
        }

        // Mb encoding
        if (CHARSET)
            mb_internal_encoding(CHARSET);
    }

    /**
     * Processing routes
     */
    private function getRoute()
    {
        Route::processRoutes();
        $routesArray = Route::getList();

        $uri = (trim(_URI_, '/')); // mb_strtolower

        // Cut ?act=value...
        $uriPos = mb_strpos($uri, '?');
        if ($uriPos !== false)
            $uri = mb_substr($uri, 0, $uriPos);

        //set current uri for redirect
        $this->current_uri = $uri;

        $router = array(); // Router array to keep route data
        foreach ($routesArray as $value) {
            // Checking pattern in $uri
            if (preg_match($value['pattern'], $uri, $matches)) {
                $router['params'] = [];
                $router['controller'] = $value['controller'];
                $router['action'] = $value['action'];

                if ($value['name'])
                    Route::updateRouteByKey($value['name'], $uri);

                // Add route pattern value to params
                $uri = trim( mb_substr( $uri, mb_strlen($matches[0]) ) , '/');
                unset($matches[0]);
                $router['params'] = array_values($matches);

                if (!empty($uri)) {
                    $uriLeftArr = explode('/', $uri);

                    // Add uri parts to params
                    foreach ($uriLeftArr as $uriVal)
                        $router['params'][] = $uriVal;
                }
                break;
            }
        }

        // If there are no matches in routes
        if (empty($router)) {
            $uriParts = explode('/', $uri);
            $uriCount = count($uriParts);

            $router['params'] = array();

            // Set default controller if no uri[0]
            $router['controller'] = empty($uriParts[0]) ? DEFAULT_CONTROLLER : $uriParts[0];

            // Set default action if no uri[1]
            $router['action'] = empty($uriParts[1]) ? DEFAULT_ACTION : $uriParts[1];

            // Remove Controller & Action values from params
            if ($uriCount >= 3) {
                unset($uriParts[0]);
                unset($uriParts[1]);
                $router['params'] = array_values($uriParts);
            }
        }

        unset($routesArray); // Delete routes array

        if (is_array($router['params']))
            Request::setUri($router['params']);

        $this->router = $router;
    }

    /**
     * Run the module
     */
    private function dispatch()
    {
        // We can use "-" or "_" in routes for controllers and actions
        $moduleURL = str_replace('-', '_', mb_strtolower($this->router['controller']));
        $pageURL = str_replace('-', '_', mb_strtolower($this->router['action']));

        $this->controllerConnecting($moduleURL, $pageURL);
    }

    /**
     * @param $moduleURL
     * @param $pageURL
     */
    private function controllerConnecting($moduleURL, $pageURL)
    {
        Model::init();
        $redirectObj = Model::fetch(Model::select('redirects', " `uri_from` = '{$this->current_uri}' AND `deleted` = 'no' LIMIT 1"));

        // First level module path
        $path = modulePath($moduleURL) . 'system/Controller.php';

        if (!$redirectObj && file_exists($path))
            include_once($path);
        else {
            $this->processRedirect($redirectObj);
            error404('ERROR 404');
        }

        $controllerName = ucfirst(moduleName($moduleURL)) . 'Controller';
        $actionName = $pageURL . 'Action';
        $controller = new $controllerName();

        // First module level
        if (method_exists($controller, $actionName)) {
            // Set CONTROLLER & ACTION
            define('CONTROLLER', $moduleURL);
            define('ACTION', $pageURL);
            define('CONTROLLER_SHORT', moduleName($moduleURL));

            // Launch before controller
            $this->preDispatch();

            // Processing
            $controller->processing();

            // Call action
            $controller->$actionName();

            // Called if isAjax() and calling "exit" at end
            $controller->ajaxProcessing();

            // Call Layout
            $controller->printOut();

            // Launch after Layout (not go to ajaxLayout)
            $this->postDispatch();
        } else {
            $newAction = Request::getUri(0);
            if (!$newAction)
                $newAction = DEFAULT_ACTION;

            array_shift($this->router['params']); // Remove first element
            Request::setUri($this->router['params']); // Reset uri

            $this->controllerConnecting($moduleURL . '/' . $pageURL, $newAction);
        }
    }

    private function processRedirect($redirectObj)
    {
        if ($redirectObj) {
            redirect(url($redirectObj->uri_to), 301);
        }
    }

    /**
     * Launch before controller
     */
    private function preDispatch()
    {
        incFile('system/preDispatch.php');
    }

    /**
     * Launch after controller
     */
    private function postDispatch()
    {
        incFile('system/postDispatch.php');
    }
}

/* End of file */