<?php

namespace mmmga\GuestBook;
use PDO;

class Database {
    private static $link = null ;
    
    private function __construct() {
        self::getInstance();
    }

    private static function getInstance ( ) {
        if ( self::$link ) {
            return self::$link ;
        }

        $config = parse_ini_file(ROOT_DIRECTORY . '/config.ini');

        $dsn = 'mysql:dbname=' . $config['name'].';host=' . $config['host'];
        $user = $config['user'];
        $password = $config['password'];
        // $password = getenv('DB_PASSWORD');
        
        $options                                = [];
        $options[PDO::MYSQL_ATTR_INIT_COMMAND]  = "set names utf8";
        $options[PDO::ATTR_ERRMODE]             = PDO::ERRMODE_EXCEPTION;
        
        self::$link = new PDO ( $dsn, $user, $password, $options ) ;

        return self::$link ;
    }

    public static function __callStatic ( $name, $args ) {
        $callback = array ( self::getInstance(), $name ) ;
        return call_user_func_array ( $callback , $args ) ;
    }
}