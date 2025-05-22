<?php

// Class to connect to database and execute queries
class Base
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $passwd = DB_PASSWORD;
    private $base_name = DB_NAME;

    // Database handler
    private $dbh;
    // Statement
    private $stmt;
    private $error;

    public function __construct()
    {
        // Conecction conf
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->base_name;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        // Create an instance of PDO
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->passwd, $options);
            $this->dbh->exec('set names utf8');
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    // Prepare sql statement
    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }

    // Bind query to type of value
    public function bind($parameter, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;

                default:
                    $type = PDO::PARAM_STR;
                    break;
            }
        }
        $this->stmt->bindValue($parameter, $value, $type);
    }

    // Execute the query
    public function execute(){
        return $this->stmt->execute();
    }

    // Get records from query
    public function records(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Get one single record from query
    public function record(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    // Get quantity of rows with method rowCount
    public function rowCount(){
        return $this->stmt->rowCount();
    }
}
