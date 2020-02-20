<?php

require_once ('./mvc/core/SqlExcutor.php');

class Company{
    static function all() {
        $query = select('*').from('`company`');
        $entities = SqlExecutor::getList($query);
        $companies = [];
        if ($entities) {
            foreach ($entities as $key => $entity) {
                $companies[] = ($entity->COMPANY_NAME);
            }
        }
        return $companies;
    }
}