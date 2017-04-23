<?php
if (file_exists($_FILES["upload"]["name"]))
{
 echo $_FILES["upload"]["name"] . " already exists please choose another image.";
}
else
{
	$rand=rand(0,100000);
	$rand2=rand(0,10000);
	$rand3=rand(0,10000);
	$name=$rand3.$rand2.$rand.$_FILES["upload"]["name"];
	$location="upload/".$name;
	$tmp_name=$_FILES["upload"]["tmp_name"];
 	move_uploaded_file($tmp_name,$location);
   	function compresss($source, $destination, $quality) 
				{	
					$info = getimagesize($source); 
					
					if ($info['mime'] == 'image/jpeg') 
					$image = imagecreatefromjpeg($source); 
					elseif ($info['mime'] == 'image/gif') 
					$image = imagecreatefromgif($source); 
					elseif ($info['mime'] == 'image/png') 
					$image = imagecreatefrompng($source); 
					imagejpeg($image, $destination, $quality); 
					return $destination; 
				}
				$source_img="upload/".$name;
				$destination_img="upload/".$name;
	$d=compresss($source_img, $destination_img, 100);

   
   
   
 	echo "Stored in: " . $_FILES["upload"]["name"];
 // Required: anonymous function reference number as explained above.
$funcNum = $_GET['CKEditorFuncNum'] ;
// Optional: instance name (might be used to load a specific configuration file or anything else).
$CKEditor = $_GET['CKEditor'] ;
// Optional: might be used to provide localized messages.
$langCode = $_GET['langCode'] ;
 
// Check the $_FILES array and save the file. Assign the correct path to a variable ($url).
$url ="upload/". $name;
$u=$_FILES["upload"]["name"];
// Usually you will only assign something here if the file could not be uploaded.
$message = '';
 
echo "<script type='text/javascript'> window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";

}
?>