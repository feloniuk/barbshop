<?php
class Data_versionsModel extends Model
{
    public $version = 0; // increment it for auto-update

    /**
     * Method module_install start automatically if it not exist in `modules` table at first importing of model
     */
    public function module_install()
    {
        $queries = [];

        foreach ($queries as $query)
            self::query($query);
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

        foreach ($queries as $query)
            self::query($query);
    }

    public static function get($id)
    {
        $sql = "
            SELECT *
            FROM `data_versions`
            WHERE `id` = '$id'
            LIMIT 1
        ";

        return self::fetch(self::query($sql));
    }

    /**
     * Get all
     * @return array
     */
    public static function getAll($module = false)
    {
        $sql = "
            SELECT *
            FROM `data_versions`
            WHERE `deleted` = 'no'
        ";

        if ($module)
            $sql .= " AND `table` = '$module' ";

        $sql .= " ORDER BY `time` DESC";

        $versions = self::fetchAll(self::query($sql));

        $versions = self::relationship($versions, 'data_versions', 'users', ['id', 'firstname', 'lastname'],
            false, false, 'one_to_many');

        return $versions;
    }

    public static function search($where, $orderby, $sort, $start = false, $end = false)
    {
        $sql = " 
            SELECT * 
            FROM `data_versions` 
            WHERE `deleted` = 'no' 
            $where ";

        if ($orderby && $sort) {
            $sql .= " ORDER BY $orderby $sort ";
        }
        if ($start !== false && $end !== false) {
            $sql .= " LIMIT $start, $end ";
        }

        $versions =  self::fetchAll(self::query($sql));

        $versions = self::relationship($versions, 'data_versions', 'users', ['id', 'firstname', 'lastname'],
            false, false, 'one_to_many');

        return $versions;

    }

    public static function getArchived()
    {
        $sql = "
            SELECT *
            FROM `data_versions`
            WHERE `deleted` = 'yes'
        ";

        return self::fetchAll(self::query($sql));
    }
}

/* End of file */