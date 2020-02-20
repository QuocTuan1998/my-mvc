<?php

class Customer extends Database{

    // function __construct()
    // {
    //     Database::getInstance();
    // }

    public function getAllCustomer() {
        $qr = "SELECT * FROM customer";
        return mysqli_query($this->conn, $qr);
    }
}