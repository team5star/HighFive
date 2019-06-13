<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
require_once __DIR__ . "/../controllers/user.php";
require_once __DIR__ . "/../controllers/chat.php";
$user = new UserController();
$chat = new ChatController();
$profile = $user->get_user_profile_by_username($_SESSION['username'], true);
if (!isset($_GET['username']) || !$user->username_exists($_GET['username'])) {
    if (count($profile['friends']) > 0) {
        header("Location: chat.php?username=" . $profile['friends'][0]['username']);
    } else {
        header("Location: index.php");
        //@todo REdirect to find friends
    }
}
if ($user->username_exists($_GET['username']) && $user->are_friends($_SESSION['username'], $_GET['username']) == false) {
    header("Location: profile.php?username=" . $_GET['username']);
}
$active = $user->get_user_profile_by_username($_GET['username']);
if (isset($_GET['username']) && isset($_GET['update_messages'])) {
    if (!isset($_SESSION['chat_time'])) {
        $messages = $chat->GetMessages($_SESSION['username'], $_GET['username']);
    } else {
        $messages = $chat->GetMessages($_SESSION['username'], $_GET['username'], $_SESSION['chat_time']);
    }
    foreach ($messages as $message) {
        if ($_SESSION['chat_time'] < $message['timestamp']) {
            $_SESSION['chat_time'] = (string)$message['timestamp'];
        }
    }
    echo json_encode($messages);

    die();
}
if (isset($_GET['username']) && isset($_GET['send_message']) && isset($_GET['message']) && !empty($_GET['message'])) {
    $chat->SendMessage($_SESSION['username'], $_GET['username'], filter_var(htmlentities($_GET['message']), FILTER_SANITIZE_STRING));
    die(json_encode(["message" => filter_var(htmlentities($_GET['message']), FILTER_SANITIZE_STRING)]));
}
$_SESSION['chat_time'] = null;
?>

<!DOCTYPE html>
<html>

<head>
    <title>Chat with your friends - HighFive</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#action_menu_btn').click(function() {
                $('.action_menu').toggle();
            });
        });
    </script>
    <script>
        function sendMessageNow() {
            $msg = $('#txtMsg').val();
            $.getJSON("http://localhost/highfive/views/chat.php?username=<?php echo $_GET['username']; ?>&send_message&message=" + $msg, (data) => {
                console.log(data);
                $('#txtMsg').val("");
            });
        }
        var totalMessages = 0;

        function fetchNewMessages() {
            $.getJSON("http://localhost/highfive/views/chat.php?username=<?php echo $_GET['username']; ?>&update_messages", (data) => {
                var curid = <?php echo $user->get_uid_by_username($_SESSION['username']); ?>;
                var fid = <?php echo $user->get_uid_by_username($_GET['username']); ?>;
                var curimg = "../images/profile_pics/<?php echo $profile['profile_pic']; ?>";
                var fimg = "../images/profile_pics/<?php echo $active['profile_pic']; ?>";
                totalMessages += data.length;

                console.log(data);
                $('#total').html(totalMessages + " Messages");
                data.forEach((m, i) => {
                    if (m.senderId == curid) {
                        $('.msg_card_body').append(`<div class="d-flex justify-content-end mb-4">
                            <div class="msg_cotainer_send">
                                ${m.message}
                                <span class="msg_time_send">${m.timestamp}</span>
                            </div>
                            <div class="img_cont_msg">
                                <img src="${curimg}" class="rounded-circle user_img_msg">
                            </div>
                        </div>`);
                    } else {
                        $('.msg_card_body').append(`<div class="d-flex justify-content-start mb-4">
                            <div class="img_cont_msg">
                                <img src="${fimg}" class="rounded-circle user_img_msg">
                            </div>
                            <div class="msg_cotainer">
                                ${m.message}
                                <span class="msg_time">${m.timestamp}</span>
                            </div>
                        </div>`);
                    }
                });
                if (data.length > 0) {
                    var e = $('.msg_card_body');
                    var height = e[0].scrollHeight;
                    e.scrollTop(height);
                }
            });
        }
    </script>

    <link href="../css/hf_design.css" rel="stylesheet">
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            background: #00c6ff;
            background: -webkit-linear-gradient(left, #3931af, #00c6ff);
            background: linear-gradient(left, #3931af, #00c6ff);
        }

        .chat {
            margin-top: auto;
            margin-bottom: auto;
        }

        .card {
            height: 500px;
            border-radius: 15px !important;
            background-color: rgba(0, 0, 0, 0.4) !important;
        }

        .contacts_body {
            padding: 0.75rem 0 !important;
            overflow-y: auto;
            white-space: nowrap;
        }

        .msg_card_body {
            overflow-y: auto;
        }

        .card-header {
            border-radius: 15px 15px 0 0 !important;
            border-bottom: 0 !important;
        }

        .card-footer {
            border-radius: 0 0 15px 15px !important;
            border-top: 0 !important;
        }

        .container {
            align-content: center;
        }

        .type_msg {
            background-color: rgba(0, 0, 0, 0.3) !important;
            border: 0 !important;
            color: white !important;
            height: 60px !important;
            overflow-y: auto;
        }

        .type_msg:focus {
            box-shadow: none !important;
            outline: 0px !important;
        }

        .attach_btn {
            border-radius: 15px 0 0 15px !important;
            background-color: rgba(0, 0, 0, 0.3) !important;
            border: 0 !important;
            color: white !important;
            cursor: pointer;
        }

        .send_btn {
            border-radius: 0 15px 15px 0 !important;
            background-color: rgba(0, 0, 0, 0.3) !important;
            border: 0 !important;
            color: white !important;
            cursor: pointer;
        }

        .contacts {
            list-style: none;
            padding: 0;
        }

        .contacts li {
            width: 100% !important;
            padding: 5px 10px;
            margin-bottom: 15px !important;
        }

        .active {
            background-color: rgba(0, 0, 0, 0.3);
        }

        .user_img {
            height: 70px;
            width: 70px;
            border: 1.5px solid #f5f6fa;

        }

        .user_img_msg {
            height: 40px;
            width: 40px;
            border: 1.5px solid #f5f6fa;

        }

        .img_cont {
            position: relative;
            height: 70px;
            width: 70px;
        }

        .img_cont_msg {
            height: 40px;
            width: 40px;
        }


        .user_info {
            margin-top: auto;
            margin-bottom: auto;
            margin-left: 15px;
        }

        .user_info span {
            font-size: 14px;
            color: white;
            cursor: pointer;

        }

        .user_info p {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.6);
        }


        .msg_cotainer {
            margin-top: auto;
            margin-bottom: auto;
            margin-left: 10px;
            border-radius: 25px;
            background-color: #82ccdd;
            padding: 10px;
            position: relative;
            min-width: 100px;
        }

        .msg_cotainer_send {
            margin-top: auto;
            margin-bottom: auto;
            margin-right: 10px;
            border-radius: 25px;
            background-color: #78e08f;
            padding: 10px;
            position: relative;
            min-width: 100px;
        }

        .msg_time {
            position: absolute;
            left: 0;
            bottom: -15px;
            color: rgba(255, 255, 255, 0.5);
            font-size: 10px;
        }

        .msg_time_send {
            position: absolute;
            right: 0;
            bottom: -15px;
            color: rgba(255, 255, 255, 0.5);
            font-size: 10px;
        }

        .msg_head {
            position: relative;
        }

        #action_menu_btn {
            position: absolute;
            right: 10px;
            top: 10px;
            color: white;
            cursor: pointer;
            font-size: 20px;
        }

        .action_menu {
            z-index: 1;
            position: absolute;
            padding: 15px 0;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border-radius: 15px;
            top: 30px;
            right: 15px;
            display: none;
        }

        .action_menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .action_menu ul li {
            width: 100%;
            padding: 10px 15px;
            margin-bottom: 5px;
        }

        .action_menu ul li i {
            padding-right: 10px;

        }

        .action_menu ul li:hover {
            cursor: pointer;
            background-color: rgba(0, 0, 0, 0.2);
        }

        @media(max-width: 576px) {
            .contacts_card {
                margin-bottom: 15px !important;
            }
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
                        <h3>Chat - HighFive</h3>
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
    <div class="container-fluid h-100">
        <div class="row justify-content-center h-100">
            <div class="col-md-4 col-xl-3 chat">
                <div class="card mb-sm-3 mb-md-0 contacts_card">
                    <div class="card-header">
                        <h4 class="text-white">Friends</h4>
                    </div>
                    <div class="card-body contacts_body">
                        <ui class="contacts">
                            <?php
                            foreach ($profile['friends'] as $friend) {
                                ?>
                                <li data-user="<?php echo $friend['username']; ?>" class="<?php echo ($friend['username'] == $_GET['username']) ? "active" : ""; ?>">
                                    <div class="d-flex bd-highlight">
                                        <div class="img_cont">
                                            <img src="../images/profile_pics/<?php echo $friend['profile_pic']; ?>" class="rounded-circle user_img">

                                        </div>
                                        <div class="user_info">
                                            <span><a href="chat.php?username=<?php echo $friend['username']; ?>"><?php echo $friend['firstname'] . " " . $friend['lastname']; ?></a></span>
                                        </div>
                                    </div>
                                </li>
                            <?php }
                        ?>
                        </ui>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
            <div class="col-md-8 col-xl-6 chat">
                <div class="card" id="msgboard">
                    <div class="card-header msg_head">
                        <div class="d-flex bd-highlight">
                            <div class="img_cont">
                                <img src="../images/profile_pics/<?php echo $active['profile_pic']; ?>" class="rounded-circle user_img">

                            </div>
                            <div class="user_info">
                                <span><?php echo $active['firstname'] . " " . $active['lastname']; ?></span>
                                <p id="total">0 Messages</p>
                            </div>
                        </div>
                        <span id="action_menu_btn"><i class="fas fa-ellipsis-v"></i></span>
                        <div class="action_menu">
                            <ul>
                                <li><a href="profile.php?username=<?php echo $active['username']; ?>"><i class="fas fa-user-circle"></i> View profile</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body msg_card_body">
                        <!-- Messages will go here -->
                    </div>
                    <div class="card-footer">
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text attach_btn"><i class="fas fa-paperclip"></i></span>
                            </div>
                            <textarea name="" class="form-control type_msg" id="txtMsg" placeholder="Type your message..."></textarea>
                            <div class="input-group-append">
                                <span class="input-group-text send_btn" onClick="sendMessageNow();"><i class="fas fa-location-arrow"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(() => {
            fetchNewMessages();
            setInterval(fetchNewMessages, 2000);
        })
    </script>
</body>

</html>