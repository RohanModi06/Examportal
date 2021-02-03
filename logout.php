<?php 
session_start();
if(isset($_SESSION['userId']) or isset($_SESSION['courseId']) or isset($_SESSION['email'])){
session_destroy();}
$ref= @$_GET['q'];
header("location:$ref");
?>