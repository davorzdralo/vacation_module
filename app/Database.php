<?php

namespace App;

use Config\DbConfig;
use PDO;
use PDOException;

/**
 * Provides access to the database. This class implements Singleton pattern to provide single access point.
 * If the application grew, and we needed a more flexible/testable system, we could inject the DB connection into
 * classes that need it using IoC/DI container.
 */
class Database {
    /**
     * Checks if there is an existing PDO object, creates one if there isn't one already, and than returns it.
     * @return PDO An open PDO object for querying the database.
     */
    public static function getConnection() {

        static $connection = null;

        if ($connection === null) {
            try {
                $connection = new PDO("mysql:host=" . DbConfig::HOST . ";dbname=" . DbConfig::DB_NAME, DbConfig::USERNAME, DbConfig::PASSWORD);
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $exception) {
                die("Connection error: " . $exception->getMessage());
            }
        }

        return $connection;
    }

    /**
     * Private constructor so that nobody can instantiate the class from the outside.
     */
    private function __construct() {
        // Intentionally empty body.
    }
}





