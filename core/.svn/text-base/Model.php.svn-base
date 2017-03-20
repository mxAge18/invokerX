<?php

namespace core;

class Model extends \vendor\PDOWrapper
{
    public function __construct()
    {

        parent::__construct(Application::$config['database']);
    }

    public function findAll($where = '2 > 1', $order = 'id ASC', $offset = 0, $limit = false)
    {
        $sql = "SELECT * FROM `{$this->table}` WHERE {$where} ORDER BY {$order}";
        if ($limit !== false) {
            $sql .= " LIMIT {$offset},{$limit}";
        }
        return $this->getAll($sql);
    }

    public function findOneById($id)
    {
        $sql = "SELECT * FROM `{$this->table}` WHERE id={$id}";
        return $this->getOne($sql);
    }
    public function findOneBy($where = '2 > 1')
    {
        $sql = "SELECT * FROM `{$this->table}` WHERE {$where} LIMIT 1";
        return $this->getOne($sql);
    }

    public function count($where = '2 > 1')
    {
        $sql = "SELECT count(*) as count FROM `{$this->table}` WHERE {$where}";
        $row = $this->getOne($sql);
        return $row['count'];
    }

    public function deleteById($id)
    {
        $sql = "DELETE FROM `{$this->table}` WHERE id={$id}";
        return $this->exec($sql);
    }

    public function add($data)
    {
        /*
         * $data = array(
         *       '字段名' => '字段值'
         * );
         * */
        $columns = '';
        $values = '';
        foreach($data as $column => $value) {
            $columns = $columns . $column . ',';
            $values = $values . "'" . $value . "'" . ',';
        }
        $columns = rtrim($columns,',');// r => right trim => 消减
        $values = rtrim($values,',');
        $sql = "INSERT INTO `{$this->table}` ($columns) VALUES ($values)";
        return $this->exec($sql);
    }

    public function updateById($id,$data,$primaryKey = 'id')
    {
        /*
         * $data = array(
         *       '字段名' => '字段值'
         * );
         * */
        $sets = "";
        foreach($data as $column => $value) {
            $sets = $sets . "{$column}='{$value}',";
        }
        $sets = rtrim($sets,',');
        $sql = "UPDATE `{$this->table}` 
                  SET {$sets} 
                WHERE {$primaryKey}={$id}";
        return $this->exec($sql);
    }
    public static function create($modelClassName = false)
    {
        if(!$modelClassName) {
            $modelClassName = get_called_class();
        }
        $models = array();
        if (isset($models[$modelClassName])) {
            return $models[$modelClassName];
        } else {
            $xx = new $modelClassName;
            return $models[$modelClassName] = $xx;
        }
    }
}
