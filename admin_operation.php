<?php
include('connect.php');
if(!empty($_POST['id']))
{
	$id=$_POST['id'];
	echo $id;
}
?>