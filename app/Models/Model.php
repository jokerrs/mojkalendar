<?php

namespace app\Models;

use app\DB;

class Model extends DB implements ModelInterface
{
    public function all(): array
    {
        $PDO = DB::query("SELECT * FROM " . $this->modelName());
        if (!$PDO) {
            return ['error' => 'There is no data'];
        }
        return $PDO->fetchAll();
    }

    public function where(array $params, ?int $limit = null, ?array $orderBy = null): array
    {
        $query = '';
        $counter = 0;
        foreach ($params as $param => $key){
            $execute[":$param"] = $key;
            if($counter > 0){
                $query .= ' AND ';
            }
            $query .= $param.'=:'.$param.' ';
            $counter++;
        }
        if(!isset($query, $execute)){
            return ['error' => 'There is no data'];
        }
        $SQL = "SELECT * FROM " . $this->modelName() . " WHERE ".$query;
        if ($orderBy !== null) {
            $SQL .= " ORDER BY " . $orderBy[0]. " " . $orderBy[1];
        }
        if ($limit !== null) {
            $SQL .= " LIMIT " . $limit;
        }
        $PDO = DB::query($SQL, $execute);
        if (!$PDO) {
            return ['error' => 'There is no data'];
        }
        $data = $limit === 1 ? $PDO->fetch() : $PDO->fetchAll();
        if (empty($data)) {
            return ['error' => 'There is no data'];
        }
        return $data;
    }

    public function create(array $values): bool
    {
        $columns = '';
        $columnsValues = '';
        $execute = [];
        $counter = 0;
        foreach ($values as $param => $key){
            $execute[":$param"] = $key;
            if($counter > 0){
                $columns .= ', ';
                $columnsValues .= ', ';
            }
            $columnsValues .= ' :'. $param;
            $columns .= $param;
            $counter++;
        }
        $SQL = "INSERT INTO " . $this->modelName() . " ($columns) VALUES ($columnsValues)";
        if(!empty($query) && !empty($execute)){
            return false;
        }
        $PDO = DB::query($SQL, $execute);
        if ($PDO) {
            return true;
        }
        return false;
    }

    public function update(array $params, $id)
    {
        $query = '';
        $counter = 0;
        foreach ($params as $param => $key){
            $execute[":$param"] = $key;
            if($counter > 0){
                $query .= ', ';
            }
            $query .= $param.'=:'.$param;
            $counter++;
        }
        $SQL = "UPDATE ". $this->modelName() ." SET $query WHERE id=:id";
        $execute[':id'] = $id;
        if(empty($query) && empty($execute)){
            return false;
        }
        $PDO = DB::query($SQL, $execute);
        if ($PDO) {
            return true;
        }
        return false;
    }
    public function modelName(): string
    {
        return strtolower(substr(get_class($this), 11));
    }
}