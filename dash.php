<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Online examiner</title>
<link  rel="stylesheet" href="css/bootstrap.min.css"/>
 <link  rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
 <link rel="stylesheet" href="css/main.css">
 <link  rel="stylesheet" href="css/font.css">
 <script src="js/jquery.js" type="text/javascript"></script>

  <script src="js/bootstrap.min.js"  type="text/javascript"></script>
 	<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>

<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>


</head>

<body  style="background:#eee;">
<div class="header">
<div class="row">
<div class="col-lg-6">
</div>
<?php
 include_once 'dbConnection.php';
session_start();
$courseId=$_SESSION['courseId'];
  if(!(isset($_SESSION['courseId']))){
header("location:index.php");

}
else
{
$name = $_SESSION['name'];

include_once 'dbConnection.php';
echo '<span class="pull-right top title1" ><span class="log1"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;&nbsp;Hello,</span> <a href="dash.php" class="log log1">'.$name.'</a>&nbsp;|&nbsp;<a href="logout.php?q=dash.php" class="log"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;Signout</button></a></span>';
}?>

</div></div>
<!-- admin start-->

<!--navigation menu-->
<nav class="navbar navbar-default title1">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="dash.php?q=0"><b>Dashboard - COURSE</b></a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li <?php if(@$_GET['q']==0) echo'class="active"'; ?>><a href="dash.php?q=0">Home<span class="sr-only">(current)</span></a></li>
        <li <?php if(@$_GET['q']==1) echo'class="active"'; ?>><a href="dash.php?q=1">Scores</a></li>  
		    <li <?php if(@$_GET['q']==2) echo'class="active"'; ?>><a href="dash.php?q=2">Ranking</a></li>
		<!---- <li <?php if(@$_GET['q']==3) echo'class="active"'; ?>><a href="dash.php?q=3">Feedback</a></li>  ---->
        <li class="dropdown <?php if(@$_GET['q']==4 || @$_GET['q']==5) echo'active'; ?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Quiz<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="dash.php?q=4">Add Quiz</a></li>
            <li><a href="dash.php?q=5">Remove Quiz</a></li>
          </ul>
        </li>
        <li <?php if(@$_GET['q']==6) echo'class="active"'; ?>><a href="dash.php?q=6">Add Student</a></li>  
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<!--navigation menu closed-->
<div class="container"><!--container start-->
<div class="row">
<div class="col-md-12">
<!--home start-->

<?php if(@$_GET['q']==0) {

$result = mysqli_query($con,"SELECT * FROM quiz where courseId='$courseId' ORDER BY date DESC"); 
// or die('Error');
if (!$result) {
      printf("Error: %s\n", mysqli_error($con));
      exit();
    }
echo  '<div class="panel"><table class="table table-striped title1">
<tr><td><b>S.N.</b></td><td><b>Topic</b></td><td><b>Total question</b></td><td><b>Marks</b></td><td><b>positive</b></td><td><b>negative</b></td><td><b>Time limit</b></td><td><b>Edit</b></td></tr>';
$c=1;
while($row = mysqli_fetch_array($result)) {
	$title = $row['title'];
	$total = $row['total'];
	$correct = $row['correct'];
  $wrong = $row['wrong'];
  $time = $row['time'];
	$eid = $row['eid'];


	echo '<tr><td>'.$c++.'</td><td>'.$title.'</td><td>'.$total.'</td><td>'.$correct*$total.'</td><td>'.$correct.'</td><td>'.$wrong.'</td><td>'.$time.'&nbsp;min</td><td><a title="Edit" href="dash.php?q=7&editQuiz='.$eid.'"><b><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></b></a></td>
	</tr>';
}

$c=0;
echo '</table></div>';

}



//score details
if(@$_GET['q']== 1) 
{
  $q=mysqli_query($con,"SELECT distinct q.eid,q.title,u.name,u.college,h.score,h.date from user u,history h,quiz q where q.courseId='$courseId' and q.eid=h.eid and h.userId=u.userId order by q.eid DESC");
  // or die('Error197');
  if (!$q) {
      printf("Error: %s\n", mysqli_error($con));
      exit();
    }
//$q=mysqli_query($con,"SELECT * FROM history WHERE email='$email' ORDER BY date DESC " )or die('Error197');
echo  '<div class="panel title">
<table class="table table-striped title1" >
<tr style="color:black"><td><b>S.N.</b></td><td><b>Title</b></td><td><b>Name</b></td><td><b>College</b></td><td><b>Score<b></td><td><b>Date</b></td>';
$c=0;
while($row=mysqli_fetch_array($q) )
{
$title=$row['title'];
$name=$row['name'];
$college=$row['college'];
$score=$row['score'];
$date=$row['date'];
echo '<tr><td>'.++$c.'</td><td>'.$title.'</td><td>'.$name.'</td><td>'.$college.'</td><td>'.$score.'</td><td>'.$date.'</td></tr>';
}

//$q23=mysqli_query($con,"SELECT title FROM quiz WHERE  eid='$eid' " )or die('Error208');
//while($row=mysqli_fetch_array($q23) )
//{
//$title=$row['title'];
//}
//$c++;
//echo '<tr><td>'.$c.'</td><td>'.$title.'</td><td>'.$qa.'</td><td>'.$r.'</td><td>'.$w.'</td><td>'.$s.'</td></tr>';
//}
echo'</table></div>';
}


//ranking start
if(@$_GET['q']== 2) 
{
$q=mysqli_query($con,"SELECT * FROM `rank`  ORDER BY score DESC " );
// or die('Error223');
echo  '<div class="panel title">
<table class="table table-striped title1" >
<tr><td><b>Rank</b></td><td><b>Name</b></td><td><b>College</b></td><td><b>Score</b></td></tr>';
$c=0;
while($row=mysqli_fetch_array($q) )
{
$e=$row['userId'];
$s=$row['score'];
$q12=mysqli_query($con,"SELECT * FROM user WHERE userId='$e' " );
// or die('Error231');
while($row=mysqli_fetch_array($q12) )
{
$name=$row['name'];
$college=$row['college'];
}
$c++;
echo '<tr><td style="color:#99cc32"><b>'.$c.'</b></td><td>'.$name.'</td><td>'.$college.'</td><td>'.$s.'</td><td>';
}
echo '</table></div>';}

?>


<!--home closed-->
<!--users start-->



<!--user end-->

<!--feedback start-->

<!--feedback closed-->

<!--feedback reading portion start-->
<?php if(@$_GET['fid']) {
echo '<br />';
$id=@$_GET['fid'];
$result = mysqli_query($con,"SELECT * FROM feedback WHERE id='$id' ") ;
// or die('Error');
while($row = mysqli_fetch_array($result)) {
	$name = $row['name'];
	$subject = $row['subject'];
	$date = $row['date'];
	$date= date("d-m-Y",strtotime($date));
	$time = $row['time'];
	$feedback = $row['feedback'];
	
echo '<div class="panel"<a title="Back to Archive" href="update.php?q1=2"><b><span class="glyphicon glyphicon-level-up" aria-hidden="true"></span></b></a><h2 style="text-align:center; margin-top:-15px;font-family: "Ubuntu", sans-serif;"><b>'.$subject.'</b></h1>';
 echo '<div class="mCustomScrollbar" data-mcs-theme="dark" style="margin-left:10px;margin-right:10px; max-height:450px; line-height:35px;padding:5px;"><span style="line-height:35px;padding:5px;">-&nbsp;<b>DATE:</b>&nbsp;'.$date.'</span>
<span style="line-height:35px;padding:5px;">&nbsp;<b>Time:</b>&nbsp;'.$time.'</span><span style="line-height:35px;padding:5px;">&nbsp;<b>By:</b>&nbsp;'.$name.'</span><br />'.$feedback.'</div></div>';}
}?>
<!--Feedback reading portion closed-->

<!--add quiz start-->
<?php
if(@$_GET['q']==4 && !(@$_GET['step']) ) {
echo ' 
<div class="row">
<span class="title1" style="margin-left:40%;font-size:30px;"><b>Enter Quiz Details</b></span><br /><br />
 <div class="col-md-3"></div><div class="col-md-6">   <form class="form-horizontal title1" name="form" action="update.php?q=addquiz"  method="POST">
<fieldset>


<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="name"></label>  
  <div class="col-md-12">
  <input id="name" name="name" placeholder="Enter Quiz title" class="form-control input-md" type="text">
    
  </div>
</div>



<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="right"></label>  
  <div class="col-md-12">
  <input id="right" name="right" placeholder="Enter marks on right answer" class="form-control input-md" min="0" type="number">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="wrong"></label>  
  <div class="col-md-12">
  <input id="wrong" name="wrong" placeholder="Enter minus marks on wrong answer without sign" class="form-control input-md" min="0" type="number">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="time"></label>  
  <div class="col-md-12">
  <input id="time" name="time" placeholder="Enter time limit for test in minute" class="form-control input-md" min="1" type="number">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="tag"></label>  
  <div class="col-md-12">
  <input id="tag" name="tag" placeholder="Enter #tag which is used for searching" class="form-control input-md" type="text">
    
  </div>
</div>


<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="desc"></label>  
  <div class="col-md-12">
  <textarea rows="8" cols="8" name="desc" class="form-control" placeholder="Write description here..."></textarea>  
  </div>
</div>

<div class="form-group">
  <label>Allow Calculator</label>
  <input type="radio" id="Yes" name="calc" value=1>
  <label for="Yes">Yes</label>
  <input type="radio" id="No" name="calc" value=0>
  <label for="No">No</label><br>
</div>
<input id="courseId" name="cId" class="form-control input-md" type="hidden" value="'.$courseId.'">


<div class="form-group">
  <label class="col-md-12 control-label" for=""></label>
  <div class="col-md-12"> 
    <input  type="submit" style="margin-left:45%" class="btn btn-primary" value="Submit" class="btn btn-primary"/>
  </div>
</div>

</fieldset>
</form></div>';




}
?>
<!--add quiz end-->

<!--add quiz step2 start-->
<?php
if(@$_GET['q']==4 && (@$_GET['step'])==2 ) {
echo ' 
<div class="row">
<span class="title1" style="margin-left:40%;font-size:30px;"><b>Enter Question Details</b></span><br /><br />
 <div class="col-md-3"></div><div class="col-md-6"><form class="form-horizontal title1" name="form" action="update.php?q=addqns&n='.@$_GET['n'].'&eid='.@$_GET['eid'].'&ch=4 "  method="POST">
<fieldset>
';
 
 for($i=1;$i<=@$_GET['n'];$i++)
 {
echo '<b>Question number&nbsp;'.$i.'&nbsp;:</><br /><!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="qns'.$i.' "></label>  
  <div class="col-md-12">
  <textarea rows="3" cols="5" name="qns'.$i.'" class="form-control" placeholder="Write question number '.$i.' here..."></textarea>  
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="'.$i.'1"></label>  
  <div class="col-md-12">
  <input id="'.$i.'1" name="'.$i.'1" placeholder="Enter option a" class="form-control input-md" type="text">
    
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="'.$i.'2"></label>  
  <div class="col-md-12">
  <input id="'.$i.'2" name="'.$i.'2" placeholder="Enter option b" class="form-control input-md" type="text">
    
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="'.$i.'3"></label>  
  <div class="col-md-12">
  <input id="'.$i.'3" name="'.$i.'3" placeholder="Enter option c" class="form-control input-md" type="text">
    
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="'.$i.'4"></label>  
  <div class="col-md-12">
  <input id="'.$i.'4" name="'.$i.'4" placeholder="Enter option d" class="form-control input-md" type="text">
    
  </div>
</div>
<br />
<b>Correct answer</b>:<br />
<select id="ans'.$i.'" name="ans'.$i.'" placeholder="Choose correct answer " class="form-control input-md" >
   <option value="a">Select answer for question '.$i.'</option>
  <option value="a">option a</option>
  <option value="b">option b</option>
  <option value="c">option c</option>
  <option value="d">option d</option> </select><br /><br />'; 
 }
    
echo '<div class="form-group">
  <label class="col-md-12 control-label" for=""></label>
  <div class="col-md-12"> 
    <input  type="submit" style="margin-left:45%" class="btn btn-primary" value="Submit" class="btn btn-primary"/>
  </div>
</div>

</fieldset>
</form></div>';



}
?><!--add quiz step 2 end-->

<!--remove quiz-->
<?php if(@$_GET['q']==5) {

$result = mysqli_query($con,"SELECT * FROM quiz where courseId='$courseId' ORDER BY date DESC") or die('Error');
echo  '<div class="panel"><table class="table table-striped title1">
<tr><td><b>S.N.</b></td><td><b>Topic</b></td><td><b>Total question</b></td><td><b>Marks</b></td><td><b>Time limit</b></td><td></td></tr>';
$c=1;
while($row = mysqli_fetch_array($result)) {
	$title = $row['title'];
	$total = $row['total'];
	$correct = $row['correct'];
    $time = $row['time'];
	$eid = $row['eid'];
	echo '<tr><td>'.$c++.'</td><td>'.$title.'</td><td>'.$total.'</td><td>'.$correct*$total.'</td><td>'.$time.'&nbsp;min</td>
  <td><a title="Delete User" href="update.php?q=rmquiz&eid='.$eid.'"><b><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></b></a></td></tr>';
  
}
$c=0;
echo '</table></div>';

}
?>
<!-- remove quiz end -->


<!-- add student start -->
<?php
if(@$_GET['q']==6) {
echo ' 
<div class="row">
<span class="title1" style="margin-left:40%;font-size:30px;"><b>Enter Student Details</b></span><br /><br />
 <div class="col-md-3"></div><div class="col-md-6">   <form class="form-horizontal title1" name="form" action="assign.php?q=dash.php"  method="POST">
<fieldset>


<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="StudentEmail"></label>  
  <div class="col-md-12">
  <input id="StudentEmail" name="StudentEmail" placeholder="Enter email address of student" class="form-control input-md">
  </div>
</div>


<input name="course" type="hidden" value="'.$courseId.'">


<div class="form-group">
  <label class="col-md-12 control-label" for=""></label>
  <div class="col-md-12"> 
    <input  type="submit" style="margin-left:45%" class="btn btn-primary" value="Submit" class="btn btn-primary"/>
  </div>
</div>

</fieldset>
</form></div>';



}
?>
<!--add student end-->

<!--edit quiz start-->
<?php
if(@$_GET['editQuiz'] && !(@$_GET['step']) ) {
$eid=@$_GET['editQuiz'];
$result = mysqli_query($con,"SELECT * FROM quiz WHERE eid='$eid'");
while($row = mysqli_fetch_array($result)) {
  $title = $row['title'];
  $total = $row['total'];
  $correct = $row['correct'];
  $wrong = $row['wrong'];
  $time = $row['time'];
  $intro = $row['intro'];
  $tag = $row['tag'];
  $calc = $row['calculator'];
}
echo ' 
<div class="row">
<span class="title1" style="margin-left:40%;font-size:30px;"><b>Edit Quiz Details</b></span><br /><br />
 <div class="col-md-3"></div>
 <div class="col-md-6">
 <form class="form-horizontal title1" name="form" action="update.php?q=editquiz&total='.$total.'"  method="POST">
<fieldset>


<!-- Text input-->
<div class="form-group">
  <label class=" control-label" for="name">Quiz Title</label>  
  <div class="col-md-12">
  <input id="name" name="name" placeholder="Enter Quiz title" class="form-control input-md" type="text" value="'.$title.'">
    
  </div>
</div>





<!-- Text input-->
<div class="form-group">
  <label class=" control-label" for="right">Positive Marks for Correct Answer</label>  
  <div class="col-md-12">
  <input id="right" name="right" placeholder="Enter marks on right answer" class="form-control input-md" min="0" type="number" value="'.$correct.'">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class=" control-label" for="wrong">Negative Marks for Incorrect Answer (dont add minus sign)</label>  
  <div class="col-md-12">
  <input id="wrong" name="wrong" placeholder="Enter minus marks on wrong answer without sign" class="form-control input-md" min="0" type="number" value="'.$wrong.'">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class=" control-label" for="time">Maximum Test Duration</label>  
  <div class="col-md-12">
  <input id="time" name="time" placeholder="Enter time limit for test in minute" class="form-control input-md" min="1" type="number" value="'.$time.'">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class=" control-label" for="tag">Search Tag</label>  
  <div class="col-md-12">
  <input id="tag" name="tag" placeholder="Enter #tag which is used for searching" class="form-control input-md" type="text" value="'.$tag.'">
    
  </div>
</div>


<!-- Text input-->
<div class="form-group">
  <label class=" control-label" for="desc">Description and Instructions</label>  
  <div class="col-md-12">
  <textarea rows="8" cols="8" name="desc" class="form-control" placeholder="Write description here...">'.$intro.'</textarea>  
  </div>
</div>

<div class="form-group">
  <label>Allow Calculator</label>
  <input type="radio" id="Yes" name="calc" value=1 ';
  if($calc == 1) {
    echo 'checked = "checked"';
  }
  echo '>
  <label for="Yes">Yes</label>
  <input type="radio" id="No" name="calc" value=0 ';
  if($calc == 0) {
    echo 'checked = "checked"';
  }
  echo '>
  <label for="No">No</label><br>
</div>


<input id="courseId" name="courseId" class="form-control input-md" type="hidden" value="'.$courseId.'">
<input id="eid" name="eid" class="form-control input-md" type="hidden" value="'.$eid.'">


<div class="form-group">
  <label class=" control-label" for=""></label>
  <div class="col-md-12"> 
    <input  type="submit" style="margin-left:45%" class="btn btn-primary" value="Next" class="btn btn-primary"/>
  </div>
</div>

</fieldset>
</form></div>';
}


// edit step 2
if(@$_GET['q']==7 && (@$_GET['step'])==2 ) {

echo ' 
<div class="row">
<span class="title1" style="margin-left:40%;font-size:30px;"><b>Enter Question Details</b></span><br /><br />
<div class="col-md-3"></div>
<div class="col-md-6">
<form id="myform" class="form-horizontal title1 edit_q" name="form" action="update.php?q=editqns&eid='.@$_GET['eid'].'&ch=4 "  method="POST" enctype="multipart/form-data">
<fieldset>
';
 
$questions = mysqli_query($con, "SELECT * FROM questions WHERE eid='".@$_GET['eid']."'");
$i=1; 
while($row=mysqli_fetch_array($questions) )
{
    $qid=$row["qid"];
    $type=$row["type"];
    $qes = $row["qns"];
    
    $qes = str_replace("<","&lt",$qes);
    $qes = str_replace(">","&gt",$qes);
    echo '<b>Question '.$i.':</b>
    <a title="Delete Question" class="delete_q" onclick="deleteQues('.$qid.');" id='.$qid.'><b><span class="glyphicon glyphicon-trash del" aria-hidden="true" style="color:red;"></span></b></a>
    <br />
    
    <!-- Text input-->
    <div class="form-group">
      <label class=" control-label" for="qns'.$qid.' ">Write Question</label>  
      <div class="col-md-12">
      <textarea rows="3" cols="5" name="'.$qid.'" class="form-control" placeholder="Write question here...">'.$qes.'</textarea>  
      </div>
    </div>';
    if($type==="MCQ"){
    $options = mysqli_query($con, "SELECT * FROM options WHERE qid='$qid'");
    $option = array();
    while ($rowO = mysqli_fetch_array($options)){
      $option[] = $rowO; 
    }

    
    $opt1=$option[0]['option'];
    $opt1_id = $option[0]['optionid'];
    $opt2=$option[1]['option'];
    $opt2_id = $option[1]['optionid'];
    $opt3=$option[2]['option'];
    $opt3_id = $option[2]['optionid'];
    $opt4=$option[3]['option'];
    $opt4_id = $option[3]['optionid'];
    echo '<script>
              console.log("'.$opt1_id.'");
          </script>';
    $answer = mysqli_query($con, "SELECT * FROM answer WHERE qid='$qid'") or die("Error 59");
    while ($ans = mysqli_fetch_array($answer)){
      $ansid = $ans['ansid']; 
      $exp_text = $ans['exp_text'];
      $exp_img = $ans['exp_img'];
    }
    
    // $rowA=mysqli_fetch_assoc($answer);
    // $ansid = $row['ansid'];
    // $ansopt = mysqli_query($con, "SELECT * FROM options WHERE qid='$qid' AND optionid='$ansid'");
    // $rowAO = mysqli_fetch_assoc($ansopt);
    // $corrChoice = $rowAO['option'];
    
    $opt1 = str_replace('"','&#8220;',$opt1);
    $opt2 = str_replace('"','&#8220;',$opt2);
    $opt3 = str_replace('"','&#8220;',$opt3);
    $opt4 = str_replace('"','&#8220;',$opt4);
    $opt1 = str_replace("'",'&#8216;',$opt1);
    $opt2 = str_replace("'",'&#8216;',$opt2);
    $opt3 = str_replace("'",'&#8216;',$opt3);
    $opt4 = str_replace("'",'&#8216;',$opt4);
    
    echo '<script>
              console.log("'.$opt3.'");
          </script>';
    


    echo '
    
    

    <!-- Text input-->
    <div class="form-group">
      <label class=" control-label" for="'.$qid.'1">Option A</label>  
      <div class="col-md-12">
      <input id="'.$qid.'_1" name="'.$opt1_id.'" placeholder="Enter option a" class="form-control input-md" type="text" value="'.$opt1.'">
      </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
      <label class=" control-label" for="'.$qid.'2">Option B</label>  
      <div class="col-md-12">
      <input id="'.$qid.'_2" name="'.$opt2_id.'" placeholder="Enter option b" class="form-control input-md" type="text" value="'.$opt2.'">
      </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
      <label class=" control-label" for="'.$qid.'3">Option C</label>  
      <div class="col-md-12">
      <input id="'.$qid.'_3" name="'.$opt3_id.'" placeholder="Enter option c" class="form-control input-md" type="text" value="'.$opt3.'">
      </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
      <label class=" control-label" for="'.$qid.'4">Option D</label>  
      <div class="col-md-12">
      <input id="'.$qid.'4" name="'.$opt4_id.'" placeholder="Enter option d" class="form-control input-md" type="text" value="'.$opt4.'">
      </div>
    </div>
    <br />

    <b>Correct answer</b>:<br />
    <select id="ans'.$qid.'" name="'.$qid.'_a" placeholder="Choose correct answer " class="form-control input-md" >
    
       <option value="" disabled selected>Select correct option</option>
      <option value="'.$opt1_id.'" ';
      if($opt1_id == $ansid)
      {
        echo 'selected';
      }
      
      echo '>option a</option>
      <option value="'.$opt2_id.'" ';
      if($opt2_id == $ansid)
      {
        echo 'selected';
      }
      
      echo '>option b</option>
      <option value="'.$opt3_id.'" ';
      if($opt3_id == $ansid)
      {
        echo 'selected';
      }
      
      echo '>option c</option>
      <option value="'.$opt4_id.'" ';
      if($opt4_id == $ansid)
      {
        echo 'selected';
      }
      
      echo '>option d</option> </select><br /><br />'; 

    }
    else if($type ==="NAT")
    {
      
      
      $range = mysqli_query($con, "SELECT * FROM `range` WHERE qid='$qid' ")or die("Error 123456789");
      

      while($row1=mysqli_fetch_array($range) )
      {
        
        $from = $row1['range_from'];
        $to = $row1['range_to'];
        $exp_text = $row1['exp_text'];

      }
      
      
      echo '
      <div class="form-group">
      <label class="col-md-3 control-label" for="'.$qid.'1">Answer range</label>  
      <div class="col-md-4">
      <input id="'.$qid.'_from" name="'.$qid.'_from" placeholder="From" class="form-control input-md" type="text" value="'.$from.'">
      </div>
      <div class="col-md-4">
      <input id="'.$qid.'_to" name="'.$qid.'_to" placeholder="To" class="form-control input-md" type="text" value="'.$to.'">
      </div>
    </div>
      ';

    }

      echo '
      <div class="form-group">
      <label class=" control-label" for="qns'.$qid.' ">Write Explanation</label>  
      <div class="col-md-12">
      <textarea rows="3" cols="5" name="'.$qid.'_text" class="form-control" placeholder="Write explanation here...">'.$exp_text.'</textarea>  
      </div>
    </div>
     
    <div class="form-group">
      <label class=" control-label" for="qns'.$qid.' ">Input explanation image</label>  
      <div class="col-md-12">
      <input type="file" name="'.$qid.'_img" class="form-control">
      </div>
    </div>
    <br>
    <br>
    ';

    $i = $i+1;
}

    
echo '

<button type="button" class="btn btn-success" onclick="addMCQ();"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Add MCQ question</button>

<button type="button" class="btn btn-warning" onclick="addNAT();"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Add NAT question</button>
<br>
<br>
<div class="form-group">
  <label class=" control-label" for=""></label>
  <div class="col-md-12"> 
    <button style="margin-left:45%" class="btn btn-primary btn-lg" onclick="submitForm();">Submit</button>
  </div>
</div>

</fieldset>
</form></div>
';


}

?>
<!-- edit quiz end -->


<!-- alert message -->
<?php if (@$_GET['w']) {echo '<script>alert("' . @$_GET['w'] . '");</script>';}?>


<script>
  addMCQ = ()=>
  {
    <?php
    
    echo '
    
    document.getElementById("myform").action="update.php?q=editqns&eid='.@$_GET['eid'].'&ch=4&add=1&type=MCQ";
    document.getElementById("myform").submit();';
    ?>
  }

  addNAT = ()=>
  {
    <?php
    
    echo '
    
    document.getElementById("myform").action="update.php?q=editqns&eid='.@$_GET['eid'].'&ch=4&add=1&type=NAT";
    document.getElementById("myform").submit();';
    ?>
  }

  deleteQues = (qid)=>
  {
    <?php
    echo '
    document.getElementById("myform").action="update.php?q=editqns&eid='.@$_GET['eid'].'&ch=4&add=2&qid=${qid}";
    document.getElementById("myform").submit();';
    ?>
  }

  submitForm =()=>{
    document.getElementById("myform").submit();

  }
  
  
  document.addEventListener("click", e=>{
    console.log();
    if(e.target.classList.contains('del'))
    {
      console.log('Working');
      let id = e.target.parentNode.parentNode.getAttribute('id');
      <?php
    echo '
    window.location.href = `update.php?q=editquiz&step=3&n='.@$_GET['n'].'&eid='.@$_GET['eid'].'&qid=${id} `;';
    ?>
    e.preventDefault();
    }
    

    
  });
</script>


</div><!--container closed-->
</div></div>
</body>
</html>
