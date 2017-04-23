<!DOCTYPE html>
<html>
<head>
     <title>linkZone</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/home2.css">
	<link rel="stylesheet" type="text/css" href="css/post_focus.css">
	<link rel="stylesheet" type="text/css" href="css/profile.css">
	<link rel="stylesheet" type="text/css" href="css/photo.css">
    <script src="js/jquery-3.1.0.min.js"></script>
<script src="ckeditor/ckeditor.js"></script>
	<script src="ckeditor/samples/js/sample.js"></script>
	<link rel="stylesheet" href="ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
</head>
<body>
<?php
include("connect.php");
if(!empty($_SESSION['admin']))
{   $val=$_SESSION['admin'];
	$q1="select * from user_detail where user_id='$val';";
	$res1=mysqli_query($con,$q1)or exit("error in query1");
$row=mysqli_fetch_row($res1);}
else
{ header("location:linkzone.php");
exit();}
include("user_header.php");	
?>
<div class="container-fluid" style='margin-top:-12px;'>
  <div class="row">
      <div class="col-md-2" style="background:#e4d6d6;border-radius:10px; padding:2px;">
	 <?php
	 include("icons.php");
	 ?>
	  </div>
	  <div class='col-md-6' style="padding:2px;">
	  
<?php
if(!empty($_GET['page_id']))
 {
	$page_id=$_GET['page_id'];
   $q_page="select* from groups where sno='$page_id'";
	$result=mysqli_query($con,$q_page)or exit($q_page);
	$res=mysqli_fetch_row($result);
	$q_member="select* from pages_member where page_id='$res[0]'";
	 $res_member=mysqli_query($con,$q_member)or exit($q_member);
	 $r_member=mysqli_fetch_row($res_member);
     echo "<div id='cover'>
	 <img src='$res[4]'style='width:100%;height:300px;position:relative;'>
	 <form action='submit()' method='POST' enctype='multipart/form-data'>
	 <i class='fa fa-camera'>change cover photo</i>
  <input type='file' name='cover' id='input1'></form>
  <script>
$('i').click(function () {
  $('#input1').trigger('click');
});
$(document).ready(function(){
$('#ee').click(function(e){
e.preventDefault();
$.ajax({
type: 'POST',
url: 'buttons.php',
data: {cover:('#input1').val(),page_id_cover:$page_id},
success: function(data)
{
$('#cover').html(data);
}
});	
});
</script>";
echo"<button class='btn btn-success' style='float:right;margin-top:5px;background:#009688''>";
	 if(($r_member[3]=='a')&&($r_member[2]==$row[0]))
	 {
		 echo "admin";
	 }
	 else{
		 if(($r_member[3]=='m')&&($r_member[2]==$row[0]))
	     {
		 echo "Member";
	    }
		else{echo "+Join";}
	 }
	 
	 echo "</button>
	 </div>";
echo "<h2 style='color:#009688'>".ucwords($res[1])."</h2>
	 <h4 style='word-break: break-all;'>".ucwords($res[2])."</h4>";
	 if((($r_member[3]=='m')||($r_member[3]=='a'))&&($r_member[2]==$row[0])){
	 echo"<div class='box' style='background: white; padding:20px; padding-bottom:60px;'>
	               <form action='' method='POST' enctype='multipart/form-data'>
				     <div class='panel-group' id='accordion1'>
		   <div class='panel panel-default' style='border:none;'>
		   <a data-toggle='collapse' data-parent='#accordion1' href='#audio'><button class='btn btn-primary' style='background:#009688'>Add Photo</button></a>
		   <a data-toggle='collapse' data-parent='#accordion1' href='#video'><button class='btn btn-primary' style='background:#009688'>Add video</button></a>
		     <div id='audio' class='collapse'><input type='file' name='image'></div>
			 <div id='video' class='collapse' style='padding: 10px;'><h5>
			 <h6 style='color:red'>Only Youtube Embed Url Are Valid To Post</h6>
			 Video Url:-<input type='url' name='video' placeholder='URL' style='width:90%;border-radius:2px; height:25px;'></h5></div></div></div>
			       <div style='margin-top: 5px;'>
		           <textarea id='editor' name='check'> your friends timeline show's here........
			      </textarea>
				   </br>
				    <input type='submit' name='submit_post2' class='btn btn-info' value='post' style='float: right;background:#009688''></div>";
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
				  
	 echo "</div> </form>";}
$q_select="select * from pages_post where page_id='$page_id' ORDER BY sno desc";
$res2=mysqli_query($con,$q_select)or exit($q_select);
while($row2=mysqli_fetch_array($res2))
  {
$q4="select * from user_detail where user_id='$row2[2]';";
	              $res4=mysqli_query($con,$q4)or exit("error in query1");
	               $row4=mysqli_fetch_row($res4);
                    $like="select * from like_page_post where post_id='$row2[0]'";
	                $res_like=mysqli_query($con,$like)or exit($like);
                     $count_like= mysqli_num_rows($res_like);
                    $unlike="select * from unlike_page_post where post_id='$row2[0]'";
	                $res_unlike=mysqli_query($con,$unlike)or exit($unlike);
                     $count_unlike= mysqli_num_rows($res_unlike);
                   $query_comment="select * from comment_page_post where post_id='$row2[0]'";
						$result=mysqli_query($con,$query_comment)or exit($query_comment);
						$count_comment=mysqli_num_rows($result);
$total_comment=ceil($count_comment/4);
       $idactive=$total_comment;
$active=4;
if($idactive==0){$start=0;}else
$start=($idactive-1)*$active;	
$q_comment="select * from comment_page_post where post_id='$row2[0]' LIMIT $start,$active";
$result_c=mysqli_query($con,$q_comment)or exit($q_comment);				   
echo "<div class='col-md-6'style='float:all'>
<div class='box' style='margin-top: 5px;padding:10px;background:#e4d6d6;'>
				  <div style='float: left; width:12%; height: 12%''>
				  <img src='$row4[13]' style='width:100%; height: 100%'>
				  </div>
				  <div style='float: left; margin-left:5px;'>"
		          .ucwords($row4[17]);
				  echo "<br>".date_format(date_create($row2[6]),'d-M-y h:ia')."<hr></div>
				  <div style='clear:left;'><h6 align='justify' style='word-break: break-all;'>";
				  $string = strip_tags($row2[3]);
echo "<script>
$(document).ready(function(){
$('#read$row2[0]').click(function(e){
e.preventDefault();
$.ajax({
type: 'POST',
url: 'read_more.php',
data: {view:'$row2[3]',id:'$row2[0]'},
success: function(data)
{
$('#full$row2[0]').html(data);
}
});	
});	
});
</script>";				  
				 

if (strlen($string) >30) {

    // truncate string
    $stringCut = substr($string, 0,30);

    // make sure it ends in a word so assassinate doesn't become ass...
    $string = substr($stringCut, 0, strrpos($stringCut, ' '))."<a id='read$row2[0]' style='color:blue'>...read more</a>";	
}
echo "<div id='full$row2[0]'>$string</div>";
				  echo "</h6></div>";
 if(!empty($row2[4]))
				 { 
			         echo "<img src='$row2[4]' style='width:100%; height:200px'>";
					
				 } 
				 if(!empty($row2[5]))
				 { 
			       echo "<div>".$row2[5]."</div>";
					
				 }
				 echo "</br></br>
<div class='panel-group' id='comment$row2[0]' style='clear:left;'>
				 <i id='like$row2[0]' class='fa fa-thumbs-up' aria-hidden='true' style='text-shadow:2px 2px 2px grey; font-size:20px; color: #388e3c; '></i>&nbsp";
				  echo "<span id='like_count$row2[0]'>".$count_like."</span>";				  
				  echo "&nbsp<i id='unlike$row2[0]' class='fa fa-thumbs-down' aria-hidden='true' style='text-shadow:2px 2px 2px grey; font-size:20px; color: #e57373;'></i>&nbsp";
				  echo "<span id='unlike_count$row2[0]'>".$count_unlike."</span>";
echo "<script>
$(document).ready(function(){
$('#unlike$row2[0]').click(function(e){
e.preventDefault();
$.ajax({
type: 'POST',
url: 'buttons.php',
data: {unlike_like_page:'$row2[0]',status:'u',page_id:'$res[0]'},
success: function(data)
{
$('#unlike_count$row2[0]').html(data);
}
});	
});
$('#like$row2[0]').click(function(e){
e.preventDefault();
$.ajax({
type: 'POST',
url: 'buttons.php',
data: {unlike_like_page:'$row2[0]',status:'l',page_id:'$page_id'},
success: function(data)
{
$('#like_count$row2[0]').html(data);
}
});	
});	
});
</script>";					  
echo "&nbsp
<a data-toggle='collapse' data-parent='#comment$row2[0]' href='#collapseOne$row2[0]'><i class='fa fa-comment' aria-hidden='true' style='text-shadow:2px 2px 2px grey; font-size:20px;'></i>Comments&nbsp".$count_comment."
                        </a>
<div id='collapseOne$row2[0]' class='panel-collapse collapse'>
                    <div class='panel-body'>
					<div>
					<div id='btn$row2[0]'>";
					if($idactive>1)
					echo "<h6 id='previous$row2[0]' style='color:#009688'><i class='fa fa-arrow-left'>previous</i></h6>";
						while($res=mysqli_fetch_array($result_c))
						{   $query_user="select * from user_detail where user_id=$res[3]";
                          $result_user=mysqli_query($con,$query_user)or exit($query_user);
	                        $user=mysqli_fetch_row($result_user);
							echo "<div style='clear:left;'>
							<div style='float: left; width:15%; height: 15%'>
				           <img src='$user[13]' style='width:100%; height: 100%'>
						  </div>
						  <div style='float: left; margin-left:5px; width:80%;'><div style='color:#009688;font-size:15px;'>"
						  .ucwords($user[17]);
						  if($res[5]!='p'){
							$q_reply="select * from user_detail where user_id='$res[5]'";
							$res_q=mysqli_query($con,$q_reply)or exit($q_reply);
							$reply_user=mysqli_fetch_row($res_q);
						  echo "&nbsp<i class='fa fa-reply fa-rotate-180'></i>&nbsp".ucwords($reply_user[17]);
						}
						  echo"</div><div style='clear:left'><h5 align='justify' style='word-break: break-all;'>$res[4]</h5></div>";
						  if($res[3]!=$row[0]){
						  echo "<div class='panel-group' id='reply$row2[0]$res[0]'>
						  <div class='panel panel-default' style='border: none;background:#eee'>
						  <a data-toggle='collapse' data-parent='#reply$row2[0]$res[0]' href='#replypost$row2[0]$res[0]'><h6 style='color:#009688'><i class='fa fa-reply fa-rotate-180'></i>reply</h6></a>
						 <div id='replypost$row2[0]$res[0]' class='collapse'>
						  <div style='margin-top:7px;'>
						  <img src='$row[13]' style='width:15%; height:40px; float: left'>
					       <form name='form1'>
						   <textarea id='$row2[0]$res[0]' style='width: 70%; height: 40px; float: left;'></textarea>
					      <button class='btn btn-primary btn-sm' id='btnn$row2[0]$res[0]'>post</button></form></div>
						 </div>
						 <script>
						   $(document).ready(function() {
							$('#btnn$row2[0]$res[0]').click(function(e) {
								e.preventDefault();
								$.ajax({
									type: 'POST',
									url: 'comment_pages.php',
									data: {comment: $('#$row2[0]$res[0]').val(),page_id:$page_id,post_id:$row2[0],reply_id:$user[0],idactive: $idactive,t:$total_comment},
									success: function(data)
									{
										$('#btn$row2[0]').html(data);
									}
								});
							});
$('#previous$row2[0]').click(function(e) {
e.preventDefault();
								$.ajax({
									type: 'POST',
									url: 'comment_pages.php',
									data: {post_id:$row2[0],idactive: $idactive-1,t:$total_comment,page_id:$page_id},
									success: function(data)
									{
										$('#btn$row2[0]').html(data);
									}
								});
							});	});				   
						</script> 
						  </div>
						  </div>";}
						  else{echo"<h6 id='delete$row2[0]$res[0]' style='color:#009688'>delete</h6>";
						  echo "<script>$(document).ready(function() {
						   $('#delete$row2[0]$res[0]').click(function(e) {
							e.preventDefault();
$.ajax({
type: 'POST',
url: 'comment_pages.php',
data: {comment_id:$res[0],post_id:$row2[0],t:$total_comment,idactive: $idactive,page_id:$row2[1]},
success: function(data)
{
$('#btn$row2[0]').html(data);
}
});
							});
						
						   });</script>";
						  
						  }
						  echo"</div>";
						  echo"</div>";
						}
					if($idactive<($total_comment)){
					echo "<h6 id='next$row2[0]$idactive' style='color:#009688'>next<i class='fa fa-arrow-right'></i></h6>";}
echo"<script>
$(document).ready(function(){
$('#next$row2[0]$idactive').click(function(e) {
e.preventDefault();
$.ajax({
type: 'POST',
url: 'comment_pages.php',
data: {post_id:$row2[0],idactive: $idactive+1,t:$total_comment,page_id:$row2[1]},
success: function(data)
									{
										$('#btn$row2[0]').html(data);
									}
								});
							});
				});

</script>";					
				     echo "</div>
					<div style='margin-top:7px;clear:left;'><img src='$row[13]' style='width:15%; height:40px; float: left'>
					<form name='form1'><textarea id='$row2[0]' style='width: 70%; height: 40px; float: left;'></textarea>
					<button class='btn btn-primary btn-sm' id='btnn$row2[0]'>post</button></form></div>
					</div>
					</div>
				  <script>
					  $(document).ready(function() {
							$('#btnn$row2[0]').click(function(e) {
								e.preventDefault();
								$.ajax({
									type: 'POST',
									url: 'comment_pages.php',
							data: {comment: $('#$row2[0]').val(),idactive: $idactive,page_id:$row2[1],post_id:$row2[0],reply_id:'p',t:$total_comment},
									success: function(data)
									{
										$('#btn$row2[0]').html(data);
									}
								});
							});
						});

                 </script>
				  </div>    



	
	</div>				 
  </div></div>";				  
  }	
}
else
{
	      echo"<div class='box' style='margin-top:20%; background:#e4d6d6;'>
				  <div id='msg' style='word-break: break-all;'>
				     <h2 style='text-align:center;color:#009688'>Create A New Page</h2>
					 <h4>Page Title</h4>
					   <input type='text' id='title' class=' form-control inputtext'>
					   <h4>Page Description</h4>
					   <textarea id='editor1' class=' form-control inputtext' style='height:30%'></textarea>
					   <button id='create_page' class='btn btn-primary btn-sm' style='float:right;margin-top:5px;background:#009688;'>Create</button></div>
				  </div>";
}	
?>
	 </div>
	 <div class='col-md-4' style='padding:2px;'>
	 <div id='page_info'>
	 <div class="panel-group" id="accordion">
     <div class="panel panel-default" style='border:none;background:#e4d6d6;'>
	 <a data-toggle="collapse" data-parent="#accordion" href="#create"><button class ='btn btn-primary' style='background:#009688'>Create Page</button></a>
			<a data-toggle="collapse" data-parent="#accordion" href="#pagesliked"><button class='btn btn-primary' style='background:#009688'>Liked Page</button></a>
			<a data-toggle="collapse" data-parent="#accordion" href="#mypages"><button class='btn btn-primary' style='background:#009688'>My Pages</button></a>
			<div id="create" class="panel-collapse collapse" style='margin-top:10px;'>
                  <div class="jumbotron box" style='margin-top: 5px;background:#e4d6d6'>
				  <div id='msg' style='word-break: break-all;'>
				     <h2 style='text-align:center;color:#009688'>Create A New Page</h2>
					 <h4>Page Title</h4>
					   <input type='text' id='title' class='inputtext'>
					   <h4>Page Description</h4>
					   <textarea id='editor1' class='inputtext' style='height:30%'></textarea>
					   <button id='create_page' class='btn btn-primary btn-sm' style='float:right;margin-top:5px;background:#009688'>Create</button></div>
				  </div>
				  </div>
		<div id="mypages" class="panel-collapse collapse" style='margin-top:10px;'>
			 <?php
			 $q_admin="select * from groups where created_id='$val'";
			 $r_admin=mysqli_query($con,$q_admin)or exit($q_admin);
			 while($result=mysqli_fetch_array($r_admin))
			 {
			   echo "<div class='col-md-6' style='background:#e4d6d6;margin-top:2px;padding:2px;'>
			   <div class=''>
			   <img src='$result[4]' style='width:100%; height:150px'></img>
			   <h4>".ucwords($result[1])."</h4>
			   <a href='groups.php?page_id=$result[0]'><button class='btn btn-primary' style='width:100%;background:#009688'>View Page</button></a>
			   </div></div>";
			 }
		     ?>
			</div>
			 <div id='pagesliked' class='panel-collapse collapse in' style='margin-top:10px;'>
				<?php	
$q_group="select * from groups";
					  $result=mysqli_query($con,$q_group)or exit($q_group);
					  while($res=mysqli_fetch_array($result))
					  {
					$q_likedgroups="select * from pages_member where page_id='$res[0]' and member_id='$row[0]'";
					$result_liked=mysqli_query($con,$q_likedgroups)or exit($q_likedgroups);
	               $count_liked=mysqli_num_rows($result_liked);
	               if($count_liked==1){
					   echo"<div class='col-md-6' style='background:#e4d6d6;margin-top:3px;padding:2px;'>
					   <div class=''><img src='$res[4]' style='width:100%; height:150px'></img>
					   <h4>".ucwords($res[1])."</h4>
					   <div class='panel-group' id='suggest_description$res[0]'>
					   <div class='panel panel-default' style='border:none;background:#e4d6d6;'>
					   <a data-toggle='collapse' data-parent='#suggest_description$res[0]' href='#viewsuggest_description$res[0]'>About $res[1]</a>
					   <div id='viewsuggest_description$res[0]' class='collapse'>
					   <h6 style='word-break: break-all;'>$res[2]</h6></div></div></div>
					   <button id='page_member$res[0]' class='btn btn-primary' style='width:48%;background:#009688'>member</button>
				   <a href='groups.php?page_id=$res[0]'><button class='btn btn-primary' style='width:48%;background:#009688'>View Page</button></a></div>";
echo"<script>
$(document).ready(function(){
$('#page_member$res[0]').click(function(e) {
e.preventDefault();
$.ajax({
type: 'POST',
url: 'changes.php',
data: {view:$res[0],user_id:$row[0]},
success: function(data)
{
$('#page').html(data);
}
});
});	
});
				   </script></div>";					   
				   }   
					  }  
				   ?>
				   </div> 
			</div></div>
	 <?php
			  echo "<h3 style='margin-top:40px;clear:left;color:#009688'>Suggested Pages</h3>";
			 $q_group="select * from groups";
					  $result=mysqli_query($con,$q_group)or exit($q_group);
					  while($res=mysqli_fetch_array($result))
					  {
					$q_likedgroups="select * from pages_member where page_id='$res[0]' and member_id='$row[0]'";
					$result_liked=mysqli_query($con,$q_likedgroups)or exit($q_likedgroups);
	               $count_liked=mysqli_num_rows($result_liked);
	               if($count_liked!=1){
					   echo"<div class='col-md-6' style='background:#e4d6d6;margin-top:3px;padding:3px;'><img src='$res[4]' style='width:100%; height:150px'></img>
					   <h4>".ucwords($res[1])."</h4>
					   <div class='panel-group' id='accordian_description$res[0]'>
					   <div class='panel panel-default' style='border:none;background:#e4d6d6;'>
					   <a data-toggle='collapse' data-parent='#accordian_description$res[0]' href='#view_description$res[0]'>About $res[1]</a>
					   <div id='view_description$res[0]' class='collapse'>
					   <h6 style='word-break: break-all;'>$res[2]</h6></div></div></div>
					   <button id='page_member$res[0]' class='btn btn-primary' style='width:48%;background:#009688'><i class='fa fa-users'></i>+Join</button>
					  <a href='groups.php?page_id=$res[0]'><button class='btn btn-primary' style='width:48%;background:#009688'>View Page</button></a></div>";					  
					 
echo"<script>
$(document).ready(function(){
$('#page_member$res[0]').click(function(e) {
e.preventDefault();
$.ajax({
type: 'POST',
url: 'changes.php',
data: {view:$res[0],user_id:$row[0]},
success: function(data)
{
$('#page').html(data);
}
});
});	
});
				   </script>";			}			  
					}
				  ?>
	 </div></div>
</div>
</div>
<?php
echo "<script>
	initSample();
</script>
";
echo "<script> 
$(window).scroll(function() {   
var scroll = $(window).scrollTop();

if (scroll >= 300) {
    $('#page_info').addClass('fixedPos');
}
else{

    $('#page_info').removeClass('fixedPos');
}
});

</script>";
echo "<script>
$(document).ready(function() {
$('#create_page').click(function(e) {
e.preventDefault();
$.ajax({
type: 'POST',
url: 'changes.php',
data: {title: $('#title').val(),description: $('#editor1').val()},
success: function(data)
{
$('#msg').html(data);
}
});
});						
});
</script>";
include("footer.php");
?>
</body>
</html>