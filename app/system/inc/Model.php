<?php
/**
 * MODEL
 */

class Model {

    public static $_db;

    public static $_errno = false;

    public static $_detectError = true;

    protected static $initialized = false;

//    static public function __construct()
//    {
//        Mysqli_DB::connectDatabase();
//        self::$_db = Mysqli_DB::$_db;
//    }

    /**
     * Method init to initialize db connection
     */
    public static function init()
    {
        if (self::$initialized)
            return;

        Mysqli_DB::connectDatabase();
        self::$_db = Mysqli_DB::$_db;
        self::$initialized = true;
    }

    public static function deinit()
    {
        Mysqli_DB::closeConnection();
        self::$_db = null;
        self::$initialized = false;
    }

    /**
     * Method import to connect other model
     * @param $model
     */
    public static function import($model)
    {
        $model = mb_strtolower($model);

        // Connect model
        if (file_exists($pathPrepared = modulePath($model) . 'system/Model.php'))
            include_once($pathPrepared);
        else
            exit("Can't connect model: " . $model);

        self::init();


        // install / update models

        // Create model object to take version
        $modelName = ucfirst(moduleName($model)) . 'Model';
        $objModel = new $modelName();

        $module = self::check_module_install($model); // Check module install in db

        if (!$module) { // Install
            $objModel->module_install();
            self::insert_module_row($model, 0);
            $module = self::check_module_install($model); // Check module install in db
            //print_data('Module installed!');
        }
        if ($module->version != $objModel->version) { // Update
            $objModel->module_update($module->version);
            self::update_module_row($model, $objModel->version);
            //print_data('Module updated!');
        }
    }


    /**
     * Method check_module_install called automatically to check model changes in `modules` table
     * @param $module
     * @return array|object|null
     */
    public static function check_module_install($module)
    {
        $query = "SELECT * FROM `modules` WHERE `name` = '$module' LIMIT 1";

        return self::fetch(self::query($query));
    }

    /**
     * Method insert_module_row called automatically to create module row in `modules` table
     * @param $module
     * @param $version
     * @return string
     */
    public static function insert_module_row($module, $version)
    {
        $moduleData = array();
        $moduleData['name'] = $module;
        $moduleData['version'] = $version;
        $moduleData['time'] = time();

        return self::insert('modules', $moduleData);
    }

    /**
     * Method update_module_row called automatically to update module model
     * @param $module
     * @param $version
     * @return string
     */
    public static function update_module_row($module, $version)
    {
        $moduleData = array();
        $moduleData['version'] = $version;
        $moduleData['time'] = time();

        return self::update('modules', $moduleData, "`name` = '$module'");
    }

    /**
     * Simple query, all errors are logged in `logs` table
     * @param $query
     * @return mixed
     */
    public static function query($query)
    {
        $result = self::$_db->query($query);

        // Mysql log  // WARN: be careful, if not exist `logs` table or not clear self::$_db->error - can be recursive recurrence !!!
        if (self::$_detectError === true && self::$_db->error) {
            self::$_detectError = false; // Stop detect Error
            self::$_errno = self::$_db->errno;

            if (!$uid = User::get('id'))
                $uid = 0;

            $log['user_id'] = $uid;
            $log['where'] = CONTROLLER ? CONTROLLER.'/'.ACTION : 'none';
            $log['error'] = filter(self::$_db->error. "\n <br><b>Query:</b> " .$query);
            $log['status'] = 'mysql';
            $log['time'] = date("H:i:s, d.m.Y", time());

            self::insert('logs', $log);
        }

        return $result;
    }

    /**
     * To process result of query
     * @param object $result
     * @param string $mode
     * @return array|null|object
     */
    public static function fetch($result, $mode = 'object')
    {
        switch ($mode) {
            case 'all':
                return mysqli_fetch_all($result, MYSQLI_ASSOC);
                break;

            case 'row':
                return mysqli_fetch_row($result);
                break;

            case 'assoc':
                return mysqli_fetch_assoc($result);
                break;

            case 'array':
                return mysqli_fetch_array($result);
                break;

            default:
                return mysqli_fetch_object($result);
                break;
        }
    }

    /**
     * To process many result of query
     * @param $result
     * @param string $mode
     * @param false $key
     * @return array
     */
    public static function fetchAll($result, $mode = 'object', $key = false)
    {
        $return = array();

        if ($result)
            while ($row = self::fetch($result, $mode)) {
                if ($key === false) {
                    $return[] = $row;
                    continue;
                }

                if ($mode === 'object')
                    $return[ $row->{$key} ] = $row;
                else
                    $return[ $row[$key] ] = $row;
            }

        return $return;
    }

    /**
     * To get num rows
     * @param $result
     * @return int
     */
    public static function numRows($result)
    {
        return mysqli_num_rows($result);
    }

    /**
     * To get last insert id
     * @return int|string
     */
    public static function insertID()
    {
        return mysqli_insert_id(self::$_db);
    }

    /**
     * To get query error
     * @return mixed
     */
    public static function error()
    {
        return self::$_db->error;
    }

    /**
     * To get query errno
     * @return bool
     */
    public static function errno()
    {
        return self::$_errno;
    }

    /**
     * multiQuery
     * @param $query
     * @param bool $delay
     * @return bool
     */
    public static function multiQuery($query, $delay = false)
    {
        self::$_db->multi_query($query);

        if ($delay) {
            $result = true;

            while (true) {
                if ($r = self::$_db->store_result()) {
                    while ($row = $r->fetch_row()) {
                        $result = $result && $r;
                    }
                    $r->free();
                }

                if (self::$_db->more_results())
                    self::$_db->next_result();
                else
                    break;
            }

            return $result;
        } else
            return true;
    }

    /**
     * getInsertCode
     * @param $table
     * @param $data
     * @param bool $concat
     * @return string
     */
    public static function getInsertCode($table, $data, $concat = false)
    {
        $fields = null;
        $values = null;
        $prefix = null;
        $n = 0;

        foreach ($data as $key => $value)
        {
            if ($n != 0)
                $prefix = ', ';
            $fields .= "$prefix`$key`";
            $values .= "$prefix'$value'";
            $n++;
        }

        if ($concat === true) {
            return array(
                'fields' => $fields,
                'values' => $values
            );
        }


        return "INSERT INTO `$table` ($fields) VALUES ($values);";
    }

    /**
     * Insert
     * @param $table
     * @param $data
     * @param bool $return
     * @return string
     */
    public static function insert($table, $data, $return = false)
    {
        $fields = null;
        $values = null;
        $prefix = null;
        $n = 0;

        foreach ($data as $key => $value)
        {
            if ($n != 0)
                $prefix = ', ';
            $fields .= "$prefix`$key`";
            $values .= "$prefix'$value'";
            $n++;
        }

        $query = "INSERT INTO `$table` ($fields) VALUES ($values);";

        if ($return !== false)
            return $query;

        self::query($query);
        return self::errno();
//        return self::$_db->insert_id;
    }

    /**
     * Select
     * @param string $table
     * @param null $where
     * @param string $select
     * @return null|object
     */
    public static function select($table, $where = null, $select = '*')
    {
        $query = "SELECT $select FROM `$table`";

        if (!empty($where))
            $query .= " WHERE $where";

        return self::query($query);
    }

    /**
     * Update
     * @param $table
     * @param $fields
     * @param bool $where
     * @param bool $return
     * @return string
     */
    public static function update($table, $fields, $where = false, $return = false)
    {
        $set = array();
        $sql = "UPDATE `$table` SET ";

        foreach ($fields as $key => $value)
        {
            if ($value === 0)
                $set[] = "`$key` = '0'";
            else if ($value === '++')
                $set[] = "`$key` = `$key` +1";
            else if ($value === '--')
                $set[] = "`$key` = `$key` -1";
            else if (is_null($value))
                $set[] = "`$key` = NULL";
            else
                $set[] = "`$key` = '$value'";
        }

        $sql .= implode(', ', $set);

        if ($where !== false)
            $sql .= " WHERE $where;";

        if ($return)
            return $sql;

        $result = self::query($sql);
        preg_match('/^\D+(\d+)\D+(\d+)\D+(\d+)$/', self::$_db->info,$matches);

        if ($matches && $matches[1]) {
            return true;
        } else {
            return false;
        }

//        print_data($matches);
//        print_data($sql);
//        print_data('self::error() :: ');
//        print_data(self::error());
//        print_data('self::errno() :: ');
//        print_data(self::errno());
//        print_data('===');
//
//        if (self::$_db->affected_rows > 0) {
//            return self::$_db->affected_rows; // I need it to return TRUE when the MySQL was successful even if nothing was actually updated.
//        } else {
//            return FALSE;
//        }
    }

    /**
     * Delete
     * @param $table
     * @param bool $where
     * @param bool $return
     * @return mixed
     */
    public static function delete($table, $where = false, $return = false)
    {
        $query = "DELETE FROM `$table`";

        if ($where)
            $query .= " WHERE $where;";

        if ($return !== false)
            return $query;

        return self::query($query);
    }

    /**
     *  Truncate
     * @param $table
     * @param false $return
     * @return mixed|string
     */
    public static function truncate($table, $return = false)
    {
        $query = "TRUNCATE TABLE `$table`";

        if ($return !== false)
            return $query;

        return self::query($query);
    }

    /**
     * Count
     * @param $table
     * @param string $countField
     * @param bool $where
     * @return mixed
     */
    public static function count($table, $countField = '*', $where = false)
    {
        if ($countField === '*')
            $countFieldPart = $countField;
        else
            $countFieldPart = '`'.$countField.'`';

        $sql = "
            SELECT COUNT($countFieldPart)
            FROM `$table`
        ";

        if ($where)
            $sql .= "WHERE ".$where;

        return self::fetch(self::query($sql), 'row')[0];
    }

    public static function countRows($table, $params = array(), $countField = '*')
    {
        if ($countField === '*')
            $countFieldPart = $countField;
        else
            $countFieldPart = '`'.$countField.'`';

        $sql = "
            SELECT COUNT($countFieldPart)
            FROM `$table`
        ";

        if ($params) {
            $tmpArr = [];
            foreach ($params as $column => $value)
                $tmpArr[] = "`$column` = '$value'";
            $sql .= " WHERE " . implode(' AND ', $tmpArr);
        }

        return self::fetch(self::query($sql), 'row')[0];
    }

    public static function getRow($table, $params = array(), $orderBy = false, $orderDirection = false)
    {
        $sql = "
            SELECT *
            FROM `$table` 
        ";

        if ($params) {
            $tmpArr = [];
            foreach ($params as $column => $value)
                $tmpArr[] = "`$column` = '$value'";
            $sql .= " WHERE " . implode(' AND ', $tmpArr);
        }

        if ($orderBy && $orderDirection)
            $sql .= " ORDER BY `$orderBy` $orderDirection ";

        $sql .= " LIMIT 1";

        return self::fetch(self::query($sql));
    }

    public static function updateRow($table, $data = array(), $params = array(), $return = false)
    {
        $set = array();
        $sql = "UPDATE `$table` SET ";

        foreach ($data as $key => $value)
        {
            if ($value === 0)
                $set[] = "`$key` = '0'";
            else if ($value == '++')
                $set[] = "`$key` = `$key` +1";
            else if ($value == '--')
                $set[] = "`$key` = `$key` -1";
            else if (is_null($value))
                $set[] = "`$key` = NULL";
            else
                $set[] = "`$key` = '$value'";

            //else if (isset($value[0]) && $value[0] == '`')
            //$set[] = "`$key` = $value"; // $data['coins'] = '`coins` -15';
        }

        $sql .= implode(', ', $set);

        if ($params) {
            $tmpArr = [];
            foreach ($params as $column => $value)
                $tmpArr[] = "`$column` = '$value'";
            $sql .= " WHERE " . implode(' AND ', $tmpArr);
        }

        if ($return)
            return $sql;

        $result = self::query($sql);
        preg_match('/^\D+(\d+)\D+(\d+)\D+(\d+)$/', self::$_db->info,$matches);

        if ($matches && $matches[1]) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Get tables list
     * @return array
     */
    public static function getTables()
    {
        $sql = "SHOW TABLES";
        $result = self::query($sql);

        $return = array();
        while($row = self::fetch($result, 'assoc'))
            foreach ($row as $value)
                $return[] = $value;;

        return $return;
    }

    /**
     * Get mysql stat
     * @return mixed
     */
    public static function getStat()
    {
        return self::$_db->stat;
    }

    public static function affected_rows()
    {
        return self::$_db->affected_rows;
    }

    /**
     * Get data from the table with which the entity is associated
     * @param $data
     * @param $table
     * @param $toTable
     * @param string $returnFields
     * @param false $searchIds
     * @param false $customFieldToTable
     * @param string $type
     * @return mixed
     */
    public static function relationship($data, $table, $toTable, $returnFields = '*', $searchIds = false, $customFieldToTable = false, $type = 'many_to_many', $notDeletedField = 'deleted')
    {
        if ($data) {
            //form field names for the link table
            $mainFieldName = singularize($table) . '_id';
            $fieldName = singularize($toTable) . '_id';

            if ($customFieldToTable)
                $fieldName = $customFieldToTable;

            //if searchids is not an array, make it an array
            if ($searchIds && !is_array($searchIds))
                $searchIds = [$searchIds];

            $sql = "SELECT COUNT(*) as `count` FROM information_schema.columns WHERE table_name = '$toTable' AND column_name = '$notDeletedField'";

            $existsDeletedColumn = self::fetch(self::query($sql), 'row')[0];

            $notDeletedFieldQuery = '';

            if ($existsDeletedColumn > 0) {
                $notDeletedFieldQuery = "and `$notDeletedField` = 'no'";
            }

            if ($type == 'many_to_many')
                $data = Model::many_to_many($data, $table, $toTable, $mainFieldName, $fieldName, $returnFields, $searchIds, $notDeletedFieldQuery);
            else if ($type == 'one_to_many')
                $data = Model::one_to_many($data, $toTable, $fieldName, $returnFields, $searchIds, $notDeletedFieldQuery);
        }

        return $data;
    }

    /**
     * if we use the many-to-many join type, it means that the third table is used for the relationship
     * example: `vacancies` with `sectors`, third table name - `vacancies_sectors` (`vacancy_id`, `sector_id`);
     * @param $data
     * @param $table
     * @param $toTable
     * @param $mainFieldName
     * @param $fieldName
     * @param $returnFields
     * @param $searchIds
     * @return mixed
     */
    private static function many_to_many($data, $table, $toTable, $mainFieldName, $fieldName, $returnFields, $searchIds, $notDeletedFieldQuery)
    {
        if ($data) {
            //get all ids
            if (is_array($data)) {
                $entitiesIds = [];
                foreach ($data as $item) {
                    $entitiesIds[] = $item->id;
                }

                $where = "  `" . singularize($table) . "_id` IN (" . implode(',', $entitiesIds) . ")";
            } else {
                $where = "  `" . singularize($table) . "_id` = {$data->id}";
            }

            //get relation table name
            $relationTableName = $table . '_' . $toTable;
            if (!self::tableExists($relationTableName))
                $relationTableName = $toTable . '_' . $table;

            //get relationships
            $relationShips = Model::fetchAll(Model::select($relationTableName, $where));

            //get ids for second entities
            $secondEntityIds = [];
            foreach ($relationShips as $item) {
                $secondEntityIds[] = $item->$fieldName;
            }

            //get all data for second entity
            $secondEntity = [];
            if ($secondEntityIds) {
                if (is_array($returnFields))
                    $returnFields = arrayToSqlFields($returnFields);

                $secondEntity = Model::fetchAll(Model::select($toTable, " `id` IN (" . implode(',', array_unique($secondEntityIds)) . ") $notDeletedFieldQuery", $returnFields));
            }

            //insert data into main entities
            if (is_array($data)) {
                foreach ($data as $item) {
                    $item->$toTable = [];
                    foreach ($relationShips as $relation) {
                        if ($item->id == $relation->$mainFieldName) {
                            foreach ($secondEntity as $second) {
                                if ($second->id == $relation->$fieldName) {
                                    $item->{$toTable}[] = $second;
                                    $item->{singularize($toTable) . '_ids'}[] = $second->id;
                                }
                            }
                        }
                    }
                }

                //filtering
                $data = Model::filtration($data, $searchIds, $toTable);
            } else {
                $data->$toTable = [];
                foreach ($relationShips as $relation) {
                    if ($data->id == $relation->$mainFieldName) {
                        foreach ($secondEntity as $second) {
                            if ($second->id == $relation->$fieldName) {
                                $data->{$toTable}[] = $second;
                                $data->{singularize($toTable) . '_ids'}[] = $second->id;
                            }
                        }
                    }
                }
            }
        }

        return $data;
    }

    /**
     * one to many means that the identifier of the related entity is stored in the first table
     * example: `vacancies` with `microsites`, field name in `vacancies` table - `microsite_id`;
     * @param $data
     * @param $toTable
     * @param $fieldName
     * @param $searchIds
     * @param $returnFields
     * @return mixed
     */
    private static function one_to_many($data, $toTable, $fieldName, $returnFields, $searchIds, $notDeletedFieldQuery)
    {
        //get all second entity ids
        if (is_array($data)) {
            $entitiesIds = [];

            foreach ($data as $item) {
                if ($item->$fieldName) {
                    $entitiesIds[] = $item->$fieldName;
                }
            }

            if ($entitiesIds) {
                $where = "  `id` IN (" . implode(',', $entitiesIds) . ") $notDeletedFieldQuery";
            }
        } else {
            $where = "  `id` = {$data->$fieldName} $notDeletedFieldQuery";
        }

        //get second entities
        if (is_array($returnFields))
            $returnFields = arrayToSqlFields($returnFields);

        $secondEntities = Model::fetchAll(Model::select($toTable, $where, $returnFields));

        //insert data into main entities
        $secondEntityName = singularize($toTable);
        if (is_array($data)) {
            foreach ($data as $item) {
                foreach ($secondEntities as $second) {
                    if ($item->$fieldName == $second->id) {
                        $item->$secondEntityName = $second;
                        continue 2;
                    }
                }
            }

            //filtering
            $data = Model::filtration($data, $searchIds, $secondEntityName);
        } else {
            foreach ($secondEntities as $second) {
                if ($data->$fieldName == $second->id) {
                    $data->$secondEntityName = $second;
                    break;
                }
            }
        }

        return $data;
    }

    /**
     * filtering the dataset by ids of the second entities
     * @param $data
     * @param $searchIds
     * @param $toTable
     * @return mixed
     */
    private static function filtration($data, $searchIds, $toTable)
    {
        if ($searchIds) {
            if (is_array($data)) {
                foreach ($data as $k => $item) {
                    $unset = true;
                    if ($item->$toTable) {
                        //for many to many
                        if (is_array($item->$toTable)) {
                            foreach ($item->$toTable as $second) {
                                if (in_array($second->id, $searchIds)) {
                                    $unset = false;
                                    continue 2;
                                }
                            }
                            // for one to many
                        } else {
                            if (in_array($item->$toTable->id, $searchIds)) {
                                $unset = false;
                                continue;
                            }
                        }
                    }
                    if ($unset)
                        unset($data[$k]);
                }
            }
        }

        return $data;
    }

    /**
     * @param $tableName
     * @return mixed
     */
    private static function tableExists($tableName)
    {
        return in_array($tableName, self::getTables());
    }

    /**
     * Check and create uniq identifier, ex: slug
     * @param $table
     * @param $fieldValue
     * @param string $fieldName
     * @param bool $exceptId
     * @return mixed
     */
    public static function createIdentifier(string $table, string $fieldValue, string $fieldName = 'slug', int $exceptId = 0): string
    {
        $additionalWhere = '';
        if ($exceptId)
            $additionalWhere .= " AND `id` != $exceptId";

        //check if current slug exist
        $count = self::count("$table", "$fieldName", " `$fieldName` = '$fieldValue' $additionalWhere");
        if (!$count)
            return $fieldValue;

        //remove number part
        $searchValue = preg_replace("/-([0-9]*)$/", '', $fieldValue);

        $sql = "SELECT `$fieldName` 
            FROM `$table`
            WHERE `$fieldName` REGEXP '^$searchValue(\-[0-9]*)?$' {$additionalWhere}";
//            WHERE `$fieldName` LIKE '$fieldValue%'";

        $sql .= " ORDER BY LPAD(LOWER(`$fieldName`), 500,0) DESC LIMIT 1";

        $entity = self::fetch(self::query($sql));


        if ($entity) {

            preg_match("/-([0-9]*)$/", $entity->$fieldName, $results);

            if ($results)
                $number = $results[1];

            //remove number part
            $fieldValue = preg_replace("/-([0-9]*)$/", '', $fieldValue);

            $fieldValue = $fieldValue . '-' . (++$number);
        }

        return $fieldValue;
    }
}

/* End of file */