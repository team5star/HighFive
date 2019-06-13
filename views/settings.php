<?php
session_start();
require_once __DIR__ . "/../controllers/user.php";
require_once __DIR__ . "/../controllers/group.php";
if(!isset($_SESSION['uid']))
{
 header('location:login.php');
} else {
   $user = new User();
   $userc = new UserController();
   $user = $user->select_by_id($_SESSION['uid']);
   $_SESSION['email'] = $user['email'];
   $_SESSION['username'] = $user['username'];
   unset($user);
}
$uid = $_SESSION['uid'];
if(isset($_POST['change_names'])){
update_names();
}
if(isset($_POST['change_cities'])){
    update_cities();
}
if(isset($_POST['change_occupation'])){
    update_occupation();
}
if(isset($_POST['change_about'])){
    update_about();
}

function update_names(){
$userc = new UserController();
$uid = $_SESSION['uid'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$userc->update_account_names($first_name,$last_name,$uid);


}
function update_cities(){
$userc = new UserController();
$uid = $_SESSION['uid'];
$current_city = $_POST['current_city'];
$home_town = $_POST['home_town'];
$userc->update_account_cities($current_city,$home_town,$uid);


}
function update_occupation(){
    $userc = new UserController();
    $uid = $_SESSION['uid'];
    $occupation = $_POST['occupation'];
    $userc->update_account_occupation($occupation,$uid);    

}
function update_about(){
$userc = new UserController();
$uid = $_SESSION['uid'];
$about = $_POST['about'];
$userc->update_account_about($about,$uid);

}
function adding_values(){
$userc = new UserController();
$uid = $_SESSION['uid'];
$first_name = $userc->get_first_name_by_uid($uid);
$last_name = $userc->get_last_name_by_uid($uid);
$current_city = $userc->get_current_city_by_uid($uid);
$home_town = $userc->get_home_town_by_uid($uid);
$occupation = $userc->get_occupation_by_uid($uid);
$about= $userc->get_about_by_uid($uid);
echo"<script>
$(document).ready(function(){
    $('#FirstName').val('<?php
    echo $first_name;?>');
    $('#LastName').val('<?php echo$last_name;?>');
    $('#CurrentCity').val('<?php echo $current_city;?>');
    $('#HomeTown').val('<?php echo $home_town; ?>');
    $('#Occupation').val('<?php echo $occupation; ?>');
    $('#About').val('<?php echo $about;?>');

});
</script>";
}
adding_values();
?>

<!DOCTYpe html>
<html>
    <head>
        <!-- <script>
            $(document).ready(function(){
                $('#FirstName').val($first_name);
                $('#LastName').val($last_name);
                $('#CurrentCity').val($current_city);
                $('#HomeTown').val($home_town;
                $('#Occupation').val($occupation);
                $('#About').val($about);
            
            });
        </script> -->
        <title>Settings</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        
          <style>
              ul.nav-pills {
                top: 20px;
                position: fixed;
              }
              
              .profile-pic {
                max-width: 200px;
                max-height: 200px;
                display: block;
            }

            .file-upload {
                display: none;
            }
            .circle {
                border-radius: 1000px !important;
                overflow: hidden;
                width: 128px;
                height: 120px;
                border: 3px solid #0069d9;
            }
            img {
                max-width: 100%;
                height: auto;
            }
            
              .p-image button{
                  margin: 5px 10px;
              }
              
            .p-image:hover {
              transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
            }
            .upload-button {
              font-size: 1.2em;
            }

            .upload-button:hover {
              transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
              color: #999;
            }
          </style>
    </head>
    
    <body data-spy="scroll" data-target="#myScrollspy" data-offset="1">
        
        <div class="container-fluid mt-3">
            <div class="row">
                <nav class="col-5 col-sm-4 col-md-3 col-lg-3" id="myScrollspy">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#info">Personal Info</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#preferences">Personal Preferences</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#group_settings">Group Settings</a>
                        </li>
                  </ul>
                </nav>
                
                <div class="col-7 col-sm-8 col-md-9 col-lg-9">
                    
                    <!-------------------------------PERSONAL INFO----------------------------->
                    <div id="info">
                        <h3>Personal Info</h3>
                        <form method="post" enctype="multipart/form-data">
                            
                        <h4>Profile Picture</h4>
                        <div class="circle">
                            <img class="profile-pic" src="#" id="group_pic" align="middle">
                            <i class="fa fa-user fa-5x" id="temp" style="padding: 15px;"></i> 
                        </div>
                        <div class="p-image">
                            <button class="upload-button btn btn-primary"><span class="fa fa-camera"></span></button>
                            <input class="file-upload" type="file" accept="image/*"/ name="group_pic">
                            <button type="submit" class="btn btn-primary"><span class="fa fa-cloud-upload"></span></button>
                        </div>

                        <script>
                            $(document).ready(function() {
                                var readURL = function(input) {
                                    if (input.files && input.files[0]) {
                                        var reader = new FileReader();

                                        reader.onload = function (e) {
                                            document.getElementById("temp").style.padding = "0px";
                                            document.getElementById("temp").style.display = "none";
                                            $('.profile-pic').attr('src', e.target.result);
                                            document.getElementById("group_pic").style.display = "block";
                                            document.getElementById("group_pic").style.padding = "0px";
                                            
                                        }
                                        reader.readAsDataURL(input.files[0]);
                                    }
                                }
                                $(".file-upload").on('change', function(){
                                    readURL(this);
                                });
                                $(".upload-button").on('click', function() {
                                   $(".file-upload").click();
                                });
                            });
                        </script>
                        <br>
                            
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">&nbsp;&nbsp;&nbsp;&nbsp;Name:&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                </div>
                                <input type="text" class="form-control" placeholder="First Name" name="first_name" id="FirstName"/>
                                <input type="text" class="form-control" placeholder="Last Name" name="last_name" id="LastName"/>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" name="change_names" type="submit">Change</button>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">&nbsp;&nbsp;Address:&nbsp;&nbsp;&nbsp;</span>
                                </div>
                                <input type="text" class="form-control" placeholder="Current City" name="current_city" id="CurrentCity"/>
                                <input type="text" class="form-control" placeholder="Home Town" name="home_town" id="HomeTown"/>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" name="change_cities" type="submit">Change</button>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Occupation:</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Occupation" name="occupation" id="Occupation"/>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" name="change_occupation" type="submit">Change</button>
                                    </div>
                                </div>

                            <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;About:&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                    </div>
                                    <textarea type="text" class="form-control" placeholder="about" name="about" rows="1" id="About"></textarea>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" name="change_about" type="submit">Change</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                    <br>
                    <br>
                    <hr>
                    <br>
                    <br>
                    <!-------------------------------PERSONAL INFO----------------------------->
                    
                    <!-------------------------------PERSONAL PREFERENCES---------------------->
                    <div id="perferences">
                        <h3>Personal Perferences</h3>
                        <div class="card">
                            <div class="card-header">
                                <a class="card-link" data-toggle="collapse" href="#users_muted">Users Muted</a>
                            </div>
                            <div id="users_muted" class="collapse" data-parent="#perferences">
                                <div class="card-body">
                                    <form method="post" action="#">
                                        <ul>
                                            <li class="row">
                                                <div class="col">Me</div>
                                                <div class="col"><button class="btn btn-primary" type="submit" name="un_mute_user" value="Me">Un-Mute</button></div>
                                            </li>
                                        </ul>
                                    </form>
                                </div>
                            </div>
                        </div><br>

                        <div class="card">
                            <div class="card-header">
                                <a class="card-link" data-toggle="collapse" href="#users_blocked">Users Blocked</a>
                            </div>
                            <div id="users_blocked" class="collapse" data-parent="#perferences">
                                <div class="card-body">
                                    <form method="post" action="#">
                                        <ul>
                                            <li class="row">
                                                <div class="col">Me</div>
                                                <div class="col"><button class="btn btn-primary" type="submit" name="un_block_user" value="Me">Un-Block</button></div>
                                            </li>
                                        </ul>
                                    </form>
                                </div>
                            </div>
                        </div><br>



                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="switch1">
                            <label class="custom-control-label" for="switch1">Auto Attachment Download</label>
                        </div>
                        <br>

                        <form method="post" action="#">
                            <label for="customRange">Visibility Level:</label>
                            <ol>
                                <li>Level 1 means only you can view your stuff</li>
                                <li>Level 2 means only your friends can view your stuff</li>
                                <li>Level 3 means everyone can view your stuff</li>
                            </ol>
                            <input type="range" class="custom-range" id="customRange" name="visibility_level" min="1" max="4">
                        </form>
                    </div>
                    <br>
                    <br>
                    <hr>
                    <br>
                    <br>
                    <!-------------------------------PERSONAL PREFERENCES---------------------->
                    
                    <!-------------------------------GROUP SETTINGS---------------------------->
                    <div id="group_settings">
                        <h3>Group Settings</h3>    
                        
                        <h4>Admin Settings</h4>
                        <form method="post" action="#">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Search Group</span>
                                </div>
                                <input type="search" class="form-control" placeholder="Enter Group Name" name="search_group_name"/>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </div>
                            </div>
                        </form>
                        
                        <h4>Group Picture</h4>
                        <div class="circle">
                            <img class="profile-pic" src="#" id="group_pic" align="middle">
                            <i class="fa fa-user fa-5x" id="temp" style="padding: 15px;"></i> 
                        </div>
                        <div class="p-image">
                            <button class="upload-button btn btn-primary"><span class="fa fa-camera"></span></button>
                            <form method="post" action="#" enctype="multipart/form-data">
                            <input class="file-upload" type="file" accept="image/*"/ name="group_pic">
                            <button type="submit" class="btn btn-primary"><span class="fa fa-cloud-upload"></span></button>
                            </form>
                        </div>

                        <script>
                            $(document).ready(function() {
                                var readURL = function(input) {
                                    if (input.files && input.files[0]) {
                                        var reader = new FileReader();

                                        reader.onload = function (e) {
                                            document.getElementById("temp").style.padding = "0px";
                                            document.getElementById("temp").style.display = "none";
                                            $('.profile-pic').attr('src', e.target.result);
                                            document.getElementById("group_pic").style.display = "block";
                                            document.getElementById("group_pic").style.padding = "0px";
                                            
                                        }
                                        reader.readAsDataURL(input.files[0]);
                                    }
                                }
                                $(".file-upload").on('change', function(){
                                    readURL(this);
                                });
                                $(".upload-button").on('click', function() {
                                   $(".file-upload").click();
                                });
                            });
                        </script>
                        <br>
                        
                        
                        <form method="post" action="#">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Group Name</span>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter Group Name" value="M^5" name="group_name"/>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">Change</button>
                                </div>
                            </div>
                        </form>
                        
                        <div class="card">
                            <div class="card-header">
                                <a class="card-link" data-toggle="collapse" href="#banned_users">Users Banned</a>
                            </div>
                            <div id="banned_users" class="collapse" data-parent="#group_settings">
                                <div class="card-body">
                                    <form method="post" action="#">
                                        <ul>
                                            <li class="row">
                                                <div class="col">Moazzam hammed Paracha</div>
                                                <div class="col">
                                                    <button class="btn btn-primary" type="submit" name="un_ban_user" value="Moazzam hammed Paracha">Forgive</button>
                                                </div>
                                            </li>
                                        </ul>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <br>
                        
                        <label for="group_privacy">Privacy Level</label>    
                        <form method="post" action="#">
                            <div class="custom-control custom-radio">
                                <ul>
                                    <li>
                                        <input type="radio" class="custom-control-input" id="group_privacy_1" name="group_privacy" value="1">
                                        <label class="custom-control-label" for="group_privacy_1">Private Group</label>
                                    </li>
                                    <li>
                                        <input type="radio" class="custom-control-input" id="group_privacy_2" name="group_privacy" value="2">
                                        <label class="custom-control-label" for="group_privacy_2">Public Group</label>
                                    </li>
                                </ul>
                            </div> 
                            
                        </form>
                        
                        <h4>Normal Settings</h4>
                        
                        <div class="card">
                            <div class="card-header">
                                <a class="card-link" data-toggle="collapse" href="#groups_muted">Groups Muted</a>
                            </div>
                            <div id="groups_muted" class="collapse" data-parent="#group_settings">
                                <div class="card-body">
                                    <form method="post" action="#">
                                        <ul>
                                            <li class="row">
                                                <div class="col">Me</div>
                                                <div class="col"><button class="btn btn-primary" type="submit" name="un_mute_group" value="Me">Un-Mute</button></div>
                                            </li>
                                        </ul>
                                    </form>
                                </div>
                            </div>
                        </div><br>

                        <div class="card">
                            <div class="card-header">
                                <a class="card-link" data-toggle="collapse" href="#groups_blocked">Groups Blocked</a>
                            </div>
                            <div id="groups_blocked" class="collapse" data-parent="#group_settings">
                                <div class="card-body">
                                    <form method="post" action="#">
                                        <ul>
                                            <li class="row">
                                                <div class="col">Me</div>
                                                <div class="col"><button class="btn btn-primary" type="submit" name="un_block_group" value="Me">Un-Block</button></div>
                                            </li>
                                        </ul>
                                    </form>
                                </div>
                            </div>
                        </div><br>
                    </div>
                    <br>
                    <br>
                    <br>
                    <!-------------------------------GROUP SETTINGS---------------------------->
                    
                </div>
            </div>
        </div>
    </body>
</html>
