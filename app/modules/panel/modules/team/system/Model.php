<?php
class TeamModel extends Model
{
    public $version = 1;

    /**
     * Method module_install start automatically if it not exist in `modules` table at first importing of model
     */
    public function module_install()
    {
        $queries = array();

        foreach ($queries as $query)
            self::query($query);
    }

    /**
     * Method module_update start automatically if current $version != version in `modules` table, and start from "case 'i'", where i = prev version in modules` table
     * @param int $version
     */
    public function module_update($version)
    {
        $queries = array();

        switch ($version) {

            case '0':
                $queries[] = "CREATE TABLE IF NOT EXISTS `users_shops` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `shop_id` int(10) unsigned NOT NULL,
                `user_id` int(10) unsigned NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 COLLATE=utf8mb4_unicode_ci ;";
        }

        foreach ($queries as $query)
            self::query($query);
    }

    public static function getUserImage($id)
    {
        $sql = "
            SELECT *
            FROM `user_images`
            WHERE `id` = '$id'
            LIMIT 1
        ";

        return self::fetch(self::query($sql));
    }

    public static function getUserImages($uid)
    {
        $sql = "
            SELECT *
            FROM `user_images`
            WHERE `user_id` = '$uid'
            ORDER BY `id` ASC
        ";

        return self::fetchAll(self::query($sql));
    }


    /**
     * @param $email
     * @return array|object|null
     */
    public static function getUserByEmail($email)
    {
        $sql = "
            SELECT *
            FROM `users`
            WHERE `email` = '$email'
            LIMIT 1
        ";

        $user = self::fetch(self::query($sql));

        
        $user = self::relationship($user, 'users', 'services');
        $user = self::relationship($user, 'users', 'shops');
        return $user;
    }

    /**
     * Get all users
     * @return array
     */
    public static function getAllUsers($where = '')
    {
        $sql = "
            SELECT *
            FROM `users`
            WHERE `deleted` = 'no' {$where}
        ";

        $user = self::fetchAll(self::query($sql));

        
        $user = self::relationship($user, 'users', 'services');
        $user = self::relationship($user, 'users', 'shops');
        return $user;
    }

    public static function getUsersWhere($where)
    {
        $sql = "
            SELECT *
            FROM `users`
            WHERE `deleted` = 'no'
            AND $where
        ";

        $user = self::fetchAll(self::query($sql));

        
        $user = self::relationship($user, 'users', 'services');
        $user = self::relationship($user, 'users', 'shops');
        return $user;
    }

   
    public static function getArchived()
    {
        $sql = "
            SELECT *
            FROM `users`
            WHERE `deleted` = 'yes'
            AND `role` IN ('admin', 'moder')
        ";

        return self::fetchAll(self::query($sql));
    }

   

    public static function getBiggestSort()
    {
        $sql = "
            SELECT *
            FROM `users`
            WHERE `deleted` = 'no'
            ORDER BY `sort` DESC
            LIMIT 1
        ";

        return self::fetch(self::query($sql));
    }

    public static function removeServices($vid)
    {
        $sql = "
            DELETE 
            FROM `services_users` 
            WHERE `user_id` = '$vid'
        ";

        return self::query($sql);
    }

    public static function removeShops($vid)
    {
        $sql = "
            DELETE 
            FROM `users_shops` 
            WHERE `user_id` = '$vid'
        ";

        return self::query($sql);
    }

    public static function getNextSmallestSort($sort)
    {
        $sql = "
            SELECT *
            FROM `users`
            WHERE `deleted` = 'no' AND `sort` > 0 AND `sort` < '$sort'
            ORDER BY `sort` DESC
            LIMIT 1
        ";

//        print_data($sql);

        return self::fetch(self::query($sql));
    }

    public static function getNextBiggestSort($sort)
    {
        $sql = "
            SELECT *
            FROM `users`
            WHERE `deleted` = 'no' AND `sort` > 0 AND `sort` > '$sort'
            ORDER BY `sort` ASC
            LIMIT 1
        ";

//        print_data($sql);

        return self::fetch(self::query($sql));
    }

    public static function countActive($where = false)
    {
        $sql = "
            SELECT COUNT(`id`)
            FROM `users`
            WHERE `deleted` = 'no'
        ";

        if ($where) {
            $sql .= " $where";
        }

        return self::fetch(self::query($sql), 'row')[0];
    }

    





     

    /**
     * Get active users
     * @param string $where
     * @param string $order_by
     * @param string $order_way
     * @param int $start
     * @param int $limit
     * @return array
     */
    public static function getActive($where = "", $order_by = 'id', $order_way = 'DESC', $start = -1, $limit = -1)
    {
        $limitStr = generateLimitStr($start, $limit);

        $sql = "
            SELECT *
            FROM `users`
            WHERE `deleted` = 'no'
            $where
            ORDER BY `$order_by` $order_way
            $limitStr
        ";

        $users = self::fetchAll(self::query($sql));
        
        // Добавляем информацию о магазинах для каждого пользователя
        if ($users) {
            foreach ($users as $user) {
                $user->shops = self::getUserShopsData($user->id);
                $user->shop_ids = array_column($user->shops, 'id');
            }
        }

        return $users;
    }

    /**
     * Get user by id
     * @param $id
     * @return array|object|null
     */
    public static function getUser($id)
    {
        $sql = "
            SELECT *
            FROM `users`
            WHERE `id` = '$id'
            LIMIT 1
        ";

        $user = self::fetch(self::query($sql));
        
        if ($user) {
            $user->shops = self::getUserShopsData($user->id);
            $user->shop_ids = array_column($user->shops, 'id');
            $user->services = self::getUserServices($user->id);
        }

        return $user;
    }

    /**
     * Get user by where condition
     * @param $where
     * @return array|object|null
     */
    public static function getUserWhere($where)
    {
        $sql = "
            SELECT *
            FROM `users`
            WHERE $where
            LIMIT 1
        ";

        $user = self::fetch(self::query($sql));
        
        if ($user) {
            $user->shops = self::getUserShopsData($user->id);
            $user->shop_ids = array_column($user->shops, 'id');
            $user->services = self::getUserServices($user->id);
        }

        return $user;
    }

    /**
     * Get user shops data
     * @param $userId
     * @return array
     */
    public static function getUserShopsData($userId)
    {
        $sql = "
            SELECT s.*
            FROM `shops` s
            INNER JOIN `users_shops` us ON s.id = us.shop_id
            WHERE us.user_id = '$userId'
            AND s.deleted = 'no'
        ";

        return self::fetchAll(self::query($sql));
    }

    /**
     * Get user services
     * @param $userId
     * @return array
     */
    public static function getUserServices($userId)
    {
        $sql = "
            SELECT s.*
            FROM `services` s
            INNER JOIN `users_services` us ON s.id = us.service_id
            WHERE us.user_id = '$userId'
            AND s.deleted = 'no'
        ";

        return self::fetchAll(self::query($sql));
    }

    /**
     * Get users by shop
     * @param $shopId
     * @return array
     */
    public static function getUsersByShop($shopId)
    {
        $sql = "
            SELECT u.*
            FROM `users` u
            INNER JOIN `users_shops` us ON u.id = us.user_id
            WHERE us.shop_id = '$shopId'
            AND u.deleted = 'no'
        ";

        return self::fetchAll(self::query($sql));
    }

    /**
     * Get users by shops where condition
     * @param $where
     * @return array
     */
    public static function getUsersByShopsWhere($where)
    {
        $sql = "
            SELECT DISTINCT us.*
            FROM `users_shops` us
            WHERE $where
        ";

        return self::fetchAll(self::query($sql));
    }

    /**
     * Count users
     * @param string $where
     * @return mixed
     */
    public static function countUsers($where = "")
    {
        $sql = "
            SELECT COUNT(*)
            FROM `users`
            WHERE `deleted` = 'no'
            $where
        ";

        return self::fetch(self::query($sql), 'row')[0];
    }

    /**
     * Update user by ID
     * @param $id
     * @param $data
     * @return string
     */
    public static function updateUserByID($id, $data)
    {
        return self::update('users', $data, "`id` = '$id' LIMIT 1");
    }
}

/* End of file */