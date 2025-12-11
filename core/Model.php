<?php

require_once __DIR__ . '/Database.php';

class Model {
    protected $db;
    protected $table;
    protected $primaryKey = 'id';
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function all() {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function find($id) {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = $this->db->query($sql, ['id' => $id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $this->db->query($sql, $data);
        
        return $this->db->lastInsertId();
    }
    
    public function update($id, $data) {
        $setClause = [];
        foreach (array_keys($data) as $key) {
            $setClause[] = "{$key} = :{$key}";
        }
        $setClause = implode(', ', $setClause);
        
        $data[$this->primaryKey] = $id;
        $sql = "UPDATE {$this->table} SET {$setClause} WHERE {$this->primaryKey} = :{$this->primaryKey}";
        
        return $this->db->query($sql, $data);
    }
    
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE `{$this->primaryKey}` = :id";
        return $this->db->query($sql, ['id' => $id]);
    }
    
    public function where($column, $value) {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} = :value";
        $stmt = $this->db->query($sql, ['value' => $value]);
        return $stmt->fetchAll();
    }
    
    public function whereFirst($column, $value) {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} = :value LIMIT 1";
        $stmt = $this->db->query($sql, ['value' => $value]);
        return $stmt->fetch();
    }
}


