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
     * Convert MySQL LIMIT/OFFSET syntax to PostgreSQL compatible syntax
     * 
     * @param string $sql The SQL query
     * @param int|null $limit Limit value
     * @param int $offset Offset value
     * @return array Array with converted SQL and parameters
     */
    protected function prepareLimitOffset($sql, $limit = null, $offset = 0)
    {
        $params = [];
        
        if ($limit !== null) {
            // Embed LIMIT/OFFSET as integers directly in SQL to avoid PDO placeholder issues
            if (strpos($sql, 'LIMIT :limit OFFSET :offset') !== false) {
                $limit = (int)$limit;
                $offset = (int)$offset;
                $sql = str_replace('LIMIT :limit OFFSET :offset', "LIMIT {$limit} OFFSET {$offset}", $sql);
            } elseif (strpos($sql, 'LIMIT :limit') !== false) {
                $limit = (int)$limit;
                $sql = str_replace('LIMIT :limit', "LIMIT {$limit}", $sql);
            }
        }
        
        return ['sql' => $sql, 'params' => $params];
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