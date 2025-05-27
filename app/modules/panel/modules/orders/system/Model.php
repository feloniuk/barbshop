<?php

class OrdersModel extends Model
{
    public $version = 0; // increment it for auto-update

    /**
     * Method module_install start automatically if it not exist in `modules` table at first importing of model
     */
    public function module_install()
    {
        $queries = [
            "CREATE TABLE IF NOT EXISTS `orders` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `name` varchar(200) NOT NULL,
                `tel` varchar(200) NOT NULL,
                `email` varchar(200) DEFAULT NULL,
                `selectedTime` varchar(200) NOT NULL,
                `selectedDate` varchar(200) NOT NULL,
                `shop_id` int(10) NOT NULL,
                `service_id` int(10) NOT NULL,
                `user_id` int(10) NOT NULL,
                `client_id` int(10) DEFAULT NULL,
                `status` enum('new','done', 'conflict') DEFAULT 'new',
                `deleted` enum('no','yes') DEFAULT 'no',
                `time` int(10) unsigned NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 COLLATE=utf8mb4_unicode_ci ;"
        ];

        foreach ($queries as $query) {
            self::query($query);
        }
    }

    /**
     * Method module_update start automatically if current $version != version in `modules` table, and start from "case 'i'", where i = prev version in modules` table
     * @param int $version
     */
    public function module_update($version)
    {
        $queries = [];

        switch ($version) {
        }

        foreach ($queries as $query) {
            self::query($query);
        }
    }

    /**
     * Get orders by $id
     * @param $id
     * @return array|object|null
     */
    public static function get($id)
    {
        $sql = "
            SELECT *
            FROM `orders`
            WHERE `id` = '$id'
            LIMIT 1
        ";

        return self::fetch(self::query($sql));
    }

    /**
     * Get all
     * @return array
     */
    public static function getAll($where = '')
    {
        $sql = "
            SELECT *
            FROM `orders`
            WHERE `deleted` = 'no' {$where}
        ";

        $data = self::fetchAll(self::query($sql));
        $data = self::relationship($data, 'orders', 'services', '*', false, 'service_id', 'one_to_many');
        $data = self::relationship($data, 'orders', 'users', '*', false, 'user_id', 'one_to_many');
        $data = self::relationship($data, 'orders', 'shops', '*', false, 'shop_id', 'one_to_many');
        
        return $data;
    }

    public static function getArchived()
    {
        $sql = "
            SELECT *
            FROM `orders`
            WHERE `deleted` = 'yes'
        ";

        return self::fetchAll(self::query($sql));
    }

    public static function countActive($where = false)
    {
        $sql = "
            SELECT COUNT(`id`)
            FROM `orders`
            WHERE `deleted` = 'no'
        ";

        if ($where) {
            $sql .= " $where";
        }

        return self::fetch(self::query($sql), 'row')[0];
    }

    public static function getActive($where = '', $orderby = false, $sort = false, $start = false, $end = false)
    {
        $sql = "
            SELECT *
            FROM `orders`
            WHERE `deleted` = 'no'
            $where";

        if ($orderby && $sort) {
            $sql .= " ORDER BY $orderby $sort ";
        }

        if ($start !== false) {
            $sql .= "LIMIT $start";
            if ($end) {
                $sql .= ", $end";
            }
        }

        return self::fetchAll(self::query($sql));
    }
}
