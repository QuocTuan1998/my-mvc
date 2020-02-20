<?php
require_once ('./mvc/core/SqlExcutor.php');
class User{

    // function __construct()
    // {
    //     Database::getInstance();
    // }

    public function getUserByUsername($username) {
        $qr = select('*')
                .from('`user`')
                .where('username = ?');
        
        $entity =  SqlExecutor::getSingle($qr, [$username]);
        
        return $entity;
    }

    public function insertUser($username, $pasword) {
        $qr = insert('`user`')
            .cols('username, password')
            .values('?, ?');
        
        return SqlExecutor::executeQuery($qr, [$username, $pasword]);
    }
}