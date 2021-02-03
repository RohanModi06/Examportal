
<?php
include_once 'dbConnection.php';
$ref=@$_GET['q'];

$email = $_POST['StudentEmail'];

$course = $_POST['course'];

$user = mysqli_query($con,"SELECT * FROM user WHERE email='$email' " )or die('Error98');
$userRow = mysqli_fetch_array($user);
$userid = $userRow['userId'];


$check=mysqli_query($con,"SELECT * FROM assigned WHERE userId='$userid' AND courseId='$course'" )or die('Error98');
$rowcount=mysqli_num_rows($check);	

if($rowcount==0){
	$q=mysqli_query($con,"INSERT INTO assigned VALUES  ('$userid' , '$course')");
	header("location:$ref?w=Succesfully enrolled");
}
else{
	header("location:$ref?w=Student Already Enrolled");
}

?>