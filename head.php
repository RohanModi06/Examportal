<?php
include_once 'dbConnection.php';
$ref=@$_GET['q'];
$email = $_POST['email'];
$password = $_POST['password'];



$result = mysqli_query($con,"SELECT * FROM admin WHERE email = '$email' and password = '$password'") or die('Connection Error');
$count=mysqli_num_rows($result);
if($count==1){
	session_start();
	if(isset($_SESSION['email'])){session_unset();}
	while($row = mysqli_fetch_assoc($result)){
		$_SESSION["name"] = $row['name'];
		$_SESSION["email"] = $email;
	}
	header("location:headdash.php?q=0");
}
else header("location:$ref?w=Warning : Access denied");
?>
