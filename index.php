<?php
include_once 'class.php';
$blaze = new Blaze( 'DATABASEUSER', 'PASS', 'DATABASENAME' );

if(Blaze::IsPost("submit")){
   $field_1 = Blaze::GetPostKey('input1');
   echo Blaze::GetPostArray();
   echo '<br>';
   echo "Input 1: " . $field_1;
}

?>

<form method="post">
  <input type="text" name="input1" value="Text"><br>
  <input name="submit" id="submit" type="submit" value="Submit">
</form>