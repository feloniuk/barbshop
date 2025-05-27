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

    public static function recordScan($user_id, $shop_id = null)
    {
        // Проверяем последнюю запись на сегодня
        $today = date('Y-m-d');
        $lastScan = self::getLastScan($user_id, $today);

        $type = 'check_in';
        if ($lastScan && $lastScan->type == 'check_in') {
            $type = 'check_out';
        }

        // Записываем сканирование
        $data = [
            'user_id' => $user_id,
            'shop_id' => $shop_id ?: 1,
            'type' => $type,
            'scan_time' => date('Y-m-d H:i:s'),
            'date' => $today,
            'ip' => getIP(),
            'device' => $_SERVER['HTTP_USER_AGENT'] ?? ''
        ];

        $result = self::insert('attendance', $data);

        // Получаем название магазина
        $shop_name = '';
        if ($shop_id) {
            Model::import('panel/shops');
            $shop = ShopsModel::get($shop_id);
            if ($shop) {
                $shop_name = $shop->title;
            }
        }

        return [
            'success' => !$result,
            'type' => $type,
            'shop_name' => $shop_name
        ];
    }

    public static function getLastScan($user_id, $date)
    {
        $sql = "SELECT * FROM `attendance` 
                WHERE `user_id` = '$user_id' 
                AND `date` = '$date' 
                ORDER BY `scan_time` DESC 
                LIMIT 1";
        return self::fetch(self::query($sql));
    }

    public static function getTodayPresent()
    {
        $today = date('Y-m-d');
        $sql = "SELECT COUNT(DISTINCT user_id) as count 
                FROM `attendance` 
                WHERE `date` = '$today' 
                AND `type` = 'check_in'";
        $result = self::fetch(self::query($sql));
        return $result ? $result->count : 0;
    }

    public static function getTotalWorkDays($date_from, $date_to)
    {
        $sql = "SELECT COUNT(DISTINCT date) as count 
                FROM `attendance` 
                WHERE `date` BETWEEN '$date_from' AND '$date_to'";
        $result = self::fetch(self::query($sql));
        return $result ? $result->count : 0;
    }

    public static function getAverageHours($date_from, $date_to)
    {
        $totalHours = self::getTotalHours($date_from, $date_to);
        $totalDays = self::getTotalWorkDays($date_from, $date_to);
        
        return $totalDays > 0 ? $totalHours / $totalDays : 0;
    }

    public static function getSummaryStats($date_from, $date_to, $shop_id = null, $user_id = null)
{
    $where = "";
    if ($shop_id) {
        $where .= " AND a.shop_id = '$shop_id'";
    }
    if ($user_id) {
        $where .= " AND a.user_id = '$user_id'";
    }

    // Сначала получаем количество рабочих дней в периоде (исключая выходные)
    $workDaysQuery = "
        SELECT COUNT(*) as work_days
        FROM (
            SELECT DATE_ADD('$date_from', INTERVAL seq DAY) as date
            FROM (
                SELECT a.N + b.N * 10 as seq
                FROM 
                    (SELECT 0 AS N UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) a,
                    (SELECT 0 AS N UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) b
            ) seq_table
            WHERE DATE_ADD('$date_from', INTERVAL seq DAY) <= '$date_to'
        ) date_range
        WHERE DAYOFWEEK(date) NOT IN (1, 7)
    ";
    
    $workDaysResult = self::fetch(self::query($workDaysQuery));
    $totalWorkDays = $workDaysResult ? $workDaysResult->work_days : 0;

    $sql = "SELECT 
                u.id,
                u.firstname,
                u.lastname,
                u.image,
                COUNT(DISTINCT CASE WHEN a.type = 'check_in' THEN a.date END) as present_days,
                COALESCE(SUM(
                    CASE 
                        WHEN a.type = 'check_in' AND check_out.scan_time IS NOT NULL 
                        THEN TIMESTAMPDIFF(MINUTE, a.scan_time, check_out.scan_time) / 60
                        ELSE 0 
                    END
                ), 0) as total_hours,
                COUNT(DISTINCT CASE WHEN a.type = 'check_in' AND TIME(a.scan_time) > '10:00:00' THEN a.date END) as late_days,
                $totalWorkDays as total_days
            FROM users u
            LEFT JOIN attendance a ON u.id = a.user_id 
                AND a.type = 'check_in' 
                AND a.date BETWEEN '$date_from' AND '$date_to'
                $where
            LEFT JOIN attendance check_out ON a.user_id = check_out.user_id 
                AND a.date = check_out.date 
                AND check_out.type = 'check_out'
                AND check_out.scan_time > a.scan_time
            WHERE u.role IN ('master', 'admin', 'moder') 
                AND u.deleted = 'no'
            GROUP BY u.id";

    $stats = self::fetchAll(self::query($sql));

    // Вычисляем средние часы и отсутствующие дни
    foreach ($stats as &$stat) {
        $stat->avg_hours = $stat->present_days > 0 ? $stat->total_hours / $stat->present_days : 0;
        $stat->absent_days = max(0, $stat->total_days - $stat->present_days);
    }

    return $stats;
}
    public static function getDetailedRecords($date_from, $date_to, $shop_id = null, $user_id = null)
    {
        $where = "WHERE a.date BETWEEN '$date_from' AND '$date_to'";
        if ($shop_id) {
            $where .= " AND a.shop_id = '$shop_id'";
        }
        if ($user_id) {
            $where .= " AND a.user_id = '$user_id'";
        }

        $sql = "SELECT 
                    a.date,
                    u.firstname,
                    u.lastname,
                    s.title as shop_name,
                    MIN(CASE WHEN a.type = 'check_in' THEN a.scan_time END) as check_in,
                    MAX(CASE WHEN a.type = 'check_out' THEN a.scan_time END) as check_out,
                    CASE 
                        WHEN MAX(CASE WHEN a.type = 'check_out' THEN a.scan_time END) IS NOT NULL
                        THEN TIMESTAMPDIFF(
                            MINUTE,
                            MIN(CASE WHEN a.type = 'check_in' THEN a.scan_time END),
                            MAX(CASE WHEN a.type = 'check_out' THEN a.scan_time END)
                        ) / 60
                        ELSE NULL
                    END as hours_worked,
                    CASE 
                        WHEN MIN(CASE WHEN a.type = 'check_in' THEN TIME(a.scan_time) END) > '10:00:00' THEN 'late'
                        WHEN MIN(CASE WHEN a.type = 'check_in' THEN a.scan_time END) IS NULL THEN 'absent'
                        ELSE 'present'
                    END as status,
                    '' as notes
                FROM attendance a
                JOIN users u ON a.user_id = u.id
                LEFT JOIN shops s ON a.shop_id = s.id
                $where
                GROUP BY a.user_id, a.date
                ORDER BY a.date DESC, u.firstname";

        return self::fetchAll(self::query($sql));
    }

    public static function getUserStats($user_id, $date_from, $date_to)
    {
        return self::getSummaryStats($date_from, $date_to, null, $user_id)[0] ?? null;
    }
    public static function getTotalHours($date_from, $date_to)
{
    $sql = "SELECT 
                SUM(hours_worked) as total_hours
            FROM (
                SELECT 
                    user_id,
                    date,
                    TIMESTAMPDIFF(
                        MINUTE,
                        MIN(CASE WHEN type = 'check_in' THEN scan_time END),
                        MAX(CASE WHEN type = 'check_out' THEN scan_time END)
                    ) / 60 as hours_worked
                FROM attendance
                WHERE date BETWEEN '$date_from' AND '$date_to'
                GROUP BY user_id, date
                HAVING MIN(CASE WHEN type = 'check_in' THEN scan_time END) IS NOT NULL
                   AND MAX(CASE WHEN type = 'check_out' THEN scan_time END) IS NOT NULL
            ) as daily_hours";
    
    $result = self::fetch(self::query($sql));
    return $result && $result->total_hours ? $result->total_hours : 0;
}

    public static function getUserMonthlyData($user_id, $date_from, $date_to)
    {
        $sql = "SELECT 
                    DATE_FORMAT(date, '%Y-%m') as month,
                    COUNT(DISTINCT date) as days_worked,
                    SUM(
                        CASE 
                            WHEN check_out.scan_time IS NOT NULL 
                            THEN TIMESTAMPDIFF(MINUTE, a.scan_time, check_out.scan_time) / 60
                            ELSE 0 
                        END
                    ) as total_hours
                FROM attendance a
                LEFT JOIN attendance check_out ON a.user_id = check_out.user_id 
                    AND a.date = check_out.date 
                    AND check_out.type = 'check_out'
                    AND check_out.scan_time > a.scan_time
                WHERE a.user_id = '$user_id'
                    AND a.type = 'check_in'
                    AND a.date BETWEEN '$date_from' AND '$date_to'
                GROUP BY DATE_FORMAT(date, '%Y-%m')
                ORDER BY month";

        return self::fetchAll(self::query($sql));
    }

    public static function getExportData($date_from, $date_to, $shop_id = null, $user_id = null)
    {
        return self::getDetailedRecords($date_from, $date_to, $shop_id, $user_id);
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