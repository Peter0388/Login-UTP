<?php
    class ConectarBD {
        private $servername = "localhost";
        private $username = "root";
        private $password = "";
        private $dbname = "logindw";
        public $conn;

        public function __construct() {
            $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
            if ($this->conn->connect_error) {
                die("Conexión fallida: " . $this->conn->connect_error);
            }
        }

        public function getConnection() {
            return $this->conn;
        }
    }
?>