<!DOCTYPE html>
<html>
<head>
     <title>Post</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/home2.css">
	<link rel="stylesheet" type="text/css" href="css/post_focus.css">
	<link rel="stylesheet" type="text/css" href="css/profile.css">
    <script src="js/jquery-3.1.0.min.js"></script>
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
	<script src="ckeditor/ckeditor.js"></script>
	<script src="ckeditor/samples/js/sample.js"></script>
	<link rel="stylesheet" href="ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
	 </head>
<body>
<?php
include("connect.php");
if(!empty($_SESSION['admin']))
{   $val=$_SESSION['admin'];
	$q1="select * from user_detail where user_id='$val';";
	$res1=mysqli_query($con,$q1)or exit($q1);
	$row=mysqli_fetch_row($res1);
	$q3="select * from post_detail where user_id='$val' ORDER BY Sno desc;";
	$res3=mysqli_query($con,$q3)or exit($q3);
	$q_liked="select * from like_table join post_detail ON like_table.post_id=post_detail.sno and like_table.user_liking_id='$val' ORDER BY like_table.current_date_time desc;";
	$res_liked=mysqli_query($con,$q_liked)or exit($q_liked);

}
else{
	header("location:linkzone.php");
    exit();
}
if(!empty($_GET['friend_id'])){
	$friend_id=$_GET['friend_id']; 
	$q6="select * from friend_request where (destination_id='$friend_id' AND sender_id=$row[0]) or(destination_id='$row[0]' AND sender_id='$friend_id') ";
	$res6=mysqli_query($con,$q6)or exit($q6);
      $count= mysqli_num_rows($res6);
      if(!empty($count))
	  { 
         
	  }
	  else
	  {
		$q5="insert into friend_request values('','$row[0]','$friend_id','p','',now())";
        mysqli_query($con,$q5)or exit($q5);
$q_activity="insert into activity_logs values('','$row[0]','$friend_id','request_send',now())";
		mysqli_query($con,$q_activity)or exit($q_activity); 		
	  }
	   header('location:post.php');

}
  include("user_header.php");
if(!empty($_POST['submit_post1']))
	{   
	  /*$descrip=mysqli_real_escape_string($con,$_POST['check']);*/
	  $des=$_POST['check'];
	  $query="insert into post_detail values('','$row[0]','','$des',now())";
	  mysqli_query($con,$query)or exit ($query);
						  
	}
?>
<div class="container-fluid" style='margin-top:-10px;'>
  <div class="row">
      <div class="col-md-2" style='background:#e4d6d6;border-radius:10px;padding:2px;'>
	   <?php
	 include("icons.php");
	 ?>
	  </div>
	  <div class="col-md-7" style='padding:2px;'>
	       <div class="panel-group" id="accordion">
		   <div class="panel panel-default" style='border:none;background:#e4d6d6'>
		    <a data-toggle="collapse" data-parent="#accordion" href="#addpost"><button class ='btn btn-primary' style='background:#009688'>Add Post</button></a>
			<a data-toggle="collapse" data-parent="#accordion" href="#viewpost"><button class='btn btn-primary' style='background:#009688'>View Post</button></a>
			<a data-toggle="collapse" data-parent="#accordion" href="#likedpost"><button class='btn btn-primary' style='background:#009688'>My favorites</button></a>
			  <div id="addpost" class="panel-collapse collapse">
			  <?php
			    echo "<div class='jumbotron box' style='background: #e4d6d6;'>
	               <form action='' method='POST' enctype='multipart/form-data'>
				     <div class='panel-group' id='accordion1'>
		   <div class='panel panel-default' style='border:none;background:#e4d6d6'>
		   <a data-toggle='collapse' data-parent='#accordion1' href='#audio'><button class='btn btn-primary' style='background:#009688'>Add Photo</button></a>
		   <a data-toggle='collapse' data-parent='#accordion1' href='#video'><button class='btn btn-primary' style='background:#009688'>Add video</button></a>
		     <div id='audio' class='collapse'><input type='file' name='image'></div>
			 <div id='video' class='collapse' style='padding: 10px;'><h5>
			 <h6 style='color:red'>Only Youtube Embed Url Are Valid To Post</h6>
			 Video Url:-<input type='url' name='video' placeholder='URL' style='width:90%;border-radius:2px; height:25px;'></h5></div></div></div>
			       <div style='margin-top: 5px;'>
		           <textarea id='editor' name='check' > your friends timeline show's here........
			      </textarea>
				   </div></br>
				    <input type='submit' name='submit_post1' class='btn btn-info' value='post' style='float: right;background:#009688''>";  
	          	
                if(!empty($_POST['submit_post1']))
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
				
					$w= "insert into post_detail values('','$row[0]','".str_replace("'","\'",$event)."','$location','$video_url','',now())";
					  mysqli_query($con,$w) or exit($w);
				}
				  
			   echo "</div> </form>";
			  ?>
			  </div>
			  <div id="viewpost" class="panel-collapse collapse in">
			  <?php
			  $count_post=mysqli_num_rows($res3);
			  if($count_post==0){
		       echo "<h3 style='color: red;'>Dear ".ucwords($row[17]).", currently you are posted nothing.keep smiling, keep posting</h3>";}
	            while($row2=mysqli_fetch_array($res3))
				{	
                    $like="select * from like_table where post_id='$row2[0]'";
	                $res_like=mysqli_query($con,$like)or exit($like);
                     $count_like= mysqli_num_rows($res_like);
                    $unlike="select * from unlike_table where post_id='$row2[0]'";
	                $res_unlike=mysqli_query($con,$unlike)or exit($unlike);
                     $count_unlike= mysqli_num_rows($res_unlike);
$query_comment="select * from comment where post_id='$row2[0]'";
						$result=mysqli_query($con,$query_comment)or exit($query_comment);
						$count_comment=mysqli_num_rows($result);
       $total_comment=ceil($count_comment/4);
       $idactive=$total_comment;
$active=4;
if($idactive==0){$start=0;}else
$start=($idactive-1)*$active;	
$q_comment="select * from comment where post_id='$row2[0]' LIMIT $start,$active";
$result_c=mysqli_query($con,$q_comment)or exit($q_comment);					 
	              echo "<div class='col-md-4' style='clear:all;padding:2px;'>
				  <div class='box' style='padding:2px;background:#e4d6d6;border-radius:5px;'>
				  <div><h6 align='justify' style='word-break: break-all;'>";
				  $string = strip_tags($row2[2]);
echo "<script>
$(document).ready(function(){
$('#read$row2[0]').click(function(e){
e.preventDefault();
$.ajax({
type: 'POST',
url: 'read_more.php',
data: {view:'$row2[2]',id:'$row2[0]'},
success: function(data)
{
$('#full$row2[0]').html(data);
}
});	
});	
});
</script>";				  
				 

if (strlen($string) >70) {

    // truncate string
    $stringCut = substr($string, 0,70);

    // make sure it ends in a word so assassinate doesn't become ass...
    $string = substr($stringCut, 0, strrpos($stringCut, ' '))."<a id='read$row2[0]' style='color:blue'>...read more</a>";	
}
echo "<div id='full$row2[0]'>$string</div>";
				  echo "</h6></div>";
				 if(!empty($row2[3]))
				 { 
			         echo "<img src='$row2[3]' style='width:100%; height:270px'>";
					
				 } 
				 if(!empty($row2[4]))
				 { 
			       echo "<div>".$row2[4]."</div>";
					
				 }
				 echo "</br></br>
				<div class='panel-group' id='comment$row2[0]' style='clear:left;'>
				 <a href='home2.php?like=$row2[0]'><i class='fa fa-thumbs-up' aria-hidden='true' style='text-shadow:2px 2px 2px grey; font-size:20px; color: #388e3c; '></i></a>&nbsp";
				  echo $count_like;				  
				  echo "&nbsp<a href='home2.php?unlike=$row2[0]'><i class='fa fa-thumbs-down' aria-hidden='true' style='text-shadow:2px 2px 2px grey; font-size:20px; color: #e57373;'></i></a>&nbsp";
				  echo $count_unlike;
				  echo "&nbsp
                        <a data-toggle='collapse' data-parent='#comment$row2[0]' href='#collapseOne$row2[0]'><i class='fa fa-comment' aria-hidden='true' style='text-shadow:2px 2px 2px grey; font-size:20px;'></i>Comments&nbsp".$count_comment."
                        </a>
                  <div id='collapseOne$row2[0]' class='panel-collapse collapse'>
                    <div class='panel-body'>
					<div>
					<div id='btn$row2[0]'>";
					if($idactive>1)
					echo "<h6 id='previous$row2[0]' style='color:#0277bd'><i class='fa fa-arrow-left'>previous</i></h6>";
						while($res=mysqli_fetch_array($result_c))
						{   $query_user="select * from user_detail where user_id=$res[2]";
                          $result_user=mysqli_query($con,$query_user)or exit($query_user);
	                        $user=mysqli_fetch_row($result_user);
							echo "<div style='clear:left;'>
							<div style='float: left; width:15%; height: 15%'>
				           <img src='$user[13]' style='width:100%; height: 100%'>
						  </div>
						  <div style='float: left; margin-left:5px; width:80%;'><div style='color:#0277bd;font-size:15px;'>"
						  .ucwords($user[17]);
						  if($res[4]!='p'){
							$q_reply="select * from user_detail where user_id='$res[4]'";
							$res_q=mysqli_query($con,$q_reply)or exit($q_reply);
							$reply_user=mysqli_fetch_row($res_q);
						  echo "&nbsp<i class='fa fa-reply fa-rotate-180'></i>&nbsp".ucwords($reply_user[17]);
						}
						  echo"</div><div style='clear:left'><h5 align='justify' style='word-break: break-all;'>$res[3]</h5></div>";
						  if($res[2]!=$row[0]){
						  echo "<div class='panel-group' id='reply$row2[0]$res[0]'>
						  <div class='panel panel-default' style='border: none;background:#eee'>
						  <a data-toggle='collapse' data-parent='#reply$row2[0]$res[0]' href='#replypost$row2[0]$res[0]'><h6 style='color:#0277bd'><i class='fa fa-reply fa-rotate-180'></i>reply</h6></a>
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
									url: 'comment.php',
									data: {comment: $('#$row2[0]$res[0]').val(),user_id:$row[0],post_id:$row2[0],reply_id:$user[0],idactive: $idactive,t:$total_comment},
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
									url: 'comment.php',
									data: {idactive: $idactive-1,post_id:$row2[0],t:$total_comment},
									success: function(data)
									{
										$('#btn$row2[0]').html(data);
									}
								});
							});	});				   
						</script> 
						  </div>
						  </div>";}
						  else{echo"<h6 id='delete$row2[0]$res[0]' style='color:#0277bd'>delete</h6>";
						  echo "<script>$(document).ready(function() {
						   $('#delete$row2[0]$res[0]').click(function(e) {
							e.preventDefault();
$.ajax({
type: 'POST',
url: 'comment.php',
data: {comment_id:$res[0],post_id:$row2[0],t:$total_comment,idactive: $idactive},
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
					echo "<h6 id='next$row2[0]$idactive' style='color:#0277bd'>next<i class='fa fa-arrow-right'></i></h6>";}
echo"<script>
$(document).ready(function(){
$('#next$row2[0]$idactive').click(function(e) {
e.preventDefault();
$.ajax({
type: 'POST',
url: 'comment.php',
data: {idactive: $idactive+1,post_id:$row2[0],t:$total_comment},
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
									url: 'comment.php',
									data: {comment: $('#$row2[0]').val(),idactive: $idactive,user_id:$row[0],post_id:$row2[0],reply_id:'p',t:$total_comment},
									success: function(data)
									{
										$('#btn$row2[0]').html(data);
									}
								});
							});
						});

                 </script>
				  </div></div></div></div>";
		        }?>

			  </div>
			  <div id="likedpost" class="panel-collapse collapse">
			  <?php
			  $bookmark="select * from fvrts_post where user_id='$val'";
			  $res=mysqli_query($con,$bookmark)or exit($bookmark);
			while($r=mysqli_fetch_array($res))
			 { $post="select * from post_detail where sno='$r[2]'";
 $res_post=mysqli_query($con,$post)or exit($post);
	               $row2=mysqli_fetch_row($res_post);		 
              $q4="select * from user_detail where user_id='$row2[1]';";
	              $res4=mysqli_query($con,$q4)or exit("error in query1");
	               $row4=mysqli_fetch_row($res4);
				   $q_timeline="select * from user_detail where user_id='$row2[5]';";
	              $res_timeline=mysqli_query($con,$q_timeline)or exit($q_timeline);
	               $r_timeline=mysqli_fetch_row($res_timeline);
                    $like="select * from like_table where post_id='$row2[0]'";
	                $res_like=mysqli_query($con,$like)or exit($like);
                     $count_like= mysqli_num_rows($res_like);
                    $unlike="select * from unlike_table where post_id='$row2[0]'";
	                $res_unlike=mysqli_query($con,$unlike)or exit($unlike);
                     $count_unlike= mysqli_num_rows($res_unlike);
                   $query_comment="select * from comment where post_id='$row2[0]'";
						$result=mysqli_query($con,$query_comment)or exit($query_comment);
						$count_comment=mysqli_num_rows($result);

			 }
               ?>			    
			  </div>
			 </div>
			  </div>
	 <div class='col-md-12' style='background:#e4d6d6;'>
	  <?php
	  echo"<div id='people' class='box' style='background:#e4d6d6; margin-top: 5px;border-radius:10px;'>";
             echo "<h4>PEOPLE YOU MAY KNOW</h4>";
			 $q3="select * from user_detail where user_id!='$val';";
	$res3=mysqli_query($con,$q3)or exit($q3);
		        while($row3=mysqli_fetch_array($res3))
				{ 
			       $q_friend="select * from friend_request where (sender_id='$val' and destination_id='$row3[0]') or(sender_id='$row3[0]' and destination_id='$val')";
				   $res_friend=mysqli_query($con,$q_friend) or exit($q_friend);
				   $count=mysqli_num_rows($res_friend);
				   if($count==0)
				   { 
			          $q_block="select * from block_table where (user_id='$val' and block_id='$row3[0]') or(user_id='$row3[0]' and block_id='$val')";
				   $res_block=mysqli_query($con,$q_block) or exit($q_block);
				   $count_b=mysqli_num_rows($res_block);
				   if($count_b==0){
			      echo "<div class='col-md-3' style='padding: 5px;'>
					<img src='$row3[13]' style='width:100%; height:130px;'>						  
			         <h4 class='point'><a href='user.php?user=$row3[0]' class='point' style='color:#009688;'>".ucwords($row3[17])."</a></h4>
					 <a href='post.php?friend_id=$row3[0]'><button class='btn btn-primary btn-xs' style='background:#009688;'>Add Friend</button></a>
                    </div>	";
				   }}				   
} echo "</div>";
	  ?>
	  </div>
	  </div>
	 <?php
	 echo "<div class='col-md-3' style='padding:2px;'>";
 echo " <div class='col-md-12' style='background: #e4d6d6; margin-top: 5px;border-radius:10px;'>";
			  echo "<h3 style='margin-top:40px;clear:left;color:#009688'>Suggested Pages</h3>";
			 $q_group="select * from groups";
					  $result=mysqli_query($con,$q_group)or exit($q_group);
					  while($res=mysqli_fetch_array($result))
					  {
					$q_likedgroups="select * from pages_member where page_id='$res[0]' and member_id='$row[0]'";
					$result_liked=mysqli_query($con,$q_likedgroups)or exit($q_likedgroups);
	               $count_liked=mysqli_num_rows($result_liked);
	               if($count_liked!=1){
					   echo"<div class='col-md-6' style='background:#e4d6d6;margin-top:3px;padding:3px;'><img src='$res[4]' style='width:100%; height:100px'></img>
					   <h4>".ucwords($res[1])."</h4>
					   <div class='panel-group' id='accordian_description$res[0]'>
					   <div class='panel panel-default' style='border:none;background:#e4d6d6;'>
					   <a data-toggle='collapse' data-parent='#accordian_description$res[0]' href='#view_description$res[0]'>About $res[1]</a>
					   <div id='view_description$res[0]' class='collapse'>
					   <h6 style='word-break: break-all;'>$res[2]</h6></div></div></div>
					   <button id='page_member$res[0]' class='btn btn-primary' style='width:100%;background:#009688'>View</button>
					  </div>";					  
					 
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
					echo "</div>";
				  ?></div>
	  
	  
	  
	  
	  
	  
</div>
</div>
<?php
include("footer.php");
?>
<script>
	initSample();
</script>
</body>
</html>