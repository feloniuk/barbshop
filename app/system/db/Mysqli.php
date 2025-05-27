<?php
/**
 * MySQLi
 */
class Mysqli_DB
{
    static public $_db;

    /**
     * Database
     */
    final static public function connectDatabase()
    {
        if (!self::$_db) {
            self::$_db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            if (mysqli_connect_errno()) {
                exit('Error DB connection...');
            } else {
                /* Set Charset utf8mb4 */
                self::$_db->set_charset("utf8mb4");

                self::$_db->query("SET NAMES 'utf8mb4'");
                self::$_db->query("SET CHARACTER SET 'utf8mb4'");
            }
        }
    }

    final static public function closeConnection()
    {
        if (self::$_db) {
            self::$_db->close();
            self::$_db = null; // Ensure the reference is also cleared to prevent further use.
        }
    }

    final static public function newConnection($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME)
    {
        $db = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

        if (mysqli_connect_errno()) {
            return false; // Error DB connection
        } else {
            /* Set Charset utf8mb4 */
            self::$_db->set_charset("utf8mb4");

            $db->query("SET NAMES 'utf8mb4'");
            $db->query("SET CHARACTER SET 'utf8mb4'");
        }

        return $db;
    }
}
/* End of file */