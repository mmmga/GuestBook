<?php
declare(strict_types=1);
namespace mmmmga\GuestBookTest;


define('ROOT_DIRECTORY', realpath(__DIR__ . '/..'));

// composer autoloader
require_once ROOT_DIRECTORY . '/vendor/autoload.php';


use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
// use mmmga\GuestBook\Database;



class DatabaseTest extends TestCase {

    use TestCaseTrait;

    // only instantiate pdo once for test clean-up/fixture load
    static private $pdo = null;

    // only instantiate PHPUnit_Extensions_Database_DB_IDatabaseConnection once per test
    private $conn = null;

    /**
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    public function getConnection()
    {

        if ($this->conn === null) {
            $config = parse_ini_file(ROOT_DIRECTORY . '/config.ini');
            $database = $config['name'];
            $user = $config['user'];
            $password = $config['password'];
            $dsn = 'mysql:dbname=' . $config['name'].';host=' . $config['host'];

            if (self::$pdo == null) {
                self::$pdo = new PDO($dsn, $user, $password);
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo, $database);
        }
        return $this->conn;
    }

    public function getDataSet()
    {
        // return $this->createMySQLXMLDataSet('/path/to/file.xml');
    }

}