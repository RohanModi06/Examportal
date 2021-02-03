<?php
include_once 'dbConnection.php';
session_start();

$uid = $_SESSION['userId'];
//delete feedback

if(@$_GET['fdid'] ) {
$id=@$_GET['fdid'];
$result = mysqli_query($con,"DELETE FROM feedback WHERE id='$id' ") or die('Error');
header("location:headdash.php?q=3");
}


//delete user

if(@$_GET['duid'] ) {
$userId=@$_GET['duid'];
printf($duid);
$r1 = mysqli_query($con,"DELETE FROM `rank` WHERE userId='$userId' ") or die('Error');
$r2 = mysqli_query($con,"DELETE FROM history WHERE userId='$userId' ") or die('Error');
$result = mysqli_query($con,"DELETE FROM user WHERE userId='$userId' ") or die('Error');
header("location:headdash.php?q=1");
}


//delete admin


if(@$_GET['demail1'] ) {
$demail1=@$_GET['demail1'];

$result = mysqli_query($con,"DELETE FROM admin WHERE email='$demail1'") or die('Error');
header("location:headdash.php?q=5");
}




//remove quiz

if(@$_GET['q']== 'rmquiz') {
$eid=@$_GET['eid'];
$result = mysqli_query($con,"SELECT * FROM questions WHERE eid='$eid'") or die('Error');
while($row = mysqli_fetch_array($result)) {
	$qid = $row['qid'];
$r1 = mysqli_query($con,"DELETE FROM options WHERE qid='$qid'") or die('Error');
$r2 = mysqli_query($con,"DELETE FROM answer WHERE qid='$qid' ") or die('Error');
}
$r3 = mysqli_query($con,"DELETE FROM questions WHERE eid='$eid' ") or die('Error');
$r4 = mysqli_query($con,"DELETE FROM quiz WHERE eid='$eid' ") or die('Error');
$r4 = mysqli_query($con,"DELETE FROM history WHERE eid='$eid' ") or die('Error');

header("location:dash.php?q=5");
}


//add quiz

if(@$_GET['q']== 'addquiz' ) {
$name = $_POST['name'];
$name= ucwords(strtolower($name));

$correct = $_POST['right'];
$wrong = $_POST['wrong'];
$time = $_POST['time'];
$tag = $_POST['tag'];
$desc = $_POST['desc'];
$calc = $_POST['calc'];
$cId = $_POST['cId'];
$id=uniqid();
$q3=mysqli_query($con,"INSERT INTO quiz VALUES  ('$id','$name', '$correct' , '$wrong','0','$time' ,'$desc','$tag', NOW() ,'$cId', '$calc')");

header("location:update.php?q=editquiz&step=2&eid=$id&ch=4&type=MCQ ");
}



//add question

if(@$_GET['q']== 'addqns' ) {
$n=@$_GET['n'];
$eid=@$_GET['eid'];
$ch=@$_GET['ch'];

for($i=1;$i<=$n;$i++)
 {
 $qid=uniqid();
 $qns=$_POST['qns'.$i];
$q3=mysqli_query($con,"INSERT INTO questions VALUES  ('$eid','$qid','$qns' , '$ch' , '$i')");
  $oaid=uniqid();
  $obid=uniqid();
$ocid=uniqid();
$odid=uniqid();
$a=$_POST[$i.'1'];
$b=$_POST[$i.'2'];
$c=$_POST[$i.'3'];
$d=$_POST[$i.'4'];
$qa=mysqli_query($con,"INSERT INTO options VALUES  ('$qid','$a','$oaid')") or die('Error61');
$qb=mysqli_query($con,"INSERT INTO options VALUES  ('$qid','$b','$obid')") or die('Error62');
$qc=mysqli_query($con,"INSERT INTO options VALUES  ('$qid','$c','$ocid')") or die('Error63');
$qd=mysqli_query($con,"INSERT INTO options VALUES  ('$qid','$d','$odid')") or die('Error64');
$e=$_POST['ans'.$i];
switch($e)
{
case 'a':
$ansid=$oaid;
break;
case 'b':
$ansid=$obid;
break;
case 'c':
$ansid=$ocid;
break;
case 'd':
$ansid=$odid;
break;
default:
$ansid=$oaid;
}


$qans=mysqli_query($con,"INSERT INTO answer VALUES  ('$qid','$ansid')");

 }
header("location:dash.php?q=0");
}

if(@$_GET['q']== 'quiz' && @$_GET['step']== 2) {
$eid=@$_GET['eid'];

$total=@$_GET['t'];




  
  $q=mysqli_query($con,"INSERT INTO history VALUES('$uid','$eid','$total' ,'0','0','0','0',NOW())")or die('Error69');

    $q5 = mysqli_query($con, "SELECT qid,type FROM questions WHERE eid='$eid'")or die('Error69');
    while ($row = mysqli_fetch_array($q5)) {
        $qid = $row['qid'];
        $type = $row['type'];
        echo $_COOKIE[$qid];
        if($type === 'MCQ'){
        $q=mysqli_query($con,"SELECT * FROM answer WHERE qid='$qid' " )or die('Error70');
        while($row=mysqli_fetch_array($q) )
        {
        $ansid=$row['ansid'];
        }
        if($_COOKIE[$qid] == $ansid)
        {
          echo 1;
        $q=mysqli_query($con,"SELECT * FROM quiz WHERE eid='$eid' " )or die('Error71');
        while($row=mysqli_fetch_array($q) )
        {
        $correct=$row['correct'];
        }
        
        $q=mysqli_query($con,"SELECT * FROM history WHERE eid='$eid' AND userId='$uid' ")or die('Error115');

        while($row=mysqli_fetch_array($q) )
        {
        $s=$row['score'];
        $r=$row['correct'];
        }
        $r++;
        $s=$s+$correct;
        $q=mysqli_query($con,"UPDATE `history` SET `score`=$s,`correct`=$r, date= NOW()  WHERE  userId = '$uid' AND eid = '$eid'")or die('Error124');

        } 
        else if(!isset($_COOKIE[$qid]) || $_COOKIE[$qid] ==='unset')
        {
        echo 2;
        $q=mysqli_query($con,"SELECT * FROM history WHERE eid='$eid' AND userId='$uid' " ) or die('Error139');
        while($row=mysqli_fetch_array($q) )
        {
        
        $w=$row['unattempted'];
        }
        $w++;
        
        $q=mysqli_query($con,"UPDATE `history` SET `unattempted`=$w, date=NOW() WHERE  userId = '$uid' AND eid = '$eid'") or die('Error147');
        
        }
        else if($_COOKIE[$qid])
        {
          echo 3;
        $q=mysqli_query($con,"SELECT * FROM quiz WHERE eid='$eid' " )or die('Error129');

        while($row=mysqli_fetch_array($q) )
        {
        $wrong=$row['wrong'];
        }
        
        $q=mysqli_query($con,"SELECT * FROM history WHERE eid='$eid' AND userId='$uid' " ) or die('Error139');
        while($row=mysqli_fetch_array($q) )
        {
        $s=$row['score'];
        $w=$row['wrong'];
        }
        $w++;
        $s=$s-$wrong;
        $q=mysqli_query($con,"UPDATE `history` SET `score`=$s,`wrong`=$w, date=NOW() WHERE  userId = '$uid' AND eid = '$eid'") or die('Error147');
      }    
    }
    else if($type==='NAT'){

      $q=mysqli_query($con,"SELECT * FROM `range` WHERE qid='$qid' " )or die('Error72');
        while($row=mysqli_fetch_array($q) )
        {
        $from=$row['range_from'];
        $to = $row['range_to'];
        }
        if($from<=$_COOKIE[$qid] && $_COOKIE[$qid]<=$to)
        {
          echo 4;
        $q=mysqli_query($con,"SELECT * FROM quiz WHERE eid='$eid' " )or die('Error73');
        while($row=mysqli_fetch_array($q) )
        {
        $correct=$row['correct'];
        }
        
        $q=mysqli_query($con,"SELECT * FROM history WHERE eid='$eid' AND userId='$uid' ")or die('Error115');

        while($row=mysqli_fetch_array($q) )
        {
        $s=$row['score'];
        $r=$row['correct'];
        }
        $r++;
        $s=$s+$correct;
        $q=mysqli_query($con,"UPDATE `history` SET `score`=$s,`correct`=$r, date= NOW()  WHERE  userId = '$uid' AND eid = '$eid'")or die('Error124');

        } 
        else if(!isset($_COOKIE[$qid]) || $_COOKIE[$qid] ==='unset')
        {
        echo 5;
        $q=mysqli_query($con,"SELECT * FROM history WHERE eid='$eid' AND userId='$uid' " ) or die('Error139');
        while($row=mysqli_fetch_array($q) )
        {
        
        $w=$row['unattempted'];
        }
        $w++;
        
        $q=mysqli_query($con,"UPDATE `history` SET `unattempted`=$w, date=NOW() WHERE  userId = '$uid' AND eid = '$eid'") or die('Error147');
        
        }
        else if($_COOKIE[$qid])
        {
          echo 6;
        $q=mysqli_query($con,"SELECT * FROM quiz WHERE eid='$eid' " )or die('Error129');

        while($row=mysqli_fetch_array($q) )
        {
        $wrong=$row['wrong'];
        }
        
        $q=mysqli_query($con,"SELECT * FROM history WHERE eid='$eid' AND userId='$uid' " ) or die('Error139');
        while($row=mysqli_fetch_array($q) )
        {
        $s=$row['score'];
        $w=$row['wrong'];
        }
        $w++;
        $s=$s-$wrong;
        $q=mysqli_query($con,"UPDATE `history` SET `score`=$s,`wrong`=$w, date=NOW() WHERE  userId = '$uid' AND eid = '$eid'") or die('Error147');
      }    

    }
  }

  $q=mysqli_query($con,"SELECT score FROM history WHERE eid='$eid' AND userId='$uid'" )or die('Error156');
        while($row=mysqli_fetch_array($q) )
        {
        $s=$row['score'];
        }
        
        $q=mysqli_query($con,"SELECT * FROM `rank` WHERE userId='$uid'" );
        // or die('Error161');
    //     if (!$q) {
    //   printf("Error: %s\n", mysqli_error($con));
    //   exit();
    // }
        $rowcount=mysqli_num_rows($q);
        
        if($rowcount == 0)
        {
        $q2=mysqli_query($con,"INSERT INTO `rank` VALUES('$uid','$s',NOW())");
        // or die('Error165');
        }
        else
        {
        while($row=mysqli_fetch_array($q) )
        {
        $sun=$row['score'];
        }
        $sun=$s+$sun;
        $q=mysqli_query($con,"UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE userId= '$uid'")or die('Error174');
      }




  header("location:account.php?q=result&step=2&eid=$eid&t=$total")or die('Error152');

}


// edit quiz
if(@$_GET['q']== 'editquiz' && !@$_GET['step']) {
$name = $_POST['name'];
$name= ucwords(strtolower($name));
$total = $_GET['total'];
$correct = $_POST['right'];
$wrong = $_POST['wrong'];
$time = $_POST['time'];
$tag = $_POST['tag'];
$desc = $_POST['desc'];
$calc = $_POST['calc'];
$courseId = $_POST['courseId'];
$eid=$_POST['eid'];
$q3=mysqli_query($con,"UPDATE quiz SET title='$name',correct='$correct',wrong='$wrong',time='$time',intro='$desc',tag='$tag',date=NOW(),courseId='$courseId',calculator='$calc' WHERE eid='$eid'");

header("location:dash.php?q=7&step=2&eid=$eid&n=$total");
}

if(@$_GET['q']== 'editquiz' && @$_GET['step']== 2) {
  $qid =uniqid();
  $eid = @$_GET['eid'];
  $type = @$_GET['type'];
  echo $type;
  $q = mysqli_query($con, "INSERT INTO questions VALUES ('$eid','$qid','',4,0,'$type')")
   or die('Error 123456');

  if (!$q) {
      printf("Error: %s\n", mysqli_error($con));
      exit();
    }
  
    if($type === 'MCQ'){
  $oaid=uniqid();
  $obid=uniqid();
  $ocid=uniqid();
  $odid=uniqid();

  $qa=mysqli_query($con,"INSERT INTO `options` VALUES  ('$qid','','$oaid')") or die('Error61');
  $qb=mysqli_query($con,"INSERT INTO `options` VALUES  ('$qid','','$obid')") or die('Error62');
  $qc=mysqli_query($con,"INSERT INTO `options` VALUES  ('$qid','','$ocid')") or die('Error63');
  $qd=mysqli_query($con,"INSERT INTO `options` VALUES  ('$qid','','$odid')") or die('Error64');

  $qans=mysqli_query($con,"INSERT INTO answer (qid) VALUES  ('$qid')");
  // or die('Error question');
  if (!$qans) {
      printf("Error: %s\n", mysqli_error($con));
      exit();
    }
  
    }
    else if($type === 'NAT'){
      $qans=mysqli_query($con,"INSERT INTO `range` (qid) VALUES  ('$qid')");
      //  or die('Error question');
      if (!$qans) {
      printf("Error: %s\n", mysqli_error($con));
      exit();
    }
      // $qans=mysqli_query($con,"INSERT INTO answer VALUES  ('$qid','','','')");
    }
  header("location:dash.php?q=7&step=2&eid=$eid&n=$total");
  // header("location:update.php?q=editqns&eid=$eid&ch=4&add=1");


}

if(@$_GET['q']== 'editquiz' && @$_GET['step']== 3) {
  $qid =@$_GET['qid'];
  $eid = @$_GET['eid'];
  $q = mysqli_query($con, "DELETE FROM questions WHERE qid='$qid'");

  $qa=mysqli_query($con,"DELETE FROM options WHERE qid='$qid'") or die('Error61');
  

  $qans=mysqli_query($con,"DELETE FROM answer WHERE qid='$qid'");
  $qans=mysqli_query($con,"DELETE FROM `range` WHERE qid='$qid'");
  
  header("location:dash.php?q=7&step=2&eid=$eid&n=$total");


}

// step 2 of edit quiz
if(@$_GET['q']== 'editqns' ) {

$eid = @$_GET['eid'];

// deleting previous records
$i = 1;
$result = mysqli_query($con,"SELECT * FROM questions WHERE eid='$eid'") or die('Error');
$num = mysqli_num_rows($result);
$q9 = mysqli_query($con,"UPDATE quiz SET total ='$num' WHERE eid='$eid'") or die('Error');

while($row = mysqli_fetch_array($result)) {
    $qid = $row['qid'];
    $type = $row['type'];
    $ques = $_POST[$qid];
    $q1 = mysqli_query($con,"UPDATE questions SET qns='$ques', sn='$i' WHERE eid= '$eid' AND qid='$qid'"); 
    // or die('Error 1');
    
    if($type ==="MCQ")
    {
    $q2 = mysqli_query($con,"SELECT * FROM options WHERE qid='$qid'") or die('Error 2');
    while($opt = mysqli_fetch_array($q2)) {
      $opt_id = $opt['optionid'];
      $opt_val = $_POST[$opt_id];
      $q3 = mysqli_query($con,"UPDATE options SET `option`='$opt_val' WHERE optionid= '$opt_id' AND qid='$qid'");
      //  or die('Error 3');
      
    if (!$q3) {
      printf("Error: %s\n", mysqli_error($con));
      exit();
    }
    }
    $ans = $_POST[$qid.'_a'];
    $exp_text = $_POST[$qid.'_text'];
    $exp_text = str_replace("'", "''", "$exp_text");
    $q4 = mysqli_query($con,"UPDATE answer SET ansid='$ans',exp_text='$exp_text' WHERE qid='$qid'");
    //  or die('Error 123456');

    if (!$q4) {
      printf("Error: %s\n", mysqli_error($con));
      exit();
    }


    if(isset($_FILES[$qid.'_img']) && $_FILES[$qid.'_img']["error"] == 0){
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES[$qid.'_img']["name"];
        $filetype = $_FILES[$qid.'_img']["type"];
        $filesize = $_FILES[$qid.'_img']["size"];
    
        
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        
        $maxsize = 17 * 1024 * 1024;
        if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");
    
        // Verify MYME type of the file
        
            // Check whether file exists before uploading it
                
                move_uploaded_file($_FILES[$qid.'_img']
                ["tmp_name"], "upload/" . $filename);
                $imageContent=addslashes(file_get_contents('upload/'.$filename));
                $q4 = mysqli_query($con,"UPDATE answer SET  exp_img='$imageContent'  WHERE qid='$qid'");
               
                echo "Your file was uploaded successfully.";
              unlink("upload/" . $filename);
        
    } else{
        echo "Error: " . $_FILES[$qid.'_img']["error"];
    }
  }
  else if($type ==="NAT"){
    $from = $_POST[$qid.'_from'];
    $to = $_POST[$qid.'_to'];
    

    $exp_text = $_POST[$qid.'_text'];
    $exp_text = str_replace("'", "''", "$exp_text");
    $q4 = mysqli_query($con,"UPDATE `range` SET `range_from`='$from', `range_to`='$to', exp_text='$exp_text' WHERE qid='$qid'");
    //  or die('Error 123456');

    if (!$q4) {
      printf("Error: %s\n", mysqli_error($con));
      exit();
    }


    if(isset($_FILES[$qid.'_img']) && $_FILES[$qid.'_img']["error"] == 0){
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES[$qid.'_img']["name"];
        $filetype = $_FILES[$qid.'_img']["type"];
        $filesize = $_FILES[$qid.'_img']["size"];
    
        
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        
        $maxsize = 17 * 1024 * 1024;
        if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");
    
        // Verify MYME type of the file
        
            // Check whether file exists before uploading it
                
                move_uploaded_file($_FILES[$qid.'_img']
                ["tmp_name"], "upload/" . $filename);
                $imageContent=addslashes(file_get_contents('upload/'.$filename));
                $q4 = mysqli_query($con,"UPDATE `range` SET  exp_img='$imageContent'  WHERE qid='$qid'");
               
                echo "Your file was uploaded successfully.";
              unlink("upload/" . $filename);
        
    } else{
        echo "Error: " . $_FILES[$qid.'_img']["error"];
    }

  }
    $i++;
    
}
    


  if(@$_GET['add'] ==1)
  {
    $type =@$_GET['type'];
    echo $type;
    header("location:update.php?q=editquiz&step=2&eid=$eid&type=$type");
  }
  else if(@$_GET['add'] ==2)
  {
    $qid =@$_GET['qid'];
    header("location:update.php?q=editquiz&step=3&eid=$eid&qid=$qid");
  }
  else
  {
    header("location:dash.php?q=0");

  }



}

if(@$_GET['addCourse'] == 1)
{
  
$cid = $_POST['cid'];

$password = $_POST['password'];
$name = $_POST['name'];



$q=mysqli_query($con,"INSERT INTO course VALUES  ('$cid' ,'$name', '$password' )");

header("location:headdash.php?q=6&al=1");

}

if(@$_GET['dcid'])
{
  
$cid = @$_GET['dcid'];

$q=mysqli_query($con,"DELETE FROM course WHERE courseId='$cid'");

header("location:headdash.php?q=7&al=1");

}


?>



