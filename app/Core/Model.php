<?php

namespace App\Core;

use PDO;

class Model
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Get the database connection
     * 
     * @return PDO
     */
    protected function getConnection()
    {
        return $this->db;
    }

    /**
     * Execute a SELECT query
     * 
     * @param string $sql The SQL query
     * @param array $params The query parameters
     * @return array
     */
    protected function select($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Execute an INSERT query
     * 
     * @param string $table The table name
     * @param array $data The data to insert
     * @return bool
     */
    protected function insert($table, $data)
    {
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute($data);
    }

    /**
     * Execute an UPDATE query
     * 
     * @param string $table The table name
     * @param array $data The data to update
     * @param string $condition The WHERE condition
     * @param array $params The condition parameters
     * @return bool
     */
protected function update($table, $data, $condition, $params = [])
    {
        $set = [];
        foreach (array_keys($data) as $column) {
            $set[] = "{$column} = :{$column}";
        }
        $set = implode(', ', $set);
        
        $sql = "UPDATE {$table} SET {$set} WHERE {$condition}";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute(array_merge($data, $params));
    }

    /**
     * Execute a DELETE query
     * 
     * @param string $table The table name
     * @param string $condition The WHERE condition
     * @param array $params The condition parameters
     * @return bool
     */
    protected function delete($table, $condition, $params = [])
    {
        $sql = "DELETE FROM {$table} WHERE {$condition}";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute($params);
    }
}