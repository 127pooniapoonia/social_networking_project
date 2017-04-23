<html>
<head>
     <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<script src="js/jquery-3.1.0.min.js"></script>
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="css/logo.css">
</head>
<body>
<?php
session_start();
$con=mysqli_connect("localhost","root","","linkzone")or exit("error in database");
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
<div class="container-fluid">
     <div class= "header">
	      <div class="row">
		  <div class="col-md-2">
		  </div>
		     <div class="col-md-2">
	         <h1 class="logo1">linkZone</h1>
		      </div>
			  <div class="col-md-2">
		       </div>
			   <form action="" method="post" enctype="">
			   <div class="col-md-2" style="margin-top: 0px ;"> 
			    <h4 class="logo1">Username</h4>
				<input type="username" name="username" style="border-radius:5px"></input>
				<h5 style="color: white"> <input type="checkbox">keep me as login</input></h5>
				</div>
			   <div class="col-md-2" style="margin-top:0px;">
			     <h4 class="logo1">Password</h4>
				<input type="Password" name="password" style="border-radius:5px"></input>
				<!--<input type="submit" class="btn btn-info" value="submit">-->
				 <h5><a href="#" style="color: white">Forgotten account?</a></h5>
		       </div>
               <div  class="col-md-1" style="margin-top: 33px">
				<input type="submit" class="btn btn-info" value="submit" name="submit">
                </div>
                 </form>				
	</div>
	 </div>
	 </div>
	 </body>
	 </html>