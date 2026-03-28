<?php

namespace Core;

use PDO;
use PDOException;

/**
 * Database Singleton
 * 
 * Provides a single PDO connection instance throughout the application.
 * Uses lazy initialization — connection is only created when first requested.
 */
class Database
{
    private static ?Database $instance = null;
    private ?PDO $pdo = null;
    private array $config;

    /**
     * Private constructor to prevent direct instantiation.
     */
    private function __construct()
    {
        $this->config = require BASE_PATH . '/config/database.php';
    }

    /**
     * Prevent cloning.
     */
    private function __clone() {}

    /**
     * Get the singleton instance.
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get the PDO connection (lazy loaded).
     */
    public function getConnection(): PDO
    {
        if ($this->pdo === null) {
            try {
                $dsn = sprintf(
                    '%s:host=%s;port=%s;dbname=%s;charset=%s',
                    $this->config['driver'],
                    $this->config['host'],
                    $this->config['port'],
                    $this->config['database'],
                    $this->config['charset']
                );

                $this->pdo = new PDO(
                    $dsn,
                    $this->config['username'],
                    $this->config['password'],
                    $this->config['options']
                );
            } catch (PDOException $e) {
                if (defined('APP_DEBUG') && APP_DEBUG) {
                    die('Database connection failed: ' . $e->getMessage());
                }
                die('Database connection failed. Please check your configuration.');
            }
        }

        return $this->pdo;
    }

    /**
     * Execute a raw query with prepared statement.
     */
    public function query(string $sql, array $params = []): \PDOStatement
    {
        $stmt = $this->getConnection()->prepare($sql);
        
        if (empty($params)) {
            $stmt->execute();
            return $stmt;
        }

        // ✅ Deteksi apakah named atau positional
        $isNamed = array_keys($params) !== range(0, count($params) - 1);

        if ($isNamed) {
            // Bind satu per satu — hindari PDO salah baca ':' di dalam nilai string
            foreach ($params as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
            $stmt->execute();
        } else {
            // Positional — langsung execute
            $stmt->execute($params);
        }

        return $stmt;
    }

    /**
     * Begin a database transaction.
     */
    public function beginTransaction(): bool
    {
        return $this->getConnection()->beginTransaction();
    }

    /**
     * Commit the current transaction.
     */
    public function commit(): bool
    {
        return $this->getConnection()->commit();
    }

    /**
     * Roll back the current transaction.
     */
    public function rollBack(): bool
    {
        return $this->getConnection()->rollBack();
    }

    /**
     * Get the last inserted ID.
     */
    public function lastInsertId(): string
    {
        return $this->getConnection()->lastInsertId();
    }
}
