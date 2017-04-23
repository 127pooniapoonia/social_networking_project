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
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
</head>
<body>
<?php
include("connect.php");
 if(!empty($_SESSION['admin']))
{
	$val=$_SESSION['admin'];
	$q1="select * from user_detail where user_id='$val';";
	$res1=mysqli_query($con,$q1)or exit($q1);
	$row=mysqli_fetch_row($res1);
	$q_people="select * from user_detail where user_id!='$val';";
	$res3=mysqli_query($con,$q_people)or exit($q_people);
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
	   header('location:friends.php');

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
	header('location: friends.php');
}
  include("user_header.php");
?>
<div class="container-fluid" style='margin-top:-10px;'>
  <div class="row">
        <div class="col-md-2" style='padding:2px;'>
	 <?php
	 echo "<div class='col-md-12' style='background:#e4d6d6;border-radius:5px;margin-right:1px;'>";
	 include("icons.php");
	 ?></div>
	 <div class='col-md-12' style='background:#e4d6d6;border-radius:5px;margin-top:3px;'>
	  <?php
echo "<div class='box' style='background:#e4d6d6'>
<form action='' method='POST' enctype=''>
<h4> Quick Message</h4>
<label>Friend</label>
<select id='recepient' class='form-control' style='width:100%;'>
<option value=''>Select</option>";
$select_friend="select* from friends where user_id1='$val' or user_id2='$val'";
$result_friend=mysqli_query($con,$select_friend)or exit($select_friend);
while($friends=mysqli_fetch_array($result_friend))
{   if($friends[1]==$val)
    {
	$query="select * from user_detail where user_id='$friends[2]'";
	$result=mysqli_query($con,$query)or exit($query);
	$res=mysqli_fetch_row($result);}
     else
    {
	 $query="select * from user_detail where user_id='$friends[1]'";
	 $result=mysqli_query($con,$query)or exit($query);
	$res=mysqli_fetch_row($result);}
	echo"<option value='$res[0]'>".ucwords($res[17])."</option>";
}	
echo "</select>
<label>Message</label>
		 <textarea class='form-control' id='recepient_msg' style='width:100%;'>
		</textarea></br>
		<button type='submit' id='send_msg' class='btn btn-info' style=''>Send message</button>
<script>
$(document).ready(function() {
$('#send_msg').click(function(e) {
e.preventDefault();
$.ajax({
type: 'POST',
url: 'msg_user.php',
data: {msg: $('#recepient_msg').val(),friend_id:('#recepient').val()},
success: function(data)
{	
$('#chat1').html(data);
}
});
});});
</script>				   
</form>   
</div>";?>	  
	  </div>
	  </div>
	  <div class='col-md-3' style='padding:3px;'>
	  <?php
	  echo "<div class='col-md-12' style='background:#e4d6d6;border-radius:10px;'>";
			echo "<div class='about' style='background: #e4d6d6; margin-top: 10px;margin-bottom:10px;'>
		    <h3>Friends</h3>";
			   $select_friend="select* from friends where user_id1='$val' or user_id2='$val'";
			   $result_friend=mysqli_query($con,$select_friend)or exit($select_friend);
			    $count_friend=mysqli_num_rows($result_friend);
				$total_count_request=ceil(($count_friend)/4);
			 $idactive_friend=$total_count_request;
			 $active=4;
			 if($idactive_friend==0){$start=0;}else
			 $start=($idactive_friend-1)*$active;
			 $q_request="select * from friend_request where (sender_id='$row[0]' AND request_status='p')LIMIT $start,$active";
	         $result_q=mysqli_query($con,$q_request)or exit($q_request);
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
					echo "<div style='margin: 5px; padding: 5px;'>
						  <a href='user.php?user=$res[0]' class='point'><img src=".$res[13]." style='width:20%; height: 60px;'></a>
                    <div style='float: right; width: 76%; height:60px'>						  
			         <h4><a href='user.php?user=$res[0]' class='point'  style='color:#009688;'>".ucwords($res[17])."</a></h4>
					 <a  href='message.php?user=$res[0]'><button class='btn btn-primary btn-sm' style='background:#009688;'>Start Conversation</button></a>
					 </div>
                    </div>";
				   
                   				   
			   }
          if($idactive_friend>1)
			 {echo "<h5 id='previous' class='point'><i class='fa fa-arrow-left'>previous</i></h5>";}  			   
		  echo "</div></div>";
		  ?>
		  <div class='col-md-12' style='background:#e4d6d6;border-radius:10px;margin-top:3px;'>
		  	  <div id='friends_request' class='box' style='background: #e4d6d6;'>
		<h3>Pending sent Request</h3>
		<?php
		
             $request="select * from friend_request where (sender_id='$row[0]' AND request_status='p')";
	         $result=mysqli_query($con,$request)or exit($request);
             $count_request= mysqli_num_rows($result);
			 $total_count_request=ceil(($count_request)/4);
			 $idactive_pendingrequest=$total_count_request;
			 $active=4;
			 if($idactive_pendingrequest==0){$start=0;}else
			 $start=($idactive_pendingrequest-1)*$active;
			 $q_request="select * from friend_request where (sender_id='$row[0]' AND request_status='p')LIMIT $start,$active";
	         $result_q=mysqli_query($con,$q_request)or exit($q_request);
             if(!empty($count_request))
			 { 
			     while($row4=mysqli_fetch_array($result_q))
				{ 
			        $sender="select * from user_detail where user_id='$row4[2]'";
					$res_sender=mysqli_query($con,$sender) or exit($sender);
					$detail=mysqli_fetch_row($res_sender);
			      echo "<div style='margin: 5px; padding: 5px;'>
						  <a href='user.php?user=$detail[0]' class='point'><img src=".$detail[13]." style='width:20%;height: 60px;'></a>
                      <div style='float: right; width: 76%; height: 60px;'>						  
			         <h4><a href='user.php?user=$detail[0]' class='point'  style='color:#009688;'>".ucwords($detail[17])."</a></h4>
					 <a href='friends.php?accept_id=$detail[0]&status=c' style='color:white;'><button class='btn btn-primary btn-xs' style='background:#009688;'>Cancel Request</input></a>
					 </div>
                    </div>";					
				}
			 }
             else
			 {
				 echo "<h5 style='text-align:center'>No pending sent request</h5>";
			 }
			 if($idactive_pendingrequest>1)
			 {echo "<h6 id='previous'class='point'><i class='fa fa-arrow-left'>previous</i></h6>";}
			 echo "</div>";?>
	  </div></div>
	  <div class='col-md-3' style='padding:3px;'>
	  <div class='col-md-12' style='background:#e4d6d6;border-radius:10px; padding:2px;'>
	  <div id= 'friends_request1' class="box" style="background: #e4d6d6; margin-top: 10px;">
		<h3>Friend Request</h3>
		<?php
		
             $request="select * from friend_request where (destination_id='$row[0]' AND request_status='p')";
	         $result=mysqli_query($con,$request)or exit($request);
             $count_request= mysqli_num_rows($result);
			 $total_count_request=ceil(($count_request)/5);
			 $idactive_request=$total_count_request;
			 $active=5;
			 if($idactive_request==0){$start=0;}else
			 $start=($idactive_request*$active)-1;
			 $q_request="select * from friend_request where (destination_id='$row[0]' AND request_status='p')LIMIT $start,$active";
             if(!empty($count_request))
			 {
			     while($row4=mysqli_fetch_array($result))
				{ 
			        $sender="select * from user_detail where user_id='$row4[1]'";
					$res_sender=mysqli_query($con,$sender) or exit($sender);
					$detail=mysqli_fetch_row($res_sender);
			      echo "<div style='margin: 5px; padding: 5px;'>
						  <img src=".$detail[13]." style='width:20%; height: 60px;'>
                      <div style='float: right; width: 76%; height:60px'>						  
			         <h4 style='color:#009688;'><a href='user.php?user=$detail[0]'>".ucwords($detail[17])."</a></h4>
<a href='friends.php?accept_id=$detail[0]&status=a'><button class='btn btn-primary btn-xs' style='background:#009688;'>Accept</button></a>
<a href='friends.php?accept_id=$detail[0]&status=c'><button  class='btn btn-primary btn-xs' style='background:#009688;'>Cancel Request</button></a>
					 </div>
                    </div>";
				}
			 }
             else
			 {
				 echo "<h5 style='text-align:center'>No pending request</h5>";
			 }
			 if($idactive_request>1)
			 {echo "<h6 id='previous' style='color:#0277bd'><i class='fa fa-arrow-left'>previous</i></h6>";}
			 echo "</div></div>
			   <div class='col-md-12' style='background:#e4d6d6;border-radius:10px; padding:2px; margin-top:3px;'>
		  <div id='people' class='box' style='background: #e4d6d6; margin-top: 5px;'>";
         echo "<h3>People You May Know</h3>";			 
		     
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
						  <img src='$row3[13]' style='width:20%; height: 50px;'>
                      <div style='float: right; width:77%; height:50px'>						  
			         <h4 class='point' style='margin-top:-5px;'><a href='user.php?user=$row3[0]' class='point' style='color:#009688;'>".ucwords($row3[17])."</a></h4>
					 <a href='friends.php?friend_id=$row3[0]'><button id='send_request$row3[0]' class='btn btn-primary btn-xs' style='background:#009688;'>Add Friend</button></a>
					 </div>
                    </div>	";
				   }}
}
	   ?>
	   </div></div></div>
	   <?php
	      echo "<div class='col-md-4' style='padding:1px;'>
		  <div class='col-md-12' style='background:#e4d6d6;border-radius:10px;'>
		  <div id='people' class='box' style='background: #e4d6d6; margin-top: 1px;'>";
         echo "<h3>Suggested Pages</h3>";			 
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
	  <div>
  </div>
</div>
<?php
include("footer.php");
?>
</body>
</html>