<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="css/photo.css">
<?php
include("connect.php");
if(!empty($_SESSION['admin']))
{   $val=$_SESSION['admin'];
	$q1="select * from user_detail where user_id='$val';";
	$res1=mysqli_query($con,$q1)or exit("error in query1");
	$row=mysqli_fetch_row($res1);
}
else{
	header("location:index.php");
	exit();
}
if(!empty($_POST['prefer1']))
{
	$prefer=$_POST['prefer1'];
	$q_prefer="update user_detail set preference_status='$prefer' where user_id='$row[0]'";
		$result=mysqli_query($con,$q_prefer)or exit($q_prefer);
	echo "Successfully you change your prefernce";
}
if(!empty($_POST['basic']))
{
	$basic=$_POST['basic'];
	$q_prefer="update user_detail set basic_info_priv='$basic' where user_id='$row[0]'";
		$result=mysqli_query($con,$q_prefer)or exit($q_prefer);
	echo "Successfully you change your privacy settings";
}
if(!empty($_POST['timeline']))
{
	$timeline=$_POST['timeline'];
	$q_prefer="update user_detail set timeline_priv='$timeline' where user_id='$row[0]'";
		$result=mysqli_query($con,$q_prefer)or exit($q_prefer);
	echo "Successfully you change your timeline privacy settings";
}
if(!empty($_POST['current']))
{
	$current=$_POST['current'];
	$password=$_POST['id2'];
	if(empty($password)){exit;}
	$re_password=$_POST['id3'];
	if($password==$re_password){
	$q_password="update users set password='$password' where user_id=$row[0] and password='$current'";
	$q_result=mysqli_query($con,$q_password)or exit($q_password);
	$count=mysqli_affected_rows($q_result);
	if($count==1){
	echo "Successfully you change your password";}}
}
if(!empty($_POST['current1']))
{
	$current=$_POST['current1'];
	$username=$_POST['id2'];
	if(empty($username)){exit;}
	$re_username=$_POST['id3'];
	if($username==$re_username){
	$q_username="update users set username='$username' where user_id=$row[0] and password='$current'";
	$result=mysqli_query($con,$q_username)or exit($q_username);
	$count=mysqli_affected_rows($result);
	if($count==1){
	echo "Successfully you change your username";}}
}
if(!empty($_POST['description']))
{
	$title=$_POST['title'];
	$desc=$_POST['description'];
	$q_create="insert into groups() values('','$title','".str_replace("'","\'",$desc)."','$row[0]','cover_photo/default.jpg', now())";
	mysqli_query($con,$q_create)or exit($q_create);
	$q_view="select * from groups where created_id='$row[0]'and group_title='$title' and group_description='$desc'";
	$result=mysqli_query($con,$q_view)or exit($q_view);
	$res=mysqli_fetch_row($result);
	$q_member="insert into pages_member() values('','$res[0]','$row[0]','a',now())";
	mysqli_query($con,$q_member)or exit($q_member);
	echo "<h5 style='color: green'>Successfully you create your page</h5>";
	echo "<button id='view_page$res[0]' class='btn btn-primary'>View Your page</button></a>";
	
}
if(!empty($_POST['user_id']))
{
	$page_id=$_POST['view'];
	$user_id=$_POST['user_id'];
	$q_page="select* from pages_member where page_id='$page_id' and member_id='$user_id'";
	$result=mysqli_query($con,$q_page)or exit($q_page);
	$res=mysqli_fetch_row($result);
	$count=mysqli_num_rows($result);
	if($count==1){
		if($res[3]=='m')
		{	
        $q_member="delete from pages_member where page_id='$page_id' and member_id='$user_id'";
		mysqli_query($con,$q_member)or exit($q_member);}
	}
	else{	
	$q_member="insert into pages_member() values('','$page_id','$user_id','m',now())";
	mysqli_query($con,$q_member)or exit($q_member);}
}
if(!empty($_POST['view']))
{
	$page_id=$_POST['view'];
   $q_page="select* from groups where sno='$page_id'";
	$result=mysqli_query($con,$q_page)or exit($q_page);
	while($res=mysqli_fetch_row($result))
	{ $q_member="select* from pages_member where page_id='$res[0]'";
	 $res_member=mysqli_query($con,$q_member)or exit($q_member);
	 $r_member=mysqli_fetch_row($res_member);
     echo "<div>
	 <div id='cover'><img src='$res[4]'style='width:100%;height:300px;position:relative;'></div>
	 <div class='element'>
	 <form action='' method='POST' enctype='multipart/form-data'>
  <i id='cover_photo' class='fa fa-camera'>change cover photo</i>
  <input type='file' name='' id='input1' onchange='this.form.submit();></form>
</div>
<script>
$('i').click(function(){
    $('#input').click();
});
$(document).ready(function(){
$('#input1').click(function(e) {
e.preventDefault();
$.ajax({
type: 'POST',
url: 'buttons.php',
data: {photo:'6',link:('#input1').val()},
success: function(data)
{
$('#cover').html(data);
}
});});});
</script>
	 <button class='btn btn-success' style='float:right;margin-top:5px;'>";
	 if($r_member[3]=='a')
	 {
		 echo "admin";
	 }
	 else{
		 if($r_member[3]=='m')
	     {
		 echo "Member";
	    }
		else{echo "+Join";}
	 }
	 
	 echo "</button>
	 <h2 style='color:#0277bd'>".ucwords($res[1])."</h2>
	 <h4 style='word-break: break-all;'>".ucwords($res[2])."</h4>
	 <div class='box' style='background: white; padding:20px; padding-bottom:60px;'>
	               <form action='' method='POST' enctype='multipart/form-data'>
				     <div class='panel-group' id='accordion1'>
		   <div class='panel panel-default' style='border:none;'>
		   <a data-toggle='collapse' data-parent='#accordion1' href='#audio'><button class='btn btn-primary'>Add Photo</button></a>
		   <a data-toggle='collapse' data-parent='#accordion1' href='#video'><button class='btn btn-primary'>Add video</button></a>
		     <div id='audio' class='collapse'><input type='file' name='image'></div>
			 <div id='video' class='collapse' style='padding: 10px;'><h5>
			 <h6 style='color:red'>Only Youtube Embed Url Are Valid To Post</h6>
			 Video Url:-<input type='url' name='video' placeholder='URL' style='width:90%;border-radius:2px; height:25px;'></h5></div></div></div>
			       <div style='margin-top: 5px;'>
		           <textarea id='editor' name='check'> your friends timeline show's here........
			      </textarea>
				   </br>
				    <input type='submit' name='submit_post2' class='btn btn-info' value='post' style='float: right'></div>";
		 if(!empty($_POST['submit_post2']))
				{				
				       if(!empty($_POST['check']))
						{  $event= $_POST['check'];
						}
						else{
						$event="";}
				  if(!empty($_POST['video']))
						{  $video_url= $_POST['video'];
						}
						else{
						$video_url="";}
					   if(!empty($_FILES['image']['name']))
							{
							$img=$_FILES['image']['name'];	
							$size=$_FILES['image']['size'];
							$type=$_FILES['image']['type'];
							$error=$_FILES['image']['error'];
							$tmp_name=$_FILES['image']['tmp_name'];
							$location="upload/".rand(0,1000).$img;
							move_uploaded_file($tmp_name,$location);
							$image=imagecreatefromjpeg($location);
		                    imagejpeg($image,$location,20);
				     }else{$location="";}
				
					$w= "insert into pages_post values('','$page_id','$val','".str_replace("'","\'",$event)."','$location','$video_url',now())";
					  mysqli_query($con,$w) or exit($w);
				}
				  
			 echo "</div> </form>			
	 </div>";
	 
	}
}
if(!empty($res[0])){
echo "<script>
$(document).ready(function(){
$('#view_page$res[0]').click(function(e) {
e.preventDefault();
$.ajax({
type: 'POST',
url: 'changes.php',
data: {view:$res[0]},
success: function(data)
{
$('#page').html(data);
}
});
});	});
</script>";}	
?>
<script>
	initSample();
</script>