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
{ header("location:facebook.php");
exit();}
 if(!empty($_GET['unblock']))
 {   $id=$_GET['unblock'];
	$q_block="delete from friend_request where (sender_id=$val and destination_id=$id) or (sender_id=$id and destination_id=$val) and request_status='b'";
    $r_block=mysqli_query($con,$q_block)or exit($q_block); 
 }	 
include("user_header.php");	
?>
<div class="container-fluid" style='margin-top:-10px;'>
  <div class="row">
      <div class="col-md-2" style="background:#e4d6d6;border-radius:10px;padding:2px;">
	 <?php
	 include("icons.php");
	 ?>
	  </div>
	 <div class='col-md-7' style='padding:2px;'>
	 <div class='box' style='background: #e4d6d6; margin-top: 5px;'>
	   <h4 style='font-size:22px;color:#0277bd'>Settings</h4>
        <?php 
		  $query_user="select * from users where user_id='$val'";
		  $result=mysqli_query($con,$query_user)or exit($query_user);
		  $res=mysqli_fetch_row($result);
		  echo "
		  <div class='panel group' id='#changeusername' style='background: #e4d6d6;'>
		  <div class='panel-default'><span>Username</span><a data-toggle='collapse' data-parent='#changeusername' href='#username' style='word-break: break-all;float:right;'><i class='fa fa-edit'>edit</i></a>
		   <div id='username' class='collapse'>
		  <div class='jumbotron'><b> Change Username</b><div id='msg1'></div>Enter current password-</br>
		   <input type='password' id='current_password1'class='inputtext'/>
		   Enter new username-</br>
		   <input type='text' id='new_username' class='inputtext'/>
		  Re-enter new username-</br>
		   <input type='text' id='reenter_new_username' class='inputtext''/></br>
		   <button id='changeusername_button' class='btn btn-primary btn-sm' style='float:right;background:#009688;'>Save</button></div>
		  </div></div></div>
		  <div class='panel group' id='#changepassword' style='background: #e4d6d6;'>
		  <div class='panel-default'><span>Password&nbsp &nbsp</span>
		  <a data-toggle='collapse' data-parent='#changepassword' href='#password' style='word-break: break-all;float:right;'><i class='fa fa-edit'>edit</i></a>
		  <div id='password' class='collapse'>
		   <div class='jumbotron'><b> Change Password</b><div id='msg'></div>Enter Current Password-</br>
		   <form><input type='password' id='current_password' class='inputtext'/>
		   Enter new Password-</br>
		   <input type='password' id='new_password' class='inputtext'/>
		  Re-enter new Password-</br>
		   <input type='password' id='reenter_new_password'class='inputtext'/>
		   <button id='changepassword_button' class='btn btn-primary btn-sm' style='float:right;background:#009688;'>Save</button></form></div>
		  </div></div></div>";
		?>	   
	 <div class='panel group' id='#timelime' style='background: #e4d6d6;'>
		  <div class='panel-default'><span>Timeline</span>
		  <a data-toggle='collapse' data-parent='#timelime' href='#timelimw1' style='word-break: break-all;float:right;'><?php echo $row[19]; ?> <i class='fa fa-edit'>edit</i></a>
		  <div id='timelimw1' class='collapse'>
	 <div class='box' style='background: #e4d6d6; margin-top: 5px;'>
			  <h4 style='font-size:22px'>Timeline Setting-</h4>
		   <div id='confirm_timeline' style='color:green'></div>
			  <h4>
			  <form action='' method='' enctype='' id='timeline'>
			  <input type='radio' value='only me' name='radio3'<?php if($row[19]=='only me'){echo "checked";}?>>Only Me</br>
			  <input type='radio' value='public' name='radio3' <?php if($row[19]=='public'){echo "checked";}?>>Public</br>
			  <input type='radio' value='friends' name='radio3' <?php if($row[19]=='friends'){echo "checked";}?>>Friends</br>
			<input id='timeline_button' class='btn btn-primary btn-sm' type='submit' value='Update' style='float: right;background:#009688;'></input></form>
			  </h4>
		</div>
	   </div></div></div>
	   <div class='panel group' id='#nickname' style='background: #e4d6d6;'>
		  <div class='panel-default'><span>Nickname/Username</span>
		  <a data-toggle='collapse' data-parent='#nickname' href='#nickname1' style='word-break: break-all;float:right;'> <?php echo $row[17]; ?> <i class='fa fa-edit'>edit</i></a>
		  <div id='nickname1' class='collapse'>
	    <div class='box' style='background: #e4d6d6; margin-top: 5px;'>
		  <h4 style='font-size:22px'>Select Nickname/Username-</h4>
		   <div id='confirm' style='color:green'></div>
			  <h4>
			  <form action='' method='' enctype='' id='prefernce'>
			  <input type='radio' value='<?php echo $row[16];?>' name='radio1' <?php 
			  if($row[16]==$row[17])
			  {echo "checked";}
		      else{
				  if(empty($row[16])) 
				  {echo "disabled";}
			  }
			  ?> ><?php echo $row[16];?></br>
			  <input type='radio' value='<?php echo $row[1]." ".$row[2];?>' name='radio1'<?php if($row[16]!=$row[17]){echo "checked";}?> ><?php echo ucwords($row[1]." ".$row[2]); ?></br></br>
			<input id='prefer_button' class='btn btn-primary btn-sm' type='submit' value='Update' style='float: right;background:#009688;'></input></form>
			  </h4>
		</div></div></div></div>
		<div class='panel group' id='#info' style='background: #e4d6d6;'>
		  <div class='panel-default'><span>General Info&nbsp &nbsp <?php echo $row[18]; ?></span>
		  <a data-toggle='collapse' data-parent='#info' href='#info1' style='word-break: break-all;float:right;'> <?php echo $row[18]; ?> <i class='fa fa-edit'>edit</i></a>
		  <div id='info1' class='collapse'>
		<div class='box' style='background: #e4d6d6; margin-top: 5px;'>
		  <h4 style='font-size:22px'>Info Setting-</h4>
		   <div id='confirm_basic' style='color:green'></div>
			  <h4>
			  <form action='' method='' enctype='' id='basic'>
			  <input type='radio' value='only me' name='radio2'<?php if($row[18]=='only me'){echo "checked";}?>>Only Me</br>
			  <input type='radio' value='public' name='radio2' <?php if($row[18]=='public'){echo "checked";}?>>Public</br>
			  <input type='radio' value='friends' name='radio2' <?php if($row[18]=='friends'){echo "checked";}?>>Friends</br>
			<input id='basic_button' class='btn btn-primary btn-sm' type='submit' value='Update' style='float: right;background:#009688;'></input></form>
			</div></div>
     </div></div></div></div>
	 <div class='col-md-3' style='padding:2px;'>
	 <div class='col-md-12'style="background:#e4d6d6;border-radius:10px;">
	  <div id='friends_request' class="box" style="background: #e4d6d6; margin-top: 10px;">
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
						  <a href='user.php?user=$detail[0]' class='point'><img src=".$detail[13]." style='width:30%;height: 80px;'></a>
                      <div style='float: right; width: 65%; height: 80px;'>						  
			         <h4><a href='user.php?user=$detail[0]' class='point' style='color:#009688;'>".ucwords($detail[17])."</a></h4>
					 <button id='cancel_request$detail[0]' class='btn btn-primary btn-sm' style='background:#009688;'>Cancel</input></a>
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
			 echo "</div>";?></div>
	 <div class='col-md-12' style="background:#e4d6d6;border-radius:10px;margin-top:5px;">
	 <div class='box' style='background: #e4d6d6; margin-top: 5px;'>
		  <h4 style='font-size:22px'>Block List</h4>
		   <?php
		   $q_block="select * from block_table where user_id=$val";
		   $r_block=mysqli_query($con,$q_block)or exit($q_block);
		   while($result_b=mysqli_fetch_array($r_block))
		   {
					$query="select * from user_detail where user_id='$result_b[2]'";
					$result=mysqli_query($con,$query)or exit($query);
					$res=mysqli_fetch_row($result);
					echo "<div style='margin: 5px; padding: 5px;'>
						  <a href='user.php?user=$res[0]' class='point'><img src=".$res[13]." style='width:30%; height: 80px;'></a>
                      <div style='float: right; width: 65%; height:80px'>						  
			         <h4 style='color:#009688;'>".ucwords($res[17])."</h4>
					 <a  href='settings.php?unblock=$res[0]'><button class='btn btn-primary btn-sm' style='background:#009688;'>Unblock</button></a>
					 </div>
                    </div>";  
		   }   
		   ?>
		</div></div></div>
</div>
</div>
<?php
include("footer.php");
?>
<?php
if(!empty($_POST['id1'])){
	echo"done";
}
?>
<script>
 $(document).ready(function(){
$('#changepassword_button').click(function(e){
e.preventDefault();
$.ajax({
type: 'POST',
url: 'changes.php',
data: {current: $('#current_password').val(),id2: $('#new_password').val(),id3: $('#reenter_new_password').val()},
success: function(data)
{
$('#msg').html(data);
}
});
});
$('#changeusername_button').click(function(e){
e.preventDefault();
$.ajax({
type: 'POST',
url: 'changes.php',
data: {current1: $('#current_password1').val(),id2: $('#new_username').val(),id3: $('#reenter_new_username').val()},
success: function(data)
{
$('#msg1').html(data);
}
});
});
$('#prefer_button').click(function(e){
	var value=$("input[name='radio1']:checked").val();
e.preventDefault();
$.ajax({
type: 'POST',
url: 'changes.php',
data: {prefer1:value},
success: function(data)
{
$('#confirm').html(data);
}
});
});
$('#basic_button').click(function(e){
	var value=$("input[name='radio2']:checked").val();
e.preventDefault();
$.ajax({
type: 'POST',
url: 'changes.php',
data: {basic:value},
success: function(data)
{
$('#confirm_basic').html(data);
}
});
});	
$('#timeline_button').click(function(e){
	var value=$("input[name='radio3']:checked").val();
e.preventDefault();
$.ajax({
type: 'POST',
url: 'changes.php',
data: {timeline:value},
success: function(data)
{
$('#confirm_timeline').html(data);
}
});
});			
});  
</script>
</body>
</html>	 
	