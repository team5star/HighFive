<?php
// Import credentials for database.
require_once __DIR__ . "/database.php";

/**
 * Database Helper class for executing raw queries on database.
 *
 * This class provides a connection between the app an the database.
 * Every query to the database should be executed using this class,
 * so we have a central point where we can log or manipulate them.
 *
 * @author Muhammad Tayyab Sheikh <cstayyab@gmail.com>
 *
 * @license MIT
 *
 * @since 1.0
 */
class Database
{
    /** @var PDO Connection Object */
    private $db_connection;

    /**
     * Constructor for the Database Object. Connects to database and save the connection object.
     *
     * @throws Exception if there is an error while connecting to Database.
     */
    public function __construct()
    {
        global $DB_HOST,
        $DB_NAME,
        $DB_PASSWORD,
        $DB_USER;
        
        try {
            $this->db_connection = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
        } catch (PDOException $ex) {
            throw new Exception("Cannot connection to HighFive Database: " . $ex->getMessage());
        }
    }
    /**
     * Return the connection object for executing queries though SQL
     *
     * @return PDO Returns the active PDO
     */
    public function get_connection()
    {
        return $this->db_connection;
    }
}
