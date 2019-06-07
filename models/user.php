<?php
require_once __DIR__ . "/../config/connection.php";

/**
 * Perfoms the CRUD operation on Users Table.
 * 
 * This class includes all the CRUD operations including other minor operation like get_user_by_uid etc.
 */
class User
{
    /**
     * @todo Implement Cached functionality to reduce response time
     */
    private $tbl = "users";
    private $primary = "uid";
    private $db = null;

    /**
     * Selects all the rows in the users tables.
     * 
     * @returns mixed[][]|null Returns array of all the columns
     */
    public function select_all()
    {
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
    public function select_by_uid($uid)
    {
        $query = "SELECT * FROM `$this->tbl` WHERE $this->primary=$uid";
        return $this->db->query($query, PDO::FETCH_ASSOC)->fetch(PDO::FETCH_ASSOC);
    }
    /**
     * Delete user by uid (primary key)
     * 
     * @param integer $uid The uid of user to be fetched
     * 
     * @returns boolean Return if the operation was successful or not
     */
    public function delete_user($uid)
    {
        $query = "DELETE FROM `$this->tbl` WHERE $this->primary=$uid";
        return $this->db->exec($query) > 0;
    }

    /**
     * Inserts a record in to user table
     * 
     * @todo change it according to https://stackoverflow.com/a/37591506/7337013
     * 
     * @todo By Moz125: Don't add uid and timestamp column while inserting
     * 
     * @param mixed[] $vals Associative array containing keys as column names
     * 
     * @return boolean Returns if the operation was successful or not
     */
    public function insert_user($vals)
    {
        $fields = array_keys($vals);
        $values = array_values($vals);
        $fieldlist = implode(',', $fields);

        /* Fixed by @Moz125 */
        for($x = 0; $x < count($values); $x++){
            $values[$x] = "'{$values[$x]}'";
        }
        $qs = implode(", ", $values);
        /* end of fix */

        $sql = "insert into `$this->tbl`($fieldlist) values(${qs}?)";
        $q = $this->db->prepare($sql);
        return $q->execute($values);
    }
}
