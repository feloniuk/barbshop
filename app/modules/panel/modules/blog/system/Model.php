<?php
class BlogModel extends Model
{
    public $version = 0; // increment it for auto-update

    /**
     * Method module_install start automatically if it not exist in `modules` table at first importing of model
     */
    public function module_install()
    {
        $queries = array(
            "CREATE TABLE IF NOT EXISTS `blog` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `consultant_id` int(10) unsigned DEFAULT 0,
                `title` varchar(200) NOT NULL,
                `image` varchar(60) DEFAULT NULL,
                `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `meta_title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
                `meta_keywords` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
                `meta_desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
                `sector` int(10) unsigned DEFAULT NULL,
                `views` int(10) unsigned DEFAULT 0,
                `posted` enum('no','yes') DEFAULT 'yes',
                `deleted` enum('no','yes') DEFAULT 'no',
                `slug` varchar(200) NOT NULL DEFAULT '',
                `time` int(10) unsigned NOT NULL,
                PRIMARY KEY (`id`),
                INDEX (`slug`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 COLLATE=utf8mb4_unicode_ci ;",

            "CREATE TABLE IF NOT EXISTS `blog_categories` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `name` varchar(200) NOT NULL,
                `deleted` enum('no','yes') DEFAULT 'no',
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 COLLATE=utf8mb4_unicode_ci ;",

            "CREATE TABLE IF NOT EXISTS `blogs_analytics` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `entity_id` int(10) unsigned DEFAULT 0,
                `user_id` int(10) unsigned DEFAULT 0,
                `ref` varchar(50) DEFAULT '',
                `referrer` varchar(200) DEFAULT NULL,
                `ip` varchar(200) DEFAULT NULL,
                `time` int(10) unsigned NOT NULL,
                PRIMARY KEY (`id`), 
                KEY (`entity_id`) 
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 COLLATE=utf8mb4_unicode_ci ;",

            "CREATE TABLE IF NOT EXISTS `blogs_referrers` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `blog_id` int(10) unsigned DEFAULT 0,
                `title` varchar(200) DEFAULT NULL,
                `count` int(10) unsigned DEFAULT 0,
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
//                $queries[] = "ALTER TABLE `blog_categories` ADD COLUMN `subtitle` varchar(200) DEFAULT NULL AFTER `subtitle`;";
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
            FROM `blog`
            WHERE `id` = '$id'
            LIMIT 1
        ";

        $blog = self::fetch(self::query($sql));

        if ($blog)
            $blog = ImageAlts::getAlts('blog', $blog);

        return $blog;
    }

    /**
     * Get all
     * @return array
     */
    public static function getAll()
    {
        $sql = "
            SELECT *
            FROM `blog`
            WHERE `deleted` = 'no'
        ";

        return self::fetchAll(self::query($sql));
    }

    public static function getArchived()
    {
        $sql = "
            SELECT *
            FROM `blog`
            WHERE `deleted` = 'yes'
        ";

        return self::fetchAll(self::query($sql));
    }

    public static function getViewsByDays($id, $days = 9)
    {
        $sql = "
            SELECT *
            FROM `blogs_analytics`
            WHERE `entity_id` = '$id' AND `time` > " . (time() - $days * 24 * 3600) . " 
            ORDER BY `time` DESC
            LIMIT 500
        ";

        return self::fetchAll(self::query($sql));
    }

    public static function getViews($id)
    {
        $sql = "
            SELECT *
            FROM `blogs_analytics`
            WHERE `entity_id` = '$id' AND (`referrer` != '' OR `ref` != '')
        ";

        return self::fetchAll(self::query($sql));
    }

    public static function getReferrersList($blog_id)
    {
        $sql = "
            SELECT *
            FROM `blogs_referrers`
            WHERE `blog_id` = '$blog_id'
        ";

        return self::fetchAll(self::query($sql));
    }

    public static function getReferrer($id)
    {
        $sql = "
            SELECT *
            FROM `blogs_referrers`
            WHERE `id` = '$id'
        ";

        return self::fetch(self::query($sql));
    }

    public static function countBlogs($where = false)
    {
        $sql = "
            SELECT COUNT(`id`)
            FROM `blog`
            WHERE `deleted` = 'no'
        ";

        if ($where)
            $sql .= " $where";

        return self::fetch(self::query($sql), 'row')[0];
    }

    public static function search($where, $orderby, $sort, $start = false, $end = false)
    {
        $sql = " 
            SELECT * 
            FROM `blog` 
            WHERE `deleted` = 'no' 
            $where ";

        if ($orderby && $sort) {
            $sql .= " ORDER BY $orderby $sort ";
        }
        if ($start !== false && $end !== false) {
            $sql .= " LIMIT $start, $end ";
        }

        return self::fetchAll(self::query($sql));
    }

    public static function getAllByCategoryId($category) {
        $sql = "
            SELECT *
            FROM `blog`
            WHERE `deleted` = 'no' 
        ";

        if ($category !== false) {
            $sql .= " AND `sector` = '$category' ";
        }

        return self::fetchAll(self::query($sql));
    }

    public static function countActive($where = false, $categoryId = false)
    {
        $sql = "
            SELECT COUNT(`id`)
            FROM `blog`
            WHERE `deleted` = 'no'
        ";

        if ($where) {
            $sql .= " $where";
        }

        if ($categoryId) {
            $sql .= " AND `sector` = $categoryId ";
        }

        return self::fetch(self::query($sql), 'row')[0];
    }

    public static function getActive($where = false, $categoryId = false, $orderby = false, $sort = 'DESC', $start = false, $end = false)
    {
        $sql = "
            SELECT *
            FROM `blog`
            WHERE `deleted` = 'no'
        ";

        if ($where) {
            $sql .= " $where";
        }

        if ($categoryId) {
            $sql .= " AND `sector` = $categoryId ";
        }

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
