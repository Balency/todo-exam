<?php

class Database {
    private $host = "localhost";
    private $db_name = "todo_db";
    private $username = "root";
    private $password = "";

    public $conn;

    public function getConnection() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);

        if ($this->conn->connect_error) {
            die("Erreur lors de l'ouverture de la connexion : " . $this->conn->connect_error);
        }

        return $this->conn;
    }
}
