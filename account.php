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
 <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
 <script src="js/jquery.js" type="text/javascript"></script>


  <script src="js/bootstrap.min.js"  type="text/javascript"></script>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  

<script>
         //function that display value
         function dis(val)
         {
             document.getElementById("result").value+=val
         }

         //function that evaluates the digit and return result
         function solve()
         {
             let x = document.getElementById("result").value
             let y = eval(x)
             document.getElementById("result").value = y
         }

         //function that clear the display
         function clr()
         {
             document.getElementById("result").value = ""
         }

     
         
      </script>
<style>

        

         .title{
         margin-bottom: 10px;
         text-align:center;
         width: 210px;
         color:green;
         border: solid black 2px;
         }

         

        .bg {
          display: block;
          padding: 15px;
          float: left;
          width: 100%;
          /* width: calc(100% - 350px); */
        }
        .calc-button{
          margin-top: 9px;
          height:35px;
          width: 35px;
          display: none;
        }

      </style>



<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
 <!--alert message-->
<?php if (@$_GET['w']) {echo '<script>alert("' . @$_GET['w'] . '");</script>';}
?>
<!--alert message end-->

</head>
<?php
include_once 'dbConnection.php';
?>
<body>
<div class="header">
<div class="row" style="background-color:#f4511e;">
<div class="col-lg-6" >
<span class="logo"></span></div>
<div class="col-md-4 col-md-offset-2">
 <?php
include_once 'dbConnection.php';
session_start();
if (!(isset($_SESSION['userId']))) {
    header("location:index.php");

} else {
    $name = $_SESSION['name'];
    $email=$_SESSION['email'];
    $uid = $_SESSION['userId'];

    include_once 'dbConnection.php';
    echo '<span class="pull-right top title1" ><span class="log1"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;&nbsp;Welcome,</span> <a href="account.php?q=1" class="log log1">' . $name . '</a>&nbsp;|&nbsp;<a href="logout.php?q=account.php" class="log"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;Signout</button></a></span>';
}?>
</div>
</div></div>
<div class="bg">

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
      <a class="navbar-brand" href="account.php?q=1"><b>Dashboard - Student</b></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->


    
  
  
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

    <?php
  if (@$_GET['q'] != 'quiz' || @$_GET['step'] != 2)
  {
     echo  '<ul class="nav navbar-nav navbar left">
        <li ';
         if (@$_GET['q'] == 1) {
    echo 'class="active"';
}
echo '
 >


<a href="account.php?q=1"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;Home<span class="sr-only">(current)</span></a></li>
        <li '; 
        if (@$_GET['q'] == 2) {
    echo 'class="active"';
}
echo '>
<a href="account.php?q=2"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp;History</a></li>
    <li ';
    if (@$_GET['q'] == 3) {
    echo 'class="active"';
}
echo '><a href="account.php?q=3"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span>&nbsp;Ranking</a></li>
  


  </ul>';
  }

?>
<button class="button calc-button mt-5 pull-right" aria-hidden="true" onclick="toggleSidebar()"><i class="fas fa-calculator"></i></button>
      </div><!-- /.navbar-collapse -->
      
  </div><!-- /.container-fluid -->
</nav><!--navigation menu closed-->
<div class="container"><!--container start-->
<div class="row">
<div class="col-md-12">






<!--home start-->
<?php if (@$_GET['q'] == 1) {
    // $result = mysqli_query($con, "SELECT * FROM quiz WHERE  ORDER BY date DESC") or die('Connection Error');

    $q = mysqli_query($con, "SELECT * FROM assigned  WHERE userId = $uid");
    if (!$q) {
      printf("Error: %s\n", mysqli_error($con));
      exit();
    }
    //  or die('Connection Error');
    while($ci = mysqli_fetch_array($q))
    {
      $cid = $ci['courseId'];
      
      $q1 = mysqli_query($con, "SELECT courseName FROM  course WHERE courseId = '$cid'");
      while($cn = mysqli_fetch_array($q1))
    {
      $cname= $cn['courseName'];
    }
    $result = mysqli_query($con, "SELECT * FROM quiz WHERE courseId = '$cid' ORDER BY date DESC"); 
    // or die('Connection Error');
    if (!$result) {
      printf("Error: %s\n", mysqli_error($con));
      printf($cid);
      exit();
    }
    
    echo '<div class="panel">
    <h2>'.$cname.'</h2>
    <table class="table table-striped title1">
<tr style="color:black"><td><b>S.N.</b></td><td><b>Topic</b></td><td><b>Total question</b></td><td><b>Marks</b></td><td><b>positive</b></td><td><b>negative</b></td><td><b>Time limit</b></td><td></td><td></td></tr>';
    $c = 1;
    while ($row = mysqli_fetch_array($result)) {
        $title = $row['title'];
        $total = $row['total'];
        $sahi = $row['correct'];
        $wrong = $row['wrong'];
        $time = $row['time'];
        $eid = $row['eid'];
        // $id = $row['id'];
        $q12 = mysqli_query($con, "SELECT score FROM history WHERE eid='$eid' AND userId='$uid'") or die('Error98');
        $rowcount = mysqli_num_rows($q12);
        if ($rowcount == 0) {
            echo '<tr><td>' . $c++ . '</td><td>' . $title . '</td><td>' . $total . '</td><td>' . $sahi * $total . '</td><td>' . $sahi . '</td><td>' . $wrong . '</td><td>' . $time . '&nbsp;min</td>
  <td><a title="Open quiz description" href="account.php?q=1&fid=' . $eid . '"><b><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span></b></a></td>
  <td><b><a href="account.php?q=quiz&step=2&eid=' . $eid . '&n=1&t=' . $total . '&timer=1" class="pull-right btn sub1" style="margin:0px;background:#99cc32"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Start</b></span></a></b></td></tr>';
        } else {
            echo '<tr style="color:#99cc32"><td>' . $c++ . '</td><td>' . $title . '&nbsp;<span title="This quiz is already solve by you" class="glyphicon glyphicon-ok" aria-hidden="true"></span></td><td>' . $total . '</td><td>' . $sahi * $total . '</td><td>' . $sahi . '</td><td>' . $wrong . '</td><td>' . $time . '&nbsp;min</td><td></td><td><b>
            
            <a href="account.php?q=quiz&step=3&eid=' . $eid . '&n=1&t=' . $total . '" class="btn pull-right sub1
            " role="button" aria-pressed="true" style="margin:0px;background:#99cc32;width:160px;"><span class="glyphicon glyphicon-check" aria-hidden="true"></span>&nbsp;<span class="title1"><b>View Solution</b></span></a></b>

            
            </td>
  </tr>';
        }
    }
    $c = 0;
    echo '</table></div>';
  }

}?>
<!----quiz reading portion starts--->

<?php if (@$_GET['fid']) {
    echo '<br />';
    $eid = @$_GET['fid'];
    $result = mysqli_query($con, "SELECT * FROM quiz WHERE eid='$eid' ") or die('Error');
    while ($row = mysqli_fetch_array($result)) {
        // $name = $row['name'];
        $title = $row['title'];
        $date = $row['date'];
        $date = date("d-m-Y", strtotime($date));
        //$time = $row['time'];
        $intro = $row['intro'];

        echo '<div class="panel"<a title="Back to Archive" href="update.php?q1=2"><b><span class="glyphicon glyphicon-level-up" aria-hidden="true"></span></b></a><h2 style="text-align:center; margin-top:-15px;font-family: "Ubuntu", sans-serif;"><b>' . $title . '</b></h1>';
        echo '<div class="mCustomScrollbar" data-mcs-theme="dark" style="margin-left:10px;margin-right:10px; max-height:450px; line-height:35px;padding:5px;"><span style="line-height:35px;padding:5px;">-&nbsp;<b>DATE:</b>&nbsp;' . $date . '</span>
<span style="line-height:35px;padding:5px;"></span><br />' . $intro . '</div></div>';}
}?>


<!--home closed-->

<!--quiz start-->
<?php
if (@$_GET['q'] == 'quiz' && @$_GET['step'] == 2) {
  
    $eid = @$_GET['eid'];
    $sn = @$_GET['n'];
    $total = @$_GET['t'];
    $q = mysqli_query($con, "SELECT * FROM quiz WHERE eid='$eid'") or die('Error6969');
    
    while($row = mysqli_fetch_array($q))
    {
      $time = $row['time'];
    }
    
    if (@$_GET['timer'] == 1)
    {
      $_SESSION['time'] = time() + $time*60;
    }
    

    echo '<script>
              console.log('.$time.');
          </script>';
    $q = mysqli_query($con, "SELECT * FROM questions WHERE eid='$eid' AND sn='$sn' ");
    echo '<div class="panel" style="margin:5%">';
    while ($row = mysqli_fetch_array($q)) {
        $qns = $row['qns'];
        $qid = $row['qid'];
        $type = $row['type'];
        $qns = str_replace("<","&lt",$qns);
        $qns = str_replace(">","&gt",$qns);
        echo '<b>Question &nbsp;' . $sn . '&nbsp;::<br />' . $qns . '</b><br /><br />';
    }
    if($type === 'MCQ')
    {
    $q = mysqli_query($con, "SELECT * FROM options WHERE qid='$qid' ");

    echo '<form   class="form-horizontal">
<br />';

    while ($row = mysqli_fetch_array($q)) {
        $option = $row['option'];
        $option = str_replace("<","&lt",$option);
        $option = str_replace(">","&gt",$option);
        $optionid = $row['optionid'];
        echo '<input type="radio" id="' . $optionid . '"  name="ans" value="' . $optionid . '" onchange="handleClick(this);" class="radio-btn">  ' . $option . ' <br /><br />';
    }
    echo '<br /></form>';

    echo '
      <button class="btn btn-warning" onclick="clearOption()">Clear option</button>
      <br>
      <br>
    ';
  }
  else if($type === 'NAT'){
      echo '
      <br>
      <div id="pinpad">
      <form >
        <input type="text" name="ans" id="password" style="margin-left:20px" onkeyup="keyUp(this)" value="';
      if(isset($_COOKIE[$qid])&&$_COOKIE[$qid]!=='unset') echo $_COOKIE[$qid];
      echo '" step=".001" > <br />
        <input type="button" value="1" id="1" class="pinButton calc"/>
        <input type="button" value="2" id="2" class="pinButton calc"/>
        <input type="button" value="3" id="3" class="pinButton calc"/><br>
        <input type="button" value="4" id="4" class="pinButton calc"/>
        <input type="button" value="5" id="5" class="pinButton calc"/>
        <input type="button" value="6" id="6" class="pinButton calc"/><br>
        <input type="button" value="7" id="7" class="pinButton calc"/>
        <input type="button" value="8" id="8" class="pinButton calc"/>
        <input type="button" value="9" id="9" class="pinButton calc"/><br>
        <input type="button" value="clear" id="clear" class="pinButton clear"/>
        <input type="button" value="0" id="0 " class="pinButton calc"/>
        <input type="button" value="." id="." class="pinButton calc"/>
      </form>
    </div>
    <br>';
  }


    if($sn!=1){
    echo '<button class="btn btn-primary" style="margin-right:10px;" onclick="previousQuestion();"><span  aria-hidden="true">&laquo;</span>&nbsp;Previous</button>';
    }
    if($sn!=$total){
    echo '<button class="btn btn-primary" onclick="nextQuestion();">&nbsp;Next <span  aria-hidden="true">&raquo;</span></button>';
    }

    echo '</div>
  <div class="panel card" style="margin:5%;">
  <div class="card-body">
    <h3 class="time"> Time left: <span class="timer"></span></h3>
    <h3 class="card-title">Questions</h5>
    <ul class="pagination">
    ';
    $q = mysqli_query($con, "SELECT * FROM questions WHERE eid='$eid' ORDER BY sn ASC");
    $num = mysqli_num_rows($q);

    while($row = mysqli_fetch_array($q))
    {
      echo '<li class="page-item"><a class="page-link ';
      if(isset($_COOKIE[$row['qid']])){
        if($_COOKIE[$row['qid']]==='unset'){
          echo 'unanswered';
        }
        else{
          echo 'answered';
        }
      }
      echo'" href="account.php?q=quiz&step=2&eid='.$eid.'&n='.$row['sn'].'&t='.$total.'">'.$row['sn'].'</a></li>';
    }
    
    echo '
  </ul>
    <br>

    <a href="update.php?q=quiz&step=2&eid='.$eid.'&t='.$total.'" class="btn btn-danger  active" role="button" aria-pressed="true"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span>&nbsp;Submit Quiz</a>

    
  
  </div>
</div>
  ';

    echo '
    <script>
    let btns = document.getElementsByClassName("radio-btn");
    let val = null;';
    if(isset($_COOKIE[$qid])&&$_COOKIE[$qid]!=='unset') 
    {
      echo 'val = "'.$_COOKIE[$qid].'";';
    }
    else
    {
      setcookie($qid, 'unset');
      
      echo 'document.cookie = `'.$qid.'= unset`;';
    }
    
    echo '
    Array.from(btns).forEach(btn=>{
      if(val === btn.value){
        btn.checked= "checked";
      }
    });
    function nextQuestion(){
      console.log("Working");
      window.location.href = "account.php?q=quiz&step=2&eid='.$eid.'&n='.++$sn.'&t='.$total.'";
    }
    function previousQuestion(){
      console.log("Working");
      
      window.location.href = "account.php?q=quiz&step=2&eid='.$eid.'&n='.($sn-=2).'&t='.$total.'";
    }
    function handleClick(myRadio) {
      console.log("Yesss");
      document.cookie = `'.$qid.'= ${myRadio.value}`;
      
    }
    function keyUp(e) {
      console.log("Yesss");
      if(e.value !== "")
      document.cookie = `'.$qid.'= ${e.value}`;
      else 
      document.cookie = `'.$qid.'= unset`;
    }
    function clearOption(){
      
      Array.from(btns).forEach(btn=>{
        // console.log(btn.checked);
      if(btn.checked === true){
        btn.checked= false;
        console.log(btn.checked);
      }
    });
      // document.querySelector("#'.$_COOKIE[$qid].'").checked = false;
      document.cookie = `'.$qid.'= unset`;
      
    }

    


    var countDownDate = '.$_SESSION['time'].' * 1000;
var now = '.time().' * 1000;
var distance = countDownDate - now;
// Time calculations for days, hours, minutes and seconds
var days = Math.floor(distance / (1000 * 60 * 60 * 24));
var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
var seconds = Math.floor((distance % (1000 * 60)) / 1000);
// Output the result in an element with id="demo"
document.querySelector(".timer").innerHTML = hours + "h " +
minutes + "m " + seconds + "s ";

// Update the count down every 1 second
var x = setInterval(function() {
now = now + 1000;
// Find the distance between now an the count down date
var distance = countDownDate - now;
// Time calculations for days, hours, minutes and seconds
var days = Math.floor(distance / (1000 * 60 * 60 * 24));
var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
var seconds = Math.floor((distance % (1000 * 60)) / 1000);
// Output the result in an element with id="demo"
document.querySelector(".timer").innerHTML = hours + "h " +
minutes + "m " + seconds + "s ";
// If the count down is over, write some text 
if (distance < 0) {
clearInterval(x);
 document.querySelector(".timer").innerHTML = "Timeout";
 window.location.href = "update.php?q=quiz&step=2&eid='.$eid.'&t='.$total.'";
}
    
}, 1000);

  
    </script>';


}



if (@$_GET['q'] == 'quiz' && @$_GET['step'] == 3) {
    $eid = @$_GET['eid'];
    $sn = @$_GET['n'];
    $total = @$_GET['t'];
    $q = mysqli_query($con, "SELECT * FROM questions WHERE eid='$eid'");
    $num = mysqli_num_rows($q);
    // printf($num);
    echo '<script>
              console.log('.$num.');
          </script>';
    $q = mysqli_query($con, "SELECT * FROM questions WHERE eid='$eid' AND sn='$sn' ");
    echo '<div class="panel" style="margin:5%">';
    while ($row = mysqli_fetch_array($q)) {
        $qns = $row['qns'];
        $qid = $row['qid'];
        $type = $row['type'];
        $qns = str_replace("<","&lt",$qns);
        $qns = str_replace(">","&gt",$qns);
        echo '<b>Question &nbsp;' . $sn . '&nbsp;::<br />' . $qns . '</b><br /><br />';
    }

    if($type === 'MCQ'){

    $q = mysqli_query($con, "SELECT * FROM answer WHERE qid='$qid' ");
    while ($row = mysqli_fetch_array($q)) {
        $ans = $row['ansid'];
        $exp_text = $row['exp_text'];
        $exp_img = base64_encode($row['exp_img']);
    }
    echo '<script>console.log("'.$ans.'");</script>';

    $q = mysqli_query($con, "SELECT * FROM options WHERE qid='$qid' ");

    echo '<form   class="form-horizontal">
<br />';

    while ($row = mysqli_fetch_array($q)) {
        $option = $row['option'];
        $option = str_replace("<","&lt",$option);
        $option = str_replace(">","&gt",$option);
        $optionid = $row['optionid'];
        echo '<input type="radio" name="ans" value="' . $optionid . '" class="radio-ans"';
        
        
        echo 'disabled>  <label ';
         if($ans == $optionid)
        {
          echo 'style="color:green;" ';
        }
        echo '><strong>' . $option . '</strong></label> <br /><br />';
        echo '<script>console.log("'.$optionid.'");</script>';
    }
    echo '<br /></form>';
    if($sn!=1){
    echo '<button class="btn btn-primary mr-3" style="margin-right:10px;" onclick="previousAns();"><span  aria-hidden="true">&laquo;</span>&nbsp;Previous</button>';
    }
    if($sn!=$total){
    echo '<button class="btn btn-primary" onclick="nextAns();">&nbsp;Next <span  aria-hidden="true">&raquo;</span></button>';
    }

    echo '
      <br><br>
      <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    Explanation
  </button>

<div class="collapse" id="collapseExample">
  <div class="panel panel-body well" style="margin:10px">
  <br>
    <p style="margin-left:5%">'.$exp_text.'</p>
    <br>
    <img src="data:image/jpg;charset=utf8;base64,'.$exp_img.'" style="width:90%;display: block;margin-left: auto;margin-right: auto;"  > 
  </div>
</div>
    ';
  }
  else if($type ==='NAT'){

    $q = mysqli_query($con, "SELECT * FROM `range` WHERE qid='$qid' ");
    while ($row = mysqli_fetch_array($q)) {
        $from = $row['range_from'];
        $to = $row['range_to'];
        $exp_text = $row['exp_text'];
        $exp_img = base64_encode($row['exp_img']);
    }
    
    echo '<form   class="form-horizontal">
<br />

        <label for="ans">Answer range:</label>
        <input type="text" name="ans" id="password" style="margin-left:20px" onkeyup="keyUp(this)" value="'.$from.' to '.$to.'" step=".001" style="color:green;" disabled>
        
      
    <br /></form>
    <br>
    <br>';
    if($sn!=1){
    echo '<button class="btn btn-primary mr-3" style="margin-right:10px;" onclick="previousAns();"><span  aria-hidden="true">&laquo;</span>&nbsp;Previous</button>';
    }
    if($sn!=$total){
    echo '<button class="btn btn-primary" onclick="nextAns();">&nbsp;Next <span  aria-hidden="true">&raquo;</span></button>';
    }

    echo '
      <br><br>
      <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    Explanation
  </button>

<div class="collapse" id="collapseExample">
  <div class="panel panel-body well" style="margin:10px">
  <br>
    <p style="margin-left:5%">'.$exp_text.'</p>
    <br>
    <img src="data:image/jpg;charset=utf8;base64,'.$exp_img.'" style="width:90%;display: block;margin-left: auto;margin-right: auto;"  > 
  </div>
</div>
    ';

  }

    echo '</div>
  <div class="panel card" style="margin:5%;">
  <div class="card-body">
    <h3 class="card-title">Questions</h5>
    <ul class="pagination">
    ';
    $q = mysqli_query($con, "SELECT * FROM questions WHERE eid='$eid'");
    $num = mysqli_num_rows($q);
    for($i=1;$i<=$num;$i++)
    {
      echo '<li class="page-item"><a class="page-link" href="account.php?q=quiz&step=3&eid='.$eid.'&n='.$i.'&t='.$total.'">'.$i.'</a></li>';
    }
    
    echo '
  </ul>
    <br>    
  
  </div>
</div>
  ';

    echo '
    <script>
    let btns = document.getElementsByClassName("radio-btn");
    let val = null;';
    if(isset($_COOKIE[$qid])) 
    {
      echo 'val = "'.$_COOKIE[$qid].'";';
    }
    
    echo '
    Array.from(btns).forEach(btn=>{
      if(val === btn.value){
        btn.checked= "checked";
      }
    });


    function nextAns(){
      console.log("Working");
      window.location.href = "account.php?q=quiz&step=3&eid='.$eid.'&n='.++$sn.'&t='.$total.'";
    }
    function previousAns(){
      console.log("Working");
      
      window.location.href = "account.php?q=quiz&step=3&eid='.$eid.'&n='.($sn-=2).'&t='.$total.'";
    }
    function handleClick(myRadio) {
      console.log("Yesss");
      document.cookie = `'.$qid.'= ${myRadio.value}`;
      
    }
    </script>';

}

if (@$_GET['q'] == 'result' && @$_GET['eid']) {
    $eid = @$_GET['eid'];
    $qa = @$_GET['t'];

    

    $q = mysqli_query($con, "SELECT * FROM history WHERE eid='$eid' AND userId='$uid' ") or die('Error157');
        echo '<div class="panel">
    <center><h1 class="title" style="color:#660033">Result</h1><center><br /><table class="table table-striped title1" style="font-size:20px;font-weight:1000;">';

        while ($row = mysqli_fetch_array($q)) {
            $s = $row['score'];
            $w = $row['wrong'];
            $r = $row['correct'];
            $u = $row['unattempted'];
            
            echo '<tr style="color:#66CCFF"><td>Total Questions</td><td>' . $qa . '</td></tr>
          <tr style="color:#99cc32"><td>right Answer&nbsp;<span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span></td><td>' . $r . '</td></tr>
        <tr style="color:red"><td>Wrong Answer&nbsp;<span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></td><td>' . $w . '</td></tr>
        <tr style="color:blue"><td>Unattempted&nbsp;<span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></td><td>' . $u . '</td></tr>
        <tr style="color:#66CCFF"><td>Score&nbsp;<span class="glyphicon glyphicon-star" aria-hidden="true"></span></td><td>' . $s . '</td></tr>
        ';
        }
        // $q = mysqli_query($con, "SELECT * FROM rank WHERE  email='$email' ") or die('Error157');
        // while ($row = mysqli_fetch_array($q)) {
        //     $s = $row['score'];
        //     echo '<tr style="color:#990000"><td>Overall Score&nbsp;<span class="glyphicon glyphicon-stats" aria-hidden="true"></span></td><td>' . $s . '</td></tr>';
        // }
        // echo '</table></div>';

        echo '</center><br><a href="account.php?q=quiz&step=3&eid=' . $eid . '&n=1&t=' . $qa . '" class="btn sub1 pull-left" role="button" aria-pressed="true" style="background:#99cc32;width:160px;"><span class="glyphicon glyphicon-check" aria-hidden="true"></span>&nbsp;<span class="title1"><b>View Solution</b></span></a>';

    
}


?>


<!--quiz end-->
<?php
//history start
if (@$_GET['q'] == 2) {
    $q = mysqli_query($con, "SELECT * FROM history WHERE userId='$uid' ORDER BY date DESC ") or die('Error197');
    echo '<div class="panel">
<table class="table table-striped title1" >
<tr style="color:black"><td><b>S.N.</b></td><td><b>Quiz</b></td><td><b>Total Questions</b></td><td><b>Right</b></td><td><b>Wrong<b></td><td><b>Unattempted<b></td><td><b>Score</b></td>';
    $c = 0;
    while ($row = mysqli_fetch_array($q)) {
        $eid = $row['eid'];
        $s = $row['score'];
        $w = $row['wrong'];
        $t = $row['total'];
        $r = $row['correct'];
        $u = $row['unattempted'];
        
        $q23 = mysqli_query($con, "SELECT title FROM quiz WHERE  eid='$eid' ") or die('Error208');
        while ($row = mysqli_fetch_array($q23)) {
            $title = $row['title'];
        }
        $c++;
        echo '<tr><td>' . $c . '</td><td>' . $title . '</td><td>' . $t . '</td><td>' . $r . '</td><td>' . $w . '</td><td>' . $u . '</td><td>' . $s . '</td></tr>';
    }
    echo '</table></div>';
}

//ranking start
if (@$_GET['q'] == 3) {
    $q = mysqli_query($con, "SELECT * FROM `rank`  ORDER BY score DESC ");
// or die('Error223');
    echo '<div class="panel">
    <h4 ><b>Your Rank: <span id="rank"></span><b></h4>
    <br>
<table class="table table-striped title1" >
<tr style="color:black"><td><b>Rank</b></td><td><b>Name</b></td><td><b>College</b></td><td><b>Score</b></td></tr>';
    $c = 0;
    $rank;
    while ($row = mysqli_fetch_array($q)) {
        $u = $row['userId'];
        $s = $row['score'];
        $q12 = mysqli_query($con, "SELECT * FROM user WHERE userId='$u' ") or die('Error231');
        while ($row = mysqli_fetch_array($q12)) {
            $name = $row['name'];
            
            $college = $row['college'];
        }
        $c++;
        echo '<tr><td style="color:#99cc32"><b>' . $c . '</b></td><td>' . $name . '</td><td>' . $college . '</td><td>' . $s . '</td><td>';
        if($uid == $u)
        {
          $rank = $c;
        }
    }
    echo '</table></div>
    <script>
    document.querySelector("#rank").textContent = '.$rank.';
    </script
    
    
    ';}
?>

</div></div></div>


</div>

<?php
if (@$_GET['q'] == 'quiz' && @$_GET['step'] == 2) {
  $eid = @$_GET['eid'];
  $q = mysqli_query($con,"SELECT calculator FROM quiz WHERE eid='$eid' ");
  // echo($q);
  $calc;
  while ($row = mysqli_fetch_array($q)) {
  $calc = $row['calculator'];
  
  }
  if($calc == 1)
  {
    echo
    
        '
        <style>
        
        
        .calc-button{
          
          display: block;
        }
        </style>
<script>
        
    function toggleSidebar(){
      
      myWindow = window.open("https://www.tcsion.com/OnlineAssessment/ScientificCalculator/Calculator.html#nogo", "Calculator", "width=480, height=350");    // Opens a new window
  // myWindow.document.write("<p>This is myWindow</p>");       
    }

    
    </script>
        

';

  }
  
    echo '
    <script>
    $(document).ready(function () {
  const input_value = $("#password");

  //disable input from typing
  //add password
  $(".calc").click(function () {
    let value = $(this).val();
    field(value);
  });
  function field(value) {
    // input_value.val(input_value.val() + value);
    document.querySelector("#password").value= input_value.val() + value;
    document.cookie = `'.$qid.'= ${input_value.val()}`;
  }
  $("#clear").click(function () {
    input_value.val("");
    document.cookie = `'.$qid.'= unset`;
  });
  
});
</script>';
  }

?>


</body>
</html>