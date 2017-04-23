<?php
include('connect.php');
if(!empty($_SESSION['super']))
{   $val=$_SESSION['super'];
	$q1="select * from user_detail where user_id='$val';";
	$res1=mysqli_query($con,$q1)or exit("error in query1");
	$row=mysqli_fetch_row($res1);
}
if(!empty($_POST['page_id']))
{
	$page_id=$_POST['page_id'];
	$q_page="select * from groups where sno='$page_id'";
	$res=mysqli_query($con,$q_page)or exit($q_page);
	$page=mysqli_fetch_row($res);
	echo "<h4><a href='admin_dashboard.php'>Dashborad</a>/<a href=''admin_pages.php>Pages</a>/$page[1]</h4>";
	echo "<div class='col-md-9'>
	<img src='$page[4]' style='width:60%;  height:40%;float:left;'>
	 <div  style='float:left; width:30%;'>
	 <h4>Description</h4>
	 $page[2]
	 <div class='dropdown' style='float:right'>
       <a href='#' class='dropdown-toggle' data-toggle='dropdown'><button class= 'btn btn-primary'>Setting<b class='caret'></b></button></a>
                    <ul class='dropdown-menu'>
                        <li>
                            <a href=''><i class='fa fa-fw fa-user'></i>Block</a>
                        </li>
                    </ul>
                </li></div></div>
	</div>
	<div class='col-md-3'>
	<h4>Members</h4>";
	$q_member="select * from pages_member where page_id='$page_id'";
	$r_member=mysqli_query($con,$q_member)or exit($q_member);
	while($member=mysqli_fetch_array($r_member))
	{
		 $q_user="select * from user_detail where user_id='$member[2]'";
	$res_user=mysqli_query($con,$q_user)or exit($q_user);
	$page_u=mysqli_fetch_row($res_user);
	  echo "<img src='$page_u[13]' style='width:50px;heigt:50px;'>";
	}
	echo "</div>";
}	
if(!empty($_POST['post_id'])){
	$post_id=$_POST['post_id'];
	$q_select_post="select * from post_detail where sno='$post_id'";
	$result= mysqli_query($con,$q_select_post) or exit($q_select_post);
	$row2=mysqli_fetch_row($result);
	$q4="select * from user_detail where user_id='$row2[1]';";
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
echo "<div class='col-md-12 box' style='background:#e4d6d6;outline-right:1px solid black;margin-top:4%;padding:5px;'>
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
                        </a>";
						echo "<a href='admin_post.php?post_delete=$row2[0]'><span TITLE='delete' class='fa fa-trash-o' style='float:right;color:#388e3c;'></span></a>";
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

if(!empty($_POST['user_id']))
{
$user_id=$_POST['user_id'];
$q_select_user="select * from user_detail where user_id='$user_id'";
	$result= mysqli_query($con,$q_select_user) or exit($q_select_user);
	$user_detail=mysqli_fetch_row($result);
	
	echo "<div class='col-md-4'>";
echo"<table class='table table-bordered table-hover table-striped'>";
					 echo "<tr>
					 <th>User_id</th>
					 <td>$user_detail[0]</td>
					 </tr>
					 <tr>
					 <th>First_name</th>
					 <td>$user_detail[1]</td>
					 </tr>
					 <tr>
					 <th>Last_name</th>
					 <td>$user_detail[2]</td>
					 </tr>
					 <tr>
					 <th>Birth_day</th>
					 <td>$user_detail[3]</td>
					 </tr>
					 <tr>
					 <th>Gender</th>
					 <td>$user_detail[4]</td>
					 </tr>
					 <tr>
					 <th>Mobile_no</th>
					 <td>$user_detail[5]</td>
					 </tr>
					 <tr>
					 <th>Education</th>
					 <td>$user_detail[6]</td>
					 </tr>
					 <tr>
					 <th>Hometown</th>
					 <td>$user_detail[7]</td>
					 </tr>
					 <tr>
					 <th>Current_city</th>
					 <td>$user_detail[8]</td>
					 </tr>
					 <tr>
					 <th>Status</th>
					 <td>$user_detail[9]</td>
					 </tr>
					 <tr>
					 <th>language</th>
					 <td>$user_detail[10]</td>
					 </tr>
					 <tr>
					 <th>interest</th>
					 <td>$user_detail[11]</td>
					 </tr>
					 <tr>
					 <th>about</th>
					 <td>$user_detail[12]</td>
					 </tr>
					 <tr>
					 <th>profile_photo</th>
					 <td>$user_detail[13]</td>
					 </tr>
					 <tr>
					 <th>cover_photo</th>
					 <td>$user_detail[14]</td>
					 </tr>";
}echo "</div>";?>