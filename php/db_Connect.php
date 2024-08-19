<?php
    class ConectarBD {
        private $servername = "database-utp.czkuw6smefsd.us-east-2.rds.amazonaws.com";
        private $username = "admin";
        private $password = "Utepino2024";
        private $dbname = "datautp";
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