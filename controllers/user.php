<?php
require_once __DIR__ . "/../models/user.php";

/**
 * Controller for managing Users
 * 
 * This controller implements and perfoem all the major functionality required for managing usesrs.
 * This includes Sign Up, Login, account recovery etc.
 */
class UserController
{
    private $user = null;

    /**
     * The neccessary constructor
     */
    public function __construct()
    {
        $this->user = new User();
    }

    /**
     * Check if username already exists
     * 
     * @param string $username String for username that is to be check for existance
     * 
     * @returns boolean Return true if user already exists false otherwise (in case of DB error too)
     */
    public function username_exists($username)
    {
        $users = $this->user->select_all();
        if (count($users) > 0) {
            foreach ($users as $user) {
                if ($user['username'] == $username) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Check if email is already reistered.
     * 
     * @param string $email Valid email address that is to be checked
     * 
     * @returns boolean Returns true if user already exists false otherwise
     */
    public function email_exists($email)
    {
        $users = $this->user->select_all();
        if (count($users) > 0) {
            foreach ($users as $user) {
                if ($user['email'] == $email) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Verify credentials using username
     * 
     * @param string $username String representing an existing username
     * @param string $salted_password represent a salted/digested password
     * 
     * @returns boolean Returns if the credentials matched or not
     * 
     */
    public function verify_login_via_username($username, $salted_password) {
        $users = $this->user->select_all();
        if(count($users)>0) {
            foreach ($users as $user) {
                if ($user['username'] == $username && $user['password'] == $salted_password) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Verify credentials using email address
     * 
     * @param string $email String representing an existing email address
     * @param string $salted_password represent a salted/digested password
     * 
     * @returns boolean Returns if the credentials matched or not
     * 
     */
    public function verify_login_via_email($email, $salted_password) {
        $users = $this->user->select_all();
        if(count($users)>0) {
            foreach ($users as $user) {
                if ($user['email'] == $email && $user['password'] == $salted_password) {
                    return true;
                }
            }
        }
        return false;
    }

    public function create_account() {
        
    }
}
