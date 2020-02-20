<?php

require_once('./mvc/configs/ConfigDatabase.php');
/**
 * This class is an sql util that help execute sql query and fetch data when execute successful
 */
class SqlExecutor {

    /**
     * A static string variable represent for general Data Source Name for all instance of class SqlExecutor 
     * that consist mysql host and database name
     * with format: mysql:host=[host];dbname=[database_name]
     * used for connecting database when call function connect()
     * Ex: mysql:host=localhost; dbnamr=mydb    
     */
    static private $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME;


    /**
     * A static string variable represent for a general Username for all instance of class SqlExecutor 
     * used for connecting database when call function connect()
     */
    static private $username = DB_USERNAME;


    /**
     * A static string variable represent for a general Password for all instance of class SqlExecutor 
     * used for connecting database when call function connect()
     */
    static private $password = DB_PASSWORD;


    /**
     * A member PDO variable that cache the PDO object
     * when call function connect()
     */
    static private $pdo;


    /**
     * A member PDO::Statement variable that cache the PDO::Statement object
     * when call function connect()
     */
    static private $statement;    


    /**
     * Empty Constructor
     */
    private function __construct() {        
    }


    /**
     * Static function called to set general Data Source Name for all instance of class SqlExecutor 
     * used for connecting database when call function connect()
     * 
     * @param dsn A String represent for Data Source Name with format: mysql:host=[host];dbname=[database_name]
     */
    public static function setDsn(string $dsn) {
        static::$dsn = $dsn;
    }


    /**
     * Static function called to get current general Data Source Name
     * 
     * @return String data source name
     */
    public static function getDsn() : string {
        return static::$dsn;
    }


    /**
     * Static function called to set general Username for all instance of class SqlExecutor 
     * used for connecting database when call function connect()
     * 
     * @param username A String represent for Username
     */
    public static function setUsername(string $username) {
        static::$username = $username;
    }


    /**
     * Static function called to get current general Username
     * 
     * @return String Username
     */
    public static function getUsername() : string {
        return static::$username;
    }


    /**
     * Static function called to set general Password for all instance of class SqlExecutor 
     * used for connecting database when call function connect()
     * 
     * @param password A String represent for Password
     */
    public static function setPassword(string $password) {
        static::$password = $password;
    }


    /**
     * Static function called to get current general Password
     * 
     * @return String Password
     */
    public static function getPassword() : string {
        return static::$password;
    }


    /**
     * Member function called to connect to database
     * must call first to make an execution
     * 
     * @return Boolean true if connect success, false if connect fail 
     */
    private static function connect() {                         
        try {                   
            static::$pdo = new PDO(static::$dsn, static::$username, static::$password);                                
            return static::$pdo;                
        }
        catch(PDOException $e) {}
        return null;        
    }


    /**
     * Member function called to disconnect to database
     * must call when have no more use         
     */
    public static function disconnect() {
        static::$statement = null;
        static::$pdo = null;
    }


    /**
     * Member function called to execute a query
     *
     * @return Boolean true if execute success, false if execute fail
     */
    private static function execute(string $query,array $params = null) : bool {
        static::$pdo->query('set names utf8');
        static::$statement = static::$pdo->prepare($query);                
        $result = static::$statement->execute($params);        
        return $result;
    }


    /**
     * Member function called to fetch one row of result set after execute sucessful
     *
     * @param fetchType the type indicated how to fetch
     * @return Mixed data
     */
    private static function fetch(int $fetchType = PDO::FETCH_OBJ) {
        return static::$statement->fetch($fetchType);
    }


    /**
     * Member function called to fetch all rows of result set after execute sucessful
     *
     * @param fetchType the type indicated how to fetch
     * @return Mixed data
     */
    private static function fetchAll(int $fetchType = PDO::FETCH_OBJ) {
        return static::$statement->fetchAll($fetchType);
    }


    /**
     * Member function called to get the number of affected row after execute sucessful
     *     
     * @return Integer the number of affected row
     */
    public static function getNumberOfAffectedRow() : int {
        return static::$statement->rowCount();
    }    

    public static function getList($query, $params = null) {        
        if(static::$pdo || static::connect()) {
            if(static::execute($query, $params)) {
                return static::fetchAll();
            }            
        }
        return null;
    }

    public static function getSingle($query, $params = null) {        
        if(static::$pdo || static::connect()) {
            if(static::execute($query, $params)) {
                return static::fetch();
            }            
        }
        return null;
    }

    public static function executeQuery($query, $params = null) {
        if(static::$pdo || static::connect()) {                        
            return static::execute($query, $params);                
        }        
        return false;
    }

    public static function insert($table, $params) {
        $cols = [];
        $values = [];
        $anonymousValues = [];        

        foreach($params as $key => $value) {            
            $cols[] = '`'.$key.'`';
            $values[] = $value;
            $anonymousValues[] = '?';            
        }        

        $query = insert($table) 
                . cols($cols) 
                . values($anonymousValues);        
                
        return static::executeQuery($query, $values);
    }

    public static function insertOrUpdate($table, array $params) {        
        $cols = [];
        $values = [];
        $anonymousValues = [];
        $updateQueries = [];

        foreach($params as $key => $value) {            
            $cols[] = '`'.$key.'`';
            $values[] = $value;
            $anonymousValues[] = '?';
            $updateQueries[] = '`'.$key.'`' . ' = ?';
        }        

        $query = insert($table) 
                . cols($cols) 
                . values($anonymousValues) 
                . onDuplicateKeyUpdate(implode(', ', $updateQueries));

        $values = array_merge($values, $values);                
        return static::executeQuery($query, $values);
    }

    public static function update($table, $whereField, $whereOperator, $whereValue, array $params) {        
        $values = [];        
        $updateQueries = [];

        foreach($params as $key => $value) {            
            $values[] = $value;            
            $updateQueries[] = '`'.$key.'`' . ' = ?';
        }        

        $query = update($table)
                . set(implode(', ', $updateQueries))
                . where($whereField . $whereOperator. '?');        
        
        $values[] = $whereValue;       
        return static::executeQuery($query, $values);
    }

    public static function delete($table, $whereField, $whereOperator, $whereValue) {        
        $values = [];           

        $query = delete($table)
                . where($whereField . $whereOperator. '?');        
        
        $values[] = $whereValue;       
        return static::executeQuery($query, $values);
    }
}
?>