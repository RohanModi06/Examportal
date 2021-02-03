<?php
session_start();
if(isset($_SESSION["email"])){
session_destroy();
}
include_once 'dbConnection.php';
$ref=@$_GET['q'];
$email = $_POST['email'];
$password = $_POST['password'];

$password=md5($password); 
$result = mysqli_query($con,"SELECT name,userId FROM user WHERE email = '$email' and password = '$password'") or die('Error');
$count=mysqli_num_rows($result);
$name;$userId;
if($count==1){
while($row = mysqli_fetch_array($result)) {
	$name = $row['name'];
	$userId = $row['userId'];
}
echo '<script>
              console.log('.$userId.');
          </script>';
$_SESSION["name"] = $name;
$_SESSION["userId"] = $userId;
header("location:account.php?q=1&uid='$userId'");
}
else
header("location:$ref?w=Wrong Username or Password");


?>