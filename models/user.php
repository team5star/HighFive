<?php
require_once __DIR__ . "/../config/connection.php";

/**
 * Perfoms the CRUD operation on Users Table.
 * 
 * This class includes all the CRUD operations including other minor operation.
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
     * Selects all the rows in the table.
     * 
     * @returns mixed[][]|null Returns array of all the rows
     */
    public function select_all()
    {
        $query = "SELECT * FROM `$this->tbl`";
        return $this->db->query($query, PDO::FETCH_ASSOC)->fetchAll(PDO::FETCH_ASSOC);
    }
    /** 
     * Selects record by uid
     * 
     * @param integer $id The primary id of the record to be fetched
     * 
     * @returns mixed[]|null Return the row required in form of an associated array
     */
    public function select_by_id($id)
    {
        $query = "SELECT * FROM `$this->tbl` WHERE $this->primary=$id";
        return $this->db->query($query, PDO::FETCH_ASSOC)->fetch(PDO::FETCH_ASSOC);
    }
    /**
     * Delete record by uid (primary key)
     * 
     * @param integer $id The primary key of record to be deleted
     * 
     * @returns boolean Return if the operation was successful or not
     */
    public function delete($id)
    {
        $query = "DELETE FROM `$this->tbl` WHERE $this->primary=$id";
        return $this->db->exec($query) > 0;
    }

    /**
     * Inserts a record in to the table
     * 
     * @todo change it according to https://stackoverflow.com/a/37591506/7337013
     * 
     * @todo: Don't add primary key and timestamp column while inserting
     * 
     * @param mixed[] $vals Associative array containing keys as column names
     * 
     * @return boolean Returns if the operation was successful or not
     */
    public function insert($vals)
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

    /**
     * Update a record in to the table
     * 
     * @todo change it according to https://stackoverflow.com/a/37591506/7337013
     * 
     * @todo Don't add primary key and timestamp column while updating
     * 
     * @param mixed[] $vals Associative array containing keys as column names
     * @param integer $id User ID to update record
     * 
     * @return boolean Returns if the operation was successful or not
     */
    public function update($vals, $id)
    {
        $fields = array_keys($vals);
        $fieldlist = "";
        for($i=0;$i<count($fields); $i++) {
            $field = $fields[$i];
            $fieldlist .= "`$field`=:$field";
            if($i+ 1 != count($fields)) {
                $fieldlist .= ", ";
            }
        }
        $sql = "UPDATE `$this->tbl` SET $fieldlist WHERE `$this->primary` = $id";
        $q = $this->db->prepare($sql);
        return $q->execute($vals);
    }
}
