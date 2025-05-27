<?php

class Data_versionsController extends Controller
{
    protected $layout = 'layout_panel';

    use Validator, RecordVersion;

    public function indexAction()
    {
        $this->view->list = Data_versionsModel::getAll();

        $modules = [];
        if ($this->view->list) {
            foreach ($this->view->list as $item) {
                $modules[] = $item->table;
            }
        }

        $this->view->modules = array_unique($modules);

        Request::setTitle('Data Versions');
    }
    //data table pagination
    public function paginationAction()
    {
        Request::ajaxPart();

        $draw         = post('draw'); // request-response identifier
        $start        = intval(post('start')); // limit start
        $end          = post('length'); // rows display per page
        $columnIndex  = intval(post('order')[0]['column']); // column index
        $orderby      = post('columns')[$columnIndex]['data']; // column name
        $sort         = post('order')[0]['dir']; // asc or desc
        $searchValue  = post('search')['value']; // search value
        $moduleFilter = post('moduleFilter');

        //prepare query for search
        $where = '';
        if ($searchValue) {
            $where .= " AND (`table` LIKE '%$searchValue%' OR `entity_id` LIKE '%$searchValue%')";
        }

        if ($moduleFilter) {
            $where .= " AND `table` = '$moduleFilter'";
        }

        //total number of records without filtering
        $totalRecords = Model::count('data_versions', 'id', "`deleted` = 'no'");

        //total number of record with filtering
        $totalRecordWithFilter = Model::count('data_versions', 'id', "`deleted` = 'no' $where");

        //search
        $data = Data_versionsModel::search($where, $orderby, $sort, $start, $end);

        //prepare data for response
        $responseData = [];
        if (count($data) > 0) {
            foreach ($data as $value) {
                $responseData[] = [
                    'id' => $value->id,
                    'table' => $value->table,
                    'user_id' => $value->user->id,
                    'entity_id' => $value->entity_id,
                    'user_firstname' => $value->user->firstname,
                    'user_lastname' => $value->user->lastname,
                    'type' => $value->type,
                    'time' => date('Y-m-d H:i:s', $value->time),
                ];
            }
        }

        //response
        $response = [
            "draw"            => intval($draw), // request-response identifier
            "recordsTotal"    => intval($totalRecords), //total number of records without filtering
            "recordsFiltered" => intval($totalRecordWithFilter), //total number of record with filtering
            "data"            => $responseData // data for table
        ];

        echo json_encode($response);
        exit;
    }

    public function data_popupAction()
    {
        Request::ajaxPart();

        $id    = intval(Request::getUri(0));
        $this->view->state = $state = Data_versionsModel::get($id);

        if (!$state)
            redirectAny(url('panel/data_versions'));

        $stateData = json_decode($state->data);

        //if version is not content element
        if ($state->entity_type !== 'array') {
            //get current data
            $currentData = Model::fetch(Model::select($state->table, "`id` = '$state->entity_id' "));

            //comparing fields and forming an array with changes
            $this->view->changedRows = $this->checkRows($currentData, $stateData->rows);

            //get relationships if they exist
            if ($stateData->relationships)
                $this->view->changedManyToManyRows = $this->checkRelationships($state->entity_id, $stateData->relationships);

        } else {
            //comparing fields and forming an array with changes
            $this->view->changedRows = $this->checkContentsRows($stateData->rows, $state->entity_id, $state->table);
        }

        $this->view->json = json_encode($stateData, JSON_PRETTY_PRINT);

        Request::addResponse('html', '#popup', $this->getView());
    }

    public function filterAction()
    {
        Request::ajaxPart();

        $module = post('module') ?: false;

        $this->view->list = Data_versionsModel::getAll($module);
        Request::addResponse('html', '#filter_result', $this->getView());
    }

    public function rollbackAction()
    {
        Request::ajaxPart();

        $id = intval(Request::getUri(0));

        $state = Data_versionsModel::get($id);

        if (!$state)
            Request::returnError('Rollback Error');

        if ($state->entity_type !== 'array') {
            $this->defaultRollback($state);
        } else {
            $this->contentsRollback($state);
        }

        Request::addResponse('func', 'noticeSuccess', 'Rollback');
        Request::endAjax();
    }

    /**
     * default rollback for all entities except content elements
     * @param $state
     */
    private function defaultRollback($state)
    {
        $table     = $state->table;
        $entityId  = $state->entity_id;
        $stateData = json_decode($state->data);

        $currentRows = Model::fetch(Model::select("{$state->table}", "`id` = '{$state->entity_id}'"));

        if ($currentRows)
            $result = Model::update($table, $stateData->rows, "`id` = '$entityId'"); // Update row
        else
            $result = !Model::insert($table, $stateData->rows); // Insert row

        if ($result) {
            //rollback relationships
            $stateManyToMany = $stateData->relationships;
            $relationshipsArray = [];
            if ($stateManyToMany) {
                foreach ($stateManyToMany as $relationTable => $manyToMany) {
                    $relationshipsArray[] = $relationTable;
                    Model::query("DELETE FROM `$relationTable` WHERE `$manyToMany->fk_main` = '$entityId'");
                    foreach ($manyToMany->rows as $row) {

                        Model::insert("$relationTable", [
                            "$manyToMany->fk_main" => $entityId,
                            "$manyToMany->fk_second" => $row->{$manyToMany->fk_second},
                        ]);
                    }
                }
            }

            //make version for rollback
            $this->makeVersion($entityId, $table, 'rollback', $relationshipsArray);
        } else {
            Request::returnError('Database error');
        }
    }

    /**
     * rollback for content elements
     * @param $state
     */
    private function contentsRollback($state)
    {
        $table     = $state->table;
        $entityId  = $state->entity_id;
        $stateData = json_decode($state->data);

        list($module, $page) = stringToArray($entityId);

        $current = Model::fetchAll(Model::select($table, "`page` = '$page' AND `module` = '$module'"));

        //data version
        $this->makeVersions($current, 'content_pages_tree', 'rollback');

        if ($stateData->rows) {
            foreach ($stateData->rows as $row) {
                //move the file to the entity folder if it exists
                $this->checkFile($state->id, $row->type, $row->content);

                $result = Model::update($table, ['content' => $row->content], "`id` = $row->id"); // Update row

                if (!$result) {
                    Request::returnError('Database error');
                }
            }
        }
    }

    /**
     * check file and move to folder
     * @param int $id
     * @param string $type
     * @param string $filePath
     * @return bool
     */
    private function checkFile(int $id, string $type, string $filePath)
    {
        $fileName = basename($filePath);

        $filePath = "data/data_versions/$id/$type/$fileName";
        if (file_exists(_SYSDIR_ . $filePath)) {
            if (Storage::copy($filePath, "data/$type/$fileName"))
                return true;
        }

        return false;
    }

    /**
     * comparing fields and forming an array with changes
     * @param $current
     * @param $state
     * @return array
     */
    private function checkRows($current, $state)
    {
        $result = [];
        foreach ($current as $field => $currentRow) {
            if ($current->$field !== $state->$field) {
                $result[$field] = [
                    'state' => $state->$field,
                    'current' => $current->$field
                ];
            }
        }
        return $result;
    }

    /**
     * comparing fields and forming an array with changes (for content elements)
     * @param array $state
     * @param string $pageModule
     * @param string $table
     * @return array
     */
    private function checkContentsRows(array $state, string $pageModule, string $table)
    {
        list($module, $page) = stringToArray($pageModule);

        $result = [];
        if ($module && $page) {
            $current = Model::fetchAll(Model::select($table, "`page` = '$page' AND `module` = '$module'"));
            foreach ($current as $k => $currentObj) {
                foreach ($state as $stateObj) {
                    if ($currentObj->name === $stateObj->name) {
                        if ($currentObj != $stateObj) {
                            $result[$currentObj->name] = [
                                'state' => $stateObj->content,
                                'current' => $currentObj->content,
                                'type' => $currentObj->type
                            ];

                        }
                        continue 2;
                    }
                }
            }
        }

        return $result;
    }

    /**
     * @param int $entityId
     * @param $relationships
     * @return array
     */
    public function checkRelationships(int $entityId, $relationships)
    {
        $result = [];
        foreach ($relationships as $table => $manyToMany) {
            //get current relationships
            $currentRows = Model::fetchAll(Model::select($table, "`$manyToMany->fk_main` = '$entityId'"));
            //old relationships
            $stateRows     = $manyToMany->rows;
            $secondKeyName = $manyToMany->fk_second;
            $currentValues = [];
            $stateValues   = [];

            //preparing ids for get names
            foreach ($currentRows as $current) {
                $currentValues[] = $current->$secondKeyName;
            }

            foreach ($stateRows as $state) {
                $stateValues[] = $state->$secondKeyName;
            }

            //get names for relation ids
            $arrayIds = array_unique(array_merge($currentValues, $stateValues));
            list($currentRows, $stateRows) = $this->getFieldsNames($currentRows, $stateRows, $manyToMany->second_table, $arrayIds, $secondKeyName);

            //return an empty array if there were no changes
            if ($currentValues === $stateValues) {
                $result = [];
            } else {
                $result[$table]['fk_second'] = $manyToMany->fk_second;
                $result[$table]['current'] = $currentRows;
                $result[$table]['old']   = $stateRows;
            }
        }

        return $result;
    }

    /**
     * get all names for ids in relationships
     * @param array $currentValues
     * @param array $stateValues
     * @param string $table
     * @param array $allIds
     * @param string $key
     * @return array[]
     */
    private function getFieldsNames(array $currentValues, array $stateValues, string $table, array $allIds, string $key)
    {
        if ($allIds) {
            //get all entities from table
            $entities = Model::fetchAll(Model::select($table, " `id` IN(" . implode(',', $allIds) . ")"));

            //set names for entities in current relationships
            foreach ($currentValues as $current) {
                foreach ($entities as $entity) {
                    if ($current->$key === $entity->id) {
                        $current->field_name = $entity->name ?: false;
                        continue 2;
                    }
                }
            }

            //set names for entities in old relationships
            foreach ($stateValues as $state) {
                foreach ($entities as $entity) {
                    if ($state->$key === $entity->id) {
                        $state->field_name = $entity->name ?: false;
                        continue 2;
                    }
                }
            }
        }

        return [$currentValues, $stateValues];
    }

    public function deleteAction()
    {
        Request::ajaxPart();

        $id = intval(Request::getUri(0));
        $version = Data_versionsModel::get($id);

        if (!$version)
            Request::returnError('Version error');

        $data['deleted'] = 'yes';
        $result = Model::update('data_versions', $data, "`id` = '$id'"); // Update row

        if ($result) {

            Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'delete', 'entity' => 'data_version#' . $id, 'time' => time()]);

            Request::addResponse('func', 'noticeSuccess', 'Removed');
            Request::addResponse('remove', '#item_' . $id);
            Request::endAjax();
        } else {
            Request::returnError('Database error');
        }
    }
}
/* End of file */
