<html>
<head>
     <title>linkZone login</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/custom1.css">
	<script src="js/jquery-3.1.0.min.js"></script>
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
</head>
<body>
<?php
session_start();
$con=mysqli_connect("localhost","root","","linkzone")or exit("error in database");
    if(!empty($_SESSION['log']))
	{
	
	}
	else{
		header('location: facebook.php');
		exit();
	}
?>
    <div class="container-fluid">
	  <div class="header">
	     <div class="row">
				<div class="col-md-2">
				</div>
				<div class="col-md-2">
	            <h1 class="logo1">linkZone</h1>
				</div>
				<div class="col-md-2">
				</div>
				<div class="col-md-2">
				</div>
				<div class="col-md-2">
				</div>
				<div class="col-md-2">
			     <a href="facebook.php" class="btn btn-success sign">Sign Up</a>
		       </div>
		</div>
	  </div>
	  <div class="section">
	         <div class="row">
			  <div class="col-md-4">
				</div>
				<div class="col-md-4">
				  <div class="box">
				    <h2 style="text-align: center; color: blue; font-family: verdana;">LOG IN<h2/>
					<?php
					  if(!empty($_POST["username"]))
						   {  
							  $adminusername=$_POST["username"]; 
							  $adminpassword=$_POST["password"];
							  $q="select * from users where username='$adminusername' and password='$adminpassword';";
							  $res=mysqli_query($con,$q);
							  $count= mysqli_num_rows($res);
							  if($count==1)
							  {
								 $row=mysqli_fetch_row($res);
								 $_SESSION['admin']=$row[0];
								 if($row[1]=='admin')
								 {
									 header("location:admin.php");
									 exit();
								 }
								 else{
								  header("location:home2.php");
								  exit(); 
								 }
							  }
							  else
								echo "invalid username and password";		  
						   }
					?>
				    <form action="" method="post" enctype="">
					  <h4>Username</h4>
					  <input type="username" name="username" style="width: 100%;"></input><br/>
					  <h4>Passward</h4>
					  <input type="password" name="password" style="width:100%;"></input>
					  <h5><input type="checkbox">Keep me logged in</input><br/></h5>
					  <h5><a href="#" style="float: right">Forgotten Password?</a><h5><br/><br/>
					  <button class="btn btn-primary btn-lg" style="width: 100px; text-align: center; margin-left: 40%" type="submit">Log in</button>
					</form>
				  </div>
				</div>
			  </div>
	  </div>
	<?php
	  include("footer.php");
     ?>	
	</div>
</body>
</html>
