
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
<<<<<<< HEAD
if(isset($_POST['login'])) {
   login();
}
//testing
$user = new UserController();
=======
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


>>>>>>> f4c177f86e38674f4bff0e110dff00d25b758ae5
$error = '';
function signup(){
$user = new UserController();
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$date = $_POST['date'];
$gender = $_POST['Gender'];
if(!($user->email_exists($email) && $user->username_exists($username))){
   // $user->create_account('ali@gmail.com','ali','ali','1998-02-02','Male');
   $user->create_account($email,$username,$password,$date,$gender);
}
else{
   
   echo "<script> alert ('Username or email already used'); </script>";
   echo "<script> $(document).ready(function(){
      $('#signup_modal').modal('show'); }); </script>";
   // $_SESSION['signup_error'] = "Username or email already used";
   // if(isset($_SESSION['signup_error'])){
   //    $error_msg = "<div class='signup-modal'>Username or password already used2</div>";
   //    $script = "<script> $(document).ready(function(){ $('#signup_modal').modal('show'); }); </script>";
      
      // echo "<div class='alert alert-danger' role='alert'>";
      // echo $_SESSION['signup_error'];
   }
}

function login() {
$user = new UserController();
$email = $_POST['email'];
$password = $_POST['password'];
if($user->verify_login_via_email($email,$password)) {
   unset($_SESSION['login_error']);
   $_SESSION['uid'] = $user->get_uid_by_email($email);
   header('Location:index.php');

}
else{
$_SESSION['login_error'] = "Invalid credentials! Can't login.";
header("Location: login.php");
}
}

function send_code(){
echo "<script> alert ('Username or email already used'); </script>";
$user = new UserController();
$email = $_POST['emailrecover'];
if($email == ''){
   echo "<script> alert ('Username or email already used'); </script>";
}
if($user->email_exists($email)) {
   $rec_code = $user->generate_recovery_code($email);
   // the message
$msg =  " This is srecover code for forget password ". $rec_code.'</br>';
// mail($email,"Recovery Code",$msg);
}
else{
   //Show error alert on same dialog
}
}

function verify_code(){
   $user = new UserController();
   $recovery_code = $_POST['rec_code'];
   $email = $_POST['emailrecover'];
   
   if ($user->verify_recovery_code($email, $recovery_code)){

   }
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
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
      <link href="High_Five_Design.css" rel="stylesheet">
   </head>
   <script>


/* jquery.validate plagin added using cdn. Go to jqueryvalidation.org to see what methods are provided */
/* Create custom validation method */
// $.validator.addMethod("startWithA", function(value, element) {
// 	return /^A/.test(value);
// }, "Field must start with A");

$(document).ready(function(){
$("button#signup").click(function(){
$.ajax({
type: "POST",
url: "login.php",
data: $('form.signup_').serialize(),
success: function(message){
// $("#feedback").html(message)
$("#signup_modal").modal('hide');
},
error: function(){
alert("Error");
$("#signup_modal").modal('show');
}
});
});
});

</script>
   <body class="login_page" style="background-color: #eef7fe">
      <section class="h-100">
         <div class="container h-100">
            <div class="row justify-content-md-center h-100">
               <div class="card-wrapper" style="width: 20em">
                  
                  <!--Group logo-->
                  <div class="logo">
                     <img src="Pictures/logo/logo.png" alt="logo" height = 90px class="rounded-circle" >
                  </div>
                  
                  <div class="card fat">
                     <div class="card-body" style="border: 1px solid #89cdfd;">
                        <h4 class="card-title" style="text-align: center" >Welcome</h4>
                        <?php if(isset($_SESSION['login_error'])) { ?> 
                     <div class="alert alert-danger" role="alert">
                        <?php echo $_SESSION['login_error']; ?>
                     </div>
                       <?php }
                     ?>
                        <!--Main Login MENU-->
                        <form method="POST" action = "login.php">
                           <div class="form-group">
                              <label for="email">E-Mail Address</label>
                              <input id="email" type="email" class="form-control" name="email" value="" required autofocus>
                           </div>
                           <div class="form-group">
                              <label for="password">Password</label>
                              <input id="password" type="password" class="form-control" name="password" required data-eye>
                           </div>
                           <div class="form-group">
                              <div class="custom-checkbox custom-control">
                                 <input type="checkbox" name="remember" id="remember" class="custom-control-input">
                                 <label for="remember" class="custom-control-label">Remember Me</label>
                              </div>
                           </div>
                           <div class="form-group">
                              <button type="submit" class="btn btn-primary btn-block" name="login" style="background-color: #46B1FC"> Login </button>
                           </div>
                        </form>
                        
                        <!--Options in case user cannot login-->
                        <div class = "login_help" style="text-align: center">
                           <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#signup_modal" >
                           Sign Up
                           </button>
                           <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#forgotpass_modal">
                           Forgot Password?
                           </button>
                        </div>
                        
                        <!--Pop up form gor user to sign up-->
                        <div class="modal" id="signup_modal">
                           <div class="modal-dialog">
                              <div class="modal-content" style="width:80%">
                                 <div class="modal-header">
                                    <h4 class="modal-title" style="text-align: center">Sign Up</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                 </div>
                                 <div class="modal-body">
                                    <form method="POST" class="signup_" name = "signup_">
                                       <div class="form-group">
                                          <label for="username">Username</label>
                                          <input id="username" type="text" class="form-control" name="username" value="" required autofocus>
                                       </div>
                                       <div class="form-group">
                                          <label for="email">E-Mail Address</label>
                                          <input id="email" type="email" class="form-control" name="email" value="" required autofocus>
                                       </div>
                                       <div class="form-group">
                                          <label for="password">Password</label>
                                          <input id="password" type="password" class="form-control" name="password" required data-eye>
                                       </div>
                                       <div class="form-group">
                                          <label for="dob">Date of Birth</label>
                                          <input id="dob" type="date" class="form-control" name="date" required data-eye>
                                       </div>
                                       <div class="form-group">
                                          <div class="row">
                                             <div class="col"><label>Gender</label></div>
                                             <div class="col"><input type="radio" name="Gender" value="Male">Male</div>
                                             <div class="col"><input type="radio" name="Gender" value="Female">Female</div>
                                             <div class="col"><input type="radio" name="Gender" value="Other">Other</div>
                                          </div>
                                       </div>
                                       <div class="form-group m-0">
                                          <button type="submit" class="btn btn-primary btn-block" name="signup"
                                             >Sign Up </button>
                                       </div>
                                    </form>
                                 </div>
                                 <div class="modal-footer">
                                    <button type="button" class="btn btn-danger btn-block" data-dismiss="modal" center>Close</button>
                                 </div>
                              </div>
                           </div>
                        </div>
                        
                        <!--Pop up form for user to reset their password-->
                        <div class="modal" id="forgotpass_modal">
                           <div class="modal-dialog" style="text-align: center">
                              <div class="modal-content" style="width:75%">
                                 <div class="modal-header">
                                    <h4 class="modal-title">Forgot your password?</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                 </div>
                                 <div class="modal-body">
                                    <div class="form-group m-0">
                                       <form  method = "POST" action = "" name="rec_password">
                                          <div class="form-group">
                                             <label for="email">Enter e-mail address for password renewal</label>
                                             <input id="emailrecover" type="email" class="form-control" name="emailrecover" value="" required autofocus>
                                          </div>
                                          <div class="form-group">
                                          <button type="submit" name="send" id = "send" class="btn btn-danger btn-block" data-toggle="modal"  data-target="#recovery_pass_modal"
                                             data-dismiss="modal">Send request</button>
                                          </div>
                                       
                                       </form>
                                       <?php
                                       if(isset($_POST['emailrecover'])) {
   
                                          send_code();
                                       } ?>
                                    </div>
                                 </div>
                                 <div class="modal-footer">
                                    <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Close</button>
                                 </div>
                              </div>
                           </div>
                        </div>
                        
                        <!--Pop up form for user to enter recovery code obtained from email-->
                        <div class="modal" id="recovery_pass_modal">
                           <div class="modal-dialog" style=" text-align: center">
                              <div class="modal-content" style="width:75%">
                                 <div class="modal-header">
                                    <h4 class="modal-title">Enter Recovery Code</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                 </div>
                                 <div class="modal-body">
                                    <div class="form-group m-0">
                                       <form method="POST">
                                          <div class="form-group">
                                             <label for="r-code">Please enter the recovery code you have received</label>
                                             <input id="rec_code" type="text" class="form-control" name="rec_code" value="" required autofocus>
                                          </div>
                                          <button type="submit" name="rec_code2" class="btn btn-danger btn-block" data-toggle="modal"  data-target="#new_pass_modal"
                                             data-dismiss="modal">Send request</button>
                                       </form>
                                    </div>
                                 </div>
                                 <div class="modal-footer">
                                    <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Close</button>
                                 </div>
                              </div>
                           </div>
                        </div>
                        
                        <!--Pop up form to create new password-->
                        <div class="modal" id="new_pass_modal">
                           <div class="modal-dialog" style=" text-align: center">
                              <div class="modal-content" style="width:75%">
                                 <div class="modal-header">
                                    <h4 class="modal-title">Enter New Password</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                 </div>
                                 <div class="modal-body">
                                    <div class="form-group m-0">
                                       <form method="POST">
                                          <div class="form-group">
                                             <label for="new_pass">Enter new password</label>
                                             <input id="new_pass" type="password" class="form-control" name="new_pass" value="" required autofocus>
                                          </div>
                                          <div class="form-group">
                                             <label for="verify_pass">Confirm new password</label>
                                             <input id="verify_pass" type="password" class="form-control" name="verify_pass" value="" required autofocus>
                                          </div>
                                          <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                       </form>
                                    </div>
                                 </div>
                                 <div class="modal-footer">
                                    <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Close</button>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="footer" style="text-align:center;"> &copy; High-Five </div>
               </div>
            </div>
         </div>
      </section>
      <!-- Bootstrap core JavaScript
         ================================================== -->
      <!-- Placed at the end of the document so the pages load faster -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>

   </body>
</html>


