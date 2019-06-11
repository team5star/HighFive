<?php

require_once _DIR_ . "/../models/group.php";
require_once _DIR_ . "/../models/groupmember.php";
require_once _DIR_ . "/../models/post.php";
require_once _DIR_ . "/../models/comment.php";
require_once _DIR_ . "/../models/user.php";
require_once _DIR_ . "/../models/attachment.php";
/**
 * Controller for the Different Groups
 */
class GroupController{
    
    private $group = null;
    private $group_member = null;
    private $post = null;
    private $comment = null;
    private $user = null;
    private $attachment = null;
    
    /*
     * class constructor 
     */
    
    public function __construct(){
        $this->group = new Group();
        $this->group_member = new GroupMember();
        $this->post = new Post();
        $this->comment = new Comment();
        $this->user = new User();
        $this->attachment = new Attachment();
    }
    
    /*
     * Get User id through username
     * @param String username
     */
    
    function get_uid($username){
        foreach($this->user->select_all() as $users){
            if(users["username"] == $username){
                return $users["uid"];
            }
        }return null;
    }
    
    /*
     * Get group id through group_name
     * @param String group_name
     */
    
    function get_gid($group_name){
        foreach($this->group->select_all() as $groups){
            if(groups["group_name"] == $group_name){
                return groups["group_name"];
            }
        }return null;
    }

    /*
     * Get attachment id through path
     * @param String path
     */
    
    function get_aid($path){
        foreach($this->group->select_all() as $aids){
            if(aids["path"] == $path){
                return aids["aid"];
            }
        }return null;
    }

    /*
     * Creates a new group using the following parameters and sets the default role of creater to admin.
     *
     * @param String username, used as an attribute of get_uid to get uid of user.
     * @param String group_name, both used to create the group and get gid usig get_gid.
     * @param int    used to set minimum age for a user to join a group
     * @param String category, Describe the category of the group.
     * @param String description, A small description about the group. Nullable.
     * @param int visibility, Used to set the visibility level of the group. 0 only viewed by members, 1 means can              be viewd by public.
     * @param String banned_users, uids of users that are banned. Split using ','.
     * @param String group_profile, Stores the path of the profile pic.
     */
    
    function create_group($username, $group_name, $age_restrict, $category, $description, $visibility, $banned_users, $group_profile){
        $created = $this->group->insert(["group_name" => $group_name,
                                     "age_restrict" => $age_restrict,
                                     "category" => $category,
                                     "description" => $description,
                                     "visibility" => $visibility,
                                     "banned_users" => $banned_users,
                                     "group_profile" => $group_profile]);

        if($created){
            return $this->group_member->insert(["gid" => $this->get_gid($group_name),
                                     "uid" => $this->get_uid($username),
                                     "role" => "admin"]);
        }
        return false;
    }
    
    /*
     * Creates a new post for the group using the following parameters.
     *
     * @param String username,   used as an attribute of get_uid to get uid of user.
     * @param String group_name, get gid usig get_gid.
     * @param String path,       used to get the aid. Default is 0.
     * @param String content,    The content of the text message. Nullable.
     */

    function create_post($group_name, $username, $path, $content){
        return $this->post->insert(["gid" => $this->get_gid($group_name),
                                    "uid" => $this->get_uid($username),
                                    "aid" => $this->get_aid($path),
                                    "content" => $content]);
    }

    /*
     * Creates a new comment in a post
     *
     * @param String username,     used as an attribute of get_uid to get uid of user.
     * @param String parent_comid, The id of the parent comment.  Nullable.
     * @param String path,       used to get the aid. Default is 0.
     * @param String comment,    The content of the text comment.
     */
    
    function create_comment($username, $pid, $parent_comid, $comment){
        return $this->comment->insert(["uid" => $this->get_gid($group_name),
                                       "pid" => $pid,
                                       "parent_comid" => $parent_comid,
                                       "comment" =>$comment]);
    }

    /*
     * Get all the posts in the group 
     *
     * @param String group_name,     used as an attribute of get_gid to get gid of group.
     * @return Associative array. Keys are the columns of the table.
     */
    
    function get_group_posts($group_name){
        $posts = array();
        $gid = $this->get_gid($group_name);
        foreach($this->post->select_all() as $post){
            if($post["gid"] == $gid){
                $posts[] = $post;
            }
        }
        return $posts;
    }
    
    /*
     * Get all the comments of a post
     *
     * @param int pid,     the id of the post.
     * @return Associative array. Keys are the columns of the table.
     */
    
    function get_post_comments($pid){
        $comments = array();
        foreach($this->comment->select_all() as $comment){
            if($comment["pid"] == $pid){
                $comments[] = $comment;
            }
        }
        return $comments;
    }
    
    /*
     * Used to remove a member from a group and put their uid in the banned user list.
     *
     * @param String username,     used as an attribute of get_uid to get uid of user.
     * @param String group_name,   get gid usig get_gid.
     */
    
    function ban_user($group_name, $username){
        $gid = $this->get_gid($group_name);
        $uid = $this->get_uid($username);
        $group = $this->group->select_by_id($gid);
        $group["banned_users"] .= ",$uid";
        $this->remove_member($group_name, $username);
        return $this->group->update(["banned_users" => $banned_users]);
    }

    /*
     * Used to change the role of a member. MUST ONLY BE USED BY ADMIN.
     *
     * @param String username,     used as an attribute of get_uid to get uid of user.
     * @param String $new_role,    the new role of the member.
     */
    
    function change_role($username, $new_role){
        return $this->group->update(["role" => $new_role], $this->get_uid($username));
    }
    
    /*
     * Used to add a member to the group. MUST ONLY BE USED BY AN ADMIN.
     *
     * @param String username,     used as an attribute of get_uid to get uid of user.
     * @param String group_name,   get gid usig get_gid.
     */

    function add_members($group_name, $username){
        return $this->group_member->insert(["gid" => $this->get_gid($group_name),
                                     "uid" => $this->get_uid($username),
                                     "role" => "member"]);
    }
    
    /*
     * Used to remove a member from a group
     *
     * @param String username,     used as an attribute of get_uid to get uid of user.
     * @param String group_name,   get gid usig get_gid.
     */

    function remove_member($group_name, $username){
        foreach($this->group_member->select_all() as $members){
            if($member["gid"] == $this->get_gid($group_name) and $member["uid"] == $this->get_uid($username)){
                return $this->group_member->delete($member["gmid"]);
            }
        }
        return false;
    }

    /*
     * Returns a list of groups the user has joined.
     *
     * @param String username,     used as an attribute of get_uid to get uid of user.
     * @return Associative array. Keys are the columns of the table.
     */
    
    function get_joined_groups($username){
        $groups = array();
        foreach($this->group_members->select_all() as $group){
            if($group["uid"] == $this->get_uid($username)){
                $groups[] = $this->group->select_by_id($group["gid"]);
            }
        }
        return $groups;
    }

    /*
     * Used to delete a group.
     *
     * @param String group_name,   get gid usig get_gid.
     */
    
    function delete_group($group_name){
        return $this->group->delete($this->get_gid($group_name));
    }
    
    
    /*
     * Used to search a group. Does not show groups the user is banned from.
     *
     * @param String username,          used as an attribute of get_uid to get uid of user.
     * @param String group_nsearched,   the search string having a part or the full name of a group
     * @return Associative array. Keys are the columns of the table.
     */
    
    function search_group($username, $group_searched){
        $uid = $this->get_uid($username);
        $groups = array();
        
        foreach($this->group->select_all() as $group){
            $flag = true;
            $banned_uids = explode(",", $group["banend_users"]);
            foreach($banned_uids as $user){
                if($user == $uid){
                    $flag = false;
                    break;
                }
            }
            if($flag){
                if(strpos(strtolower($group["group_name"]), $group_searched)){
                    $groups[] = $group;   
                }
            }
        }
        return $groups;
    }
}
?>