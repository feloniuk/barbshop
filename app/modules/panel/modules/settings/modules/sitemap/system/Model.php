<?php
class SitemapModel extends Model
{
    public $version = 1; // increment it for auto-update

    /**
     * Method module_install start automatically if it not exist in `modules` table at first importing of model
     */
    public function module_install()
    {
        $queries = array(
            "CREATE TABLE IF NOT EXISTS `site_map` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `table` varchar(200) DEFAULT NULL,
                `where` varchar(200) DEFAULT NULL,
                `url` varchar(200) NOT NULL,
                `base_url` varchar(200) NOT NULL,
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
            case '0':
                $queries[] = "INSERT INTO `site_map` (`id`, `table`, `where`, `url`, `base_url`) VALUES
                            (1, 'vacancies', '" . filter("`deleted` = 'no' AND `posted` = 'yes' AND (`time_expire` > UNIX_TIMESTAMP() OR `time_expire` = 0)") . "', 'job/{slug}', '" . SITE_URL . "'),
                            (2, 'blog', '" . filter("`deleted` = 'no' AND `posted` = 'yes'") . "', 'blog/{slug}', '" . SITE_URL . "')";
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
            FROM `site_map`
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
            FROM `site_map`
            WHERE `deleted` = 'no'
        ";

        return self::fetchAll(self::query($sql));
    }

    /**
     * Get tech items as array with key => id, value => object
     * @return array
     */
    public static function getArrayWithID()
    {
        $sql = "
            SELECT *
            FROM `site_map`
            WHERE `deleted` = 'no'
        ";

        $techList = self::fetchAll(self::query($sql));

        $techArray = array();
        foreach ($techList as $item)
            $techArray[ $item->id ] = $item;

        return $techArray;
    }
}

/* End of file */