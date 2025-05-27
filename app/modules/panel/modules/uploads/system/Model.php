<?php
class UploadsModel extends Model
{
    public $version = 1; // increment it for auto-update

    /**
     * Method module_install start automatically if it not exist in `modules` table at first importing of model
     */
    public function module_install()
    {
        $queries = array(
            "CREATE TABLE IF NOT EXISTS `uploads` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `name` varchar(200) NOT NULL,
                `file` varchar(200) DEFAULT NULL,
                `slug` varchar(200) NOT NULL UNIQUE,
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
//                $queries[] = "ALTER TABLE `uploads` ALTER COLUMN `position` varchar(200) DEFAULT NULL;";

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
            FROM `uploads`
            WHERE `id` = '$id'
            LIMIT 1
        ";

        return self::fetch(self::query($sql));
    }


    public static function getBySlug($slug)
    {
        $sql = "
            SELECT *
            FROM `uploads`
            WHERE `slug` = '$slug'
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
            FROM `uploads`
            WHERE `deleted` = 'no'
        ";

        return self::fetchAll(self::query($sql));
    }

    public static function getArchived()
    {
        $sql = "
            SELECT *
            FROM `uploads`
            WHERE `deleted` = 'yes'
        ";

        return self::fetchAll(self::query($sql));
    }


    /**
     * @param $pages
     * @param $country_code
     * @return array
     */
    public static function getFromViewed($pages = false, $country_code = false)
    {
        $sql = "
            SELECT *
            FROM `uploads`
            WHERE `deleted` = 'no'
        ";


        return self::fetchAll(self::query($sql));
    }

    public static function countActive($where = false)
    {
        $sql = "
            SELECT COUNT(`id`)
            FROM `uploads`
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
            FROM `uploads`
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