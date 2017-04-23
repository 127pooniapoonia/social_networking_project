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
if(!empty($_GET['post_delete']))
{
	$post_id=$_GET['post_delete'];
	$q_delete="delete from post_detail where sno='$post_id'";
	mysqli_query($con,$q_delete)or exit($q_delete);
}	
	   
?>
<div id='wrapper'>
		<?php 
include('admin_icon.php');	
		echo"<div class='row' style='margin:3%;'>
		<div class='col-md-7'>
		<h4><a href='admin_dashboard.php'>dashborad</a>/Posts</h4>";
		echo "<div id='p'>here</div>";
		echo "<input id='num' type='text'>
<a id='delete_post'><button class='btn btn-default'>Delete</button></a>
<button id='edit_post' class='btn btn-default'>Edit</button>
<button id='detail_post' class='btn btn-default'>Details</button>";
		echo "<script>
 $(document).ready(function(){
$('#delete_post').click(function(e) {	
e.preventDefault();
$.ajax({
type: 'POST',
url: 'admin_operation.php',
data: {id:('#num').val()},
success: function(data)
{
$('#p').html(data);
}
});
 });		
});</script>";
		echo "<div id='post' class='table-responsive'>";
		$q2= "select * from post_detail";
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
echo"<h5>   <table class='table table-bordered table-hover table-striped'>";
					echo "<tr>
					<th>select</th>
					<th>Post_id</th>
					<th>User_id</th>
					<th>Post_Text</th>
					<th>Post_Content</th>
	                <th>Post_date</th>
					</tr>";
					$q_select= "select * from post_detail LIMIT $start,$active";
$res= mysqli_query($con,$q_select) or exit($q_select);
				  while($row2=mysqli_fetch_array($res))
				  {
					 echo "<tr>
					 <th align='center'><input type='checkbox' rel='textbox' name='$row2[0]'/></th>
					 <td><a id='post_id$row2[0]'>$row2[0]</a></td>
					 <td><a href='admin_user_detail.php?user=$row2[1]'>$row2[1]</td>
					 <td><span style='word-break:break-all;'>$row2[2]</span></td>";
					 echo "<td><a  style='word-break:break-all;' id='post_hover$row2[0]'>$row2[3]</a>";
					 if(!empty($row2[4]))
						 echo "</br><b>video_url</b>";
					 echo "</td>
					<td>".date_format(date_create($row2[6]),"d-m-y h:i a")."</td>
					 </tr></h5>";
					 echo "<script>
                      $(document).ready(function(){					 
					 $('#post_id$row2[0]').click(function(e) {	
                     e.preventDefault();
$.ajax({
type: 'POST',
url: 'admin_panel_detail.php',
data: {post_id:'$row2[0]'},
success: function(data)
{
$('#detail').html(data);
}
});
});
 $('#post_hover$row2[0]').mouseover(function() {	
 $('#').show();
});
$('#user_id$row2[0]').click(function(e) {	
e.preventDefault();
$.ajax({
type: 'POST',
url: 'admin_panel_detail.php',
data: {user_id:'$row2[1]'},
success: function(data)
{
$('#detail').html(data);
}
});

                     });
					 });
					 </script>";
				  }
echo "</table>";
if($idactive>1){				  
echo "<h5 id='previous$idactive' style='float:left'><i class='fa fa-arrow-left'>previous</i></h5>";}
if($idactive<$total_post)
echo "<h5 style='float:right' id='next$idactive'>next<i class='fa fa-arrow-right'></i></h5>";
		echo "</table></div></div>
		<div id='detail' class='col-md-5'></div>
	</div>";
		echo "<script>
 $(document).ready(function(){
$('#previous$idactive').click(function(e) {	
e.preventDefault();
$.ajax({
type: 'POST',
url: 'admin_panel.php',
data: {posts:'post',idactive:$idactive-1},
success: function(data)
{
$('#post').html(data);
}
});
 });
 $('#next$idactive').click(function(e) {	
e.preventDefault();
$.ajax({
type: 'POST',
url: 'admin_panel.php',
data: {posts:'post',idactive:$idactive+1},
success: function(data)
{
$('#post').html(data);
}
 });	 
 });});</script>";?>
 		</div>
		</body>
</html>