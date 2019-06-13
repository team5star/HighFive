<!--
REQUIRED

USERNAME
USER PROFILE
POST TIMESTAMP
POST MESSAGE/ATTACHMENT

COMMENTER USERNAME
COMMENTER PROFILE
COMMENT TIMESTAMP
COMMENT MESSAGE

-->

<?php
require_once dirname(__DIR__) . "\controllers\group.php";
require_once dirname(__DIR__) . "\controllers\user.php";
require_once dirname(__DIR__) . "\models\user.php";

$gc = new GroupController();
$uc = new UserController();
$um = new User();

function display_posts($flag, $gn){
    global $gc, $uc, $um;
    
    $group_name = null;
    $total_post = 0;
    
    if($flag){
        $total_post = $_GET['tp'];
        $group_name = $_GET['gn'];
    }else{
        $group_name = $gn;
    }
    
    $posts = $gc->get_group_posts($group_name);
    $counter = 0;
    $x = 0;
    foreach($posts as $post){
        if($total_post-- > 0 and $flag){
            continue;
        }
        if($counter++ > 5){
            break;
        }

        $u_post = $um->select_by_id($post['uid']);

        $username_p = $u_post['username'];
        $profile_pic_p = $gc->get_user_info_data($post['uid'])['profile_pic'];
        $timestamp_p = $post['timestamp'];
        
        $content = "";
        if($post['content'] != null){
            $content = '<div class="row"><p class="group_post_font">'. $post['content'] .'</p></div>';
        }
        
        $aid = $post['aid'];
        $attachment = "";
        if($aid > 0){
            $attachment = '<div class="row"><img src="'. $gc->get_attachment_data($aid)['path'] .'"></div>';
        }

        $pid = $post['pid'];

        $comments = $gc->get_post_comments($pid);
        usort($comments, 'date_compare');
        
        echo '<div class="row" id="content">
        <div class="col-sm-1">
           <img src="../images/profile_pics/'. $profile_pic_p .'" alt="logo" height = 45px class="rounded-circle group_friend_icon">
        </div> 
        <div class="col" style="margin-left:3em;">
           <div class="row">
              <div class="col-sm-0">
                 <strong>'. $username_p .'</strong>
              </div>
              <div class="col post_timestamp">'. $timestamp_p .'</div>
           </div>
           '. $content .'
           '. $attachment .'
           <div class="row post_options">

    <!--           reply            -->

              <div class="col-sm-0.5">
                 <a href="#reply'.$x.'" data-toggle="collapse">Reply</a>
                 <div id="reply'.$x++.'" class="collapse">
                    <textarea class="form-control" rows="1" id="post" style="width:30em; height:2em; margin-top:0.2em"></textarea>
                     <button type="submit" class="btn btn-primary btn-sm">Post</button>
                 </div>
              </div>
              <div class="col">
                 <a href="#comments" data-toggle="collapse">View comments</a>
                 <div id="comments" class="collapse">';
        

        
        foreach($comments as $comment){
            $u_comment = $um->select_by_id($comment['uid']);

            $profile_pic_c = $gc->get_user_info_data($comment['uid'])['profile_pic'];
            $username_c = $u_post['username'];
            $timestamp_c = $post['timestamp'];
            $comment = $post['comment'];

            echo '<!--        view comments       -->
              
                    <div class="row">
                       <div class="col-sm-1">
                          <img src="../images/profile_pics/'. $profile_pic_c .'" alt="logo" height = 45px width = 45px class="rounded-circle group_friend_icon">
                       </div>
                       <div class="col" style="margin-left: 4em">
                          <div class="row">
                             <div class="col-sm-0">
                                <strong>'. $username_c .'</strong>
                             </div>
                             <div class="col post_timestamp">'. $timestamp_c .'</div>
                          </div>
                          <div class="row">
                             <p class="group_post_font">'. $comment .'</p>
                          </div>
                       </div>
                    </div>';
        }
        echo '
                 </div>
              </div></div>
        </div>
     </div>';
    echo '<hr style="background-color: #d0e2eb">';
    }
    
}

function date_compare($a, $b){
    $t1 = strtotime($a['timestamp']);
    $t2 = strtotime($b['timestamp']);
    return $t1 - $t2;
}  
display_posts(true, "");
?>