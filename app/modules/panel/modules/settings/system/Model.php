<?php
class SettingsModel extends Model
{
    public $version = 1;

    /**
     * Method module_install start automatically if it not exist in `modules` table at first importing of model
     */
    public function module_install()
    {
        $queries = array();

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
     * Get setting by $name
     * @param $name
     * @return array|object|null
     */
    public static function get($name)
    {
        $sql = "
            SELECT *
            FROM `settings`
            WHERE `name` = '$name'
            LIMIT 1
        ";

        $res = self::fetch(self::query($sql));
        return $res->value ?? '';
    }

    /**
     * @param $row
     * @return array
     */
    public static function getList($row)
    {
        $sql = "
            SELECT *
            FROM `settings`
            WHERE `name` IN ($row)
        ";

        return self::fetchAll(self::query($sql), 'object', 'name');
    }

    /**
     * Get all
     * @return array
     */
    public static function getAll()
    {
        $sql = "
            SELECT *
            FROM `settings`
        ";

        return self::fetchAll(self::query($sql));
    }


    public static function set($name, $value)
    {
        if (!self::count_rows($name)) {
            Model::insert('settings', array(
                'name' => "$name",
                'title' => "$name",
                'value' => "$value"
            ));
        } else {
            Model::update('settings', array(
                'title' => "$name",
                'value' => "$value"
            ), "`name` = '$name'");
        }

        return true;
    }

    /**
     * @param bool $name
     * @param string $countField
     * @return mixed
     */
    public static function count_rows($name = false, $countField = '*')
    {
        if ($countField === '*')
            $countFieldPart = $countField;
        else
            $countFieldPart = '`'.$countField.'`';

        $sql = "
            SELECT COUNT($countFieldPart)
            FROM `settings`
        ";

        if ($name)
            $sql .= "WHERE `name` = '$name'";

        return self::fetch(self::query($sql), 'row')[0];
    }
}

/* End of file */