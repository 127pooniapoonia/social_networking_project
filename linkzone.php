 <!DOCTYOE html>
 <html>
<head>
     <title>LinkZone</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
	<script src="js/jquery-3.1.0.min.js"></script>
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
</head>
<style>body{background-image:url('images/5.jpg');};</style>
<body>
<?php
session_start();
$con=mysqli_connect("localhost","root","","linkzone")or exit("error in database");
$error=$error1="";
if(!empty($_SESSION['super']))
   {
	header("location:admin_dashboard.php");
	exit();
	
   }
else if(!empty($_SESSION['admin']))
{
	header("location:home2.php");
	exit();
}
else if(!empty($_POST["username"]))
   {  
	  $adminusername=$_POST["username"]; 
	  $adminpassword=$_POST["password"];
      $q="select * from users where username='$adminusername' and password='$adminpassword'";
      $res=mysqli_query($con,$q);
      $count= mysqli_num_rows($res);
      if($count==1)
	  {
         $row=mysqli_fetch_row($res);
		 if($row[5]=='unblock')
		 {	 
			 if($row[1]=='admin')
			 {    $_SESSION['super']=$row[0];
				 header("location:admin_dashboard.php");
				 exit();
			 }
			 else{ $_SESSION['admin']=$row[0];
			   $q_update="update user_detail set online_status='online' where user_id='$row[0]'";
			   mysqli_query($con,$q_update)or exit($q_update);
			  header("location:home2.php");
			  exit(); 
			 }
		 }
         else{
			$error="Your Acccount Is Blocked<a onclick='openmsg()'>Click Here</a>"; 
		 }		 
	}
   
   else{
       $error="Invalid Username And Password";
   }		 
   }
?>
	 <?php
	 $fname=$lname=$username=$confirm_username=$password=$gender=$birth_day="";
       $fnameErr=$lnameErr=$usernameErr=$confirmErr=$passwordErr=$genderErr=$birthdayErr="";
 if(!empty($_POST['signup']))
	{ 
			   if(empty($_POST['fname']))
			   {   
				  $fnameErr='required filled';
			   }
			   else
			   { 
		         $fname=($_POST['fname']);
				 if (!preg_match("/^[a-zA-Z ]*$/",$fname)) {
                 $fnameErr = "Only letters and white space allowed";}
		       }
			    if(empty($_POST['lname']))
				  $lnameErr='required filled';
			   else
			   { 
		          $lname=($_POST['lname']);
				  if (!preg_match("/^[a-zA-Z ]*$/",$lname)) {
				  $lnameErr = "Only letters and white space allowed";} 
		       }
			   if(empty($_POST['emailAddr']))
				   $usernameErr='required filled';
			   else
			   { $username=($_POST['emailAddr']); 
		         if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$username)) {
                  $usernameErr = "You Entered An Invalid Email Format"; 
                   }
		       }
			   if(empty($_POST['reenter_mobileno']))
				  $confirmErr='required field';
			   else
			   { 
		        $confirm_username=($_POST['reenter_mobileno']);
		       }
			   if(empty($_POST["password"])){$passwordErr="required field";}
               else				   
			   {
                     $password =($_POST["password"]);
					if (strlen($_POST["password"]) <= '8') {
						$passwordErr = "Your Password Must Contain At Least 8 Characters!";
					}
					elseif(!preg_match("#[0-9]+#",$password)) {
						$passwordErr = "Your Password Must Contain At Least 1 Number!";
					}
					elseif(!preg_match("#[A-Z]+#",$password)) {
						$passwordErr = "Your Password Must Contain At Least 1 Capital Letter!";
					}
					elseif(!preg_match("#[a-z]+#",$password)) {
						$passwordErr = "Your Password Must Contain At Least 1 Lowercase Letter!";
					}
                }
			   if(empty($_POST['bday']))
				   $birthdayErr='required field';
			   else
			   { 
		         $birth_day=($_POST['bday']);
		       }
			   if(empty($_POST['gender']))
				   $genderErr="required field";
			   else
			   { 
		         $gender=($_POST['gender']);
		       }
			   $preference=$fname." ".$lname;
			   if($username==$confirm_username)
				   {
				    if(($fnameErr=="")&&($lnameErr=="")&&($usernameErr=="")&&($confirmErr=="")&&($birthdayErr=="")&&($genderErr=="")&&($passwordErr==""))
					{
					$check="select * from users where username='$username'";
                    $res_check=mysqli_query($con,$check)or exit($check);
                    $user=mysqli_num_rows($res_check);					
                   if($user!=1)	{					
				    $q1="insert into user_detail values('','$fname','$lname','$birth_day','$gender','','','','','','','','','profile_photo/profil-pic_dummy.png','',now(),'','$preference','','','');";
				   mysqli_query($con,$q1)or exit("error in query");
				   $q2="insert into users values('','user','$username','$password',now(),'unblock');";
				    mysqli_query($con,$q2)or exit($q2);
				   $error="Successfully!";}
				   else
				   {
					   $error1="Username is already existed";
					   echo "<script>
					   $(document).ready(function(){
						 openNav12();
					   });
					   </script>";
					   
				   }
					}
				   }
				else{
					$confirmErr="Username Does Not Match";
					 echo "<script>
					   $(document).ready(function(){
						 openNav12();
					   });
					   </script>";
				}
	}				
  
?>
<div class='container-fluid'>
<div class='row'>
 <div class='col-md-4'>
 </div>
 <div class='col-md-4'>
 <div style='background:#2e624c;border-radius:10px;border-shadow:0px 0px 10px solid grey;color:white;margin-top:40%;padding:10px;z-index:5;'>
 <h2 style='text-align:center;'>Log In</h2>
 <span class = "error"><?php echo $error;?></span></br>
 <form action="" method="post" enctype="">
			    <label style='color: white;
	font-family:geogian;
	font-size:large;'>Username</label>
				<input  class='form-control' type="username" name="username" style="border-radius:5px"></br>
			     <label style='color: white;
	font-family:geogian;
	font-size:large;'>Password</label>
				<input class='form-control' type="Password" name="password" style="border-radius:5px"></input></br>
				<span style="color: white"> <input type="checkbox">keep me as login</input></span>
				 <span><a onclick='openNav12()' style="color: white;float:right;">Forgotten account?</a></span></br>
				<input type="submit" class='btn btn-primary' value="Log In" name="submit" style='background:#009688;margin-left:45%;'></br>
				<h5 style='text-align:center'>Create a New Account?<a onclick='openNav12()' style='clear:all;cursor:pointer;'> SignUp</a><h5>
                 </form>
 </div></div>
 <div class='col-md-2'>
 </div>
</div></div>
<div id="myNav12" class="overlay" style='background:url(\"images/5.jpg\");'>
  <div class="overlay-content">
     <div class="container-fluid">
    <div class='row'>
	<div class='col-md-3'></div>
	<div class='col-md-6' style='background:#2e624c;border-radius:10px;border-shadow:0px 0px 10px solid grey;color:white;padding:10px;'>
    <form action="" method="post" enctype="">			 
			     <h2> SIGN UP </h2>
				 <h4>It's free and always will be.</h4>
				 <span class = "error" style='float:left;'><?php echo $error1;?></span>
				 <h4 style='text-align:left;'>Name</h4>
				   <input name="fname" placeholder="Firstname" style=" width: 49%;height:40px;padding-left:2px;color:black;">
				   <input name="lname" placeholder="Lastname" style=" width: 49%;height:40px;padding-left:2px;color:black;"><span class = "error"><?php echo $lnameErr;?></span>
				    <h4 style='text-align:left;'>Username</h4>
				   <input name="emailAddr" placeholder="Email address" size="" style=" width: 100%; height:40px" class='form-control'><span class = "error"><?php echo $usernameErr;?></span>
				    <h4 style='text-align:left;'>Confirm Username</h4>
				   <input name="reenter_mobileno" placeholder="Re-email address"size="" style=" width: 100%; height:40px" class='form-control'><span class = "error"><?php echo $confirmErr;?></span>
				    <h4 style='text-align:left;'>Password</h4>
				   <input type="password" name="password" placeholder="New password" size="" style=" width: 100%; height:40px" class='form-control'><span class = "error"><?php echo $passwordErr;?></span>
				   <h4 style='text-align:left;'>Birthday</h4>
				   <input type="date" name="bday" placeholder="Birthday" style="width: 100%; height: 40px;" class='form-control'><span class = "error"><?php echo $birthdayErr;?></span>
					<h4 style='text-align:left;'>Gender</br><span style='padding:10%'>
					<input type="radio" name="gender" value="male">Male</input>
					<input type="radio" name="gender" value="female">Female</input></span><span class = "error"> <?php echo $genderErr;?></h4>
					<h6 style='text-align:left; word-break:break-all;'>By clicking Sign Up, you agree to our Terms and that you have read our Data Policy, including our Cookie Use.</h6>
					<input class='btn bnt-primary' name="signup" type="submit" value="Sign up" style='background:#009688'><br/>
				<h5 style='text-align:center;'>Already Account?<span><a onclick='closeNav12()' style='clear:all;cursor:pointer;font-size:medium;display:inline'>LogIn</a></span></h5>
</form></div>
    </div>
  </div>
</div>
</div>
 <script>
function openNav12() {
    document.getElementById("myNav12").style.height = "100%";
}

function closeNav12() {
    document.getElementById("myNav12").style.height = "0%";
}
</script>
 
</body>
</html>
