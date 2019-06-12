<!DOCTYpe html>
<html>

<head>
    <title>Settings</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
    .dropbtn {
  background-color: grey;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: grey;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: grey;}
    </style>
</head>

<body>
    
    <h4><strong>Group Settings</strong></h4>
    <div class="row">
        <!-- ADD A GROUP -->
        <div class="col-5">
            <h5><strong>Create a new Group</strong></h5>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Group Name</label>
                    <input id="name" type="text" class="form-control" name="name" value="" required autofocus>
                </div>
                <div class="form-group">
                <div class="row">
                        <div class="col"><label for="pic">Group Profile Pic</label></div>
                        <div class="col"><input id="pic" type="file" class="form-control" name="pic" value="" required autofocus></div>
                </div>
                <div class="form-group">
                    <label for="category">Group Category</label>
                    <input id="category" type="text" class="form-control" name="category" value="" required autofocus>
                </div>
                <div class="form-group">
                    <label for="desc">Group Description</label>
                    <textarea id="desc" row=3 class="form-control" name="desc" value="" required autofocus></textarea>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label>Visibility</label>
                        </div>
                        <div class="col"><input type="radio" name="visibility" value="Public">Public</div>
                        <div class="col"><input type="radio" name="visibility" value="Private">Private</div>
                    </div>
                    </div>
                    <div class="form-group m-0">
                        <button type="submit" class="btn btn-primary btn-block">Create</button>
                    </div>
            </form>
            </div>
        </div>
     
        <br>
        <br>
    <!-- EDIT A GROUP -->
    <div class="col-5">
            <h5><strong>Your Groups</strong></h5>
    <div class="dropdown">
  <button class="dropbtn">Select Group</button>
        <div class="dropdown-content">
            <a href="#">Group 1</a>
            <a href="#">Group 2</a>
        </div>
     </div> 
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Group Name</label>
                    <input id="name" type="text" class="form-control" name="name" value="" required autofocus>
                </div>
                <div class="form-group">
                <div class="row">
                        <div class="col"><label for="pic">Group Profile Pic</label></div>
                        <div class="col"><input id="pic" type="file" class="form-control" name="pic" value="" required autofocus></div>
                </div>
                <div class="form-group">
                    <label for="category">Group Category</label>
                    <input id="category" type="text" class="form-control" name="category" value="" required autofocus>
                </div>
                <div class="form-group">
                    <label for="desc">Group Description</label>
                    <textarea id="desc" row=3 class="form-control" name="desc" value="" required autofocus></textarea>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label>Visibility</label>
                        </div>
                        <div class="col"><input type="radio" name="visibility" value="Public">Public</div>
                        <div class="col"><input type="radio" name="visibility" value="Private">Private</div>
                    </div>
                    </div>
                    <div class="form-group m-0">
                        <button type="submit" class="btn btn-primary btn-block">Update</button>
                    </div>
            </form>
            </div>
        </div>

    <div>
</body>

<?php
session_start();
error_reporting(~0);
ini_set('display_errors', true);
require_once __DIR__ . '/../controllers/user.php';
if(isset($_SESSION['uid'])){
   header('location:index.php');
}
if(isset($_POST['login'])) {
   
   login();
}
if(isset($_POST['signup'])){
   signup();
}
if(isset($_POST['send'])) {
   echo "yaha send code";
   send_code();
}
if(isset($_POST['rec_code2'])) {
   
   if(verify_code()){
      
   }
}
$error = '';
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
?>

</html>