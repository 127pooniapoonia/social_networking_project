<!DOCTYPE html>
<html>
<head>
     <title>linkZone profile</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/home2.css">
	<link rel="stylesheet" type="text/css" href="css/profile.css">
    <script src="js/jquery-3.1.0.min.js"></script>
	<script src="ckeditor/ckeditor.js"></script>
	<script src="ckeditor/samples/js/sample.js"></script>
	<link rel="stylesheet" href="ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
</head>
<body>
<?php
include_once("connect.php");
if(!empty($_SESSION['admin']))
{   $val=$_SESSION['admin'];
	$q1="select * from user_detail where user_id='$val';";
	$res1=mysqli_query($con,$q1)or exit("error in query");
	$row=mysqli_fetch_row($res1);
	$people="select * from user_detail where user_id!='$val'";
	$res_people=mysqli_query($con,$people)or exit("error in query2");
	
}
else{
	header("location:linkzone.php");
    exit();
    }
if(!empty($_GET['user']))
{
	 $id= $_GET['user'];
	   if($id==$val)
	   {
		  header("location:profile.php"); 
		  exit();
	   }
	   else{
	 $q2="select * from user_detail where user_id='$id';";
	 $res2=mysqli_query($con,$q2)or exit("error in query");
	 $row2=mysqli_fetch_row($res2);
	 $post_select="select * from post_detail where user_id='$id';";
	   $res_post=mysqli_query($con,$post_select)or exit("error in query");}
}
else{
	header("location:linkzone.php");
    exit();
 }
if(!empty($_GET['status'])) 
{ $status=$_GET['status'];  
$q_unfriend="delete from friends where (user_id1=$val and user_id2=$id) or (user_id1=$id and user_id2=$val)";
mysqli_query($con,$q_unfriend)or exit($q_unfriend);
if($status=='block'){
	$q_block="insert into block_table values('','$val','$id',now())";
	mysqli_query($con,$q_block)or exit($q_block);
	$q_activity="insert into activity_logs values('','$val','$id','block',now())";
		mysqli_query($con,$q_activity)or exit($q_activity);
$q_n_friend="delete from friend_request where (sender_id=$val and destination_id=$id) or (sender_id=$id and destination_id=$val)";}
else{
$q_n_friend="update friend_request set request_status='u',block_id='$val' where (sender_id=$val and destination_id=$id) or (sender_id=$id and destination_id=$val)";	
}
mysqli_query($con,$q_n_friend)or exit($q_n_friend);
}
if(!empty($_GET['friend_id']))
{
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
	   header("location:user.php?user=$friend_id");

}
include("user_header.php");
?>
 <div class="container-fluid" style='margin-top:-10px;'>
  <div class="row">
    <div class='col-md-3'style='background:#e4d6d6;border-radius:10px;padding:10px;'>
	    <div class="">
	     <?php
		   echo "<h3>About</h3>";
		   echo "<table cellpadding='5' cellspacing='3'>
				   <tr>
				   <th>Name</th>
				   <td class='word'>".ucwords($row2[1])." ".ucwords($row2[2])."</td>
				   </tr>
				   <th>Nickname</th>
				   <td class='word'>".ucwords($row2[16])."</td>
				   </tr>
				   <tr>
				   <th>Birthday</th>
				   <td class='word'>".date_format(date_create($row2[3]),'d-M-Y')."</td>
				   </tr>
				   <tr>
				   <th>Gender</th>
				   <td class='word'>".ucwords($row2[4])."</td>
				   </tr>
				   <tr>
				   <th>Mobile no</th>
				   <td class='word'>".ucwords($row2[5])."</td>
				   </tr>
				   <tr>
				   <th>Education</th>
				   <td class='word'>".ucwords($row2[6])."</td>
				   </tr>
				   <tr>
				   <th>Hometown</th>
				   <td class='word'>".ucwords($row2[7])."</td>
				   </tr>
				   <tr>
				   <th>Present city</th>
				   <td class='word'>".ucwords($row2[8])."</td>
				   </tr>
				   <tr>
				   <th>Relationship status</th>
				   <td class='word'>".ucwords($row2[9])."</td>
				   </tr>
				   <tr>
				   <th>Language</th>
				   <td class='word'>".ucwords($row2[10])."</td>
				   </tr>
				   <tr>
				   <th>Interest</th>
				   <td class='word'>".ucwords($row2[11])."</td>
				   </tr>
				   <tr>
				   <th>About</th>
				   <td class='word' style='word-break:break-all;'>".ucwords($row2[12])."</td>
				   </tr>
                 </table>"; 
		 ?>
		</div>
		<div class='about' style='background:#e4d6d6;'>
		    <h3>Gallery</h3>
			<?php
			    $count_post=mysqli_num_rows($res_post);
				if($count_post==0)
				{
				    echo "<h5 style='text-align:center'>No Post Yet</h5>";	
				}
				else{
			   while($post=mysqli_fetch_array($res_post))
			   {   if(!empty($post[3]))
				   {
				   echo "<img src='$post[3]' style='width:70px; height:60px;'>";
				   }
			   }
			}			   
		  echo "</div>";?>
	</div>
	<div class='col-md-6' style='background:#e4d6d6;border-radius:5px;padding:4px;'>
	     <div class="about" style="width: 100%; height: 400px; background: #e4d6d6;margin-bottom: 60px;">
		   <img src='<?php echo $row2[14];?>' style='width:100%; height: 100%;border-radius:10px;'>
		   <div class='row'>
		     <div class='col-md-1'>
			 </div>
		   <div class='col-md-2'>
		     <img src='<?php echo $row2[13];?>' style='width:100px; height: 100px;  z-index:5; margin-top:-60px;'>
		   </div>
		   <div class='col-md-4'>
		     <h4 style='z-index: 5;
	            margin-top:2px; color: #009688;'><?php echo ucwords($row2[17]); ?></h4>				
		   </div> 
		  <div class='col-md-5' style='z-index:1;margin-top:2px;'>
		  <div style=''>
		  <?php
		    $q_request="select * from friend_request where(sender_id='$row[0]' and destination_id='$id') or(sender_id='$id' and destination_id='$row[0]')";
			$res=mysqli_query($con,$q_request) or exit($q_request);
			$result=mysqli_fetch_row($res);
			$count_status=mysqli_num_rows($res);
			if($count_status==0)
			{
			  echo "<button class='btn btn-primary' style='background:#009688;'>Send request</button>";
			}
			else if($result[3]=='a')
			{
			 echo "<ul>
			 <li class='dropdown'>
					<a class='dropdown-toggle' data-toggle='dropdown' href='#' style='color: white;'><button class='btn btn-primary' style='background:#009688;'>friend<span class='caret'></span></button></a>
					<ul class='dropdown-menu'>
					<h5 style='padding: 10px;'>
					  <li><a href='user.php?user=$id&status=unfriend'>Unfriend</a></li>
					  <li><a href='user.php?user=$id&status=block'>Block</a></li>";				  
					echo"</ul>";	
			}
			else if($result[3]=='p')
			{
			  if($result[1]==$row[0]){
				echo "<button class='btn btn-primary' style='background:#009688;'>cancel request</button>";  
			  }
			  if($result[2]==$row[0]){
			  echo "<ul>
			 <li class='dropdown'>
					<a class='dropdown-toggle' data-toggle='dropdown' href='#' style='color: white;'><button class='btn btn-primary' style='background:#009688;'>Respond to request<span class='caret'></span></button></a>
					<ul class='dropdown-menu'>
					<h5 style='padding: 10px;'>
				<li><a href='#'>Accept Request</a></li>
					 <li><a href='#'>Cancel Request</a></li>
			  </ul>";	}	
			}
		
            echo"<a  href='message.php?user=$row2[0]'><button class='btn btn-primary' style='background:#009688;'>Message</button></a>";
			echo"<a  href='user.php?timeline=$row2[0]'><button class='btn btn-primary' style='background:#009688;'>Timeline</button></a>";?>
			</div></div></div>
		</div>
		
		<?php
	  if($result[3]=='a'){
		echo "<div class='box' style='background: #e4d6d6;'>
	               <form action='' method='POST' enctype='multipart/form-data'>
				     <div class='panel-group' id='accordion1'>
		   <div class='panel panel-default' style='border:none;'>
		   <a data-toggle='collapse' data-parent='#accordion1' href='#audio'><button class='btn btn-primary' style='background:#009688;'>Add Photo</button></a>
		   <a data-toggle='collapse' data-parent='#accordion1' href='#video'><button class='btn btn-primary' style='background:#009688;'>Add video</button></a>
		     <div id='audio' class='collapse'><input type='file' name='image'></div>
			 <div id='video' class='collapse' style='padding: 10px;'><h5>
			 <h6 style='color:red'>Only Youtube Embed Url Are Valid To Post</h6>
			 Video Url:-<input type='text' name='video' placeholder='URL' style='width:90%;border-radius:2px; height:25px;'></h5></div></div></div>
			       <div style='margin-top: 5px;'>
		           <textarea id='editor' name='check' > your friends timeline show's here........
			      </textarea>
				   </div></br>
				    <input type='submit' name='submit_post_timeline' class='btn btn-info' value='post' style='float: right;background:#009688;''>"; 
                if(!empty($_POST['submit_post_timeline']))
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
				
		$w= "insert into post_detail values('','$row[0]','".str_replace("'","\'",$event)."','$location','$video_url','$id',now())";
		mysqli_query($con,$w) or exit($w);
				}
				  
	  echo "</div> </form>";}
	  if(!empty($_GET['timeline']))
	  {
	$q2="select *,DATE(post_date)-DATE(now()) from post_detail where user_id='$id'or timeline='$id' ORDER BY Sno desc;";
	$res2=mysqli_query($con,$q2)or exit("error in query2");
	echo "here";
	  }	  
	  
	  
	  
	  
	  
	  
	  
	  
			  ?>
		
		
		
		
		
		
		
		
		
		</div>
		
	
	<div class='col-md-3' style='padding:2px;'>
	     <?php
			echo "<div class='' style='background:#e4d6d6;border-radius:10px;padding:5px;'>
		    <h3>Friends</h3>";
			   $select_friend="select* from friends where user_id1='$id' or user_id2='$id'";
			   $result_friend=mysqli_query($con,$select_friend)or exit($select_friend);
			    $count_friend=mysqli_num_rows($result_friend);
				if($count_friend==0)
				{
					echo "no friend now";
				}
			   while($friends=mysqli_fetch_array($result_friend))
			   {  
		           if($friends[1]==$id)
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
			 $q_block="select * from block_table where (user_id='$val' and block_id='$res[0]') or(user_id='$res[0]' and block_id='$val')";
				   $res_block=mysqli_query($con,$q_block) or exit($q_block);
				   $count_b=mysqli_num_rows($res_block);
             if($count_b==1){
			echo "<img src='$res[13]' style='width:70px; height:70px;margin:3px;cursor:not-allowed;'>";	
			 }else{		
			 echo "<a href='user.php?user=$res[0]'><img src='$res[13]' style='width:70px; height:70px;margin:3px;'></a>";}
                   				   
			   }   			   
		  echo "</div>";
		  echo"<div class='col-md-12' style='background:#e4d6d6;border-radius:10px;margin-top:5px;'><div  id='people' class='box' style='background: #e4d6d6; margin-top: 5px;'>";
             echo "<h3>People You May Know</h3>";					 
		        while($row3=mysqli_fetch_array($res_people))
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
					 <a href='user.php?user=$id&friend_id=$row3[0]'><button class='btn btn-primary btn-xs' style='background:#009688;'>Add Friend</button></a>
					 </div>
                    </div>	";
				   }}			   
}?>
			
	</div></div>
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