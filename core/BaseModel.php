<?php

namespace Core;

use PDO;

/**
 * Base Model
 * 
 * Provides generic CRUD operations using PDO prepared statements.
 * Child models should define $table and $fillable.
 *
 * Example:
 *   class User extends BaseModel {
 *       protected string $table = 'users';
 *       protected array $fillable = ['business_name', 'email', ...];
 *   }
 */
class BaseModel
{
    protected Database $db;
    protected string $table = '';
    protected array $fillable = [];
    protected string $primaryKey = 'id';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // -------------------------------------------------------------------------
    // READ operations
    // -------------------------------------------------------------------------

    /**
     * Get all records.
     */
    public function findAll(string $orderBy = 'id', string $direction = 'DESC'): array
    {
        $direction = strtoupper($direction) === 'ASC' ? 'ASC' : 'DESC';
        $sql = "SELECT * FROM {$this->table} ORDER BY {$orderBy} {$direction}";
        return $this->db->query($sql)->fetchAll();
    }

    /**
     * Find a record by primary key.
     */
    public function findById(int $id): ?object
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1";
        $result = $this->db->query($sql, ['id' => $id])->fetch();
        return $result ?: null;
    }

    /**
     * Find records by a specific column.
     */
    public function findBy(string $column, $value): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} = :value";
        return $this->db->query($sql, ['value' => $value])->fetchAll();
    }

    /**
     * Find a single record by a specific column.
     */
    public function findOneBy(string $column, $value): ?object
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} = :value LIMIT 1";
        $result = $this->db->query($sql, ['value' => $value])->fetch();
        return $result ?: null;
    }

    /**
     * Count all records.
     */
    public function count(): int
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        return (int) $this->db->query($sql)->fetch()->total;
    }

    // -------------------------------------------------------------------------
    // WRITE operations
    // -------------------------------------------------------------------------

    /**
     * Insert a new record.
     * Only columns defined in $fillable are allowed.
     *
     * @param  array  $data  Associative array ['column' => 'value']
     * @return int    The new record's ID
     */
    public function create(array $data): int
    {
        $data = $this->filterFillable($data);

        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $this->db->query($sql, $data);

        return (int) $this->db->lastInsertId();
    }

    /**
     * Update a record by primary key.
     *
     * @param  int    $id
     * @param  array  $data  Associative array ['column' => 'value']
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $data = $this->filterFillable($data);

        $setParts = [];
        foreach (array_keys($data) as $column) {
            $setParts[] = "{$column} = :{$column}";
        }
        $setClause = implode(', ', $setParts);

        $data['id'] = $id;
        $sql = "UPDATE {$this->table} SET {$setClause} WHERE {$this->primaryKey} = :id";
        $this->db->query($sql, $data);

        return true;
    }

    /**
     * Delete a record by primary key.
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $this->db->query($sql, ['id' => $id]);
        return true;
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Filter input data to only include fillable columns.
     */
    protected function filterFillable(array $data): array
    {
        return array_intersect_key($data, array_flip($this->fillable));
    }

    /**
     * Run a raw query (for complex joins, aggregates, etc.).
     */
    protected function raw(string $sql, array $params = []): array
    {
        return $this->db->query($sql, $params)->fetchAll();
    }

    /**
     * Run a raw query and return a single result.
     */
    protected function rawOne(string $sql, array $params = []): ?object
    {
        $result = $this->db->query($sql, $params)->fetch();
        return $result ?: null;
    }
}
