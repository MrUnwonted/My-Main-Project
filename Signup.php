<?php
require("session.php");
require_once("asset/db.php");
if($_SERVER["REQUEST_METHOD"]=="POST")
{
	foreach($_POST as $key=>$value)
	{
	if(empty($_POST[$key]))
	{
		$error_message="All fields are required";
		break;
	}
	}
	
	$name=$_POST["name"];
	$phn=$_POST["mob"];
	$em=$_POST["email"];
	$pass=$_POST["pass"];
	$conf=$_POST["cpass"];
	
/*Name validation*/
if (!isset($error_message)) {
	if(!preg_match("/^[a-zA-Z ]*$/",$name)) {
$error_message="Invalid name";
	}
}
/*Email  validation */
if (!isset($error_message)) {
	if(!filter_var($em,FILTER_VALIDATE_EMAIL)) {
$error_message="Invalid Email Address";
	}
}	
/*phone number  validation and length validation*/
if (!isset($error_message)){
	if(!preg_match("/^[6-9][0-9]{9}$/",$phn)) {
	$error_message="invalid phone number";
}
}

/*email in db validation*/
$dbemail=mysqli_query($con,"SELECT `email` from `user` WHERE `email`='$em'");
if(mysqli_num_rows($dbemail) == 1)
{
	$error_message="This email is already in used";
}
/*phone number in db validation*/
$dbph=mysqli_query($con,"SELECT `phone` from `user` WHERE `phone`='$phn'");
if(mysqli_num_rows($dbph) == 1)
{
	$error_message="This mobile number is already in used";
}
/*Password Matching Validation*/
if($pass != $conf) {
	$error_message='password must be same<br>';
}
	if(!isset($error_message)) {
		$epass=password_hash($pass,PASSWORD_BCRYPT);
   $q1 = mysqli_query($con,"INSERT INTO `login`(`username`,`password`,`type`)VALUES('$em','$epass',1)");
   if($q1){
   $q2 = mysqli_query($con,"INSERT INTO `user`(`name`,`email`,`phone`)VALUES('$name','$em',$phn)"); 
   if($q2)
   {
	   unset($_POST);
	   $success_message="<strong>Success</strong>, You are successfully registred.<br> <a href=\"login.php\">Login Now</a>";
   }
   }
}	
}
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Bevq | Signup :: User</title>

  <!-- Template CSS -->
  <link rel="stylesheet" href="admin/assets/css/style-liberty.css">

  <!-- google fonts -->
  <link href="//fonts.googleapis.com/css?family=Nunito:300,400,600,700,800,900&display=swap" rel="stylesheet">
</head>

<body class="sidebar-menu-collapsed">
<script src='//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script><script src="//m.servedby-buysellads.com/monetization.js" type="text/javascript"></script>

<meta name="robots" content="noindex">
<body><link rel="stylesheet" href="/images/demobar_w3_4thDec2019.css">

  <section>
    <!-- content -->
    <div class="">
        <!-- Register form -->
        <section class="register-form py-md-5 py-3">
            <div class="card card_border p-md-4">
                <div class="card-body">
                    <!-- form -->
                    <form action="#" method="POST">
                        <div class="register__header text-center mb-lg-5 mb-4">
                            <h3 class="register__title mb-2">User Signup</h3>
                            <p>Create your account here, and continue </p>
                        </div>
						<?php if(!empty($success_message)) {?>
							<div class="alert alert-success">
								 <?php if (isset($success_message))echo $success_message;?>
								 <button type="button" class="close" onclick="$('.alert').addClass('hidden');">&times;</button>
								 </div>	
						<?php } ?>
						<?php if(!empty($error_message)) {?>
							<div class="alert alert-danger">
								 <button type="button" class="close" onclick="$('.alert').addClass('hidden');">&times;</button>
								 <?php if (isset($error_message))echo $error_message;?>
								 </div>	
						<?php } ?>
                        <div class="form-group">
                            <label for="exampleInputName" class="input__label">Name</label>
                            <input type="text" class="form-control login_text_field_bg input-style" name ="name" placeholder="" required>
                        </div>
						<div class="form-group">
                            <label for="exampleInputEmail1" class="input__label">Mobile</label>
                            <input type="text" class="form-control login_text_field_bg input-style" name="mob" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="input__label">Email address</label>
                            <input type="email" class="form-control login_text_field_bg input-style" name="email" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1" class="input__label">Password</label>
                            <input type="password" class="form-control login_text_field_bg input-style" name="pass" placeholder="" required>
                        </div>
						<div class="form-group">
                            <label for="exampleInputPassword1" class="input__label">Confirm Password</label>
                            <input type="password" class="form-control login_text_field_bg input-style" name="cpass" placeholder="" required>
                        </div>
                       
                        <div class="d-flex align-items-center flex-wrap justify-content-between">
                            <button type="submit" class="btn btn-primary btn-style mt-4">Create Account</button>
                            <p class="signup mt-4">Already have an account? <a href="login.php"
                                    class="signuplink">Login </a>
                            </p>
                        </div>
                    </form>
                    <!-- //form -->
                    <p class="backtohome mt-4"><a href="index.php" class="back">Back to Home </a></p>
                </div>
            </div>
        </section>

    </div>
    <!-- //content -->

</section>


</body>

</html>