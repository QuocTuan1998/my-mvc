<?php
require_once('./mvc/configs/ConfigDatabase.php');
class Database {
    private static $instance = NULL;
    public $conn;

    public function __construct()
    {
        $this->conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD);
        mysqli_select_db($this->conn, DB_NAME);
        mysqli_query($this->conn, "SET NAMES 'utf8'");
    }

    private function __clone() {
        
    }

    public function getInstance() {
        if (self::$instance == NULL) {
            self::$instance = new Database();
        }

        return self::$instance;
    }
}