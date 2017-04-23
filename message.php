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
	$q_msg="select * from message where destination_id='$val' and status='s' group by sender_id";
$result_msg=mysqli_query($con,$q_msg)or exit($q_msg);
$count_msg=mysqli_num_rows($result_msg);
}
else{
	header("location:linkzone.php");
    exit();
}
if(!empty($_GET['theme']))
{  
   $theme=$_GET['theme'];
   echo $theme;
   $theme1=$theme;
	$id=$_GET['user'];
	$q_select="select * from theme_table where (user_id='$val' and friend_id='$id') or(user_id='$id' and friend_id='$val')";
	$theme=mysqli_query($con,$q_select)or exit($q_select);
	$count_theme=mysqli_num_rows($theme);
	if($count_theme==1)
	{
		$q_change="update theme_table set theme='\#$theme1' where (user_id='$val' and friend_id='$id') or(user_id='$id' and friend_id='$val')";
	}
	else{
		$q_change="insert into theme_table values('','$val','$id','\#$theme1',now())";
	}
	mysqli_query($con,$q_change)or exit($q_change);
	header("location:message.php?user=$id");
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
	   header('location:message.php');

}
include("user_header.php");
?>
<div class="container-fluid" style='margin-top:-10px;'>
  <div class="row">
      <div class="col-md-2" style="background:#e4d6d6;border-radius:10px; padding:1px;">
	 <?php
	 include("icons.php");
	 ?>
	  </div>
	  <div class='col-md-7' style='padding:1px;'>
	  <div class='col-md-12' style='background:#e4d6d6;border-radius:5px;'>
	  <?php
	if(!empty($_POST['search']))
    {
	$search=$_POST['search'];
	$query="select * from user_detail where first_name like '$search%' or last_name like'$search%' or preference_status like'$search%' order by first_name desc";
	  $result=mysqli_query($con,$query)or exit($query);
	  $q_activity="insert into activity_logs values('','$val','$search','search',now())";
		mysqli_query($con,$q_activity)or exit($q_activity);
	  echo "<div class='box' style='background:#e4d6d6; box-shadow:0px 0px 10px solid grey;'>";
  echo "<h4> Search Results</h4>";	  
	  while($res=mysqli_fetch_array($result))
      { echo "<div class='col-md-5' style='margin: 10px;'>
						  <img src=".$res[13]." style='width:20%; height: 50px;'>
                      <div style='float: right; width: 75%; height:50px;color:grey;margin-top:-2%;'>						  
			         <h4><a href='message.php?user=$res[0]'>".ucwords($res[17])."</a></h4>
	           <span>".ucwords($res[7])."</span>
		        </div>
                </div>";
     }echo "</br>";
	 echo "<div class='col-md-12'>";
	 echo "<h4>Groups</h4>";
	 $query_g="select * from groups where group_title like '%$search%'";
	  $result_g=mysqli_query($con,$query_g)or exit($query_g);
	    while($res_g=mysqli_fetch_array($result_g))
		{
		  echo"<div class='col-md-4' style='background:#e4d6d6;margin-top:3px;padding:3px;'><img src='$res_g[4]' style='width:100%; height:100px'></img>
					   <h4>".ucwords($res_g[1])."</h4>
					   <button id='page_member$res[0]' class='btn btn-primary' style='width:100%;background:#009688'>View</button>
					  </div>";	
		}	
	 echo "</div></div>";
} 
echo "<div class='col-md-12'><div class='box' style='background:#e4d6d6'>
<form action='' method='POST' enctype=''>
<h4>Direct Message</h4>
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
		<button type='submit' id='send_msg' class='btn btn-primary' style='background:#009688;float:right;'>Send message</button>
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
</script></div>				   
</form>   
</div>";?>	  
	  </div>
<div class='col-md-12' style='padding:2px;background:#e4d6d6;margin-top:3px;'>
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
					 <a href='message.php?friend_id=$row3[0]'><button class='btn btn-primary btn-xs' style='background:#009688;'>Add Friend</button></a>
                    </div>	";
				   }}
} echo "</div>";
	  ?>
</div>	  
	  </div>
<div class='col-md-3' style='padding:2px;'>
	  <div class='col-md-12' style="background:#e4d6d6;border-radius:10px;">
	  <?php
	  echo "<div style='background:;padding:10px;border-radius:10px;'>";
	  echo "<h3>Messages <span class='badge'> $count_msg</span></h3>";
	  $q_select="SELECT * FROM `message` WHERE destination_id='$val' or sender_id='$val' group by sender_id, destination_id order by sno desc";
$result=mysqli_query($con,$q_select);
$friend='';
$newarr= array();
while($r=mysqli_fetch_array($result))
{
	if($r[1]==$val)
	{
		$friend=$r[2];
	}
	else if($r[2]==$val)
	{
		$friend=$r[1];
	}
	
	
	if(in_array($friend,$newarr))
	{
		
	}
	else{
		$q_m="select * from message where (sender_id='$val' and destination_id='$friend') or (sender_id='$friend' and destination_id='$val') order by sno desc LIMIT 0,1";
		$r_m=mysqli_query($con,$q_m);
		$m=mysqli_fetch_row($r_m);
		$q_newmsg="select * from message where sender_id='$friend' and destination_id='$val' and status='s'";
		$r_newmsg=mysqli_query($con,$q_newmsg)or exit($q_newmsg);
		$count_newmsg=mysqli_num_rows($r_newmsg);
		$q_select_f="select * from user_detail where user_id='$friend'";
		$re_select=mysqli_query($con,$q_select_f)or exit($q_select_f);
		$f=mysqli_fetch_row($re_select);
echo "<div style='margin: 10px;clear:all;'>
						  <img src=".$f[13]." style='width:20%; height: 50px;'>
                      <div style='float: right; width: 75%; height:50px;color:grey;margin-top:-8px;'>						  
			         <a href='message.php?user=$f[0]' style='font-size:17px;'>".ucwords($f[17])."</a>
					 <span style='float:right;font-size:15px;'>".date_format(date_create($m[4]),'h:ia')."</span></br>
					 <span style='float:left'>".substr($m[3], 0,20)."</span>";
					 if($count_newmsg!=0)
					 echo "<span class='badge' style='float:right;'>$count_newmsg</span>";
		        echo "</div>
                </div>";
	}$newarr[]=$friend;
}
echo "</div>";
?>
<?php
	   if(!empty($_GET['user']))
	   {
		$id=$_GET['user'];
		$q_read="update message set status='r' where sender_id='$id' and destination_id='$val'";
		mysqli_query($con,$q_read)or exit($q_read);
       $q_color="select * from theme_table where (user_id='$val' and friend_id='$id') or(user_id='$id' and friend_id='$val')";
	$theme_color=mysqli_query($con,$q_color)or exit($q_color);
    $color=mysqli_fetch_row($theme_color);
$count_color=mysqli_num_rows($theme_color);	
		echo "
	<div id='chat' draggable='true' class='resizable' style='padding:2px;bottom-padding:5px;border-radius:10px;margin-right:5px;width:100%;background:";
		if($count_color==1)
		{echo $color[3];}
	else echo"#eee";
	    echo "'>";  
        $q_user="select * from user_detail where user_id='$id'";
		$result_user=mysqli_query($con,$q_user)or exit($q_user);
	    $res_user=mysqli_fetch_row($result_user);
		echo "<div style='background:#ffcdd2; padding:5px;'><a href='user.php?user=$res_user[0]'><img src='$res_user[13]' style='width:13%;height:40px; border-radius:50%;'></a>
		<div style='float:right;width:85%;height:40px;'><a href='user.php?user=$res_user[0]'>".ucwords($res_user[17])."</a><a href='message.php'><span class='close'>&times;</span></a></br>";
		if($res_user[20]=='online'){
		echo "<span>$res_user[20]</span>";}
		else{
			echo "<span>Last seen at ".date_format(date_create($res_user[20]),'h:ia')."</span>";
		}
		echo "";
		echo "<div id='icon' style='margin-right:0px;background:#e0e0e0;float:right;'><i class='fa fa-chevron-down' style='margin:4px;'></i>";
		echo"<div id='theme' style='display:none;'>
		<h6>Chat Theme</h6>
		 <a href='message.php?user=$id&theme=#c8e6c9'><div style='width:30px;height:30px; background:#c8e6c9;padding:1px;border-radius:30%;float:right'></div></a>
		 <a href='message.php?user=$id&theme=eee'><div style='width:30px;height:30px; background:#eee;padding:1px;border-radius:30%;float:right'></div></a>
		 <a href='message.php?user=$id&theme=b2ebf2'><div style='width:30px;height:30px; background:#b2ebf2;padding:1px;border-radius:30%;float:right'></div></a>
		 <a href='message.php?user=$id&theme=c5cae9'><div style='width:30px;height:30px; background:#c5cae9;padding:1px;border-radius:30%;float:right'></div></a>
		 <a href='message.php?user=$id&theme=fff9c4'><div style='width:30px;height:30px; background:#fff9c4;padding:1px;border-radius:30%;float:right'></div></a>
		 </div>
		 ";echo "</div></div></div>";
		echo "<div id='chat1' class='msg_chat_box' style='height:280px;background:;'>";
		$q_user_msg="select * from message where (sender_id='$id' and destination_id='$val') or(sender_id='$val' and destination_id='$id')";
		$result_user_msg=mysqli_query($con,$q_user_msg)or exit($q_user_msg);
		$count_msg=mysqli_num_rows($result_user_msg);
		if($count_msg==0)
		{
		 echo "<div class='conversation'>you have no conversation with ".Ucwords($res_user[17])." yet.Start Conversation</div>";	
		}
		while($r_user_msg=mysqli_fetch_array($result_user_msg))
		{
		  if($r_user_msg[1]==$val)
		  {
		echo "<div style='clear:both;'><div style='float:right;padding-right:10%'><div class='msg_chat'><h5 style='word-break: break-all;'>";
			echo $r_user_msg[3];
			echo "</h5></div><h6 style='float:right;'>".date_format(date_create($r_user_msg[4]),'h:ia');
			if($r_user_msg[5]=='r')
			{
				echo "<i class='fa fa'></i>";
			}echo "</h6></div></div>";  
		  }
		  if($r_user_msg[1]==$id)
		  {
		echo "<div style='clear:both;'><div style='float:left'>
		<div class='msg_chat'><h5 style='word-break: break-all;'>".
			$r_user_msg[3]."</h5></div><h6>".date_format(date_create($r_user_msg[4]),'h:ia');
			if($r_user_msg[5]=='r')
			{
				echo "<i class='fa fa'></i>";
			}
			echo"</h6></div></div>";  
		  }
           			 
		}
		echo "</div>";
		echo "<textarea id='msg$id$val' style='width:87%;height:40px;background:#eee;color:black' placeholder='start typing....'>
		</textarea>
		<i id='send$id$val' class='fa fa-arrow-circle-right fa-3x' style='width:10%;float:right;color:#0270bd'></i>";
echo "<script>
$(document).ready(function() {
$('#send$id$val').click(function(e) {
e.preventDefault();
$.ajax({
type: 'POST',
url: 'msg_user.php',
data: {msg: $('#msg$id$val').val(),friend_id:$id},
success: function(data)
{	
$('#chat1').html(data);
}
});
});});
    $(document).ready(function(){
		var scrolled=false;
        setInterval(function() {
            $('#chat1').load('load_msg.php?id='+$id)
			if(!scrolled){
			var elem = document.getElementById('chat1');
			elem.scrollTop = elem.scrollHeight;}
        }, 1000);
		$('#chat1').on('scroll', function(){
    scrolled=true;
}); 
    });
</script>
</div>";		
}?>
</div>	  	  
	  
	  
	  
	  
  </div>
</div>

<script>
$(document).ready(function(){
	$('#icon').mouseover(function(){
	$('#theme').css('display','block');	
	});
	$('#icon').mouseleave(function(){
	$('#theme').css('display','none');	
	});
  $( function() {
    $( "#chat" ).draggable();
  } );});
</script>
</body>
</html>