<?php
/**
 * User
 */

class User
{
    static protected $role = []; // User role

    static protected $properties = []; // User fields

    static protected $accessLevels = [
       'guest'      => 10,
       'user'       => 20,
       'moder'      => 30,
       'admin'      => 40,
       'superadmin' => 50,
    ];


    /**
     * @param $value ex: guest,user,moder,admin,superadmin
     * @param string $scope
     */
    static public function setRole($value, $scope = 'user')
    {
        self::$role[$scope] = $value;
    }

    /**
     * @param string $scope
     * @return mixed   guest,user,moder,admin
     */
    static public function getRole($scope = 'user')
    {
        return self::$role[$scope];
    }

    /**
     * @param $role
     * @param string $scope
     * @return bool
     */
    static public function checkRole($role, $scope = 'user')
    {
        if (is_array($role))
            return in_array(self::$role[$scope], $role);

        return self::$role[$scope] === $role;
    }

    /**
     * @param $object
     * @param string $scope
     */
    static public function set($object, $scope = 'user')
	{
        //if (is_object($object) || is_null($object))
        self::$properties[$scope] = $object; // object or null
	}

    /**
     * @param false $property
     * @param string $scope
     * @return mixed
     */
    static public function get($property = false, $scope = 'user')
    {
        if (!isset(self::$properties[$scope]))
            return null;

        if ($property === false)
            return self::$properties[$scope];

        return self::$properties[$scope]->$property;
    }

    /**
     * get access level for user
     * @return int
     */
    static public function getAccessLevel()
    {
        return self::$accessLevels[self::getRole()];
    }

    /**
     * @param $neededLevel
     * @return bool
     */
    static public function checkAccessLevel($neededLevel)
    {
        $currentLevel = self::getAccessLevel();

        if ($currentLevel >= $neededLevel)
            return true;

        return false;
    }

    // Auth

    // todo add method: isAuth

    /**
     * @param $userID
     * @param string $scope
     * @return int
     */
    static public function setSession($userID, $scope = 'user')
    {
        return setSession($scope, $userID, 'int'); // save user ID in session
    }

    /**
     * @param string $scope
     * @return int
     */
    static public function getSession($scope = 'user')
    {
        return getSession($scope, 'int'); // get user ID from session
    }

    /**
     * @param $userID
     * @param string $scope
     * @return bool
     */
    static public function setCookie($userID, $scope = 'user')
    {
        $secure = ERRORS_CONTROL == 'live';
        $httponly = ERRORS_CONTROL == 'live';

        return setcookie($scope . "_id", $userID, time() + 3600 * 24 * 30, '/', '', false, false);
    }

    /**
     * @param string $scope
     * @return mixed
     */
    static public function getCookie($scope = 'user')
    {
        return $_COOKIE[$scope . '_id'] ?? null;
    }

    /**
     * @param $token
     * @param string $scope
     * @return bool
     */
    static public function setTokenCookie($token, $scope = 'user')
    {
        $secure = ERRORS_CONTROL == 'live';
        $httponly = ERRORS_CONTROL == 'live';

        return setcookie($scope . "_token", $token, time() + 3600 * 24 * 30, '/', '', false, false);
    }

    /**
     * @param string $scope
     * @return mixed
     */
    static public function getTokenCookie($scope = 'user')
    {
        return $_COOKIE[$scope . '_token'] ?? null;
    }

}
/* End of file */