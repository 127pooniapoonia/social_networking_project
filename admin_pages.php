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
echo "<div class='row'>
<div id='page_detail' class='col-md-12' style='margin-top:5%;'>";
$q_page="select * from groups";
$res=mysqli_query($con,$q_page)or exit($q_page);
echo "<h4><a href='admin_dashboard.php'>Dashborad</a>/Pages</h4>";
while($r=mysqli_fetch_array($res))
{
 echo "<div class='col-md-2' style='margin-top:3px;'>
  <a id='page$r[0]'><img src='$r[4]' style='width:100%;
  height:100px;'>$r[1]</a>
 </div>";
 echo "<script>
                      $(document).ready(function(){					 
					 $('#page$r[0]').click(function(e) {	
                     e.preventDefault();
$.ajax({
type: 'POST',
url: 'admin_panel_detail.php',
data: {page_id:'$r[0]'},
success: function(data)
{
$('#page_detail').html(data);
}
});
					  }); });</script>"; 	
}
echo "</div>
</div>";
?>
</div>
</body>
</html>