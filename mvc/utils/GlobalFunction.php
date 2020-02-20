<?php

// --------------------------- My SQL Query Builder Functions ---------------------------------
function select($cols) {
    if(is_array($cols))
        return 'SELECT ' .  implode(',', $cols) . ' ';
    return 'SELECT ' .  $cols . ' ';
}

function from($tables) {
    if(is_array($tables))
        return 'SELECT ' .  implode(',', $tables) . ' ';
    return 'FROM ' . $tables . ' ';
}

function where($condition) {
    return 'WHERE (' . $condition . ') ';
}

function whereNot($condition) {
    return 'WHERE NOT (' . $condition . ') ';
}

function orWhere($condition) {
    return 'OR (' . $condition . ') ';
}

function andWhere($condition) {
    return 'AND (' . $condition . ') ';
}

function betweenWhere($col, $value1, $value2) {
    return $col . ' BETWEEN ' . $value1 . ' AND ' . $value2;
}

function inWhere($col, $values) {
    if(is_array($values))
        return $col . ' IN (' . implode(', ', $values) . ') ';
    return $col . ' IN (' . $values . ') ';
}

function innerJoin($table) {
    return 'INNER JOIN ' . $table . ' '; 
}

function on($condition) {
    return 'ON (' . $condition . ') ';
}

function groupBy($cols) {
    if(is_array($cols))
        return 'GROUP BY (' . implode(', ', $cols) . ') ';
    return 'GROUP BY (' .  $cols . ') ';
}

function having($condition) {
    return 'HAVING (' . $condition . ') ';
}

function orderBy($condition) {
    return 'ORDER BY (' . $condition . ') ';
}

function limit($limit, $start = 0) {
    return 'LIMIT (' . $start . ', ' . $limit . ') ';
}

function insert($table) {
    return 'INSERT INTO ' . $table . ' ';
}

function cols($cols) {
    if(is_array($cols))
        return '(' . implode(', ' , $cols) . ') ';
    return '(' . $cols . ') ';
}

function values($values) {
    if(is_array($values))
        return 'VALUES (' . implode(', ' , $values) . ') ';
    return 'VALUES (' .  $values . ') ';
}

function delete($table) {
    return 'DELETE FROM ' . $table . ' ';
}

function update($table) {
    return 'UPDATE ' . $table . ' ';
}

function set($query) {
    return 'SET ' . $query . ' ';
}

function onDuplicateKeyUpdate($query) {
    return 'ON DUPLICATE KEY UPDATE ' . $query . ' ';
}
?>