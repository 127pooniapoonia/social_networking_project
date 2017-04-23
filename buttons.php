<?php
include("connect.php");
if(!empty($_SESSION['admin']))
{   $val=$_SESSION['admin'];
	$q1="select * from user_detail where user_id='$val';";
	$res1=mysqli_query($con,$q1)or exit($q1);
	$row=mysqli_fetch_row($res1);
}
else{
	header("location:index.php");
	exit();
}
if(!empty($_POST['accept_id'])){
	$accept=$_POST['accept_id'];
	$status_cmd=$_POST['status'];
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
	echo "<h3>Friend Request</h3>";
		
             $request="select * from friend_request where (destination_id='$row[0]' AND request_status='p')ORDER BY sno desc";
	         $result=mysqli_query($con,$request)or exit($request);
             $count_request= mysqli_num_rows($result);
             if(!empty($count_request))
			 {
			     while($row4=mysqli_fetch_array($result))
				{ 
			        $sender="select * from user_detail where user_id='$row4[1]'";
					$res_sender=mysqli_query($con,$sender) or exit($sender);
					$detail=mysqli_fetch_row($res_sender);
			      echo "<div style='margin: 5px; padding: 5px;'>
						  <img src=".$detail[13]." style='width:30%; height: 80px;'>
                      <div style='float: right; width: 70%; height:80px'>						  
			         <h4><a href='user.php?user=$detail[0]'>".ucwords($detail[17])."</a></h4>
				<button id='accept_request$detail[0]' class='btn btn-primary btn-xs'>Accept</button>
				<button id='cancel_request$detail[0]'  class='btn btn-primary btn-xs'>Cancel Request</button>
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
$('#friends_request').html(data);
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
				 echo "<h5 style='text-align:center'>No pending request</h5>";
			 }
}

 
 
 
 
 
 
 
 
 if(!empty($_POST['unlike_like_page']))
 {
	$unlike_like=$_POST['unlike_like_page'];
	$status=$_POST['status'];
	$page_id=$_POST['page_id'];
   if($status=='u')	{
	$q6="select * from unlike_page_post where (post_id='$unlike_like' AND user='$row[0]')";
	$res6=mysqli_query($con,$q6)or exit($q6);
      $count= mysqli_num_rows($res6);
      if(!empty($count))
	  { 
          $delete="delete from unlike_page_post where (post_id='$unlike_like' AND user='$row[0]')";
	     mysqli_query($con,$delete)or exit($delete);
	  }
	  else
	  {
		$q5="insert into unlike_page_post values('','$page_id','$unlike_like','$row[0]','1',now())";
        mysqli_query($con,$q5)or exit($q5);		
	  }
	  $q_unlike="select * from unlike_page_post where post_id='$unlike_like'";
	   $res_unlike=mysqli_query($con,$q_unlike)or exit($q_unlike);
       $count_unlike= mysqli_num_rows($res_unlike);
   echo $count_unlike;}
   else{
	   $q6="select * from like_page_post where (post_id='$unlike_like' AND user_id='$row[0]')";
	$res6=mysqli_query($con,$q6)or exit($q6);
      $count= mysqli_num_rows($res6);
      if(!empty($count))
	  {
        $delete="delete from like_page_post where (post_id='$unlike_like' AND user_id='$row[0]')";
	    mysqli_query($con,$delete)or exit($delete);
	  }
	  else
	  {
		$q5="insert into like_page_post values('','$page_id','$unlike_like','$row[0]','1',now())";
        mysqli_query($con,$q5)or exit($q5);
	  }
	  $q_like="select * from like_page_post where post_id='$unlike_like'";
	  $res_like=mysqli_query($con,$q_like)or exit($q_like);
      $count_like= mysqli_num_rows($res_like);
	  echo $count_like;
   }
 }
 if(!empty($_POST['photo']))
 {
	$photo=$_POST['photo'];
echo $photo;	
 }
 
 
 if(!empty($_POST['page_id_cover']))
 {  $page_id=$_POST['page_id_cover'];
	if(!empty($_FILES['cover']['name']))
	{
							$img=$_FILES['cover']['name'];	
							$size=$_FILES['cover']['size'];
							$type=$_FILES['cover']['type'];
							$error=$_FILES['cover']['error'];
							$tmp_name=$_FILES['cover']['tmp_name'];
							$location="cover_photo/".rand(0,1000).$img;
							move_uploaded_file($tmp_name,$location);
							$image=imagecreatefromjpeg($location);
		                    imagejpeg($image,$location,20);
     }else{$location="cover_photo/default.jpg";}
     $w= "update groups set cover_photo='$location' where sno='$page_id'";
	 mysqli_query($con,$w);	 
 }
?>