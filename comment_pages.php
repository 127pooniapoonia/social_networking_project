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
if(!empty($_POST['comment'])){
	$post_id=$_POST['post_id'];
	$comment=$_POST['comment'];
	$reply_id=$_POST['reply_id'];
	$idactive=$_POST['idactive'];
	$total_comment=$_POST['t'];
	$page_id=$_POST['page_id'];
$query_insert="insert into comment_page_post values('','$page_id','$post_id','$row[0]','$comment','$reply_id',now())";
$result_q=mysqli_query($con,$query_insert)or exit($query_insert);
}
if(!empty($_POST['comment_id']))
{ $post_id=$_POST['post_id'];
	$comment_id=$_POST['comment_id'];
	$idactive=$_POST['idactive'];
	$total_comment=$_POST['t'];
	$page_id=$_POST['page_id'];
	$q_delete="delete from comment_page_post where sno='$comment_id'";
	mysqli_query($con,$q_delete)or exit($q_delete);	
}

if(!empty($_POST['post_id']))
{    $idactive=$_POST['idactive'];
$page_id=$_POST['page_id'];
$post_id=$_POST['post_id'];
$total_comment=$_POST['t'];
	$active=4;
	if($idactive==0){$start=0;}else
$start=($idactive-1)*$active;

}

?>
<?php
if(!empty($_POST['post_id'])){
	if($idactive>1)
	{echo "<h6 id='previous$post_id$idactive' style='color:#0277bd'><i class='fa fa-arrow-left'>previous</i></h6>";}
$q_comment="select * from comment_page_post where post_id='$post_id' LIMIT $start,$active";
$result_c=mysqli_query($con,$q_comment)or exit($q_comment);
while($res=mysqli_fetch_array($result_c))
{   $query_user="select * from user_detail where user_id=$res[3]";
    $result_user=mysqli_query($con,$query_user)or exit($query_user);
	$user=mysqli_fetch_row($result_user);
							echo "<div style='clear:left;'>
							<div style='float: left; width:15%; height: 15%'>
				           <img src='$user[13]' style='width:100%; height: 100%'>
						  </div>
						  <div style='float: left; margin-left:5px; width:80%;'><div style='color:#0277bd;font-size:15px;'>"
						  .ucwords($user[17]);
						  if($res[5]!='p'){
							$q_reply="select * from user_detail where user_id='$res[5]'";
							$res_q=mysqli_query($con,$q_reply)or exit($q_reply);
							$reply_user=mysqli_fetch_row($res_q);
						  echo "&nbsp<i class='fa fa-reply fa-rotate-180'></i>&nbsp".ucwords($reply_user[17]);
						}
						  echo"</div><div style='clear:left'><h5 align='justify' style='word-break: break-all;'>$res[4]</h5></div>";
						  if($res[3]!=$row[0]){
						  echo "<div class='panel-group' id='reply$post_id$res[0]'>
						  <div class='panel panel-default' style='border: none;background:#eee'>
						  <a data-toggle='collapse' data-parent='#reply$post_id$res[0]' href='#replypost$post_id$res[0]'><h6 style='color:#0277bd'><i class='fa fa-reply fa-rotate-180'></i>reply</h6></a>
						 <div id='replypost$post_id$res[0]' class='collapse'>
						  <div style='margin-top:7px;'>
						  <img src='$row[13]' style='width:15%; height:40px; float: left'>
					       <form name='form1'>
						   <textarea id='$post_id$res[0]' style='width: 70%; height: 40px; float: left;'></textarea>
					 <button class='btn btn-primary btn-sm' id='btnn$post_id$res[0]'>post</button></form></div>
						 </div>	
						 </div>
						  </div>";}
						  else{echo"<h6 id='delete$post_id$res[0]' style='color:#0277bd'>delete</h6>";
						  }
						  echo"</div>";
						  echo"</div></div>";
echo "<script>
$(document).ready(function(){
$('#next$post_id$idactive').click(function(e) {
		e.preventDefault();
								$.ajax({
									type: 'POST',
									url: 'comment_pages.php',
									data: {idactive: $idactive+1,post_id:$post_id,t:$total_comment,page_id:$page_id},
									success: function(data)
									{
										$('#btn$post_id').html(data);
									}
								});
});
$('#previous$post_id$idactive').click(function(e) {
								e.preventDefault();
								$.ajax({
									type: 'POST',
									url: 'comment_pages.php',
									data: {idactive: $idactive-1,post_id:$post_id,t:$total_comment,page_id:$page_id},
									success: function(data)
									{
										$('#btn$post_id').html(data);
									}
								});
							});
$('#delete$post_id$res[0]').click(function(e) {
							e.preventDefault();
$.ajax({
type: 'POST',
url: 'comment_pages.php',
data: {comment_id:$res[0],post_id:$post_id,t:$total_comment,idactive: $idactive,page_id:$page_id},
success: function(data)
{
$('#btn$post_id').html(data);
}
});
});
$('#btnn$post_id$res[0]').click(function(e) {
e.preventDefault();
$.ajax({
type: 'POST',
url: 'comment_pages.php',
data: {comment:$('#$post_id$res[0]').val(),post_id:$post_id,idactive:$total_comment,page_id:$page_id,reply_id:$user[0],t:$total_comment},
success: function(data)
{
$('#btnpost_id').html(data);}
});
});							
});
</script>";								 
}if($idactive<($total_comment)){
echo "<h6 id='next$post_id$idactive' style='color:#0277bd'>next<i class='fa fa-arrow-right'></i></h6>";}}				 			 
?>