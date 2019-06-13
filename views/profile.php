<?php
session_start();
require_once __DIR__ . "/../controllers/user.php";
$user = new UserController();
if (isset($_SESSION['username']) && isset($_GET['friend'])) {
    die(json_encode(["success" => $user->make_friend($_SESSION['username'], $_GET['friend'])]));
}
if (isset($_SESSION['username']) && isset($_GET['unfriend'])) {
    die(json_encode(["success" => $user->unfriend($_SESSION['username'], $_GET['unfriend'])]));
}
$userinfo = [];
extract($_GET);
if (isset($username) && $user->username_exists($username)) {
    $userinfo = $user->get_user_profile_by_username($username, true);
} else if (isset($_SESSION['username'])) {
    $userinfo = $user->get_user_profile_by_username($_SESSION['username'], true);
} else {
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <title><?php echo $userinfo['firstname']; ?> - HighFive</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

    <link href="../css/hf_design.css" rel="stylesheet">
    <style>
        body {
            background: -webkit-linear-gradient(left, #3931af, #00c6ff);
        }

        .emp-profile {
            padding: 4%;
            margin-top: 5%;
            margin-bottom: 3%;
            border-radius: 0.5rem;
            background: #fff;
        }

        .profile-img {
            text-align: center;
        }

        .profile-img img {
            /* width: 70%;
            height: 70%; */
            width: 16rem;
            height: 16rem;
        }


        .profile-head h5 {
            color: #333;
        }

        .profile-head h6 {
            color: #0062cc;
        }

        .profile-friend-btn {
            border: none;
            border-radius: 1.5rem;
            width: 70%;
            padding: 2%;
            font-weight: 600;
            color: #6c757d;
            cursor: pointer;
        }


        .profile-friends {
            padding: 14%;
            margin-top: -15%;
        }

        .profile-friends p {
            font-size: 12px;
            color: #818182;
            font-weight: 600;
            margin-top: 10%;
        }

        .profile-friends a {
            text-decoration: none;
            color: #495057;
            font-weight: 600;
            font-size: 14px;
        }

        .profile-friends ul {
            list-style: none;
        }
    </style>
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
                        <h3>Profile - HighFive</h3>
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
    <div class="container emp-profile">
        <form method="post">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">
                        <img class="rounded-circle" src="../images/profile_pics/<?php echo $userinfo['profile_pic']; ?>" alt="<?php echo $userinfo['username']; ?>" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="profile-head">
                        <h5>
                            <?php echo $userinfo['firstname']; ?>
                        </h5>
                        <h6>
                            <?php echo $userinfo['occupation']; ?>
                        </h6>
                        <p>
                            <?php echo $userinfo['about']; ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-2">
                    <?php if (isset($_SESSION['username']) && $userinfo['username'] != $_SESSION['username']) {
                        if ($user->are_friends($_SESSION['username'], $userinfo['username']) == false) { ?>
                            <input type="button" class="btn btn-primary" id="btnAddFriend" name="btnAddFriend" value="Add Friend" />
                            <script>
                                $(() => {
                                    $('#btnAddFriend').click(() => {
                                        $.getJSON("profile.php?friend=<?php echo $userinfo['username']; ?>", (data) => {
                                            if (data.success) {
                                                window.location.reload();
                                            }
                                        })
                                    })
                                });
                            </script>
                        <?php } else { ?>
                            <input type="button" class="btn btn-success" id="btnUnFriend" name="btnUnFriend" value="Friend" style="width: 10em;" />
                            <script>
                                $(() => {
                                    $('#btnUnFriend').mouseenter(() => {
                                        $('#btnUnFriend').toggleClass('btn-success');
                                        $('#btnUnFriend').toggleClass('btn-danger');
                                        $('#btnUnFriend').val("Unfriend");
                                    })
                                });
                                $(() => {
                                    $('#btnUnFriend').mouseleave(() => {
                                        $('#btnUnFriend').toggleClass('btn-success');
                                        $('#btnUnFriend').toggleClass('btn-danger');
                                        $('#btnUnFriend').val("Friend");
                                    })
                                });
                                $(() => {
                                    $('#btnUnFriend').click(() => {
                                        $.getJSON("profile.php?unfriend=<?php echo $userinfo['username']; ?>", (data) => {
                                            if (data.success) {
                                                window.location.reload();
                                            }
                                        })
                                    })
                                });
                            </script>

                        <?php }
                } ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-friends">
                        <p>FRIENDS LIST</p>
                        <?php
                        foreach ($userinfo['friends'] as $friend) {
                            echo '<a href="profile.php?username=' . $friend['username'] . '">' . $friend['firstname'] . ' ' . $friend['lastname'] . '</a><br/>';
                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="profile-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Username</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo $userinfo['username']; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Name</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo $userinfo['firstname'] . " " . $userinfo['lastname']; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Email Address</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo $userinfo['email']; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Home Town</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo $userinfo['home_town']; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Current City</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo $userinfo['current_city']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>

</html>