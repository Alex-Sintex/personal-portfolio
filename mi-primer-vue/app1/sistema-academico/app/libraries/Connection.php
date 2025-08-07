<?php

    // Class for connecting to database and execute queries
    class Connection {
        private $host = DB_HOST;
        private $user = DB_USER;
        private $password = DB_PASSWORD;
        private $basename = DB_NAME;
        
        private $dbh;
        private $stmt;
        private $error;

        public function __construct(){
            // Configure connection
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->basename;

            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );

            // Create an instance of PDO
            try {
                $this->dbh = new PDO($dsn, $this->user, $this->password, $options);
                $this->dbh->exec('set names utf8');
            } catch (PDOException $e) {
                $this->error = $e->getMessage();
                echo $this->error;
            }
        }

        // Prepare the query
        public function query($sql){
            $this->stmt = $this->dbh->prepare($sql);
        }

        // Link the query with bind
        public function bind($parameter, $value, $type = null){
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

        // Get the records
        public function getRecords(){
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }

        // Get only one record
        public function getRecord(){
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }

        // Get quantity files with the method rowCount
        public function rowCount(){
            return $this->stmt->rowCount();
        }
    }