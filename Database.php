<?php
    class Database {
        private $host;
        private $username;
        private $password;
        private $database;

        public function __construct($host, $username, $password, $database) {
            $this->host = $host;
            $this->username = $username;
            $this->password = $password;
            $this->database = $database;
        }

        public function connect() {
            try {
                $connect = new mysqli($this->host, $this->username, $this->password, $this->database);
                if ($connect->connect_error) {
                    throw new Exception($connect->connect_error);
                }
                return $connect;
            } catch (Exception $e) {
                die('Error connect to DataBase: '. $e->getMessage());
            }
        }
    }
?>