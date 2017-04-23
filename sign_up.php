<html>
<head>
     <title>linkZone</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
	<script src="js/jquery-3.1.0.min.js"></script>
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
</head>
<body>
<?php
include_once("connect.php");
    if(!empty($_POST['signup']))
	{  echo "done";
			   if(!empty($_POST['fname']))
			   {   
				   $fname=$_POST['fname'];
			   }
			   else
			   { 
		         header("location:facebook.php");
		         exit();
		       }
			    if(!empty($_POST['fname']))
				   $lname=$_POST['lname'];
			   else
			   { 
		         header("location:facebook.php");
		         exit();
		       }
			   if(!empty($_POST['fname']))
				   $username=$_POST['mobileno'];
			   else
			   { 
		         header("location:facebook.php");
		         exit();
		       }
			   if(!empty($_POST['fname']))
				   $confirm_username=$_POST['reenter_mobileno'];
			   else
			   { 
		         header("location:facebook.php");
		         exit();
		       }
			   if(!empty($_POST['fname']))
				   $password=$_POST['password'];
			   else
			   { 
		         header("location:facebook.php");
		         exit();
		       }
			   if(!empty($_POST['fname']))
				   $birth_day=$_POST['bday'];
			   else
			   { 
		         header("location:facebook.php");
		         exit();
		       }
			   if(!empty($_POST['fname']))
				   $gender=$_POST['gender'];
			   else
			   { 
		         header("location:facebook.php");
		         exit();
		       }
			   if($username==$confirm_username)
				   {
				   $q="insert into user_detail values('$fname','$lname','$username','$confirm_username','$password','$birth_day','$gender',now())";
				   mysqli_query($con,$q)or exit("erroe in database");
				   echo "done";
				   }
				else{
					echo "username does not match";
				}   
    }
?>
<div class="container-fluid">
	 <div class="section">
	    <div class="row">
		    <div class="col-md-6">
			   <img src="images/1.png" width=100% style="padding-top:15%; padding-left:10%"></img>
			</div>
			 <div class="col-md-1">
			 </div>
			 <form action="" method="post" enctype="">
			 <div class="col-md-4 content"> 
<form action="" method="post" enctype="">			 
			     <h1> SIGN UP </h1>
				 <h3>It's free and always will be.</h3>
				 <h4>Name</h4>
				   <input name="fname" placeholder="firstname" style=" width: 49%;height:40px"></input>
				   <input name="lname" placeholder="lastname" style=" width: 50%;height:40px"></input>
				    <h4>Username</h4>
				   <input name="mobileno" placeholder="mobile number or email address" size="" style=" width: 100%; height:40px"></input>
				    <h4>Confirm Username</h4>
				   <input name="reenter_mobileno" placeholder="re-enter mobile number or email address"size="" style=" width: 100%; height:40px"></input>
				    <h4>Password</h4>
				   <input type="password" name="password" placeholder="New password" size="" style=" width: 100%; height:40px"></input>
				   <h4>Birthday</h4>
				   <input type="date" name="bday" placeholder="birthday" style="width: 100%; height: 40px;"></input><br/>
					<h4>Gender</h4>
					<input type="radio" name="gender" value="male">Male</input>
					<input type="radio" name="gender" value="female">Female</input>
					<!--<a class="link" href="#">Why do i need to provide my dateof birth</a>-->
					<h6>By clicking Sign Up, you agree to our Terms and that you have read<br/> our Data Policy, including our Cookie Use.</h6>
					<input class="btn btn-success btn-lg" style="width: 150px; text-align: center;" name="signup" type="submit" value="Sign up"></input>
					<h5>Create a Page for a celebrity, band or business.</h5>
</form>
	 </div>
	 </div>
</div>
</body>
</html>