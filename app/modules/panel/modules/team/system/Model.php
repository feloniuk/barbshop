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
     * Get user by $id
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
        $user = self::relationship($user, 'users', 'services');
        $user = self::relationship($user, 'users', 'shops');
        return $user;
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
    public static function getAllUsers()
    {
        $sql = "
            SELECT *
            FROM `users`
            WHERE `deleted` = 'no'
        ";

        $user = self::fetchAll(self::query($sql));

        
        $user = self::relationship($user, 'users', 'services');
        $user = self::relationship($user, 'users', 'shops');
        return $user;
    }

    public static function getUserByBarcode($barcode)
    {
        $sql = "SELECT * FROM `users` 
                WHERE `barcode` = '$barcode' 
                AND `deleted` = 'no' 
                LIMIT 1";
        return self::fetch(self::query($sql));
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

    public static function getUsersByShopsWhere($where)
    {
        $sql = "
            SELECT *
            FROM `users_shops`
            WHERE $where
        ";

        return self::fetchAll(self::query($sql));
    }

    public static function getUserWhere($where)
    {
        $sql = "
            SELECT *
            FROM `users`
            WHERE `deleted` = 'no'
            AND $where
            LIMIT 1
        ";

        $user = self::fetch(self::query($sql));
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

    public static function countUsers($where = false)
    {
        $sql = "
            SELECT COUNT(`id`)
            FROM `users`
        ";

        if ($where)
            $sql .= "WHERE ".$where;

        return self::fetch(self::query($sql), 'row')[0];
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
     * @param false $where
     * @param false $orderby
     * @param false $sort
     * @param false $start
     * @param false $end
     * @return array|mixed
     */
    public static function getActive($where = '', $orderby = false, $sort = false, $start = false, $end = false)
    {
        $sql = " 
            SELECT *
            FROM `users`
            WHERE `deleted` = 'no'
            $where";

        if ($orderby && $sort) {
            if ($sort == 'asc' && $orderby == 'sort') {
                $sql .= " ORDER BY `sort` = 0, `sort`";
            } else {
                $sql .= " ORDER BY $orderby $sort ";
            }
        }

        if ($start !== false) {
            $sql .= "LIMIT $start";
            if ($end) {
                $sql .= ", $end";
            }
        }

        $user = self::fetchAll(self::query($sql));
        
        $user = self::relationship($user, 'users', 'services');
        $user = self::relationship($user, 'users', 'shops');
        return $user;
    }
    
}

/* End of file */