<?php
include_once 'dbConnection.php';
$ref=@$_GET['q'];
$courseId = $_POST['courseId'];
$password = $_POST['password'];


$result = mysqli_query($con,"SELECT * FROM course WHERE courseId = '$courseId' and password = '$password'") or die('Error');
$count=mysqli_num_rows($result);
if($count==1){
session_start();
if(isset($_SESSION['courseId']) or isset($_SESSION['email'])){
session_unset();}
$row=$result -> fetch_array();
$_SESSION["name"] = $row['courseName'];
$_SESSION["courseId"] = $courseId;
header("location:dash.php?q=0");
}
else header("location:$ref?w=Warning : Access denied");
?>