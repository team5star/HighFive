<?php
require_once __DIR__ . "/../config/connection.php";

/**
 * Perfoms the CRUD operation on Users Table.
 * 
 * This class includes all the CRUD operations including other minor operation like get_user_by_uid etc.
 * 
 * @propert-read integer $uid
 * @property-read string $username
 * @property-read string $email
 * @property-read string $password
 * @property-read date $DOB
 * @property-read string $gender
 * @property-read date $timestamp
 * @property-read string $recovery_code
 * @property-read boolean $status
 */
class User {
    /**
     * @todo Implement Cached functionality to reduce response time
     */
    private $user = [];
    private $tbl = "users";
    private $db = null;

    public function __construct($user=null) {
        /**
         * Initialize the user array either with default values which is null or with the given set of values.
         * It is to be done so there is not "key not found" exception in __get method.
         */
        if($user == null) {
            $this->user = array(
                'uid' => null, 
                'username'=>null, 
                'email'=>null,
                'password'=>null,
                'DOB'=>null,
                'gender'=>null,
                'timestamp'=>null,
                'recovery_code'=>null,
                'status'=>null
            ); 
        } else {
            $this->user['uid'] = isset($user['uid']) ? $user['uid'] : null;
            $this->user['username'] = isset($user['username']) ? $user['username'] : null;
            $this->user['email'] = isset($user['email']) ? $user['email'] : null;
            $this->user['password'] = isset($user['password']) ? $user['password'] : null;
            $this->user['DOB'] = isset($user['DOB']) ? $user['DOB'] : null;
            $this->user['gender'] = isset($user['gender']) ? $user['gender'] : null;
            $this->user['timestamp'] = isset($user['timestamp']) ? $user['timestamp'] : null;
            $this->user['recovery_code'] = isset($user['recovery_code']) ? $user['recovery_code'] : null;
            $this->user['status'] = isset($user['status']) ? $user['status'] : null;
        }

        $this->db = (new Database())->get_connection();
    }
    public function __get($prop) {
        if(array_key_exists($prop, $this->user)) {
            return $this->user[$prop];
        } else {
            $trace = debug_backtrace();
            trigger_error(
                'Undefined property via __get(): ' . $prop .
                ' in ' . $trace[0]['file'] .
                ' on line ' . $trace[0]['line'],
                E_USER_NOTICE);
            return null;
        }
    }
    /**
     * Selects all the rows in the users tables.
     * 
     * @returns mixed[][]|null Returns array of all the columns
     */
    public function select_all() {
        $query = "SELECT * FROM `$this->tbl`";
        return $this->db->query($query, PDO::FETCH_ASSOC)->fetchAll(PDO::FETCH_ASSOC);
    }
    /** 
     * Selects user by uid
     * 
     * @param integer $uid The uid of user to be fetched
     * 
     * @returns mixed[]|null Return the user column required in form of an associated array
     */
    public function select_by_uid($uid) {
        $query = "SELECT * FROM `$this->tbl` WHERE uid=$uid";
        return $this->db->query($query, PDO::FETCH_ASSOC)->fetch(PDO::FETCH_ASSOC);
    }
}
