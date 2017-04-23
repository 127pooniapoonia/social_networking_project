
  <div class="about" style="background:#e4d6d6; margin-top: 10px;border-radius:10px;;height:auto;padding:10px;margin-right:0;">
<style>
a{color:#009688;}
</style>
  <?php
define("URL","http://localhost/linkzone/social%20networking/");
$select_friend="select* from friends where user_id1='$val' or user_id2='$val'";
$result_friend=mysqli_query($con,$select_friend)or exit($select_friend);
$count_friend=mysqli_num_rows($result_friend);
$q_likedgroups="select * from pages_member where member_id='$val'";
$result_liked=mysqli_query($con,$q_likedgroups)or exit($q_likedgroups);
$count_page=mysqli_num_rows($result_liked);
$q_msg="select * from message where destination_id='$val' and status='s' group by sender_id";
$result_msg=mysqli_query($con,$q_msg)or exit($q_msg);
$count_msg=mysqli_num_rows($result_msg);
echo "<div class='' style='align:center;'> 
<a href='user.php?user=$row[0]'><img src='$row[13]' style='width:100%; height: 100%' class='profile'></a>		  
</div>";
echo "<a href='home2.php?profile=username'><h3 style='text-align:center;color:#009688;'>".ucwords($row[17])."</h3></a>";
 echo "<ul style='color:#009688;'>
<h4>
<li><a  class='fa fa-home' href='homepage'> Home</a></li>
<li><a class='fa fa-user-plus' href='friends'> Friends <span class='badge' style='float:right'>$count_friend</span></a></li>
<li><a class='fa fa-inbox' href='message'> Messages <span class='badge' style='float:right'>$count_msg</span></a></li>
<li><a class='fa fa-users' href='pages'> Pages <span class='badge' style='float:right'>$count_page</span></a></li>
<li><a  class='fa fa-pencil-square-o' href='post'> Post</a></li>
<li><a href='home2.php?logout1=logout1'><i class='fa fa-sign-out fa-rotate-180'></i> logout</a></li></h4>
</ul>";
?>	
 </div>