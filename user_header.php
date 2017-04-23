<script src='js/bootstrap.min.js' type='text/javascript'></script>
<script src="js/jquery-3.1.0.min.js"></script>
<style>
.header{background:#009688;}
</style>
<?php
$q_notific="select * from  notification where (user_id='$val' or reply_id='$val') and status='n'";
$r_notific=mysqli_query($con,$q_notific) or exit($q_notific);
$count_notif=mysqli_num_rows($r_notific);
?>
<nav class="navbar" style='background:#009688;'>
<div class='container-fluid'>
			<div class="header">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar" style='color:white'>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span> 
					</button>
				</div>
				<div class='row'>
				<div class='col-md-2' style='margin-top:-20px'>
		          <h3 style='color: white;'><label>LinkZone</label><h3>
				</div>
				<div class='col-md-4' style=''>
				<form action='message.php' method='post' enctype=''>
<input type='text' name='search' placeholder="Search Friends and Pages" onkeyup="showresult(this.value)" class='form-control'>
<input style='display:none' type='submit'value='submit'>
</form><div id='livesearch' style='width:93%; background:white; z-index:10; position:absolute; border-radius:2px; box-shadow:0px 0px 5px  grey;'></div>
				</div>
				<div class='col-md-6' style='margin-top:-20px;'>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav1 navbar-nav navbar-right" style='margin-right: 100px;'>
				<li><a href='home2.php?profile=username' class="fa fa-user" style="color: white;">
					 <?php echo ucwords($row[17])?>
					</a></li>
				 <li><a  class='fa fa-home' href='home2.php' style="color: white;"> Home</a></li>
<li id='check_try'><a class='fa fa-bell' style="color: white;" href='home2.php?updates=up'>Notification <span class="badge" style='background-color:white;color:#009688;'><?php if($count_notif!=0){echo $count_notif; }?></span></a>
</li>
<li><a href="settings.php" class='fa fa-gear' style='color:white'>Settings</a></li>
                  <li><a class="fa fa-sign-out" style="color: white;" href="home2.php?logout1=logout1">LogOut</a></li>
				</ul>
			</div>
			</div>

			</div></div>
			</div>
		</nav>		
		<?php echo "<script>
		$('document').ready(function(){
			$('#check_try').mouseover(function(){
		   $('#show').css('display','block');
			});
			$('#check_try').mouseleave(function(){
		   $('#show').css('display','none');
			});
		});</script>";?>
		<?php
echo "<div id='today' style='z-index:11;position:absolute;display:none;'>";		
  $q_friend="select * from friends where user_id1='$val' or user_id2='$val'";
  $r_friend=mysqli_query($con,$q_friend)or exit($q_friend);
  echo "<div style='padding:5%;'>";
  while($result=mysqli_fetch_array($r_friend))
  {
	  if($result[1]==$val)
	  {
		$q_select_f="select *,CURDATE() from user_detail where user_id='$result[2]'";  
	  }
     else
	 {
      $q_select_f="select *,CURDATE() from user_detail where user_id='$result[1]'";}
      $r_select_f=mysqli_query($con,$q_select_f)or exit($q_select_f);
      $res_f=mysqli_fetch_row($r_select_f);
      $dob=$res_f[3];
      $current= $res_f[20];		  
     $user_dob=explode("-",$dob);
     $new_dob=explode("-",$current);
     $user_date=$user_dob[2];
     $user_month=$user_dob[1];
     $new_date=$new_dob[2];	 
     $new_month=$new_dob[1];
     if(($new_date==$user_date)&&($new_month==$user_month))
     {
	   echo "<h6>today's Birthday $res_f[17]</h6>";
	 }
else{echo "bhjdbhfbjhfbjfbdjbfjd";}	 
  }echo "</div></div>";	  ?></script><script>		
		  function showresult(str)
		  {
			  if (str.length==0) { 
            document.getElementById("livesearch").innerHTML="";
            document.getElementById("livesearch").style.border="0px";
            return;
          }
		  if (window.XMLHttpRequest) {
			xmlhttp=new XMLHttpRequest();
		  } else {  
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		  xmlhttp.onreadystatechange=function() {
			if (this.readyState==4 && this.status==200) {
			  document.getElementById("livesearch").innerHTML=this.responseText;
			  document.getElementById("livesearch").style.border="1px solid #A5ACB2";
			}
		  }
		  xmlhttp.open("GET","comment.php?q="+str,true);
		  xmlhttp.send();
		  }
		</script>