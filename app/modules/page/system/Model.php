<?php
class PageModel extends Model
{
    public $version = 5;

    /**
     * Method module_install start automatically if it not exist in `modules` table at first importing of model
     */
    public function module_install()
    {
        $queries = array(
            "CREATE TABLE IF NOT EXISTS `modules` (
               `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
               `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
               `version` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
               `visible` varchar(10) DEFAULT 'no',
               `time` int(10) unsigned NOT NULL,
               PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 COLLATE=utf8mb4_unicode_ci ;",

            "CREATE TABLE IF NOT EXISTS `settings`(
                `name` VARCHAR(150) NOT NULL,
                `title` VARCHAR(150) NOT NULL,
                `value` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                PRIMARY KEY(`name`)
            ) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;",

            "CREATE TABLE IF NOT EXISTS `guests` (
               `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
               `ip` varchar(30) DEFAULT NULL,
               `browser` varchar(255) DEFAULT NULL,
               `referer` varchar(255) DEFAULT NULL,
               `count` int(11) NOT NULL DEFAULT '0',
               `time` int(11) UNSIGNED NOT NULL,
               PRIMARY KEY (`id`),
               UNIQUE KEY (`ip`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 COLLATE=utf8mb4_unicode_ci ;",

            "CREATE TABLE IF NOT EXISTS `logs` (
               `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
               `user_id` int(10) unsigned DEFAULT 0,
               `where` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
               `error` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
               `status` enum('mysql','php') DEFAULT 'mysql',
               `time` varchar(20) DEFAULT '',
               PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 COLLATE=utf8mb4_unicode_ci ;",

            "CREATE TABLE IF NOT EXISTS `redirects` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `uri_from` varchar(200) NOT NULL,
                `uri_to` varchar(200) DEFAULT NULL,
                `deleted` enum('no','yes') DEFAULT 'no',
                `time` int(10) unsigned DEFAULT 0,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 COLLATE=utf8mb4_unicode_ci ;",

            "CREATE TABLE IF NOT EXISTS `data_versions` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `user_id` int(10) unsigned NOT NULL,
                `entity_id` varchar(255) NOT NULL,
                `data` json DEFAULT NULL,
                `table` varchar(255) DEFAULT NULL,
                `type` varchar(255) DEFAULT NULL,
                `entity_type` VARCHAR(255) DEFAULT 'default',
                `deleted` enum('no','yes') DEFAULT 'no',
                `time` int(10) unsigned NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 COLLATE=utf8mb4_unicode_ci ;",

            "CREATE TABLE IF NOT EXISTS `users` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `email` varchar(200) NOT NULL,
                `password` varchar(60) DEFAULT '',
                `token` varchar(50) DEFAULT NULL,
                `role` enum('unconfirmed', 'user','moder','master','admin', 'superadmin') DEFAULT 'unconfirmed',
                `firstname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
                `lastname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
                `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `tel` varchar(30) NOT NULL DEFAULT '',
                `skype` varchar(100) NOT NULL DEFAULT '',
                `twitter` varchar(100) NOT NULL DEFAULT '',
                `linkedin` varchar(150) NOT NULL DEFAULT '',
                `image` varchar(100) NOT NULL DEFAULT '',
                `job_title` varchar(150) DEFAULT NULL,
                `sectors` varchar(255) DEFAULT '',
                `locations` varchar(255) DEFAULT '',
                `location` varchar(255) DEFAULT '',
                `cv` varchar(150) DEFAULT NULL,
                `display_team` varchar(10) DEFAULT 'no',
                `sort` int(10) DEFAULT 0,
                `meta_title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
                `meta_keywords` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
                `meta_desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
                `slug` varchar(100) NOT NULL DEFAULT '',
                `deleted` enum('no','yes') DEFAULT 'no',
                `reg_time` int(10) unsigned NOT NULL,
                `last_time` int(10) unsigned NOT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY (`email`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 COLLATE=utf8mb4_unicode_ci ;",

            "CREATE TABLE IF NOT EXISTS `user_images` (
               `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
               `user_id` int(10) unsigned DEFAULT 0,
               `image` varchar(100) DEFAULT NULL,
               PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 COLLATE=utf8mb4_unicode_ci ;",

            "CREATE TABLE IF NOT EXISTS `content_pages_tree` (
               `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
               `module` varchar(100) NOT NULL,
               `page` varchar(50) NOT NULL,
               `name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
               `alias` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
               `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
               `type` enum('input','textarea','image','video', 'picture', 'meta','file','page_name') NOT NULL DEFAULT 'textarea',
               `image_width` varchar(200) DEFAULT NULL,
               `image_height` varchar(200) DEFAULT NULL,
               `video_type` varchar(200) DEFAULT '',
               `position` int(10) unsigned DEFAULT '0',
               `time` int(10) unsigned NOT NULL,
               PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 COLLATE=utf8mb4_unicode_ci ;",

            "CREATE TABLE IF NOT EXISTS `actions_logs` (
               `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
               `user_id` int(10) unsigned NOT NULL,
               `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
               `entity` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
               `time` int(11) DEFAULT 0,
               PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 COLLATE=utf8mb4_unicode_ci ;",

            "CREATE TABLE IF NOT EXISTS `email_logs` (
               `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
               `email` varchar(255) DEFAULT '',
               `entity` varchar(255) DEFAULT '',
               `status` varchar(50) DEFAULT 'send',
               `token` varchar(50) DEFAULT '',
               `time` int(11) DEFAULT 0,
               PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 COLLATE=utf8mb4_unicode_ci ;",

            "CREATE TABLE IF NOT EXISTS `sitemap` (
               `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
               `link` varchar(255) DEFAULT NULL,
               PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 COLLATE=utf8mb4_unicode_ci ;",

            "CREATE TABLE IF NOT EXISTS `subscribers` (
               `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
               `email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
               `name` varchar(255) DEFAULT NULL,
               `tel` varchar(255) DEFAULT NULL,
               `location` varchar(255) DEFAULT NULL,
               `deleted` enum('no','yes') DEFAULT 'no',
               `sectors` varchar(255) DEFAULT NULL,
               `time` varchar(20) DEFAULT '',
               PRIMARY KEY (`id`),
               UNIQUE KEY (`email`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 COLLATE=utf8mb4_unicode_ci ;",

            "CREATE TABLE IF NOT EXISTS `refer_friend` (
              `id` int unsigned NOT NULL AUTO_INCREMENT,
              `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
              `friend_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
              `email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
              `friend_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
              `tel` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
              `friend_tel` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
              `deleted` enum('no','yes') COLLATE utf8mb4_unicode_ci DEFAULT 'no',
              `cv` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
              `time` int unsigned NOT NULL DEFAULT 0,
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
            case '0':
                $queries[] = "INSERT INTO `users` (`id`, `email`, `password`, `role`, `firstname`, `lastname`, `job_title`, `slug`, `deleted`, `reg_time`, `last_time`) VALUES
                    (1, 'user@gmail.com', '0cef1fb10f60529028a71f58e54ed07b', 'user', 'Alex', 'Userov', 'Developers', 'tom-wild', 'no', 1581189342, 1585141182);";
                $queries[] = "INSERT INTO `users` (`id`, `email`, `password`, `role`, `firstname`, `lastname`, `job_title`, `slug`, `deleted`, `reg_time`, `last_time`) VALUES
                    (2, 'admin@gmail.com', 'fb6dfc7542d4cf878dc958024bd14ef3', 'admin', 'Admin', 'Admin', 'Manager', 'manager-manager', 'no', 1581189342, 1585141182);";
                $queries[] = "INSERT INTO `users` (`id`, `email`, `password`, `role`, `firstname`, `lastname`, `job_title`, `slug`, `deleted`, `reg_time`, `last_time`) VALUES
                    (3, 'master@gmail.com', '613ba0a0b709a943a6d5b7fcd83ecf32', 'master', 'Master', 'Master', 'Tester', 'tester-tester', 'no', 1581189342, 1585141182);";
                $queries[] = "INSERT INTO `users` (`id`, `email`, `password`, `role`, `firstname`, `lastname`, `job_title`, `slug`, `deleted`, `reg_time`, `last_time`) VALUES
                    (4, 'manager@gmail.com', '24af45f1feb24889340909b0aa890f38', 'moder', 'Manager', 'Manager', 'Front', 'front-front', 'no', 1581189342, 1585141182);";
                $queries[] = "INSERT INTO `users` (`id`, `email`, `password`, `role`, `firstname`, `lastname`, `job_title`, `slug`, `deleted`, `reg_time`, `last_time`) VALUES
                    (5, 'back@gmail.com', 'b7d7384fa7bbf3cea37bd135ef48fe3e', 'superadmin', 'Back', 'Back', 'Back', 'back-back', 'no', 1581189342, 1585141182);";

            case '1':
                $queries[] = "ALTER TABLE `users` ADD COLUMN `restore_token` varchar(255) DEFAULT NULL AFTER `token`;";
            case '2':
                $queries[] = "CREATE TABLE IF NOT EXISTS `users_session` (
                    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                    `user_id` int(10) unsigned NOT NULL,
                    `scope` varchar(64) NOT NULL DEFAULT 'user',
                    `session` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                    `status` tinyint(3) unsigned NOT NULL DEFAULT 1,
                    `created` int(10) unsigned NOT NULL,
                    `updated` int(10) unsigned NOT NULL,
                    `ip` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                    PRIMARY KEY (`id`),
                    KEY (`user_id`),
                    UNIQUE KEY (`session`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 COLLATE=utf8mb4_unicode_ci ;";
            case '3':
                $queries[] = "CREATE TABLE IF NOT EXISTS `alt_attributes` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `entity` varchar(255) DEFAULT NULL,
                `entity_id` int(10) unsigned,
                `field_name` varchar(200) DEFAULT NULL,
                `alt` varchar(255) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 COLLATE=utf8mb4_unicode_ci ;";
             case '4':
                $queries[] =  "CREATE TABLE IF NOT EXISTS `modules` (
                    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                    `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
                    `version` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
                    `visible` varchar(10) DEFAULT 'no',
                    `time` int(10) unsigned NOT NULL,
                    PRIMARY KEY (`id`)
                 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 COLLATE=utf8mb4_unicode_ci ;
                 
                 
                 CREATE TABLE IF NOT EXISTS `attendance` (
                    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                    `user_id` int(10) unsigned NOT NULL,
                    `shop_id` int(10) unsigned DEFAULT NULL,
                    `type` enum('check_in','check_out') DEFAULT 'check_in',
                    `scan_time` datetime NOT NULL,
                    `date` date NOT NULL,
                    `ip` varchar(45) DEFAULT NULL,
                    `device` varchar(255) DEFAULT NULL,
                    PRIMARY KEY (`id`),
                    KEY `user_id` (`user_id`),
                    KEY `date` (`date`),
                    KEY `shop_id` (`shop_id`)
                 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 COLLATE=utf8mb4_unicode_ci ;";
//            case '1':
//                $queries[] = "ALTER TABLE `vacancies_analytics` CHANGE COLUMN `vacancy_id` `entity_id` int(10) unsigned DEFAULT 0;";
//                $queries[] = "ALTER TABLE `blogs_analytics` CHANGE COLUMN `blog_id` `entity_id` int(10) unsigned DEFAULT 0;";
//                $queries[] = "ALTER TABLE `microsites_analytics` CHANGE COLUMN `microsite_id` `entity_id` int(10) unsigned DEFAULT 0;";
        }

        foreach ($queries as $query)
            self::query($query);
    }

    public static function getSectors()
    {
        $sql = "
            SELECT *
            FROM `sectors`
            WHERE `deleted` = 'no'
            ORDER BY `id` ASC
        ";

        $sectors = self::fetchAll(self::query($sql));

        if (is_array($sectors) && count($sectors)) {
            foreach ($sectors as $sector) {
                // Vacancies
                $sector->vacancies = array();
                $vacancies = self::getSectorVacancies($sector->id);

                if (is_array($vacancies) && count($vacancies))
                    foreach ($vacancies as $vacancy)
                        $sector->vacancies[] = $vacancy;
            }
        }

        return $sectors;
    }

    public static function getSectorVacancies($sid)
    {
        $sql = "
            SELECT *
            FROM `vacancies`
            WHERE `deleted` = 'no' AND (`id` IN (SELECT `vacancy_id` FROM `vacancies_sectors` WHERE `sector_id` = '$sid'))
            LIMIT 5
        ";

        $vacancies = self::fetchAll(self::query($sql));

        if (is_array($vacancies) && count($vacancies)) {
            foreach ($vacancies as $vacancy) {
                // Locations
                $vacancy->locations = array();
                $locations = self::getVacancyLocations($vacancy->id);

                if (is_array($locations) && count($locations))
                    foreach ($locations as $location)
                        $vacancy->locations[] = $location;
            }
        }

        return $vacancies;
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


    // Content pages ---------

    public static function checkContentPage($name = false, $module = CONTROLLER, $page = ACTION)
    {
        $sql = "
            SELECT *
            FROM `content_pages_tree`
            WHERE `module` = '$module' AND `page` = '$page' AND `name` = '$name'
            LIMIT 1
        ";

        return self::fetch(self::query($sql));
    }


    /**
     * Create session
     * @param $uid
     * @param string $scope
     * @return false|string
     */
    public static function createSession($uid, $scope = 'user')
    {
        $token = genToken();
        $result = self::insert('users_session', [
            'user_id' => $uid,
            'scope'   => $scope,
            'session' => $token,
            'created' => time(),
            'updated' => time(),
            'ip'      => getIP(),
        ]);
        $insertID = Model::insertID();

        if (!$result && $insertID)
            return $token;

        return false;
    }

    /**
     * Get user session
     * @param $token
     * @return array|object|null
     */
    public static function getSession($token)
    {
        $sql = "
            SELECT *
            FROM `users_session`
            WHERE `session` = '$token'
            LIMIT 1
        ";

        return self::fetch(self::query($sql));
    }

    public static function closeSession($token)
    {
        self::update('users_session', ['status' => 0], "`session` = '$token' LIMIT 1");
    }

    public static function closeAllSessions($id)
    {
        self::update('users_session', ['status' => 0], "`user_id` = '$id'");
    }

    /**
     * Get user by id
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

        return self::fetch(self::query($sql));
    }

    /**
     * Get user by email
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

        return self::fetch(self::query($sql));
    }

    /**
     * @param $email
     * @return array|object|null
     */
    public static function getCandidateByEmail($email)
    {
        $sql = "
            SELECT *
            FROM `candidates`
            WHERE `email` = '$email' 
            LIMIT 1
        ";

        return self::fetch(self::query($sql));
    }

    /**
     * Get guest by id
     * @param $id
     * @return array|object|null
     */
    public static function getGuestByID($id)
    {
        $sql = "
            SELECT *
            FROM `guests`
            WHERE `id` = '$id'
            LIMIT 1
        ";

        return self::fetch(self::query($sql));
    }

    /**
     * Get guest by ip
     * @param $ip
     * @return array|object|null
     */
    public static function getGuestByIP($ip)
    {
        $sql = "
            SELECT *
            FROM `guests`
            WHERE `ip` = '$ip'
            LIMIT 1
        ";

        return self::fetch(self::query($sql));
    }

    /**
     * Update last visit time & etc.. in preDispatch
     * @param $id
     * @param $data
     * @return string
     */
    public static function updateUserByID($id, $data)
    {
        return self::update('users', $data, "`id` = '$id' LIMIT 1");
    }
}

/* End of file */
