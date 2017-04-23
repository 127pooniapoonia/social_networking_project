 <nav>
 <div class='dashboard'>
 <h3><?php echo"WELCOME</br>".$row[1]." ".$row[2];?></h3>
 <hr>
 <ul>
 <h4><li><a href='admin.php?student=student'><i class="fa fa-home"> Home</i></a></li>
		  <li><a id='posts'><i class="fa fa-sign-out"> Posts</i></a></li>
		  <li><a href='admin.php?student=student'><i class="fa fa-sign-out"> Media</i></a></li>
		  <li><a href='admin.php?student=studen'><i class="fa fa-sign-out"> Pages</i></a></li>
		  <li><a href='admin.php?student=student'><i class="fa fa-sign-out"> Comments</i></a></li>
		  <li><a href='admin.php?student=student'><i class="fa fa-sign-out"> Plugins</i></a></li>
		  <li><a id='users'><i class="fa fa-sign-out"> Users</i></a></li>
		  <li><a href='admin.php?student=student'><i class="fa fa-sign-out"> Tools</i></a></li>
		  <li><a href='admin.php?student=student'><i class="fa fa-sign-out"> Settings</i></a></li>
		  <li><a href='admin.php?logout=logout'><i class="fa fa-sign-out"> Logout</i></a></li></h4>
 </ul>
 </div>
 </nav>
 <script>
 $(document).ready(function(){
$('#posts').click(function(e) {	
e.preventDefault();
$.ajax({
type: 'POST',
url: 'admin_panel.php',
data: {posts:'post'},
success: function(data)
{
$('#post').html(data);
}
});
 });
 $('#users').click(function(e) {	
e.preventDefault();
$.ajax({
type: 'POST',
url: 'admin_panel.php',
data: {users:'user'},
success: function(data)
{
$('#post').html(data);
}
});
 });
 });
</script> 
 
 
 
 
 
 
 
