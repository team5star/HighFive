<?php
require_once __DIR__ . "/../models/user.php";
require_once __DIR__ . "/../models/userinfo.php";
require_once __DIR__ . "/../models/friend.php";

/**
 * Controller for managing Users
 * 
 * This controller implements and perfoem all the major functionality required for managing usesrs.
 * This includes Sign Up, Login, account recovery etc.
 */
class UserController
{
    private $user = null;
    private $userinfo = null;
    private $friends = null;

    /**
     * The neccessary constructor
     */
    public function __construct()
    {
        $this->user = new User();
        $this->userinfo = new UserInfo();
        $this->friends = new Friend();
    }

    /**
     * Check if username already exists
     * 
     * @param string $username String for username that is to be check for existance
     * 
     * @return boolean Return true if user already exists false otherwise (in case of DB error too)
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
     * @return boolean Returns true if user already exists false otherwise
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
     * @return boolean Returns if the credentials matched or not
     * 
     */
    public function verify_login_via_username($username, $salted_password)
    {
        $users = $this->user->select_all();
        if (count($users) > 0) {
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
     * @return boolean Returns if the credentials matched or not
     * 
     */
    public function verify_login_via_email($email, $salted_password)
    {
        $users = $this->user->select_all();
        if (count($users) > 0) {
            foreach ($users as $user) {
                if ($user['email'] == $email && $user['password'] == $salted_password) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Create new account when validated parameters are given
     * 
     * @param string $email Email address to associate with new account
     * @param string $username username for new users
     * @param string $salted_password salted password string
     * @param string $dob Date of birth of the user
     * @param string $gender Gender of the user
     * 
     * @return boolean Returns true if creation is successful false otherwise
     */
    public function create_account($email, $username, $salted_password, $dob, $gender)
    {
        return $this->user->insert([
            "email" => $email,
            "username" => $username,
            "password" => $salted_password,
            "dob" => $dob,
            "gender" => $gender
        ]);
    }

    /**
     * Generate recovery code for the user
     * 
     * @param string $email String representating email of the user to be recovered
     * 
     * @return string|false a string representaing the returened recovery code if successful or false otherwise
     */
    public function generate_recovery_code($email)
    {
        date_default_timezone_set('UTC');
        $uid = $this->get_uid_by_email($email);
        $code = $this->guidv4();
        $timestamp = date("Y-m-d H:i:s");
        if ($this->user->update([
            'recovery_code' => $code,
            'recovery_code_created' => $timestamp,
        ], $uid)) {
            return $code;
        } else {
            return false;
        }
    }

    /**
     * Function to verify the recovery code entered by user
     * 
     * @param string $email Email address of the user to recover
     * 
     * @param string $code Recovery code provided by the user
     * 
     * @return boolean Returns true if code in matched false otherwise
     */
    function verify_recovery_code($email, $code)
    {
        $users = $this->user->select_all();
        foreach ($users as $user) {
            if ($user['email'] == $email) {
                if ($user["recovery_code"] == $code) {
                    return true;
                } else {
                    return false;
                }
            }
        }
        return false;
    }

    /**
     * Get the UID of user by username
     * 
     * @param string $username Username for which UID is to be found
     * 
     * @return integer|null UID of the username if found, null otherwise
     */
    public function get_uid_by_username($username)
    {
        $users = $this->user->select_all();
        foreach ($users as $user) {
            if ($user['username'] == $username) {
                return $user['uid'];
            }
        }
        return null;
    }
    /**
     * Get the UID of user by email
     * 
     * @param string $email Email for which UID is to be found
     * 
     * @return integer|null UID of the email if found, null otherwise
     */
    public function get_uid_by_email($email)
    {
        $users = $this->user->select_all();
        foreach ($users as $user) {
            if ($user['email'] == $email) {
                return $user['uid'];
            }
        }
        return null;
    }

    /**
     * Get information about user by username
     * 
     * @param string $username Username to fetch info
     * @param boolean $fetch_friends Tell if Friends should also be fetched. Default is false.
     */
    public function get_user_profile_by_username($username, $fetch_friends = false)
    {
        $uid = $this->user->get_uid_by_username($username);
        $ufid = $this->userinfo->get_ufid_by_uid($uid);
        $profile = $this->userinfo->select_by_id($ufid);
        $info = $this->user->select_by_id($uid);
        $profile = array_merge($profile, $info);
        if ($fetch_friends) {
            $friends = [];
            $frlist = $this->friends->select_all();
            foreach ($frlist as $fr) {
                if ($fr['uidr'] == $uid || $fr['uidl'] == $uid) {
                    $fid = ($fr['uidr'] == $uid) ? $fr['uidl'] : $fr['uidr'];
                    $funame = $this->user->select_by_id($fid)['username'];
                    $friends[] = $this->get_user_profile_by_username($funame);
                }
            }
            $profile['friends'] = $friends;
        }
        return $profile;
    }
    /**
     * Check if two users are friend
     * 
     * @param string $usernamel Username of one user
     * @param string $usernamer USername of other user
     * 
     * @return boolean Returns true if they are friends false otherwise
     */
    public function are_friends($usernamel, $usernamer)
    {
        $uidr = $this->user->get_uid_by_username($usernamer);
        $uidl = $this->user->get_uid_by_username($usernamel);
        $friends = $this->friends->select_all();
        foreach ($friends as $friend) {
            if ($friend['uidr'] == $uidr || $friend['uidr'] == $uidl || $friend['uidl'] == $uidr || $friend['uidl'] == $uidr) {
                return true;
            }
        }
        return false;
    }

    /**
     * Unfriend two users
     * 
     * 
     * @param string $usernamel Username of one user
     * @param string $usernamer USername of other user
     * 
     * @param boolean returns true if successfull. false otherwise
     * 
     */
    public function unfriend($usernamel, $usernamer) {
        $uidr = $this->user->get_uid_by_username($usernamer);
        $uidl = $this->user->get_uid_by_username($usernamel);
        $friends = $this->friends->select_all();
        foreach ($friends as $friend) {
            if ($friend['uidr'] == $uidr || $friend['uidr'] == $uidl || $friend['uidl'] == $uidr || $friend['uidl'] == $uidr) {
                return $this->friends->delete($friend['fid']);
            }
        }
        return false;
    }

    /**
     * Friend two users
     * 
     * 
     * @param string $usernamel Username of one user
     * @param string $usernamer USername of other user
     * 
     * @param boolean returns true if successfull. false otherwise
     * 
     */
    public function make_friend($usernamel, $usernamer) {
        $uidr = $this->user->get_uid_by_username($usernamer);
        $uidl = $this->user->get_uid_by_username($usernamel);
        $friends = $this->friends->select_all();
        foreach ($friends as $friend) {
            if ($friend['uidr'] == $uidr || $friend['uidr'] == $uidl || $friend['uidl'] == $uidr || $friend['uidl'] == $uidr) {
                return true;
            }
        }
        return $this->friends->insert([
            "uidr"=>$uidr,
            "uidl" => $uidl
        ]);
    }

    /**
     * GUID generation function for compatibility issues
     * 
     * @return string Returns a string representing a GUID v4
     */
    private function guidv4()
    {
        if (function_exists('com_create_guid') === true)
            return trim(com_create_guid(), '{}');

        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
