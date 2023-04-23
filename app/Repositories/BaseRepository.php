<?php

namespace App\Repositories;

use stdClass;

class BaseRepository
{
    protected $db;

    protected $table;

    public function __construct($table = '')
    {
        $this->db = \F3::get('DB');
        $this->table = $table;
    }

    public function add($data)
    {
        // prepare the insert query
        $query = "INSERT INTO $this->table(" . implode(", ", array_keys($data)) . ") VALUES ('" . implode("', '", array_values($data)) . "')";
        if ($this->db->exec($query)) {
            $lastId = $this->db->lastInsertId();
            return $lastId;
        }
        return 0;
    }

    function update($id, $data = [])
    {
        $id = intval($id);

        // Build the query
        $query = "UPDATE $this->table SET ";
        foreach ($data as $key => $value) {
            $query .= "`$key` = '$value',";
        }
        $query = rtrim($query, ','); // Remove the trailing comma
        $query .= " WHERE `id` = $id";

        // Execute the query
        $result = $this->db->exec($query);
        return $result;
    }

    public function getAll()
    {
        $result = $this->db->exec("SELECT * FROM $this->table");
        return $result;
    }

    public function getById($id)
    {
        $id = intval($id);
        $result = $this->db->exec("SELECT * FROM $this->table WHERE id = ?", $id);
        if ($result) {
            $obj = new stdClass();

            foreach ($result[0] as $key => $value) {
                $obj->{$key} = $value;
            }
            return $obj;
        }

        return null;
    }

    public function getByWhere($where = "1")
    {
        $result = $this->db->exec("SELECT * FROM $this->table where $where");
        return $result;
    }

    public function deleteById($id)
    {
        $id = intval($id);
        $this->db->exec("DELETE FROM $this->table WHERE id = ?", $id);
    }

    // add other common functions here
}
