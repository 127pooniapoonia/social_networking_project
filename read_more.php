<?php
if(!empty($_POST['view']))
{
$msg=$_POST['view'];
$id=$_POST['id'];
echo "<h6>".$msg."</h6>";
echo "<h6 id='read' style='color:blue'>...read less</h6>";
}
if(!empty($_POST['view_less']))
{
$msg=$_POST['view_less'];
$id=$_POST['id'];
  if (strlen($msg) >120) {

    // truncate string
    $stringCut = substr($msg, 0,120);

    // make sure it ends in a word so assassinate doesn't become ass...
    $msg1 = substr($stringCut, 0, strrpos($stringCut, ' '))."<a id='read1' style='color:blue'>...read more</a>";	
   }
   echo "</h6>".$msg1."</h6>";
}
echo "<script>
$(document).ready(function(){
$('#read').click(function(e){
e.preventDefault();
$.ajax({
type: 'POST',
url: 'read_more.php',
data: {view_less:'$msg',id:'$id'},
success: function(data)
{
$('#full$id').html(data);
}
});	
});	
});
</script>";
echo "<script>
$(document).ready(function(){
$('#read1').click(function(e){
e.preventDefault();
$.ajax({
type: 'POST',
url: 'read_more.php',
data: {view:'$msg',id:'$id'},
success: function(data)
{
$('#full$id').html(data);
}
});	
});	
});
</script>";
?>