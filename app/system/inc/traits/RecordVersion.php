<?php
/**
 * RecordVersion - for save versions of records of tables(then we can recover any version in admin panel)
 */

trait RecordVersion
{
    private array  $version;
    private string $table;
    private string $type;
    private $entityId;
    private string $entityType = 'default';

    //for content elements
    private int $versionID;

    /**
     * prepare all data  for entity and insert into DB
     * @param int $id
     * @param string $table
     * @param string $type
     * @param array $manyToManyList
     */
    public function makeVersion(int $id, string $table, string $type, array $manyToManyList = [])
    {
        $this->entityId = $id;
        $this->table    = $table;
        $this->type     = $type;

        //set version from DB by entity ID
        $this->version['rows'] = $this->getEntity();

        //set relationships for this entity
        $this->versionRelationships($manyToManyList);

        //save version to DB
        $this->saveVersion();
    }

    /**
     * make version from array with DB rows (content elements)
     * @param array $data
     * @param string $table
     * @param string $type
     */
    public function makeVersions(array $data, string $table, string $type)
    {
        //get module and page from 1st row (for content elements data )
        $modulePage = [$data[0]->module ?: '', $data[0]->page ?: ''];

        $this->entityId        = arrayToString($modulePage);
        $this->table           = $table;
        $this->type            = $type;
        $this->entityType      = 'array';
        $this->version['rows'] = $data;

        $this->saveVersion();
    }

    /**
     * move file from current folder to data_versions folder
     * @param string $filePath
     * @param string $type
     * @return bool
     */
    public function moveFile(string $filePath, string $type)
    {
        $fileName = basename($filePath);
        if (File::copy("data/$type/" . $fileName,"data/data_versions/{$this->versionID}/$type/" . $fileName))
            return true;

        return false;
    }

    /**
     * get entity from DB by id
     * @return array|false|object
     */
    private function getEntity()
    {
        $entity = false;

        if ($this->entityId && $this->table) {
            $entity = Model::fetch(Model::select($this->table, " `id` = {$this->entityId} LIMIT 1"));
        }

        return $entity;
    }

    /**
     * set for version relationships with tables example: vacancies_locations, vacancies_sectors etc.
     * @param array $manyToManyList
     */
    private function versionRelationships(array $manyToManyList)
    {
        if ($manyToManyList) {
            foreach ($manyToManyList as $relationTable) {
                $relationData = [];

                $mainTable   = $this->table;
                $secondTable = str_replace($mainTable . '_', '', $relationTable);

                $relationData['main_table']   = $mainTable;
                $relationData['second_table'] = $secondTable;
                $relationData['fk_main']      = singularize($mainTable) . '_id';
                $relationData['fk_second']    = singularize($secondTable) . '_id';

                $this->version['relationships'][$relationTable] = $relationData;
                $this->version['relationships'][$relationTable]['rows']
                    = Model::fetchAll(Model::select($relationTable, "{$relationData['fk_main']} = '$this->entityId'"));
            }
        }

    }

    /**
     * Insert version into DB
     * @return bool
     */
    private function saveVersion()
    {
        $json = json_encode($this->version);
        $data = [
            'user_id'     => User::get('id'),
            'entity_id'   => $this->entityId,
            'entity_type' => $this->entityType,
            'table'       => $this->table,
            'data'        => filter($json, 'json'),
            'type'        => $this->type,
            'time'        => time(),
        ];

        $result = Model::insert('data_versions', $data);
        $insertId = Model::insertID();

        if (!$result && $insertId) {
            $this->versionID = $insertId;
            return true;
        }

        return false;
    }


}
/* End of file */