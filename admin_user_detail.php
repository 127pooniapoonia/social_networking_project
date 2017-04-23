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
 include_once("connect.php");
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
	  if(!empty($_GET['user']))
	  {
		  $user2=$_GET['user'];
		  $q_user="select * from user_detail where user_id='$user2';";
	         $res_user=mysqli_query($con,$q_user)or exit($q_user);
	         $user1=mysqli_fetch_row($res_user);
	  }
?>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
 <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="admin_dashboard.php">Dashboard</a>
            </div>
			<div class="collapse navbar-collapse navbar-ex1-collapse">
<ul class="nav navbar-right top-nav">
                    <li>
                      <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>Settings<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                           <?php echo"<a href='admin_dashboard.php?user=$user2'><i class='fa fa-fw fa-envelope'></i>Block</a>";?>
                        </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
<div class='container-fluid'>
<div class='row'>
<div class='col-md-2' style='padding:2px;'>
<?php
echo "<img src='$user1[13]' style='width:100%;height:30%;'></img>";
echo "<div  class='table-responsive'>";
echo "<h4>About</h4>";
echo "<form action='' method='' enctype=''>";
echo"<table class='table table-bordered table-hover table-striped'>";
					 echo "<tr>
					 <th>User_id</th>
					 <td>$user1[0]</td>
					 </tr>
					 <tr>
					 <th>First_name</th>
					 <td>$user1[1]</td>
					 </tr>
					 <tr>
					 <th>Last_name</th>
					 <td>$user1[2]</td>
					 </tr>
					 <tr>
					 <th>Birth_day</th>
					 <td>$user1[3]</td>
					 </tr>
					 <tr>
					 <th>Gender</th>
					 <td>$user1[4]</td>
					 </tr>
					 <tr>
					 <th>Mobile_no</th>
					 <td>$user1[5]</td>
					 </tr>
					 <tr>
					 <th>Education</th>
					 <td>$user1[6]</td>
					 </tr>
					 <tr>
					 <th>Hometown</th>
					 <td>$user1[7]</td>
					 </tr>
					 <tr>
					 <th>Current_city</th>
					 <td>$user1[8]</td>
					 </tr>
					 <tr>
					 <th>Status</th>
					 <td>$user1[9]</td>
					 </tr>
					 <tr>
					 <th>language</th>
					 <td>$user1[10]</td>
					 </tr>
					 <tr>
					 <th>interest</th>
					 <td>$user1[11]</td>
					 </tr>
					 <tr>
					 <th>about</th>
					 <td>$user1[12]</td>
					 </tr>
					</table></form></div>";
?>
</div>
<div class='col-md-7' style='padding:2px;'>
<h6 style='color:grey;'><i class='fa fa-edit' ></i>What's on mind</h6>
<h4>Timeline</h4>
<div class='' style='padding:2px;'>
<textarea style='width:70%;'></textarea>
</div>
<div class='col-md-12'>
<?php
$q_post="select * from post_detail where user_id='$user1[0]'";
$res1=mysqli_query($con,$q_post)or exit ($q_post);
  while($row2=mysqli_fetch_array($res1))
  { 
 $q4="select * from user_detail where user_id='$row2[1]';";
	              $res4=mysqli_query($con,$q4)or exit($q4);
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
				 <a href='home2.php?unlike_like=$row2[0]&status=l'><i class='fa fa-thumbs-up' aria-hidden='true' style='text-shadow:2px 2px 2px grey; font-size:20px; color: #388e3c; '></i></a>&nbsp";
				  echo "<span id='like_count$row2[0]' class='point'>".$count_like."</span>";				  
				  echo "&nbsp<a href='home2.php?unlike_like=$row2[0]&status=u'><i id='unlike$row2[0]' class='fa fa-thumbs-down' aria-hidden='true' style='text-shadow:2px 2px 2px grey; font-size:20px; color: #e57373;'></i></a>&nbsp";
				  echo "<span id='unlike_count$row2[0]' class='point'>".$count_unlike."</span>";
				  echo "&nbsp
                        <a data-toggle='collapse' data-parent='#comment$row2[0]' href='#collapseOne$row2[0]'><i class='fa fa-comment' aria-hidden='true' style='text-shadow:2px 2px 2px grey; font-size:20px;'></i>Comments&nbsp".$count_comment."
                        </a>"; if($row2[1]==$val){
						echo "<a href='home2.php?post_delete=$row2[0]'><span TITLE='delete' class='fa fa-trash-o' style='float:right;color:#388e3c;'></span></a>";
						}
	$q_select="select * from fvrts_post where post_id='$row2[0]' and user_id='$user1[0]'";
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
						  if($res[2]!=$user[0]){
						  echo "<div class='panel-group' id='reply$row2[0]$res[0]'>
						  <div class='panel panel-default' style='border: none;background:#eee'>
						  <a data-toggle='collapse' data-parent='#reply$row2[0]$res[0]' href='#replypost$row2[0]$res[0]'><h6 class='point'><i class='fa fa-reply fa-rotate-180'></i>reply</h6></a>
						 <div id='replypost$row2[0]$res[0]' class='collapse'>
						  <div style='margin-top:7px;'>
						  
						  <img src='$user[13]' style='width:15%; height:40px; float: left'>
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
					<div style='margin-top:7px;clear:left;'><img src='$user[13]' style='width:15%; height:40px; float: left'>
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
		        } ?>
</div></div>
<div class='col-md-3' style='padding:2px'>
<div class='col-md-12'>
<h3>Activity Logs</h3>
<?php
$q_activity="select * from activity_logs where user_id='$user1[0]' order by sno desc";  
$res_activity=mysqli_query($con,$q_activity)or exit($q_activity);
$count=mysqli_num_rows($res_activity);
echo "<div class='col-md-12' style=''>";
if(empty($count))
{ echo "No Activity Logs From Past 24 Hours"; 
}
while($r_activity=mysqli_fetch_row($res_activity))
{
  echo "<div>";
   if($r_activity[3]=='search')
   {
	echo "<div style='padding:2px;'><h5>Do You Know '$r_activity[2]'</h5>".date_format(date_create($r_activity[4]),'h:ia')."</div>";   
   }
   else{
	   $q_query="select * from post_detail where Sno='$r_activity[2]'";
	  $res=mysqli_query($con,$q_query)or exit($q_query);
	  $post=mysqli_fetch_row($res);
   if($r_activity[3]=='like')
   {
	 echo "<div style='padding:2px; width:60%;height:50px;float:left;'><h5>You liked a post</h5>
	  ".date_format(date_create($r_activity[4]),'h:ia')."</div>
	  <div style='width:38%;height:50px;float:left;'>
	 <img src='$post[3]' style='width:100%;height:100%;'></img>
	  </div>";  
   }
   if($r_activity[3]=='unlike')
   {
	 echo "<div style='padding:2px;'><h5>You unliked a post</h5>".date_format(date_create($r_activity[4]),'h:ia')."</div>
<div style='width:38%;height:50px;float:left;'>
	 <img src='$post[3]' style='width:100%;height:100%;'></img>
	  </div>";	 
   }
   if($r_activity[3]=='accept')
   {
	 echo "<div style='padding:2px;'><h5>You are now friend of </h5>".date_format(date_create($r_activity[4]),'h:ia')."</div>";   
   }
   if($r_activity[3]=='request_send')
   {
	 echo "<div style='padding:2px;'><h5>You send a request to</h5>".date_format(date_create($r_activity[4]),'h:ia')."</div>";   
   }
   if($r_activity[3]=='post')
   {
	 echo "<div style='padding:2px;'><h5>You have new post</h5>".date_format(date_create($r_activity[4]),'h:ia')."</div>
<div style='width:38%;height:50px;float:left;'>
	 <img src='$post[3]' style='width:100%;height:100%;'></img>
	  </div>";	 
   }
   if($r_activity[3]=='comment')
   {
	 echo "<div style='padding:2px;'><h5>You are commented on post</h5>".date_format(date_create($r_activity[4]),'h:ia')."</div>
<div style='width:38%;height:50px;float:left;'>
	 <img src='$post[3]' style='width:100%;height:100%;'></img>
	  </div>";	 
   }}
 echo"</div>";
}
echo "</div>";
?>
</div>
<?php
 echo "<div class='col-md-12' style='background:#e4d6d6;border-radius:10px;'>";
			echo "<div class='about' style='background: #e4d6d6; margin-top: 10px;margin-bottom:10px;'>
		    <h3>Friends</h3>";
			   $select_friend="select* from friends where user_id1='$user1[0]' or user_id2='$user1[0]'";
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
			         <h4 style='color:#009688;'><a href='user.php?user=$res[0]' class='point'>".ucwords($res[17])."</a></h4>
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
		
             $request="select * from friend_request where (sender_id='$user1[0]' AND request_status='p')";
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
			         <h4 style='color:#009688;'><a href='user.php?user=$detail[0]' class='point'>".ucwords($detail[17])."</a></h4>
					 <button id='cancel_request$detail[0]' class='btn btn-primary btn-xs' style='background:#009688;'>Cancel Request</input></a>
					 </div>
                    </div>";
echo "<script>
$(document).ready(function(){					
$('#cancel_request$detail[0]').click(function(e){
e.preventDefault();
$.ajax({
type: 'POST',
url: 'buttons.php',
data: {accept_id:$detail[0],status:'c'},
success: function(data)
{
$('#friends_request').html(data);
}
});	
});	
});
</script>";					
				}
			 }
             else
			 {
				 echo "<h5 style='text-align:center'>No pending sent request</h5>";
			 }
			 if($idactive_pendingrequest>1)
			 {echo "<h6 id='previous'class='point'><i class='fa fa-arrow-left'>previous</i></h6>";}
			 echo "</div></div>	";
echo "<div class='col-md-12' style='background:#e4d6d6;border-radius:10px; padding:2px;margin-top:2px;'>
	  <div id= 'friends_request1' class='box' style='background: #e4d6d6; margin-top: 10px;'>
		<h3>Friend Request</h3>";
             $request="select * from friend_request where (destination_id='$user1[0]' AND request_status='p')";
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
<button id='accept_request$detail[0]' class='btn btn-primary btn-xs' style='background:#009688;'>Accept</button>
<button id='cancel_request$detail[0]'  class='btn btn-primary btn-xs' style='background:#009688;'>Cancel Request</button>
					 </div>
                    </div>";
echo "<script>
$(document).ready(function(){
$('#accept_request$detail[0]').click(function(e){
e.preventDefault();
$.ajax({
type: 'POST',
url: 'buttons.php',
data: {accept_id:$detail[0],status:'a'},
success: function(data)
{
$('#friends_request1').html(data);
}
});	
});
$('#cancel_request$detail[0]').click(function(e){
e.preventDefault();
$.ajax({
type: 'POST',
url: 'buttons.php',
data: {accept_id:$detail[0],status:'c'},
success: function(data)
{
$('#friends_request1').html(data);
}
});	
});	
});
</script>";	
				}
			 }
             else
			 {
				 echo "<h5 style='text-align:center'>No pending request</h5>";
			 }
			 if($idactive_request>1)
			 {echo "<h6 id='previous' style='color:#0277bd'><i class='fa fa-arrow-left'>previous</i></h6>";}
			 echo "</div></div>	";		 
 ?>
</div>
</div>
</div>	  
</body>
</html>