<?php
class VacanciesModel extends Model
{
    public $version = 0; // increment it for auto-update

    /**
     * Method module_install start automatically if it not exist in `modules` table at first importing of model
     */
    public function module_install()
    {
        $queries = array(
            "CREATE TABLE IF NOT EXISTS `vacancies` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `title` varchar(200) NOT NULL,
                `ref` varchar(200) DEFAULT NULL,
                `contract_type` enum('permanent', 'temporary', 'contract') DEFAULT 'permanent',
                `salary_value` varchar(200) DEFAULT NULL,
                `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `meta_title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
                `meta_keywords` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
                `meta_desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
                `consultant_id` int(10) unsigned DEFAULT 0,
                `content_short` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `internal` tinyint(2) unsigned NOT NULL DEFAULT 0,
                `image` varchar(100) DEFAULT NULL,
                `expire_alert` varchar(10) DEFAULT 'no',
                `expire_reason` varchar(255) DEFAULT '',
                `posted` enum('no','yes') DEFAULT 'yes',
                `deleted` enum('no','yes') DEFAULT 'no',
                `views` int(10) unsigned DEFAULT 0,
                `slug` varchar(200) NOT NULL DEFAULT '',
                `time_expire` int(10) unsigned NOT NULL,
                `time` int(10) unsigned NOT NULL,
                PRIMARY KEY (`id`),
                INDEX (`slug`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 COLLATE=utf8mb4_unicode_ci ;",

            "CREATE TABLE IF NOT EXISTS `vacancies_sectors` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `vacancy_id` int(10) unsigned NOT NULL,
                `sector_id` int(10) unsigned NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 COLLATE=utf8mb4_unicode_ci ;",

            "CREATE TABLE IF NOT EXISTS `vacancies_locations` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `vacancy_id` int(10) unsigned NOT NULL,
                `location_id` int(10) unsigned NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 COLLATE=utf8mb4_unicode_ci ;",

            "CREATE TABLE IF NOT EXISTS `cv_library` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `vacancy_id` int(10) unsigned DEFAULT 0,
                `candidate_id` int(10) unsigned DEFAULT 0,
                `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
                `email` varchar(200) NOT NULL,
                `tel` varchar(30) default NULL,
                `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `linkedin` varchar(150) DEFAULT NULL,
                `job_spec` varchar(50) DEFAULT NULL,
                `cv` varchar(50) DEFAULT NULL,
                `status` varchar(100) DEFAULT '',
                `application_id` int(10) unsigned DEFAULT 0 COMMENT 'Bullhorn field',
                `bh_notes` varchar (255)  DEFAULT 'Integration access revoked' COMMENT 'Bullhorn field',
                `bh_candidate_id` int(10) unsigned DEFAULT 0 COMMENT 'Bullhorn field',
                `deleted` enum('no', 'yes') DEFAULT 'no',
                `time` int(10) unsigned,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 COLLATE=utf8mb4_unicode_ci ;",

            "CREATE TABLE IF NOT EXISTS `vacancies_analytics` (
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

             "CREATE TABLE IF NOT EXISTS `vacancies_referrers` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `vacancy_id` int(10) unsigned DEFAULT 0,
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

        }

        foreach ($queries as $query)
            self::query($query);
    }

    /**
     * @param $id
     * @return array|object|null
     */
    public static function getApplication($id)
    {
        $sql = "
            SELECT *
            FROM `cv_library`
            WHERE `id` = '$id'
            LIMIT 1
        ";

        return self::fetch(self::query($sql));
    }


    /**
     * @param false $where
     * @return array
     */
    public static function getAppWhere($where = false)
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
     * Get user by $id
     * @param $id
     * @return array|object|null
     */
    public static function get($id)
    {
        $sql = "
            SELECT *
            FROM `vacancies`
            WHERE `id` = '$id'
            LIMIT 1
        ";

        $vacancy = self::fetch(self::query($sql));

        if ($vacancy) {
            $vacancy = self::relationship($vacancy, 'vacancies', 'locations');
            $vacancy = self::relationship($vacancy, 'vacancies', 'sectors');

            // Customers
//            $vacancy->customer_ids = array();
//            $vacancy->customers = array();
//            $customers = self::getVacancyCustomers($vacancy->id);
//
//            if (is_array($customers) && count($customers)) {
//                foreach ($customers as $customer) {
//                    $vacancy->customer_ids[] = $customer->customer_id;
//                    $vacancy->customers[] = $customer;
//                }
//            }
        }

        return $vacancy;
    }

    /**
     * Get all
     * @return array
     */
    public static function getAll($microsite_id = false, $limit = false, $where = false, $status = 'no')
    {
        $sql = "
           SELECT *,
            (SELECT COUNT(`id`) FROM `cv_library` cl WHERE cl.`vacancy_id` = v.`id` AND cl.`deleted` = 'no') as 'applications'
            FROM `vacancies` v
            WHERE v.`deleted` = '$status'
        ";

        if ($microsite_id !== false)
            $sql .= " AND `microsite_id` = '$microsite_id'";

        if ($where !== false)
            $sql .=  $where;

        $sql .= " ORDER BY `time` DESC, `id` DESC";

        if (is_numeric($limit))
            $sql .= " LIMIT $limit";

        $vacancies = self::fetchAll(self::query($sql));

        if ($vacancies) {
            $vacancies = self::relationship($vacancies, 'vacancies', 'locations');
            $vacancies = self::relationship($vacancies, 'vacancies', 'sectors');
            $vacancies = self::relationship($vacancies, 'vacancies', 'users', ['id', 'firstname', 'lastname'], false, 'consultant_id', 'one_to_many');
        }

        return $vacancies;
    }

    public static function getLatest($limit = 6)
    {
        $sql = "
            SELECT *
            FROM `vacancies`
            WHERE `deleted` = 'no'
            ORDER BY `time` DESC
            LIMIT $limit
        ";
        return self::fetchAll(self::query($sql));
    }

    public static function getSortedByField($field, $limit = 12)
    {
        $sql = "
            SELECT *
            FROM `vacancies`
            WHERE `deleted` = 'no'
            ORDER BY `$field` DESC
            LIMIT $limit
        ";
        return self::fetchAll(self::query($sql));
    }

    public static function getSectors()
    {
        $sql = "
            SELECT *,  (SELECT COUNT(*) FROM vacancies_sectors WHERE sector_id = sectors.id) AS total
            FROM `sectors`
            WHERE `deleted` = 'no'
            ORDER BY `name` ASC
        ";

        return self::fetchAll(self::query($sql));
    }

    public static function getVacancySectors($vid)
    {
        $sql = "
            SELECT `vacancies_sectors`.*, `sectors`.`name` as `sector_name`
            FROM `vacancies_sectors`
            LEFT JOIN `sectors` ON `sectors`.`id` = `vacancies_sectors`.`sector_id`
            WHERE `vacancies_sectors`.`vacancy_id` = '$vid'
        ";

        return self::fetchAll(self::query($sql));
    }

    public static function getVacancyLocations($vid)
    {
        $sql = "
            SELECT `vacancies_locations`.*, `locations`.`name` as `location_name`
            FROM `vacancies_locations`
            LEFT JOIN `locations` ON `locations`.`id` = `vacancies_locations`.`location_id`
            WHERE `vacancies_locations`.`vacancy_id` = '$vid'
        ";

        return self::fetchAll(self::query($sql));
    }

    public static function getVacancyConsultant($uid)
    {
        $sql = "
            SELECT * from `users` WHERE `id` = '$uid'
        ";

        return self::fetch(self::query($sql));
    }

    public static function removeSectors($vid)
    {
        $sql = "
            DELETE 
            FROM `vacancies_sectors` 
            WHERE `vacancy_id` = '$vid'
        ";

        return self::query($sql);
    }

    public static function removeLocations($vid)
    {
        $sql = "  
            DELETE 
            FROM `vacancies_locations` 
            WHERE `vacancy_id` = '$vid'
        ";

        return self::query($sql);
    }

    public static function getVacanciesByConsultant($consultant_id, $limit = null, $where = false)
    {
        $sql = "
            SELECT * from `vacancies` 
            WHERE `id` IN (SELECT `vacancy_id` FROM `vacancies_customers` WHERE `customer_id` = '$consultant_id')
            AND `deleted` = 'no'
        ";

        if ($where !== false)
            $sql .= "AND $where";

        $sql .= " ORDER BY `time` DESC, `id` DESC";

        if(is_numeric($limit))
            $sql .= " LIMIT $limit ";

        return self::fetchAll(self::query($sql));
    }

    public static function getViewsByDays($id, $days = 9)
    {
        $sql = "
            SELECT *
            FROM `vacancies_analytics`
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
            FROM `vacancies_analytics`
            WHERE `entity_id` = '$id' AND (`referrer` != '' OR `ref` != '')
        ";

        return self::fetchAll(self::query($sql));
    }

    public static function getReferrersList($id)
    {
        $sql = "
            SELECT *
            FROM `vacancies_referrers`
            WHERE `vacancy_id` = '$id'
        ";

        return self::fetchAll(self::query($sql));
    }

    public static function getReferrer($id)
    {
        $sql = "
            SELECT *
            FROM `vacancies_referrers`
            WHERE `id` = '$id'
        ";

        return self::fetch(self::query($sql));
    }

    /**
     * Total count of records without filtering for ajax Pagination.
     *
     * @param false $where
     * @param string $whereByArchive
     * @param string $mainWhere
     * @return array
     */
    public static function getCountWithFiltering($where = '', $whereByArchive = '', $mainWhere = '')
    {
        $sql = "
            SELECT COUNT(`id`)
            FROM `vacancies`
            WHERE $whereByArchive $where $mainWhere
        ";

        return self::fetch(self::query($sql), 'row')[0];
    }

    public static function countActive($where = false)
    {
        $sql = "
            SELECT COUNT(`id`)
            FROM `vacancies`
            WHERE `deleted` = 'no' AND (`time_expire` > '" . (time() - 180) . "' OR `time_expire` = 0)
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
            FROM `vacancies`
            WHERE `deleted` = 'no' AND (`time_expire` > '" . (time() - 180) . "' OR `time_expire` = 0)
            $where";

        if ($orderby != 'sectors' && $orderby != 'locations' && $orderby != 'applies') {
            if ($orderby && $sort) {
                $sql .= " ORDER BY $orderby $sort ";
            }
        }

        $vacancies = self::fetchAll(self::query($sql));

        $idsVacancies = array_column($vacancies, 'id');
        $applies = array_column($idsVacancies ? self::getApplies($idsVacancies) : [], 'applies', 'vacancy_id');

        foreach ($vacancies as $vacancy) {
            if (isset($applies[$vacancy->id])) {
                $vacancy->applies = $applies[$vacancy->id];
            } else {
                $vacancy->applies = 0;
            }
        }

        $vacancies = self::relationship($vacancies, 'vacancies', 'sectors');
        $vacancies = self::relationship($vacancies, 'vacancies', 'locations');

//        if ($orderby == 'sectors' || $orderby == 'locations' || $orderby == 'applies') {
//            if ($orderby != 'applies') {
//                eval(sprintf('function cmpString($a, $b) {
//                   $a = strtolower($a->%s[0]->name);
//                   $b = strtolower($b->%s[0]->name);
//
//                    if ($a == $b) {
//                        return 0;
//                    }
//
//                    return ($a < $b) ? -1 : 1;
//                }', $orderby, $orderby));
//
//                usort($vacancies, 'cmpString');
//            } else {
//                uasort($vacancies, 'cmpApplies');
//            }
//
//            if ($sort == 'asc') {
//                $vacancies = array_reverse($vacancies);
//            }
//        }

        if ($start !== false && $end !== false) {
            $vacancies = array_slice($vacancies, $start, $end);
        }

        return $vacancies;
    }

    public static function getApplies($ids)
    {
        $sql = "
            SELECT `vacancy_id`, COUNT(`id`) as `applies`
            FROM `cv_library` 
            WHERE `vacancy_id` in (" . implode(',', $ids) . ")
            GROUP BY `vacancy_id`
        ";

        return self::fetchAll(self::query($sql));
    }

    public static function getByLocationSector($keywords)
    {
        //get relations with locations
        $vacanciesIdsByLocations = [];
        $vacanciesIdsBySectors = [];

        if ($keywords) {
            $idsLocations = array_column(Model::fetchAll(Model::select('locations', " `name` like '%$keywords%'")), 'id');
            $idsSector = array_column(Model::fetchAll(Model::select('sectors', " `name` like '%$keywords%'")), 'id');

            if ($idsSector) {
                $vacanciesIdsBySectors = array_column(Model::fetchAll(Model::select('vacancies_sectors', " `sector_id` IN (" . implode(',', $idsSector) . ")")), 'vacancy_id');
            }

            if ($idsLocations) {
                $vacanciesIdsByLocations = array_column(Model::fetchAll(Model::select('vacancies_locations', " `location_id` IN (" . implode(',', $idsLocations) . ")")), 'vacancy_id');
            }
        }

        $vacanciesIds = array_merge($vacanciesIdsBySectors, $vacanciesIdsByLocations);

        if ($vacanciesIds) {
            $vacanciesIds = array_unique($vacanciesIds);

            return " or `id` IN (" . implode(',', $vacanciesIds) . ") ";
        } else {
            return '';
        }
    }

    public static function getVacanciesForConsultant($consultant_id)
    {
        $sql = "
           SELECT *,
            (SELECT COUNT(`id`) FROM `cv_library` cl WHERE cl.`vacancy_id` = v.`id`) as 'applications'
            FROM `vacancies` v
            WHERE v.`deleted` = 'no' AND v.`consultant_id` = '$consultant_id'
            AND (`time_expire` > '" . (time() - 180) . "' OR `time_expire` = 0)
        ";

        $sql .= " ORDER BY `time` DESC, `id` DESC";

        $vacancies = self::fetchAll(self::query($sql));

        if (is_array($vacancies) && count($vacancies)) {
            foreach ($vacancies as $vacancy) {
                // Sectors
                $vacancy->sector_ids = array();
                $vacancy->sectors = array();
                $sectors = self::getVacancySectors($vacancy->id);

                if (is_array($sectors) && count($sectors)) {
                    foreach ($sectors as $sector) {
                        $vacancy->sector_ids[] = $sector->id;
                        $vacancy->sectors[] = $sector;
                    }
                }

                // Locations
                $vacancy->location_ids = array();
                $vacancy->locations = array();
                $locations = self::getVacancyLocations($vacancy->id);

                if (is_array($locations) && count($locations)) {
                    foreach ($locations as $location) {
                        $vacancy->location_ids[] = $location->location_id;
                        $vacancy->locations[] = $location;
                    }
                }

                // Consultant
                if ($vacancy->consultant_id)
                    $vacancy->consultant = self::getVacancyConsultant($vacancy->consultant_id);
            }
        }

        return $vacancies;
    }
}

/* End of file */
