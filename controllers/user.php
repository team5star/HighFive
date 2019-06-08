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
}
