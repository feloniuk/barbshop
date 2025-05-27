<?php
class SectorsModel extends Model
{
    public $version = 0; // increment it for auto-update

    /**
     * Method module_install start automatically if it not exist in `modules` table at first importing of model
     */
    public function module_install()
    {
        $queries = array(
            "CREATE TABLE IF NOT EXISTS `sectors` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `name` varchar(200) NOT NULL,
                `deleted` enum('no','yes') DEFAULT 'no',
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 COLLATE=utf8mb4_unicode_ci ;"
        );

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
//            case '0':
//                $queries[] = "ALTER TABLE `sectors` ADD COLUMN `subtitle` varchar(200) DEFAULT NULL AFTER `name`;";
        }

        foreach ($queries as $query)
            self::query($query);
    }

    /**
     * Get user by $id
     * @param $id
     * @return array|object|null
     */
    public static function get($id)
    {
        $sql = "
            SELECT *
            FROM `sectors`
            WHERE `id` = '$id'
            LIMIT 1
        ";

        return self::fetch(self::query($sql));
    }

    /**
     * Get all
     * @return array
     */
    public static function getAll()
    {
        $sql = "
            SELECT *
            FROM `sectors`
            WHERE `deleted` = 'no'
        ";

        return self::fetchAll(self::query($sql));
    }

    public static function getArchived()
    {
        $sql = "
            SELECT *
            FROM `sectors`
            WHERE `deleted` = 'yes'
        ";

        return self::fetchAll(self::query($sql));
    }

    public static function countActive($where = false)
    {
        $sql = "
            SELECT COUNT(`id`)
            FROM `sectors`
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
            FROM `sectors`
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

/* End of file */