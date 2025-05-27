<?php
class PanelModel extends Model
{
    public $version = 0;

    /**
     * Method module_install start automatically if it not exist in `modules` table at first importing of model
     */
    public function module_install()
    {
        $queries = array(
            "CREATE TABLE IF NOT EXISTS `last_uploaded_images` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `image` varchar(60) DEFAULT NULL,
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
//                $queries[] = "ALTER TABLE `tech_stack` ADD COLUMN `subtitle` varchar(200) DEFAULT NULL AFTER `subtitle`;";
//                $queries[] = "ALTER TABLE `vacancies_analytics` CHANGE COLUMN `vacancy_id` `entity_id` int(10) unsigned DEFAULT 0;";
        }

        foreach ($queries as $query)
            self::query($query);
    }

    /**
     * Get user by $id
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

    public static function getValues($table, $column)
    {
        $sql = "
            SELECT `$column`
            FROM `$table`
        ";

        $result =  self::fetchAll(self::query($sql));
        $values = [];
        if ($result)
            foreach ($result as $v)
            {
                $values[] = $v->$column;
            }
        return $values;
    }

    public static function dataInsert( $table, $columns, $fields)
    {
        if (is_array($columns)) {
            $columnsString = '`' . implode("`, `", $columns) . '`';
        } else {
            $columnsString = $columns;
        }
        $fieldsString = '';
        foreach ($fields as $k => $field){
            if ($k == array_key_last($fields))
                $fieldsString .= "('" . implode("', '", $field) . "')";
            else
                $fieldsString .= "('" . implode("', '", $field) . "'), ";
        }

        $query = "INSERT INTO `$table` ($columnsString) VALUES $fieldsString;";

        self::query($query);
        return self::errno();


    }

    public static function getUsersOnline($minutes = 10)
    {
        $sql = "
            SELECT `id`, `nickname`, `email`, `role`, `last_time`
            FROM `users`
            WHERE `last_time` >= '" . (time() - $minutes * 60) . "'
        ";

        return self::query($sql);
    }

    // COUNTERS

    public static function countUsers($where = false)
    {
        $sql = "
            SELECT COUNT(`id`)
            FROM `users`
        ";

        if ($where)
            $sql .= "WHERE ".$where;

        return self::fetch(self::query($sql), 'row')[0];
    }


    /*---------- Guests ----------*/

    public static function countGuests($where = false)
    {
        $sql = "
            SELECT COUNT(`id`)
            FROM `guests`
        ";

        if ($where)
            $sql .= "WHERE ".$where;

        return self::fetch(self::query($sql), 'row')[0];
    }

    public static function getGuests($field, $search)
    {
        // TODO make count() instead select *
        $sql = "
            SELECT *
            FROM `guests`
        ";

        if ($field && $search)
            $sql .= "WHERE `$field` LIKE '%$search%'";

        return self::query($sql);
    }

    public static function getData()
    {
        // TODO make count() instead select *
        $sql = "
            SELECT *
            FROM `data`
        ";


        return self::fetchAll(self::query($sql));
    }

    public static function getGuestsOnline($minutes = 10)
    {
        $sql = "
            SELECT INET_NTOA(`ip`) AS 'ip', `browser`, `referer`, `count`, `time`
            FROM `guests`
            WHERE `time` >= '" . (time() - $minutes * 60) . "'
        ";

        return self::query($sql);
    }

    public static function getUserLogs()
    {
        $sql = "
            SELECT *
            FROM `actions_logs`
            ORDER BY `time` DESC
            LIMIT 100
        ";

        $logs = self::fetchAll(self::query($sql));

        if (is_array($logs) && count($logs) > 0) {
            Model::import('panel/team');
            foreach ($logs as $log) {
                $user = TeamModel::getUser($log->user_id);
                if ($user)
                    $log->user = $user;
            }
        }

        return $logs;
    }
}

/* End of file */