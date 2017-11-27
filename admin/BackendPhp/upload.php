<?php
//upload.php
if($_FILES["file"]["name"] != '')
{
  $text = $_POST['text'];
 $test = explode('.', $_FILES["file"]["name"]);
 $ext = end($test);
 $name = $text . '.' . $ext;
 $location = '../../img/' . $name;
 move_uploaded_file($_FILES["file"]["tmp_name"], $location);
 echo $name;
}
?>
