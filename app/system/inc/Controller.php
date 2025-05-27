<?php
/**
 * CONTROLLER
 */

class Controller
{
    protected $view;
	protected $layout = 'layout';

    public function __construct() {

    }

    public function checkPermission($role, $permissionAction) {
        if (is_array($role)) {
            foreach ($role as $value)
                if (array_key_exists($value, $permissionAction))
                    return true;

            return false;
        } else {
            if (array_key_exists($role, $permissionAction))
                return true;
            else
                return false;
        }
    }

    /**
     * Processing before controller in core
     */
    public function processing()
    {
        // Permissions
        $action = false;
        $permission = array();
        $scope = 'user';
        require_once(modulePath(CONTROLLER) . 'system/Permission.php');

        if (array_key_exists(ACTION, $permission))
            $action = ACTION;
        else if (array_key_exists('*', $permission))
            $action = '*';

        // Redirect if no permissions
        if ($action !== false) {
            $redirectUrl = false; // Redirect url

            if ($this->checkPermission(User::getRole($scope), $permission[$action])) { // Check role permissions
                if ($permission[$action][User::getRole($scope)]['allow'] === false) {
                    if (array_key_exists('redirect', $permission[$action][User::getRole($scope)])) // Use role('admin') redirect
                        $redirectUrl = $permission[$action][User::getRole($scope)]['redirect'];
                    else if (array_key_exists('redirect', $permission[$action]['*'])) // Use general(*) redirect
                        $redirectUrl = $permission[$action]['*']['redirect'];
                }
            } else if (array_key_exists('*', $permission[$action])) { // Check general permissions
                if ($permission[$action]['*']['allow'] === false)
                    $redirectUrl = $permission[$action]['*']['redirect'];
            }

            //add current url to redirect uri as get param
            if (strpos($redirectUrl, 'panel/login') !== false) {
                $requestUri = $_SERVER['REQUEST_URI'];
                if (_DIR_ !== '/') {
                    $requestUri = str_replace(_DIR_, '', $_SERVER['REQUEST_URI']);
                }
                setSession('redirect_uri', SITE_URL . trim($requestUri, '/'));
            }

            // Redirect way
            if ($redirectUrl)
                redirectAny($redirectUrl);
        }

        // Import Controller Model
        Model::import(CONTROLLER);

        // View
        if (file_exists($pathView = modulePath(CONTROLLER) . 'system/View.php')) {
            include_once($pathView);
            $this->view = new ModuleView;
        } else {
            $this->view = new View;
        }
    }

    /**
     * To getView method in controller
     * ex: Request::addResponse('html', '#content', $this->getView());
     * ex: Request::addResponse('html', '#content', $this->getView('modules/page/views/email_templates/refer.php'));
     * @param bool $path
     * @return mixed
     */
    public function getView($path = false) {
        if ($path) {
            return $this->view->getAnyView($path); // Return only view file code, not through layout
        }

        return $this->view->ajaxLayout($this->layout);
    }

    /**
     * To use other view file
     * @param bool $action
     */
    protected function setView($action = false)
    {
        $this->view->simulateContent($action);
    }

    /**
     * To set layout
     * @param string $layout
     */
    protected function setLayout($layout = 'layout')
    {
        $this->layout = $layout;
    }

    /**
     * Call before Layout if isAjax()
     */
    public function ajaxProcessing()
    {
        if (Request::isAjax()) {
            // todo зробити можливість заміняти або видаляти Response actions!!!
            // Request::removeResponse('func', 'scrollToEl'); // якось так or resetResponse для заміни
            // + для цього прийдеться винести перед початком обробки action код нижче
            // так як щоб видаляти в контроллері треба щоб це вже було ініціалізовано

            // this code will run if it not ajax part request
            if (!Request::isAjaxPart()) {
                // Change url
                Request::addResponse('url', false, url(_URI_));

                // Change title
                if (Request::getTitle())
                    Request::addResponse('title', false, Request::getTitle());

                // Put loaded view in "#content"
                Request::addResponse('html', '#content', $this->getView());

                // Scroll page to top after page loaded by ajax
                Request::addResponse('func', 'scrollToEl', false);
            }

            // todo merge arrays

            Request::endAjax();
        }
    }

    /**
     * To print layout in core
     */
	public function printOut()
	{
		$this->view->Layout($this->layout);
	}

    /**
     * @param string $controller
     * @return object
     */
    public static function import(string $controller) : object
    {
        $model = mb_strtolower($controller);

        // Connect controller
        if (file_exists($pathPrepared = modulePath($controller) . 'system/Controller.php'))
            include_once($pathPrepared);
        else
            exit("Can't connect controller: " . $model);

        // Create model object to take version
        $controllerName = ucfirst(moduleName($controller)) . 'Controller';

        return new $controllerName;
    }
}

/* End of file */