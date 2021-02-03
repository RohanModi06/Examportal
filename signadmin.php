
<?php
include_once 'dbConnection.php';
$ref=@$_GET['q'];
//$name = $_POST['name'];
//$name= ucwords(strtolower($name));
//$gender = $_POST['gender'];
$email = $_POST['email'];

$password = $_POST['password'];
$name = $_POST['name'];



$q=mysqli_query($con,"INSERT INTO admin VALUES  ('$email' ,'$name', '$password' )");


header("location:$ref?q=Succesfully registered");


?>