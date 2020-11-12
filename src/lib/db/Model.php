<?php

namespace app\lib\db;

use PDO;

class Model {

    private function getFields(bool $withValues = false): array
    {
        if ($withValues){
            return array_filter(get_object_vars($this), function ($key) {
                return !in_array($key, $this->dontUpdate());
            }, ARRAY_FILTER_USE_KEY);
        } else {
            return array_filter(array_keys(get_object_vars($this)), function ($value) {
                return !in_array($value, $this->dontUpdate());
            });
        }
    }

    protected static function tablename () {
        return basename(get_called_class());
    }

    public static function findAll() {

        $connection = Connection::getInstance();
        $query = "SELECT * FROM " . self::tablename();
        $statement = $connection->query($query);

        return $statement->fetchAll(PDO::FETCH_CLASS, get_called_class());
    }
    
    /**
     * Delete a model
     * 
     * @param void
     * 
     * @return bool
     */
    public function delete () : bool {
        
        $return = false;
        $connection = Connection::getInstance();

        $return = $this->beforeDelete($return);
        
        $query = "DELETE FROM " . self::tablename() . " WHERE id = ?";
        $statement = $connection->prepare($query);
        $return = $statement->execute([$this->id]);

        return $return;
    }

    /**
     * Run before delete model
     * @param bool
     * @return bool
     */
    public function beforeDelete(bool $return): bool
    {
        return $return;
    }

    public static function findOne(int $id) {
        $connection = Connection::getInstance();
        $query = "SELECT * FROM " . self::tablename() . " WHERE id = ?";

        $statement = $connection->prepare($query);
        $statement->execute([$id]);

        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if ($data) {
            $class = get_called_class();
            $class = new $class;
            $class->load(current($data));
            return $class;
        } else {
            return null;
        }
    }

    /**
     * Save the object in the database
     * 
     * @param void
     * 
     * @return bool
     */
    public function save() : bool {
        $return = false;
        $isInsert = (isset($this->id) && !empty($this->id)) ? false : true;
        $connection = Connection::getInstance();

        $this->beforeSave($return);

        if ($isInsert) {
            $query = $this->buildInsertQuery();
            $statement = $connection->prepare($query);
            if ($statement && $statement->execute(array_values(get_object_vars($this)))) {
                $this->id = $connection->lastInsertId();
                $return = true;
            }
        } else {
            $query = $this->buildUpdataQuery();
            $statement = $connection->prepare($query);
            if ($statement && $statement->execute($this->getFields(true))) {
                $return  = true;
            }
        }

        return $return;
    }

    /**
     * Run before a save
     * @param bool
     * @return bool
     */
    public function beforeSave(bool $return) : bool {
        return $return;
    }

    /**
     * Create an insert query to the object
     * 
     * @param void
     * 
     * @return string insert query
     */
    protected function buildInsertQuery() : string {
        $data = get_object_vars($this);

        $fields = array_keys($data);
        $values = array_map(function ($value) {
            return '?';
        }, array_values($data));

        $query  = "INSERT INTO ";
        $query .= self::tablename();
        $query .= " (" . implode(', ', $fields) . ") ";
        $query .= "VALUES (" . implode(', ', $values) . ")";

        return $query;
    }

    private function buildUpdataQuery() : string
    {
        $data = array_map(function ($value) {
            return "{$value} = :{$value}";
        }, $this->getFields());
        
        $query = "UPDATE " . self::tablename() . " SET ";
        $query .= implode(', ',$data);
        $query .= " WHERE id = :id";

        return $query;
    }

    /**
     * Load array data in the object
     * 
     * @param array $data
     * 
     * @return void
     */
    public function load (array $data) : void {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    protected function dontUpdate(): array
    {
        return [];
    }
}