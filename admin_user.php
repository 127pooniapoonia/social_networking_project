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
?>
<div id='wrapper'>
<?php
include('admin_icon.php');
echo"<div class='row'>
		<div class='col-md-10' style='margin:5%;'>
		<h4><a href='admin_dashboard.php'>Dashborad</a>/Users</h4>
		<div id='post' class='table-responsive'>";
		$q2= "select * from users";
 $res2= mysqli_query($con,$q2) or exit($q2);
$count=mysqli_num_rows($res2);
$total_post=ceil($count/5);	
 if(!empty($_POST['idactive']))
{
$idactive=$_POST['idactive'];	
}
else{	
$idactive=$total_post;}
$active=5;
$start=($idactive-1)*$active;
echo "<input type='text' rel='textbox'>
<button class='btn btn-default'>delete</button>
<button class='btn btn-default'>Edit</button>
<button class='btn btn-default'>details</button>";
echo"<h5><table class='table table-bordered table-hover table-striped'>
					<tr>
					<th>Select</th>
					<th>User_id</th>
					<th>User_type</th>
					<th>Username</th>
					<th>Joining_date</th>
					</tr>";
				  $q2= "select * from users LIMIT $start,$active";
				  $res2= mysqli_query($con,$q2) or exit($q2);
				  while($row2=mysqli_fetch_array($res2))
				  {
					 echo "<tr>
					 <td align='center'><input type='checkbox' rel='textbox' name='$row2[0]'/></td>
					 <td><a href='admin_user_detail.php?user=$row2[0]'>$row2[0]</a></td>
					 <td>$row2[1]</td>
					 <td>$row2[2]</td>
					 <td>".date_format(date_create($row2[4]),'d-m-y')."</td>
					 </tr>";
echo"<script>
$(document).ready(function(){
$('#user_u$row2[0]').click(function(e) {	
e.preventDefault();
$.ajax({
type: 'POST',
url: 'admin_panel_detail.php',
data: {user_id:'$row2[0]'},
success: function(data)
{
$('#detail').html(data);
}
});

                     });
					 });
					 </script>";					 
	              } 
echo "</table></h5>";
if($idactive>1){				  
echo "<h5 id='previous_user$idactive' style='float:left'><i class='fa fa-arrow-left'>previous</i></h5>";}
if($idactive<$total_post){
echo "<h5 style='float:right' id='next_user$idactive'>next<i class='fa fa-arrow-right'></i></h5>";}				  
		echo "</div></div>
		<div id='detail' class='col-md-3'>
		</div>
		</div>";
		echo "<script>
	$(document).ready(function(){	
 $('#previous_user$idactive').click(function(e) {	
e.preventDefault();
$.ajax({
type: 'POST',
url: 'admin_panel.php',
data: {users:'user',idactive:$idactive-1},
success: function(data)
{
$('#post').html(data);
}
});
 });
 $('#next_user$idactive').click(function(e) {	
e.preventDefault();
$.ajax({
type: 'POST',
url: 'admin_panel.php',
data: {users:'user',idactive:$idactive+1},
success: function(data)
{
$('#post').html(data);
}
 });	 
 });
 });
 </script>";		
?>		
</div>
</body>
</html>