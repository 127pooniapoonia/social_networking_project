<?php
include('connect.php');
if(!empty($_POST['users']))
{
$q2= "select * from users";
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
echo "<input type='text' rel='textbox'>
<button class='btn btn-default'>delete</button>
<button class='btn btn-default'>Edit</button>
<button class='btn btn-default'>details</button>";
echo"<h5><table class='table table-bordered table-hover table-striped'>
					<tr>
					<th>Select</th>
					<th>User_id</th>
					<th>User_type</th>
					<th>Username</th>
					<th>Password</th>
					<th>Joining_date</th>
					</tr>";
				  $q2= "select * from users LIMIT $start,$active";
				  $res2= mysqli_query($con,$q2) or exit($q2);
				  while($row2=mysqli_fetch_array($res2))
				  {
					 echo "<tr>
					 <td align='center'><input type='checkbox' rel='textbox' name='$row2[0]'/></td>
					 <td><a href='admin_user_detail.php?user=$row2[0]'>$row2[0]</a></td>
					 <td>$row2[1]</td>
					 <td>$row2[2]</td>
					 <td>$row2[3]</td>
					 <td>".date_format(date_create($row2[4]),'d-m-y')."</td>
					 </tr>";
				echo "<script>
				$(document).ready(function(){
$('#user_detail$row2[0]').click(function(e) {	
e.preventDefault();
$.ajax({
type: 'POST',
url: 'admin_panel_detail.php',
data: {user_id:'$row2[0]'},
succes function(data)
{
$('#detail').html(data);
}
});

                     });
					 });
					 </script>";				
	              } 
echo "</table></h5>";
if($idactive>1){				  
echo "<h5 id='previous_user$idactive' style='float:left'><i class='fa fa-arrow-left'>previous</i></h5>";}
if($idactive<$total_post){
echo "<h5 style='float:right' id='next_user$idactive'>next<i class='fa fa-arrow-right'></i></h5>";}				  
				  
}
if(!empty($_POST['posts']))	
{
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
echo"<h5><table class='table table-bordered table-hover table-striped'>";
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
					 echo "<td style='word-break:break-all;'><a id='post_hover$row2[0]'>$row2[3]</a>";
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
}
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
 });
 $('#previous_user$idactive').click(function(e) {	
e.preventDefault();
$.ajax({
type: 'POST',
url: 'admin_panel.php',
data: {users:'user',idactive:$idactive-1},
success: function(data)
{
$('#post').html(data);
}
});
 });
 $('#next_user$idactive').click(function(e) {	
e.preventDefault();
$.ajax({
type: 'POST',
url: 'admin_panel.php',
data: {users:'user',idactive:$idactive+1},
success: function(data)
{
$('#post').html(data);
}
 });	 
 });
 });
 </script>"; 
?>