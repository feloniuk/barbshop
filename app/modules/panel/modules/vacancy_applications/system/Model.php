<?php
class Vacancy_applicationsModel extends Model
{
    public $version = 0; // increment it for auto-update

    /**
     * Method module_install start automatically if it not exist in `modules` table at first importing of model
     */
    public function module_install()
    {
        $queries = array(
            "CREATE TABLE IF NOT EXISTS `talent_pool_cv` (
                  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
                  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
                  `email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
                  `tel` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
                  `linkedin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
                  `cv` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
                  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                  `status` varchar(100) DEFAULT '',
                  `deleted` enum('no','yes') COLLATE utf8mb4_unicode_ci DEFAULT 'no',
                  `time` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '',
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;"
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

        }

        foreach ($queries as $query)
            self::query($query);
    }

    /**
     * @param $id
     * @return array|object|null
     */
    public static function get($id)
    {
        $sql = "
            SELECT *
            FROM `cv_library`
            WHERE `id` = '$id'
            LIMIT 1
        ";

        return self::fetch(self::query($sql));
    }

    public static function getWhere($where = false)
    {
        $sql = "
            SELECT *
            FROM `cv_library`
            WHERE `deleted` = 'no'
        ";
        if ($where)
            $sql .= " AND $where";

        $sql .= "ORDER BY `time` DESC";

        return self::fetchAll(self::query($sql));
    }

    /**
     * Get all
     * @return array
     */
    public static function getAll()
    {
        $sql = "
            SELECT *, (SELECT `vacancies`.`title` FROM `vacancies` WHERE `id` = `cv_library`.`vacancy_id`) as vacancy_title
            FROM `cv_library`
            WHERE `deleted` = 'no'
            ORDER BY `id` DESC
        ";

        return self::fetchAll(self::query($sql));
    }

    public static function getArchived()
    {
        $sql = "
            SELECT *, (SELECT `vacancies`.`title` FROM `vacancies` WHERE `id` = `cv_library`.`vacancy_id`) as vacancy_title
            FROM `cv_library`
            WHERE `deleted` = 'yes'
        ";

        return self::fetchAll(self::query($sql));
    }

    public static function getCv($id)
    {
        $sql = "
            SELECT *
            FROM `talent_pool_cv`
            WHERE `id` = '$id'
            LIMIT 1
        ";

        return self::fetch(self::query($sql));
    }

    public static function countActive($where = false)
    {
        $sql = "
            SELECT COUNT(`id`)
            FROM `cv_library`
            WHERE `deleted` = 'no'
        ";

        if ($where) {
            $sql .= " $where";
        }

        return self::fetch(self::query($sql), 'row')[0];
    }

    public static function countActiveCv($where = false)
    {
        $sql = "
            SELECT COUNT(`id`)
            FROM `talent_pool_cv`
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
            FROM `cv_library`
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

        $res = self::fetchAll(self::query($sql));

        $res = self::relationship($res, 'cv_library', 'vacancies', ['id', 'title'], false, 'vacancy_id', 'one_to_many');

        return $res;
    }

    public static function getActiveCv($where = '', $orderby = false, $sort = false, $start = false, $end = false)
    {
        $sql = " 
            SELECT *
            FROM `talent_pool_cv`
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

    public static function getByVacancies($keywords)
    {
        $ids = [];

        if ($keywords) {
            $ids = array_column(Model::fetchAll(Model::select('vacancies', " `title` like '%$keywords%'")), 'id');
        }

        if ($ids) {
            $ids = array_unique($ids);

            return " or `vacancy_id` IN (" . implode(',', $ids) . ") ";
        } else {
            return '';
        }
    }
}

/* End of file */