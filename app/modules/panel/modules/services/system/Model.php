<?php

class ServicesModel extends Model
{
    public $version = 1; // increment it for auto-update

    /**
     * Method module_install start automatically if it not exist in `modules` table at first importing of model
     */
    public function module_install()
    {
        $queries = [
            "CREATE TABLE IF NOT EXISTS `services` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `title` varchar(200) NOT NULL,
                `image` varchar(60) DEFAULT NULL,
                `file` varchar(100) DEFAULT NULL,
                `service_time` varchar(100) DEFAULT NULL,
                `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `deleted` enum('no','yes') DEFAULT 'no',
                `posted` enum('no','yes') DEFAULT 'yes',
                `slug` varchar(200) NOT NULL DEFAULT '',
                `time` int(10) unsigned NOT NULL,
                PRIMARY KEY (`id`),
                INDEX (`slug`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 COLLATE=utf8mb4_unicode_ci ;",
             "CREATE TABLE IF NOT EXISTS `services_sectors` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `service_id` int(10) unsigned NOT NULL,
                `sector_id` int(10) unsigned NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 COLLATE=utf8mb4_unicode_ci ;",
             "CREATE TABLE IF NOT EXISTS `services_users` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `service_id` int(10) unsigned NOT NULL,
                `user_id` int(10) unsigned NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 COLLATE=utf8mb4_unicode_ci ;",
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
            case '0':
                $queries[] = "ALTER TABLE `services` ADD COLUMN `price` int(11) DEFAULT NULL AFTER `file`;";
        }

        foreach ($queries as $query) {
            self::query($query);
        }
    }

    /**
     * Get services by $id
     * @param $id
     * @return array|object|null
     */
    public static function get($id)
    {
        $sql = "
            SELECT *
            FROM `services`
            WHERE `id` = '$id'
            LIMIT 1
        ";

        $item = self::fetch(self::query($sql));

         if ($item) {
            $item = ImageAlts::getAlts('services', $item);
            $item = self::relationship($item, 'services', 'sectors');
        }

        return $item;
    }

    /**
     * Get all
     * @return array
     */
    public static function getAll()
    {
        $sql = "
            SELECT *
            FROM `services`
            WHERE `deleted` = 'no'
        ";

        return self::fetchAll(self::query($sql));
    }

    public static function getArchived()
    {
        $sql = "
            SELECT *
            FROM `services`
            WHERE `deleted` = 'yes'
        ";

        return self::fetchAll(self::query($sql));
    }

    public static function removeSectors($vid)
    {
        $sql = "
            DELETE
            FROM `services_sectors`
            WHERE `service_id` = '$vid'
        ";

        return self::query($sql);
    }

    public static function countActive($where = false)
    {
        $sql = "
            SELECT COUNT(`id`)
            FROM `services`
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
            FROM `services`
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
