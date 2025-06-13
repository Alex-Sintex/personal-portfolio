<?php

namespace App\Libraries;

use PDO;
use PDOException;

class Base
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $passwd = DB_PASSWORD;
    private $baseName = DB_NAME;

    private $dbh;
    private $stmt;
    private $error;

    public function __construct()
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->baseName;
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->passwd, $options);
            $this->dbh->exec('set names utf8');
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }

    public function bind($parameter, $value, $type = null)
    {
        if (is_null($type)) {
            if (is_int($value)) {
                $type = PDO::PARAM_INT;
            } elseif (is_bool($value)) {
                $type = PDO::PARAM_BOOL;
            } elseif (is_null($value)) {
                $type = PDO::PARAM_NULL;
            } else {
                $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($parameter, $value, $type);
    }

    public function execute()
    {
        return $this->stmt->execute();
    }

    public function records()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function record()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    // Custom method to automitize binding array[data]
    public function bindMultiple(array $data)
    {
        foreach ($data as $key => $value) {
            $this->bind(':' . $key, $value);
        }
    }

    //Custom method for INSERT INTO table VALUES data
    public function insert(string $table, array $data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $this->query($sql);
        $this->bindMultiple($data);
        return $this->execute();
    }

    //Custom method for UPDATE table SET value WHERE condition use cases
    public function update(string $table, array $data, string $where, array $whereData)
    {
        $setClause = implode(', ', array_map(fn($key) => "$key = :$key", array_keys($data)));

        $sql = "UPDATE {$table} SET {$setClause} WHERE {$where}";
        $this->query($sql);
        $this->bindMultiple($data);
        $this->bindMultiple($whereData);
        return $this->execute();
    }

    //Custom method for DELETE * FROM table WHERE condition use cases
    public function delete(string $table, string $where, array $whereData)
    {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        $this->query($sql);
        $this->bindMultiple($whereData);
        return $this->execute();
    }

    //Custom method for SELECT * FROM table WHERE condition use cases
    public function select(string $table, string $where = '', array $whereData = [])
    {
        $sql = "SELECT * FROM {$table}";
        if (!empty($where)) {
            $sql .= " WHERE {$where}";
        }
        $this->query($sql);
        if (!empty($whereData)) {
            $this->bindMultiple($whereData);
        }
        return $this->records();
    }

    // Method to run multiple tables with joins returning multiple records
    public function rawSelect(string $sql, array $params = [])
    {
        $this->query($sql);
        if (!empty($params)) {
            $this->bindMultiple($params);
        }
        return $this->records();
    }

    // Method to run multiple tables with joins returning one single record
    public function rawRecord(string $sql, array $params = [])
    {
        $this->query($sql);
        if (!empty($params)) {
            $this->bindMultiple($params);
        }
        return $this->record();
    }
}
