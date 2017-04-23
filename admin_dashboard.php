<!DOCTYPE html>
<html>
<head>
     <title>linkZone</title>
	 <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
		<link rel="stylesheet" type="text/css" href="css/sb-admin.css">
		 <script src="js/jquery-3.1.0.min.js"></script>
	<!--<link rel="stylesheet" type="text/css" href="css/home2.css">
	<link rel="stylesheet" type="text/css" href="css/sb-admin.css">
	<link rel="stylesheet" type="text/css" href="css/admin_homepage.css">
<script src="ckeditor/ckeditor.js"></script>
	<script src="ckeditor/samples/js/sample.js"></script>
	<link rel="stylesheet" href="ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">-->
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
</head>
<style>body{background-color:#eee;}</style>
<body>
<?php
 include("connect.php");
	  if(!empty($_SESSION["super"]))
      {      $val=$_SESSION['super'];
	          $q1="select * from user_detail where user_id='$val';";
	         $res1=mysqli_query($con,$q1)or exit("error in query");
	         $row=mysqli_fetch_row($res1);
      }
	  else
	  {
		  header("location:linkzone.php");
		  exit();
	  }
	 if(!empty($_GET['logout']))
       {
	    session_destroy();
	     header('location:linkzone.php');
	     exit();
       }
if(!empty($_GET['user']))
{
	$user_id=$_GET['user'];
	$q_block="update users set status='block' where user_id='$user_id'";
	mysqli_query($con,$q_block)or exit($q_block);
	header('location:admin_dashboard.php');
}	
?>
<div id='wrapper'>
<?php
include('admin_icon.php');
?>

</div>
</body>
</html>