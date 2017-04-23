<html>
<head>
     <title>Profile</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<script src="ckeditor/ckeditor.js"></script>
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/home2.css">
	<link rel="stylesheet" type="text/css" href="css/profile.css">
		<script src='js/jquery-3.1.0.min.js'></script>
<script src='js/bootstrap.min.js' type='text/javascript'></script>
	<link rel='stylesheet' href='vlb_files1/vlightbox1.css' type='text/css' />
		<link rel='stylesheet' href='vlb_files1/visuallightbox.css' type='text/css' media='screen' />
<script src='vlb_engine/jquery.min.js' type='text/javascript'></script>
		<script src='vlb_engine/visuallightbox.js' type='text/javascript'></script>
</head>
<body>
<?php
include_once("connect.php");

if(!empty($_SESSION['admin']))
{   $val=$_SESSION['admin'];
	$q1="select * from user_detail where user_id='$val';";
	$res1=mysqli_query($con,$q1)or exit("error in query");
	$row=mysqli_fetch_row($res1);
	$q2="select * from post_detail where user_id='$val';";
	$res2=mysqli_query($con,$q2)or exit("error in query");
	$q3="select * from post_detail where user_id='$val' ORDER BY Sno desc;";
	$res3=mysqli_query($con,$q3)or exit("error in query");
    $q4="select * from user_detail where user_id!='$val';";
	$res4=mysqli_query($con,$q4)or exit($q4);
}
else{
	header("location:facebook.php");
    exit();
}
 if(!empty($_POST['fname']))
 {
	 $first_name=$_POST['fname'];
	 $last_name=$_POST['lname'];
	 $birth_day=$_POST['bday'];
	 $gender=$_POST['gender'];
	 $mobile_no=$_POST['mobileno'];
	 $hometown=$_POST['hometown'];
	 $current_city=$_POST['current_city'];
	 $status=$_POST['status'];
	 $about=$_POST['about'];
	 $nickname=$_POST['nickname'];
	 $image=$_FILES['profile_photo']['name'];
	  if(!empty($_FILES['profile_photo']['name']))
	  {
	  $tmp_name=$_FILES['profile_photo']['tmp_name'];
	  $location="profile_photo/".rand(0,500).$image;
	    move_uploaded_file($tmp_name, $location);
		        $info = getimagesize($location); 
				    if ($info['mime'] == 'image/jpeg') 
					$image = imagecreatefromjpeg($location); 
					elseif ($info['mime'] == 'image/gif') 
					$image = imagecreatefromgif($location); 
					elseif ($info['mime'] == 'image/png') 
					$image = imagecreatefrompng($location);
					imagejpeg($image,$location,20);
	  }
	  else
	  {
		  $location=$row[13];
	  }
	  $image1=$_FILES['cover_photo']['name'];
	  if(!empty($_FILES['cover_photo']['name']))
	  {
	  $tmp_name1=$_FILES['cover_photo']['tmp_name'];
	  $location1="cover_photo/".rand(0,500).$image1;
	  move_uploaded_file($tmp_name1,$location1);
	    $info = getimagesize($location1); 	
			   if ($info['mime'] == 'image/jpeg') 
			  $image = imagecreatefromjpeg($location1); 			
			  elseif ($info['mime'] == 'image/gif') 
			 $image = imagecreatefromgif($location1); 
			elseif ($info['mime'] == 'image/png') 
			$image = imagecreatefrompng($location1);
			imagejpeg($image,$location1,20);
	  }
	  else
	  {
	    $location1=$row[14];
	  }
	 $q4="update user_detail set 
	 first_name='$first_name',
	 last_name='$last_name',
	 birth_day='$birth_day',
	 gender='$gender',
	 mobile_no='$mobile_no',
	 hometown='$hometown',
	 current_city='$current_city',
	 relationship_status='$status',
	 about='$about',
	 profile_photo='$location',
	 cover_photo='$location1',
     Nickname='$nickname'	 where user_id=$row[0]";
	 mysqli_query($con,$q4)or exit($q4);
	 header('location:profile.php');
        exit();
 }
  include("user_header.php");
?>
<div class='container-fluid'>
<div class='row'>
<div class='col-md-7' style='padding:2px;'>
 <div class="about" style="width: 100%; height: 400px; background:#009688;margin-bottom: 60px;padding:2px;">
		   <img src='<?php echo $row[14];?>' style='width:100%; height: 100%;'>
		   <div class='row'>
		     <div class='col-md-1'>
			 </div>
		   <div class='col-md-2'>
		     <img src='<?php echo $row[13];?>' style='width:100px; height: 100px;  z-index:5; margin-top:-60px;'>
		   </div>
		   <div class='col-md-6'>
		     <h3 style='z-index: 5;text-align:left;
	            margin:0px;color:#009688;'><?php echo ucwords($row[17]); ?></h3>				
		   </div> 
		  </div>
		  <div style='float: right; margin-top:-35px;'>
		  <button class='btn btn-primary' style='background:#009688;'>Post</button>
		  <?php
		   
			?>
			</div>
		</div>
	<div class='row'>
	<div class='col-md-5' style='background:#e4d6d6;border-radius:10px;'>
			 <div class="box" style='background:#e4d6d6;border-radius:7px;'>
			 <h4>About</h4>
		      <?php
			   if(!empty($_GET['update']))
			   { 
			    echo "<form action='' method='post' enctype='multipart/form-data'>
				<div class='form-control' style='border:0;background:#e4d6d6;'>
				 <label>Name</label>
				 <input name='lname' placeholder='lastname' style='width:40%;border: 0;color:0277bd;border-bottom:1px solid #eee;float:right;' value=".$row[2]."></input>
				   <input name='fname'  placeholder='firstname' style='width:40%;border:0;color:0277bd;border-bottom:1px solid #eee;float:right;' value=".$row[1]."></input>
				   <label>Nickname</label>
				   <input name='nickname' placeholder='nickname' style='width:50%;border:0;float:right;color:0277bd;border-bottom:1px solid #eee' value=".$row[16]."></input></br>
				   <label>Birthday</label>
				   <input type='date' name='bday' placeholder='birthday' style='border:0;float:right;color:0277bd;border-bottom:1px solid #eee' value=".$row[3]."></input></br>
				   <label>Gender</label></br>
					<input type='radio' name='gender' value='male' checked style='color:0277bd;border-bottom:1px solid #eee'>Male</input>
					<input type='radio' name='gender' value='female' checked style='color:0277bd;border-bottom:1px solid #eee'>Female</input></br>
				    <label>Mobile no</label>
				   <input name='mobileno' placeholder='mobile number' size='' style=' width: 50%;border:0;float:right;color:0277bd;border-bottom:1px solid #eee' value='$row[5]' maxlength='10' minlength='10'></input></br>
				   <label>Hometown</label>
				   <input name='hometown' placeholder='hometown' size='' style=' width: 50%;border:0;float:right;color:0277bd;border-bottom:1px solid #eee' value=".$row[7]."></input></br>
				    <label>Current City</label>
				   <input name='current_city' placeholder='current_city' size='' style=' width: 50%;border:0;float:right;color:0277bd;border-bottom:1px solid #eee' value=".$row[8]."></input></br>
				   <label>Relationship Status</label></br>
			<input type='radio' name='status' value='Single' checked>Single</input>
			<input type='radio' name='status' value='Married' checked >Married</input></br>";
					echo"
				    <label>Profile Photo</label></br>
				   <input type='file' name='profile_photo' style='float: left;'>
				   <img src='".$row[13]."' style='width:40px; height:40px;clear: left'></br>
				   <label>Cover Photo</label></br>
				   <input type='file' name='cover_photo'  style='float: left;'>
				   <img src=".$row[14]." style='width:40px; height:40px;clear: left'></br>
				   <label>About</label>
				   <textarea  name='about' cols='' rows='5' style='width: 100%' value=".$row[10].">
				   </textarea>
				<button class='btn btn-info' type='submit' name='save'>Update</button></div>
				 </form>";
			   }
			   else
			   {
				 echo "<table cellpadding='5' cellspacing='0'>
				   <tr>
				   <th>Name</th>
				   <td>".ucwords($row[1])." ".ucwords($row[2])."</td>
				   </tr>
				   <th>Nickname</th>
				   <td>".ucwords($row[16])."</td>
				   </tr>
				   <tr>
				   <th>Birthday</th>
				   <td>".date_format(date_create($row[3]),'d-M-Y')."</td>
				   </tr>
				   <tr>
				   <th>Gender</th>
				   <td>".ucwords($row[4])."</td>
				   </tr>
				   <tr>
				   <th>Mobile no</th>
				   <td>".ucwords($row[5])."</td>
				   </tr>
				   <tr>
				   <th>Education</th>
				   <td>".ucwords($row[6])."</td>
				   </tr>
				   <tr>
				   <th>Hometown</th>
				   <td>".ucwords($row[7])."</td>
				   </tr>
				   <tr>
				   <th>Present city</th>
				   <td>".ucwords($row[8])."</td>
				   </tr>
				   <tr>
				   <th>Relationship status</th>
				   <td> ".ucwords($row[9])."</td>
				   </tr>
				   <tr>
				   <th>Language</th>
				   <td>".ucwords($row[10])."</td>
				   </tr>
				   <tr>
				   <th>Interest</th>
				   <td>".ucwords($row[11])."</td>
				   </tr>
				   <tr>
				   <th>About</th>
				   <td>".ucwords($row[12])."</td>
				   </tr>
				   <tr>
				   <th>Profile Photo</th>
				   <td><img src=".$row[13]." style='width: 30px; height: 30px'></img></td>
				   </tr>
				   <tr>
				   <th>Cover Photo</th>
				   <td><img src=".$row[14]." style='width:30px; height: 30px'></img></td>
				   </tr>
                 </table>
                  <h4><a href='profile.php?update=update' style='float: right;color:#009688;'><i class='fa fa-edit fa'>Edit</i></a></h4></br>"; 				 
			   }
			  ?>
		  </div> 
	</div>
	<div class='col-md-7' style='padding:2px;'>
	<div class="box" style="background:#e4d6d6;border-radius:7px;height:auto;">
		<h6 style='color:grey;float:right;'><i class='fa fa-edit'></i>what's on mind</h6>
	     <form action="home2.php" method="POST" enctype="multipart/form-data">
		    <div class="panel-group" id="accordion">
		   <div class="panel panel-default" style='border:none;background:#e4d6d6;'>
		   <a data-toggle="collapse" data-parent="#accordion" href="#audio"><button class="btn btn-primary" style='background:#009688;'>Add Photo</button></a>
		   <a data-toggle="collapse" data-parent="#accordion" href="#video"><button class="btn btn-primary" style='background:#009688;'>Add video</button></a>
		     <div id='audio' class='collapse'><input type='file' name='image'></div>
			 <div id='video' class='collapse'><h6 style='color:red'>Only Youtube Embed Url Are Valid To Post</h6>
			 Video Url:-<input type='' class='form-control' name='video' placeholder='URL' style='width:90%;border-radius:2px; height:25px;'></div></div></div>
		     <div style="margin-top: 5px;">
		        <textarea id='editor' style="width:100%;" rows="5" name='check'>your timeline show's here........
			    </textarea>
				</div></br>
				<input type="submit" name="submit" class="btn btn-info" value="post" style="float: right;background:#009688;" ></input>
			    </br></form>
		</div>
	</div>
	</div>
</div>
<div class="col-md-5">
<div class='about' style='background:#e4d6d6;padding:10px;margin-top:5px;border-radius:7px;'>
		    <h3>Album</h3>
</div>
<div class='about' style='background:#e4d6d6;padding:10px;margin-top:5px;border-radius:7px;'>
		    <h3>Gallery</h3>
			<?php
			$count_post=mysqli_num_rows($res2);
				if($count_post==0)
				{
				    echo "<h5 style='text-align:center'>No Post Yet</h5>";	
				}
				else{
			   while($post=mysqli_fetch_array($res2))
			   {   if(!empty($post[3]))
			      {
		echo"<a class='vlightbox1' href='vlb_images1/$post[3]'><img src='vlb_thumbnails1/$post[3]' style='width:20%; height:10%;'/></a>
	";
			      }	   
			   } 
echo "<script src='vlb_engine/vlbdata1.js' type='text/javascript'></script>";			   
			}			   
             ?>
		  </div>	
<div class='col-md-12' style='background:#e4d6d6;border-radius:7px; margin: 5px;'><?php
echo "<div class='box' style='background:#e4d6d6; margin: 2px;border-radius:7px;height:auto;'>";
			   $select_friend="select* from friends where user_id1='$val' or user_id2='$val'";
			   $result_friend=mysqli_query($con,$select_friend)or exit($select_friend);
			    $count_friend=mysqli_num_rows($result_friend);
				echo "<h3>Friends<span class='badge'>$count_friend</span></h3>";
				if($count_friend==0)
				{
					echo "no friend now";
				}
			   while($friends=mysqli_fetch_array($result_friend))
			   {  
		           if($friends[1]==$val)
				   {
					$query="select * from user_detail where user_id='$friends[2]'";
				   $result=mysqli_query($con,$query)or exit($query);}
				   else
				   {
					$query="select * from user_detail where user_id='$friends[1]'";
					$result=mysqli_query($con,$query)or exit($query);}
					$res=mysqli_fetch_row($result);
					echo "<div class='col-md-6' style='padding: 5px;'>
						  <img src='$res[13]' style='width:30%; height: 70px;'>
                      <div style='float: right; width:67%; height:50px'>						  
			         <h4 class='point' style='margin-top:-5px;'><a href='user.php?user=$res[0]' class='point' style='color:#009688;'>".ucwords($res[17])."</a></h4>
					 <h5>";
					 if(!empty($res[8]))
					{echo $res[8];}
				     else $res[7];
						 echo"</h5>
					 </div>
                    </div>";   				   
			   }   			   
		  echo "</div></div>"; ?>
		  <div class='col-md-12' style='background:#e4d6d6;border-radius:7px; margin: 5px;'>
<div id='people' class='box' style='background:#e4d6d6; margin-top: 2px;border-radius:7px;height:auto;'>
<?php
             echo "<h4>PEOPLE YOU MAY KNOW</h4>";
		        while($row4=mysqli_fetch_array($res4))
				{ 
			       $q_friend="select * from friend_request where (sender_id='$val' and destination_id='$row4[0]') or(sender_id='$row4[0]' and destination_id='$val')";
				   $res_friend=mysqli_query($con,$q_friend) or exit($q_friend);
				   $count=mysqli_num_rows($res_friend);
				   if($count==0)
				   {
			      echo "<div class='col-md-6' style='padding: 5px;'>
						  <img src='$row4[13]' style='width:30%; height: 70px;'>
                      <div style='float: right; width:67%; height:50px'>						  
			         <h4 class='point' style='margin-top:-5px;'><a href='user.php?user=$row4[0]' class='point' style='color:#009688;'>".ucwords($row4[17])."</a></h4>
					 <button id='send_request$row4[0]' class='btn btn-primary btn-xs' style='background:#009688;'>Add Friend</button>
					 </div>
                    </div>	";
				   }
echo "<script>
$(document).ready(function(){
$('#send_request$row4[0]').click(function(e){
e.preventDefault();
$.ajax({
type: 'POST',
url: 'buttons.php',
data: {friend_id:$row4[0]},
success: function(data)
{
$('#people').html(data);
}
});	
});	
});
</script>";				   
}?></div>
</div>		  
</div>
	
</div>
</div>
<?php
include("footer.php");
?>
<style>
iframe
{
	width:400px !important;
	height:400px !important;
}
</style>
</body>
</html>