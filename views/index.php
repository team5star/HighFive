<?php
// Start the session
session_start();
require_once __DIR__ . "/../controllers/user.php";
require_once __DIR__ . "/../controllers/group.php";
if (!isset($_SESSION['uid'])) {
   header('location:login.php');
} else {
   $user = new User();
   $user = $user->select_by_id($_SESSION['uid']);
   $_SESSION['email'] = $user['email'];
   $_SESSION['username'] = $user['username'];
   unset($user);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta http-equiv="content-type" content="text/html; charset=UTF-8">
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <title>High-Five</title>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
   <link href="../css/hf_design.css" rel="stylesheet">
</head>

<body>
   <div class="navbar fixed-top bg-white box-shadow py-0">
      <nav class="nav nav-underline">
         <div class="container">
            <div class="row">
               <div class="col-xs-8 col-xs-offset-2">
                  <!-- <div class="input-group">
                            <div class="input-group-btn search-panel">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="width: auto; height: auto;">
                                    <span id="search_concept" style="font-size: 15px">Search by</span> <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <div style="margin-left: 1em;">
                                        <li><a href="#Posts">Posts</a></li>
                                        <li><a href="#Groups">Groups</a></li>
                                        <li><a href="#Friends">Friends</a></li>
                                        <li>
                                            <hr>
                                        </li>
                                        <li><a href="#all">All</a></li>
                                    </div>
                                </ul>
                            </div>
                            <input type="hidden" name="search_param" value="all" id="search_param">
                            <form class="form-inline my-2 my-lg-0" style="float: right">
                                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                                <button class="btn btn-outline-success btn-rounded btn-sm my-0" type="submit">Search</button>
                            </form>
                        </div> -->
                  <h3>HighFive</h3>
               </div>
            </div>
         </div>
      </nav>
      <nav class="navbar navbar-inverse  bg-white box-shadow py-0">
         <div class="container-fluid">
            <a class="nav-link" href="profile.php">
               <!-- <object type="image/svg+xml" data="../images/svg/account.svg" height=24px width=24px></object> -->
               <i class="fas fa-user-circle fa-2x"></i>
            </a>
            <a class="nav-link" href="chat.php">
               <!-- <object type="image/svg+xml" data="../images/svg/messages.svg" height=24px width=24px></object> -->
               <i class="far fa-comment-dots fa-2x"></i>
            </a>
            <a class="nav-link" href="settings.php">
               <!-- <object type="image/svg+xml" data="../images/svg/messages.svg" height=24px width=24px></object> -->
               <i class="fas fa-cog fa-2x"></i>
            </a>
            <!-- <a class="nav-link" href="#">
                    <object type="image/svg+xml" data="../images/svg/notifications.svg" height=24px width=24px></object>
                </a>
                <a class="nav-link" href="#">
                    <object type="image/svg+xml" data="../images/svg/settings.svg" height=24px width=24px></object>
                </a> -->
            <div class="logo">
               <a href="index.php"><img src="../images/logo.png" alt="logo" class="rounded-circle" style="width:48px; height:48px;"></a>
            </div>
         </div>
      </nav>
   </div>
   <div class="modal" id="message_menu">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title"><strong>Messages</strong></h5>
               <button type="button" class="close" data-dismiss="message_menu">&times;</button>
            </div>
            <div class="modal-body">
               <a href="#" data-toggle="modal" data-target="#message_chat" data-dismiss="modal">
                  <div class="message_view">
                     <div class="row">
                        <div class="col-0 comment_pic">
                           <img src="../images/friend_pics/orton.jpg" alt="logo" height=30px width=30px class="rounded-circle">
                        </div>
                        <div class="col-3">
                           <h5>
                              <strong>Randy Orton</strong>
                           </h5>
                        </div>
                        <div class="col">
                           <h5>I hope you burn in hell</h5>
                        </div>
                     </div>
                     <hr>
                  </div>
               </a>
               <a href=#>
                  <div class="message_view">
                     <div class="row">
                        <div class="col-0 comment_pic">
                           <img src="../images/friend_pics/arab.jpg" alt="logo" height=30px width=30px class="rounded-circle">
                        </div>
                        <div class="col-3">
                           <h5>
                              <strong>Hamud bin Kharis</strong>
                           </h5>
                        </div>
                        <div class="col">
                           <h5>Bhai dhai mujhay pasand bilkuy nai hai</h5>
                        </div>
                     </div>
                     <hr>
                  </div>
               </a>
            </div>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
   <div class="modal" id="message_chat">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <table>
                  <tr>
                     <td style="padding-right: 1em; ">
                        <img src="../images/friend_pics/orton.jpg" alt="logo" height=60px width=60px class="rounded-circle center-block modal-title">
                     </td>
                     <td>
                        <strong>Randy Orton</strong>
                     </td>
                  </tr>
               </table>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               <div class="friend_message">
                  <div class="row">
                     <div class="col-sm-1">
                        <img src="../images/friend_pics/orton.jpg" alt="logo" height=45px width=45px class="rounded-circle">
                     </div>
                     <div class="col" style="margin-left: 1em">
                        <div class="row">
                           <div class="col">
                              <p class="group_post_font" style="margin-top: 0.5em;">Hello</p>
                           </div>
                        </div>
                        <div class="row" style="margin-top: -1em">
                           <div class="col post_timestamp">6/1/19 10:55 AM</div>
                        </div>
                     </div>
                  </div>
               </div>
               <div id="friend_message">
                  <div class="row">
                     <div class="col-sm-1">
                        <img src="../images/friend_pics/orton.jpg" alt="logo" height=45px width=45px class="rounded-circle">
                     </div>
                     <div class="col" style="margin-left: 1em">
                        <div class="row">
                           <div class="col">
                              <p class="group_post_font" style="margin-top: 0.5em">I hope you burn in hell</p>
                           </div>
                        </div>
                        <div class="row" style="margin-top: -1em">
                           <div class="col post_timestamp">6/1/19 10:55 AM</div>
                        </div>
                     </div>
                  </div>
               </div>
               <div id="user_message">
                  <div class="row" style="float: right">
                     <div class="col">
                        <div class="row">
                           <div class="col">
                              <p class="group_post_font">Why</p>
                           </div>
                        </div>
                        <div class="row" style="margin-top: -1em;">
                           <div class="col post_timestamp">6/1/19 10:56 AM</div>
                        </div>
                     </div>
                     <div class="col-sm-1 user_message_pic">
                        <img src="../images/letter.png" alt="logo" height=45px class="rounded-circle" style="float:right">
                     </div>
                  </div>
               </div>
               <br>
               <br> <br> <br>
               <div>
                  <div class="row">
                     <div class="col">
                        <textarea class="form-control" rows="1" id="post" style="width:18em; height:2em; margin-top:0.2em"></textarea>
                     </div>
                     <div class="col">
                        <table>
                           <tr>
                              <td>
                                 <div class="input-group-btn search-panel">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="width: auto; height: auto; margin-top:1em;">
                                       <span id="search_concept" style="font-size: 15px">Add</span> <span class="caret"></span>
                                    </button>
                                    <form>
                                       <ul class="dropdown-menu" role="menu">
                                          <div style="margin-left: 1em;">
                                             <li><a href="#">Picture</a></li>
                                             <li><a href="#">Video</a></li>
                                             <li><a href="#">File</a></li>
                                          </div>
                                       </ul>
                                    </form>
                                 </div>
                              </td>
                              <td>
                                 <input type="hidden" name="search_param" value="all" id="search_param">
                                 <form class="form-inline my-2 my-lg-0" style="float: right">
                                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Send</button>
                                 </form>
                              </td>
                           </tr>
                        </table>
                     </div>
                  </div>
               </div>
               </form>
               <hr>
               <div style="margin-left: 9em;">
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#message_menu" data-dismiss="modal">Go Back</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
               </div>
            </div>
         </div>
      </div>
   </div>
   </div>
   <div class="container-fluid" style="margin-top: 4.2em" id="moazzam">

      <!-----------------------------------------group name heading----------------------------------------------------->
      <div align=center>
         <h1 id="group_name"><?php
                              if (isset($_GET['gn'])) {
                                 echo $_GET['gn'];
                              }
                              ?></h1>
      </div>
      <!---------------------------------------------------------------------------------------------------------------->

      <div class="row">

         <!--------------------------------------------left nav bar------------------------------------------------------->
         <div class="col-sm-0.5" style="margin-left: 0.5em; margin-right: 1em; margin-left: 1em; background-color: #eef7fe;border-right: 2px solid #bfd8e4; border-left: 2px solid #bfd8e4">
            <ul class="nav flex-column px-0 py-2">

               <h4 style="align-self: center; font-size: 18px; color: black; margin-top: 1em">Groups</h4>
               <?php
               require_once dirname(__DIR__) . "\controllers\group.php";

               $gc = new GroupController();
               $joined_groups = $gc->get_joined_groups($_SESSION['uid']);

               foreach ($joined_groups as $jp) {
                  echo '<li class="nav-item" >
                     <a class="nav-link" href="#">
                        <table class="group_label">
                           <tr>
                              <td><img src = "' . $jp['group_profile'] . '" height = 30px width = 30px class="rounded"></td>
                              <td>
                                 <h5><a href="index.php?gn=' . $jp['group_name'] . '">' . $jp['group_name'] . '</a></h5>
                              </td>
                           </tr>
                        </table>
                     </a>
                  </li>';
               }

               ?>
               <li>
                  <hr style="border: 1px solid antiquewhite; border-radius: 2px; width: auto;">
               </li>
               <?php
               if (isset($_GET['gn']) && !empty($_GET['gn'])) { ?>
                  <h4 style="align-self: center; font-size: 18px; color: black;">Members</h4>
                  <?php
                  require_once dirname(__DIR__) . "\controllers\group.php";
                  $gc = new GroupController();
                  if (isset($_GET['gn'])) {
                     $members = $gc->get_joined_members($_GET['gn']);

                     foreach ($members as $mem) {
                        $u_info = $gc->get_user_info_data($mem['uid']);
                        echo '<li class="nav-item">
                              <a class="nav-link" href="profile.php?username=' . $mem['username'] . '">
         
                                 <div class="row">
                                       <div class="col-sm-1">
                                             <img src="' . $u_info['profile_pic'] . '" alt="logo" height = 30px width = 30px class="rounded-circle">
                                       </div>
                                       <div class="col" >
                                          <div class="row group_label">
                                                <div class="col" ><h5>' . $mem['username'] . '</h5></div>
                                          </div>
                                       </div>
                                    </div>
                              </a>
                           </li>';
                     }
                  }
                  ?>
               <?php } ?>
               <li>
                  <hr style="border: 1px solid antiquewhite; border-radius: 2px; width: auto;">
               </li>
            </ul>
         </div>
         <!--------------------------------------------------------------------------------------------------------------->

         <div class="col" style="background-color: #f9f9f9; border-left: 2px solid #bfd8e4">

            <!-----------------------------------------user post-------------------------------------------------------------->
            <?php if(isset($_GET['gn']) && !empty($_GET['gn'])) { ?>
            <div class=user_post>
               <form method="get" action="addpost.php" id="adding_post">
                  <textarea name="pt" class="form-control" rows="2" id="post1" placeholder="Post a message" style="border: 1px solid #46B1FC;"></textarea>
                  <div class="form-group" id="attachment_div">
                  </div>
                  <div class="post_buttons">
                     <button type="submit" class="btn btn-primary btn-md">Post</button>
                  </div>
                  <script>
                     var group_name = document.getElementById('group_name').innerHTML;
                     var uid = 1;
                     <?php
                     if (isset($_SESSION['uid'])) {
                        echo "uid = {$_SESSION['uid']};";
                     }
                     ?>
                     $("#adding_post").append("<input value='<?php echo $_GET['gn']; ?>' name='gn' hidden>");
                     $("#adding_post").append("<input value='" + uid + "' name='uid' hidden>");
                  </script>
               </form>
            </div>
            <!---------------------------------------------------------------------------------------------------------------->

            <script type="text/javascript" src="js/jquery-1.3.2.js"></script>
            <script>
               $('document').ready(function() {
                  scrollalert();
               });

               function attachment(str) {
                  var div = document.getElementById("attachment_div");
                  div.innerHTML = '';
                  switch (str) {
                     case "pic":
                        div.innerHTML = '<input type="file" class="form-control-file border" accept="image/*"> id="post_attachment"';
                        break;

                     case "html":
                        div.innerHTML = '<input type="file" class="form-control-file border" accept="text/*"> id="post_attachment"';
                        break;

                     case "vid":
                        div.innerHTML = '<input type="file" class="form-control-file border" accept="video/*"> id="post_attachment"';
                        break;

                     case "audio":
                        div.innerHTML = '<input type="file" class="form-control-file border" accept="audio/*"> id="post_attachment"';
                        break;

                     case "file":
                        div.innerHTML = '<input type="file" class="form-control-file border" accept="application/*"> id="post_attachment"';
                        break;
                  }

               }

               function scrollalert() {
                  var scrolltop = $('#scrollbox').attr('scrollTop');
                  var scrollheight = $('#scrollbox').attr('scrollHeight');
                  var windowheight = $('#scrollbox').attr('clientHeight');
                  var total_posts = $('#scrollbox div[id=content]').length;
                  var group_name = document.getElementById('group_name').innerHTML;
                  var scrolloffset = 20;
                  if (scrolltop >= (scrollheight - (windowheight + scrolloffset))) {
                     $.get(('new-items.php?tp=' + total_posts + '&gn=' + group_name), '', function(newitems) {
                        $('#scrollbox').append(newitems);
                     });
                  }
                  setTimeout('scrollalert();', 1000);
               }
            </script>
            <?php } else {?>
               <h3 class="text-muted">No Group Selected</h3>
            <?php } ?>
            <hr style="background-color: #d0e2eb">
            <div class="group_posts_holder" style="overflow-y: scroll; height: 460px;" id="scrollbox">

            </div>
            <br>
            <br>
         </div>

         <!----------------------------------------------left description box---------------------------------------------->
         <?php
         require_once dirname(__DIR__) . "/controllers/group.php";
         if (isset($_GET['gn'])) {
            $gc = new GroupController();
            $group = $gc->get_group_data($_GET['gn']);

            echo '<div class="col" style="background-color: #eef7fe; border-left: 2px solid #bfd8e4; border-right: 2px solid #bfd8e4; -ms-flex: 0 0 230px;  flex: 0 0 230px;">
            <div class ="group_info">
                  <div class="row">
                     <div class="col" >
                        <h5><strong>' . $_GET['gn'] . '</strong></h5>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col">
                        <p>' . $group['description'] . '</p>
                     </div>
                  </div>

                  
               </div>
            </div>';
         }
         ?>
         <!---------------------------------------------------------------------------------------------------------------->
      </div>
   </div>
</body>

</html>