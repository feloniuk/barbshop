<?php

class {{ className }}Model extends Model
{
    public $version = 0; // increment it for auto-update

    /**
     * Method module_install start automatically if it not exist in `modules` table at first importing of model
     */
    public function module_install()
    {
        $queries = [
            "CREATE TABLE IF NOT EXISTS `{{ tableName }}` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `title` varchar(200) NOT NULL,
                `image` varchar(60) DEFAULT NULL,
                `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
     * Get {{ tableName }} by $id
     * @param $id
     * @return array|object|null
     */
    public static function get($id)
    {
        $sql = "
            SELECT *
            FROM `{{ tableName }}`
            WHERE `id` = '$id'
            LIMIT 1
        ";

        $item = self::fetch(self::query($sql));

         if ($item) {
            $item = ImageAlts::getAlts('{{ tableName }}', $item);
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
            FROM `{{ tableName }}`
            WHERE `deleted` = 'no'
        ";

        return self::fetchAll(self::query($sql));
    }

    public static function getArchived()
    {
        $sql = "
            SELECT *
            FROM `{{ tableName }}`
            WHERE `deleted` = 'yes'
        ";

        return self::fetchAll(self::query($sql));
    }

    public static function countActive($where = false)
    {
        $sql = "
            SELECT COUNT(`id`)
            FROM `{{ tableName }}`
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
            FROM `{{ tableName }}`
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
