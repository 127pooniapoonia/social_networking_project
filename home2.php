<!DOCTYPE html>
<html>
<head>
     <title>linkZone</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/home2.css">
	<link rel="stylesheet" type="text/css" href="css/post_focus.css">
	<link rel="stylesheet" type="text/css" href="css/profile.css">
    <script src="js/jquery-3.1.0.min.js"></script>
	<link href="css/pjInfiniteScroll.css" rel="stylesheet">
<!--<script src="js/jquery-1.7.min.js"></script>-->
<script src="js/jquery.pjInfiniteScroll.js"></script>
<script src="ckeditor/ckeditor.js"></script>
	<script src="ckeditor/samples/js/sample.js"></script>
	<link rel="stylesheet" href="ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
</head>
<script>
$(function () {
    $(".container_id").pjInfiniteScroll();
});
</script>
<style>
.fixedPos{
    position: fixed;
    bottom: 150px;
}

</style>
<body>
<?php
include("connect.php");
if(!empty($_SESSION['admin']))
{   $val=$_SESSION['admin'];
	$q1="select * from user_detail where user_id='$val';";
	$res1=mysqli_query($con,$q1)or exit("error in query1");
	$row=mysqli_fetch_row($res1);
	$q2="select *,DATE(post_date)-DATE(now()) from post_detail ORDER BY Sno desc;";
	$res2=mysqli_query($con,$q2)or exit("error in query2");
	$q3="select * from user_detail where user_id!='$val';";
	$res3=mysqli_query($con,$q3)or exit($q3);
	/*$q_activity="delete from activity_logs WHERE current_date_time<=DATE_SUB(NOW(), INTERVAL 1 DAY)";  
   mysqli_query($con,$q_activity)or exit($q_activity);*/
}
else{
	header("location:linkzone.php");
    exit();
}
if(!empty($_GET['logout1']))
{
	 session_destroy();
	 $q_update="update user_detail set online_status=now() where user_id='$row[0]'";
		   mysqli_query($con,$q_update)or exit($q_update);
	 header('location:linkzone.php');
	 exit();
 }
 if(!empty($_GET['profile']))
{
	 $_SESSION['admin'];
	 header('location:profile.php');
	 exit();
 }
 if(!empty($_GET['post']))
{
	 $_SESSION['admin'];
	 header('location:post.php');
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
	   header('location:home2.php');

}
if(!empty($_GET['accept_id'])){
	$accept=$_GET['accept_id'];
	$status_cmd=$_GET['status'];
	if($status_cmd=='a'){
    $status="update friend_request set request_status='a',accepting_time=now() where sender_id='$accept' and destination_id='$row[0]'";
    mysqli_query($con,$status)or exit($status);
	$q_activity="insert into activity_logs values('','$row[0]','$accept_id','accept_request',now())";
		mysqli_query($con,$q_activity)or exit($q_activity);
    $query="select * from friend_request where sender_id='$accept' and destination_id='$row[0]' and request_status='a'";
	$result_query=mysqli_query($con,$query)or exit($query);
	 $result=mysqli_fetch_row($result_query);
    $insert_query="insert into friends values('','$result[1]','$result[2]',now())";
	mysqli_query($con,$insert_query)or exit($insert_query);}
	else
	{
	$query="delete from friend_request where ((sender_id='$accept' and destination_id='$val') or(sender_id='$val' and destination_id='$accept')) and request_status='p'";
	mysqli_query($con,$query)or exit($query);	
	}
	header('location: home2.php');
}
 include("user_header.php");
?>
<?php

if(!empty($_POST['comment'])){
	$post_id=$_POST['post_id'];
	$comment=$_POST['comment'];
	$reply_id=$_POST['reply_id'];	
$query_insert="insert into comment values('','$post_id','".$val."','$comment','$reply_id',now())";
$result_q=mysqli_query($con,$query_insert)or exit($query_insert);
$last_id=mysqli_insert_id($con);
$q_detail="select * from post_detail where Sno='$post_id'";
		$r_detail=mysqli_query($con,$q_detail)or exit($q_detail);
		$post=mysqli_fetch_row($r_detail);
		if($post[1]!=$val){
   $q_noti="insert into notification values('','$post[1]','$val','$post_id','reply','$reply_id','n',now())";
		mysqli_query($con,$q_noti)or exit($q_noti);
		}
		$q_activity="insert into activity_logs values('','$val','$post_id','comment',now())";
		mysqli_query($con,$q_activity)or exit($q_activity);
$_SESSION['o']="open";
header("location:home2.php?#comment_$last_id");
exit();
}
if(!empty($_GET['post_n']))
{
	 $post_id=$_GET['post_n'];
	  $notif_id=$_GET['n'];
	$q_noti="update notification set status='r' where sno='$notif_id'";
		mysqli_query($con,$q_noti)or exit($q_noti);
		$_SESSION['o']="open";
 header("location:home2.php?#book_1$post_id");
exit();	
}
if(!empty($_GET['post_fvrts']))
{
	$post_id=$_GET['post_fvrts'];
	$q_select="select * from fvrts_post where post_id='$post_id' and user_id='$row[0]'";
	$result_f=mysqli_query($con,$q_select)or exit($q_select);
	$count=mysqli_num_rows($result_f);
	if($count==1)
	{
	  $q_fvrts="delete from fvrts_post where post_id=$post_id and user_id='$row[0]'";	
	}else{
	$q_fvrts="insert into fvrts_post values('','$post_id','$row[0]',now())";}
    mysqli_query($con,$q_fvrts)or exit($q_fvrts);
	$q_activity="insert into activity_logs values('','$val','$post_id','bookmark',now())";
   mysqli_query($con,$q_noti)or exit($q_noti);
header("location:home2.php?#book_1$post_id");
exit();
}
if(!empty($_GET['unlike_like']))
 {
	$unlike_like=$_GET['unlike_like'];
	$status=$_GET['status'];
   if($status=='u')	{
	$q6="select * from unlike_table where (post_id='$unlike_like' AND user_disliking_id='$row[0]')";
	$res6=mysqli_query($con,$q6)or exit($q6);
      $count= mysqli_num_rows($res6);
      if(!empty($count))
	  { 
          $delete="delete from unlike_table where (post_id='$unlike_like' AND user_disliking_id='$row[0]')";
	     mysqli_query($con,$delete)or exit($delete);
	  }
	  else
	  {
		$q5="insert into unlike_table values('','$row[0]','$unlike_like','1',now())";
        mysqli_query($con,$q5)or exit($q5);	
$q_activity="insert into activity_logs values('','$val','$unlike_like','unlike',now())";
		mysqli_query($con,$q_activity)or exit($q_activity);		
	  }
	  }
   else{
	   $q6="select * from like_table where (post_id='$unlike_like' AND user_liking_id='$row[0]')";
	$res6=mysqli_query($con,$q6)or exit($q6);
      $count= mysqli_num_rows($res6);
      if(!empty($count))
	  {
        $delete="delete from like_table where (post_id='$unlike_like' AND user_liking_id='$row[0]')";
	    mysqli_query($con,$delete)or exit($delete);
	  }
	  else
	  {
		$q5="insert into like_table values('','$row[0]','$unlike_like','1',now())";
        mysqli_query($con,$q5)or exit($q5);
		$q_detail="select * from post_detail where Sno='$unlike_like'";
		$r_detail=mysqli_query($con,$q_detail)or exit($q_detail);
		$post=mysqli_fetch_row($r_detail);
		$q_activity="insert into activity_logs values('','$val','$unlike_like','like',now())";
		mysqli_query($con,$q_activity)or exit($q_activity);
		if($post[1]!=$val){
		$q_noti="insert into notification values('','$post[1]','$val','$unlike_like','like','','n',now())";
		mysqli_query($con,$q_noti)or exit($q_noti);}
	  }
   }
header("location:home2.php?#book_1$unlike_like");
exit();
 }
?>
<div class="container-fluid" style='margin-top:-10px;'>
  <div class="row">
      <div class="col-md-2" style='padding:2px;'>	  
	 <?php
	 echo "<div class='col-md-12' style='background:#e4d6d6;border-radius:10px;'>";
	 include("icons.php");
	 echo "</div>
	 <div class='col-md-12' style='background:#e4d6d6;border-radius:10px;margin-top:4px;'>";
	 echo "<div class='box' style='background:#e4d6d6;border-radius:10px;'>
	 <h4>Online</h4>";
$select_friend="select* from friends where user_id1='$val' or user_id2='$val'";
$result_friend=mysqli_query($con,$select_friend)or exit($select_friend);
$count_friend=mysqli_num_rows($result_friend);
if($count_friend==0)
				{
					echo "no friend now";
				}
			   while($friends=mysqli_fetch_array($result_friend))
			   {  
		           if($friends[1]==$val)
				   {
					$query="select * from user_detail where user_id='$friends[2]'";
					$result=mysqli_query($con,$query)or exit($query);
					$res=mysqli_fetch_row($result);
				   }
				   else
				   {
					$query="select * from user_detail where user_id='$friends[1]'";
					$result=mysqli_query($con,$query)or exit($query);
				   $res=mysqli_fetch_row($result);}
					echo "<div style=' padding: 5px;'>";
					if($res[20]=='online'){
					echo "<i class='fa fa-circle' style='float:right;font-size:9px;color:green'></i>";}
						  echo "<a href='user.php?user=$res[0]' class='point'><img src=".$res[13]." style='width:30%; height: 40px;'></a>
                      <div style='float: right; width: 65%; height:40px'>						  
			         <h5><a href='message.php?user=$res[0]' class='point' style='word-break:break-all'>".ucwords($res[17])."</a></h5>
					 </div>
                    </div>";
				   
                   				   
			   }			
	 ?></div></div>
	 <div class='col-md-12' style='background:#e4d6d6;border-radius:10px;margin-top:5px;padding:7px;'>
	  <span style='word-break:break-all;'>Slow and Steady' Won't Win Your Company Growth, But This Method Will 10 Dumb Money Mistakes People Make in Their 30s 4 Common Financial Mistakes Every Small Business Owner Should Avoid To See If Your Idea Can Be a Success, Focus on N.E.R.C.M. 10 Accelerators Helping Startups Grow to the Next Level
	  Slow and Steady' Won't Win Your Company Growth, But This Method Will 10 Dumb Money Mistakes People Make in Their 30s 4 Common Financial Mistakes Every Small Business Owner Should Avoid To See If Your Idea Can Be a Success, Focus on N.E.R.C.M. 10 Accelerators Helping Startups Grow to the Next Level
	  Slow and Steady' Won't Win Your Company Growth, But This Method Will 10 Dumb Money Mistakes People Make in Their 30s 4 Common Financial Mistakes Every Small Business Owner Should Avoid To See If Your Idea Can Be a Success, Focus on N.E.R.C.M. 10 Accelerators Helping Startups Grow to the Next Level
	  Slow and Steady' Won't Win Your Company Growth, But This Method Will 10 Dumb Money Mistakes People Make in Their 30s 4 Common Financial Mistakes Every Small Business Owner Should Avoid To See If Your Idea Can Be a Success, Focus on N.E.R.C.M. 10 Accelerators Helping Startups Grow to the Next Level
	  Slow and Steady' Won't Win Your Company Growth, But This Method Will 10 Dumb Money Mistakes People Make in Their 30s 4 Common Financial Mistakes Every Small Business Owner Should Avoid To See If Your Idea Can Be a Success, Focus on N.E.R.C.M. 10 Accelerators Helping Startups Grow to the Next Level
	  </span>
	 </div>
	 </div>
	  <div class='col-md-7'style='padding:3px;'>
	  <div class='col-md-8' style="background:#e4d6d6;border-radius:10px;padding:2px;">
	    <div class="" style="padding:4px;">
		<h6 style='color:grey;float:right;'><i class='fa fa-edit' ></i>What's on mind</h6>
	     <form action="home2.php" method="POST" enctype="multipart/form-data">
		    <div class="panel-group" id="accordion">
		   <div class="panel panel-default" style='border:none;background:#e4d6d6;'>
		   <a data-toggle="collapse" data-parent="#accordion" href="#audio"><button class="btn btn-primary" style='background:#009688;'>Add Photo</button></a>
		   <a data-toggle="collapse" data-parent="#accordion" href="#video"><button class="btn btn-primary" style='background:#009688;'>Add video</button></a>
		     <div id='audio' class='collapse'><input type='file' name='image'></div>
			 <div id='video' class='collapse'><h6 style='color:red'>Only Youtube Embed Url Are Valid To Post</h6>
			 Video Url:-<input type='' class='form-control' name='video' placeholder='URL' style='width:90%;border-radius:2px; height:25px;'></div></div></div>
		     <div style="margin-top: 5px;clear:all">
		        <textarea id='editor' style="width:100%;clear:all;" name='check'>your timeline show's here........
			    </textarea>
				</div></br>
				<input type="submit" name="submit" class="btn btn-info" value="post" style="float: right;background:#009688;" ></input>
			    </br></form>
		</div></div><div class='col-md-4' style="background:#e4d6d6;border-radius:10px;padding:2px;">
		<div class='box' style='height:300px;background:#e4d6d6;'>
	    <h4>EVENTS</h4>
		<?php
	echo "<div id='today' style=''>";		
  $q_friend="select * from friends where user_id1='$val' or user_id2='$val'";
  $r_friend=mysqli_query($con,$q_friend)or exit($q_friend);
  echo "<div style='padding:5%;'>";
  while($result=mysqli_fetch_array($r_friend))
  {
	  if($result[1]==$val)
	  {
		$q_select_f="select *,CURDATE() from user_detail where user_id='$result[2]'";  
	  }
     else
	 {
      $q_select_f="select *,CURDATE() from user_detail where user_id='$result[1]'";}
      $r_select_f=mysqli_query($con,$q_select_f)or exit($q_select_f);
      $res_f=mysqli_fetch_row($r_select_f);
      $dob=$res_f[3];
      $current= $res_f[21];		  
     $user_dob=explode("-",$dob);
     $new_dob=explode("-",$current);
     $user_date=$user_dob[2];
     $user_month=$user_dob[1];
     $new_date=$new_dob[2];	 
     $new_month=$new_dob[1];
     if(($new_date==$user_date)&&($new_month==$user_month))
     {
	   echo "<h6 style='word-break:break-all;'>today's Birthday $res_f[17]</h6>";
	 }
     echo "<h6 style='word-break:break-all;'>bcjhdbdbjdsbjbdsjbfjdsbjf
	 kkcbfhdbhfbdhsbjds
	 fbdhsbfhdbfhbdhjfbdbfjdbfjdbhdb</h6>";	 
  }echo "</div></div>";?>
		</div>
		</div>
		<?php  
	          	
                if(!empty($_POST['submit']))
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
					  mysqli_query($con,$w);				
				}
              	while($row2=mysqli_fetch_array($res2))
				{  $q4="select * from user_detail where user_id='$row2[1]';";
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
       $total_comment=ceil($count_comment/4);
       $idactive=$total_comment;
$active=4;
if($idactive==0){$start=0;}else
$start=($idactive-1)*$active;	
$q_comment="select * from comment where post_id='$row2[0]' LIMIT $start,$active";
$result_c=mysqli_query($con,$q_comment)or exit($q_comment);
echo "<a name='book_1$row2[0]'><input type='hidden' value='$row2[0]'></a>";				   
echo "<div class='col-md-6 box' style='background:#e4d6d6;outline-right:1px solid black;'>
				  <div style='float: left; width:50px; height: 50px'>
				  <img src='$row4[13]' style='width:100%; height: 100%'>
				  </div>
				  <div style='float: left; margin-left:5px; width:80%;'><a href='user.php?user=$row4[0]' class='point' style='color:black;'><b>"
		          .ucwords($row4[17])."</b></a>";
				  if(!empty($row2[5])){
				  echo" posted on <a href='user.php?user=$r_timeline[0]' class='point' style='color:black;'><i>".ucwords($r_timeline[17])."</i></a>'s timeline";
				}
			  echo "<br><i style='float:right;color:#0277bd'>".date_format(date_create($row2[6]),'d-M-y h:ia')."</i><hr>
			  <i class='fa fa-delete'></i></div>
				  <div style='clear:left;'><h6 align='justify' style='word-break: break-all;'>";
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
				 

if (strlen($string) >120) {

    // truncate string
    $stringCut = substr($string, 0,120);

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
				 <a href='home2.php?unlike_like=$row2[0]&status=l'><i id='like$row2[0]'class='fa fa-thumbs-up fa-lg' aria-hidden='true' style='text-shadow:2px 2px 2px grey; color: #388e3c; '></i></a>&nbsp";
				  echo "<span id='like_count$row2[0]' class='point'>".$count_like."</span>";				  
				  echo "&nbsp<a href='home2.php?unlike_like=$row2[0]&status=u'><i id='unlike$row2[0]' class='fa fa-thumbs-down fa-lg' aria-hidden='true' style='text-shadow:2px 2px 2px grey; color: #e57373;'></i></a>&nbsp";
echo "<script>
$(document).ready(function(){
	$('#like$row2[0]').hover(function(){
	$('#like$row2[0]').toggleClass('fa-2x');	
	});
	$('#unlike$row2[0]').hover(function(){
	$('#unlike$row2[0]').toggleClass('fa-2x');	
	});
	$('#comment_p$row2[0]').hover(function(){
	$('#comment_p$row2[0]').toggleClass('fa-2x');	
	});
});
</script>";				  
				  echo "<span id='unlike_count$row2[0]' class='point'>".$count_unlike."</span>";
				  echo "&nbsp
                        <a data-toggle='collapse' data-parent='#comment$row2[0]' href='#collapseOne$row2[0]'><i id='comment_p$row2[0]' class='fa fa-comment fa-lg' aria-hidden='true' style='text-shadow:2px 2px 2px grey;'></i> Comments&nbsp".$count_comment."
                        </a>"; if($row2[1]==$val){
						echo "<a href='home2.php?post_delete=$row2[0]'><span TITLE='delete' class='fa fa-trash-o' style='float:right;color:#388e3c;'></span></a>";
						}
	$q_select="select * from fvrts_post where post_id='$row2[0]' and user_id='$row[0]'";
	$result_f=mysqli_query($con,$q_select)or exit($q_select);
	$count=mysqli_num_rows($result_f);
	if($count==1){					
	echo "<a href='home2.php?post_fvrts=$row2[0]' data-parent='#book$row2[0]'><span id='' TITLE='Add' class='fa fa-heart' style='float:right; color: #e57373;;margin-right:3px;'></span></a>";}
    else{echo "<a href='home2.php?post_fvrts=$row2[0]'><span id='' TITLE='Add' class='fa fa-heart' style='float:right; margin-right:3px;'></span></a>";
	}	
						echo "<div id='collapseOne$row2[0]' class='panel-collapse collapse "?><?php if(!empty($_SESSION['o']))
						{
							
							echo "in";
							
						}?> <?php echo "'>
                    <div class='panel-body'>
					<div>
					<div id='btn$row2[0]'>";
					if($idactive>1)
					echo "<h6 id='previous$row2[0]' class='point'><i class='fa fa-arrow-left'>previous</i></h6>";
echo "<script>
$('document').ready(function(){
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
});
});
</script>";				
						while($res=mysqli_fetch_array($result_c))
						{   $query_user="select * from user_detail where user_id=$res[2]";
                          $result_user=mysqli_query($con,$query_user)or exit($query_user);
	                        $user=mysqli_fetch_row($result_user);
							echo "<div style='clear:left;'>
							<div style='float: left; width:15%; height: 15%'>
							<a name='comment_$res[0]'><input type='hidden' value='$res[0]'></a>
				           <img src='$user[13]' style='width:100%; height: 100%'>
						  </div>
						  <div style='float: left; margin-left:5px; width:80%;'><div style='font-size:15px;'><a class='point' href='user.php?user=$user[0]'>"
						  .ucwords($user[17])."</a>";
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
						  <a data-toggle='collapse' data-parent='#reply$row2[0]$res[0]' href='#replypost$row2[0]$res[0]'><h6 class='point'><i class='fa fa-reply fa-rotate-180'></i>reply</h6></a>
						 <div id='replypost$row2[0]$res[0]' class='collapse'>
						  <div style='margin-top:7px;'>
						  
						  <img src='$row[13]' style='width:15%; height:40px; float: left'>
					<form name='form1' action='".$_SERVER['PHP_SELF']."' method='post' >
					<textarea name='comment' style='width: 70%; height: 40px; float: left;'></textarea>
					<span style='display:none'>
					<input type='text1' value='$row2[0]' name='post_id'>
					<input type='text2' value='$user[0]' name='reply_id'></span>
					<input  type='submit' class='btn btn-primary btn-sm'   value='Post'>
					</form></div>
						 </div>
						  </div>
						  </div>";}
						  else{echo"<h6 id='delete$row2[0]$res[0]' class='point'>delete</h6>";
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
					echo "<h6 id='next$row2[0]$idactive' class='point'>next<i class='fa fa-arrow-right'></i></h6>";}
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
					<form name='form1' action='".$_SERVER['PHP_SELF']."' method='post' >
					<textarea name='comment' style='width: 70%; height: 40px; float: left;'></textarea>
					<span style='display:none'>
					<input type='text1' value='$row2[0]' name='post_id'>
					<input type='text2' value='p' name='reply_id'></span>
					<input  type='submit' class='btn btn-primary btn-sm'   value='Post'>
					</form></div>
					</div>
					</div>
				 
				  </div>";
				  
				  

				  echo "</div>";
				 echo "</div>";
		        }		 
		?>
	 </div>
<script> 

/*$(document).ready(function(){
if ($(window).width()<200){*/
$(window).scroll(function() {   
var scroll = $(window).scrollTop();

if (scroll >= 300) {
    $("#info").addClass("fixedPos");
}
else{

    $("#info").removeClass("fixedPos");
}
});

</script>
	  <div class="col-md-3" style='background: #e4d6d6;border-radius:10px;'>
	  <?php
if(!empty($_GET['updates'])){	  
echo "<div id='information' class='box' style='background: #e4d6d6; margin-top: 5px;border-radius:10px;padding:4px;'>
<h4>NOTIFICATIONS</h4>";
$q_notific="select * from  notification where (user_id='$val' or reply_id='$val')and status='n' order by current_date_time desc";
$r_notific=mysqli_query($con,$q_notific) or exit($q_notific);
$count_notif=mysqli_num_rows($r_notific);
if($count_notif==0){
	echo "<h5 style='text-align:center;'>No New Notification</h5>";
}
else{
	while($new=mysqli_fetch_array($r_notific))
	{
	   $q_friend="select * from user_detail where user_id='$new[2]'";
        $r_friend=mysqli_query($con,$q_friend)or exit($q_friend);
        $re_friend=mysqli_fetch_row($r_friend);
       $q_post="select * from post_detail where Sno='$new[3]'";
        $r_post=mysqli_query($con,$q_post)or exit($q_post);
        $re_post=mysqli_fetch_row($r_post);		
	 echo "<div style='clear:left;padding:5px;'>
	 <div style='width:100%; margin-top:5px;'>
	 <img src='$re_friend[13]' style='width:50px; height:50px;float:left;'></img>&nbsp&nbsp";
	 if($new[4]=='reply')
	 {
		echo "<a href='home2.php?post_n=$new[3]&n=$new[0]' style='color:#0277bd;'><span style='word-break:break-all;'>$re_friend[17] reply your comment on post</span></a>"; 
	 }
	 if($new[4]=='like')
	 {
		echo "<a href='home2.php?post_n=$new[3]&n=$new[0]' style='color:#0277bd;'><span style='word-break:break-all;'> $re_friend[17] liked your post</span></a>";  
	 }
	 if($new[4]=='comment')
	 {
		echo "<a href='home2.php?post_n=$new[3]&n=$new[0]' style='color:#0277bd;'><span style='word-break:break-all;'> $re_friend[17] commented on your post</span></a>";  
	 }
	 echo "</div>
	 </div></hr>"; 
	}	
}
echo "
</div>";}?>	  
	    <div id= 'friends_request' class='box' style='background: #e4d6d6; margin-top: 5px;border-radius:10px;'>
		<h4>REQUEST</h4>
		<?php
             $request="select * from friend_request where (destination_id='$row[0]' AND request_status='p')";
	         $result=mysqli_query($con,$request)or exit($request);
             $count_request= mysqli_num_rows($result);
             if(!empty($count_request))
			 {  
			     while($row4=mysqli_fetch_array($result))
				{ 
			        $sender="select * from user_detail where user_id='$row4[1]'";
					$res_sender=mysqli_query($con,$sender) or exit($sender);
					$detail=mysqli_fetch_row($res_sender);
			      echo "<div style='margin: 5px;'>
						  <img src=".$detail[13]." style='width:20%; height: 50px;'>
                      <div style='float: right; width:77%; height:50px'>						  
			         <h4 class='point' style='margin-top:-5px;'><a href='user.php?user=$detail[0]' class='point' style='color:#009688;'>".ucwords($detail[17])."</a></h4>
				<a href='main2.php?accept_id=$detail[0]&status=a'><button class='btn btn-primary btn-xs' style='color:#009688;'>Accept</button></a>
					<a href='main2.php?accept_id=$detail[0]&status=c'><button class='btn btn-primary btn-xs' style='color:#009688;'>Reject</button></a>
					 </div>
                    </div>";				
				}
			 }
             else
			 { 
				echo "<h5 style='text-align:center;'>No pending request</h5>";
			 }
			 echo "</div>
			 <div id='people' class='box' style='background:#e4d6d6; margin-top: 5px;border-radius:10px;'>";
             echo "<h4>PEOPLE YOU MAY KNOW</h4>";
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
			      echo "<div style='padding: 5px;'>
						  <img src='$row3[13]' style='width:30%; height: 70px;'>
                      <div style='float: right; width:67%; height:50px'>						  
			         <h4 class='point' style='margin-top:-5px;'><a href='user.php?user=$row3[0]' class='point' style='color:#009688;'>".ucwords($row3[17])."</a></h4>
					 <a href='home2.php?friend_id=$row3[0]'><button class='btn btn-primary btn-xs' style='background:#009688;'>Add Friend</button></a>
					 </div>
                    </div>	";
				   }}
}
if(!empty($_SESSION['o']))
{
unset($_SESSION['o']);
}?></div>
<?php
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
				  ?>
   </div>
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