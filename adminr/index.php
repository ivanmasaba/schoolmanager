<?php 
	session_start();
	if( $_SESSION['authenticated'] != 'yes' )
	{header("location: ../login.php");}
	require_once($_SERVER['DOCUMENT_ROOT'].'/schoolmanager/connection/connection.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/schoolmanager/common/sidebar.php');
	$current_user = $_SESSION['current_uname'];
  $reg_num = $_SESSION['index_number'];
  $cid = $_SESSION['class'];
  $sid = $_SESSION['subject'];
  $access_level = $_SESSION['access_level'];
  $subj_name = "";
  $test_score ="";
  $exam_score = "";
  $total_score = "";

  if( $access_level == 'teacher' ){
 
  $c = $cxn->query("SELECT class_name FROM class WHERE id='$cid'");
  $cl = mysqli_fetch_assoc($c);
  $class = $cl['class_name'];
   
  $s = $cxn->query("SELECT subj_name FROM subjects WHERE id='$sid'");
  $sub = mysqli_fetch_assoc($s);
  $subject = $sub['subj_name'];
  }
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Results</title>
<script type="text/javascript" src="calc.js"></script>
<script type="text/javascript" src="../common/javascript.js"></script>
<script type="text/javascript" src="results.js"></script>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="../styles.css">
<link rel="stylesheet" type="text/css" href="styles.css">
<link href="SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="top">
    <h1>SCHOOL MANAGER</h1>
    <h2>access your school everywhere!</h2>
</div>
<div class="bar">
    <div id="current_time" style="color: #49AF3A; text-align:right; margin-bottom: 10px;"><?php echo date("l, d.M H:i", time()); ?></div>
    <div style="float: right;">
        <a href="../index1.php" style="background: url(../images/frontpage.gif) no-repeat; padding-left: 22px;">Home</a>&nbsp;&nbsp;
        <a href="../sign out.php" style="background: url(../images/b_drop.png) no-repeat; padding-left: 18px;">Sign out</a>
    </div>
    <div id="greeting" style=" float: left;">Welcome, <?php echo $current_user ?></div>
</div>
<div class="content">
 <div class="sidebar">
 <?php 

echo "<h4>Select an activity</h4>";
echo "<h3 style=\"background-image: url(../images/frontpage1.png);\" ><a href=\"../index.php\">Home</a></h3>";
if( $access_level == 'teacher' ){
echo "<h3><a href=\"../adminr\">EDIT Results</a></h3>";
echo "<h3 style=\"background-image: url(../images/email_initiator.gif);\" ><a href=\"../advres/\">View results</a></h3>";
}
echo "<h3><a href=\"../adminreg/\">Account info</a></h3>";
echo "<h3 style=\"background-image: url(../images/icon-30-cpanel.png);\" ><a href=\"../options/\">Change your settings</a></h3>";

?>
    
 </div>
 <div class="contents">   
  
   <a class="tabs" id="tab2" onclick="tabOver('Class_results', 'tab2')">Stream results</a>
    
    <div id="Create_report" class="tab_body">
    <div style="background-color: #FFFFFF; padding: 10px 3px; border: 1px solid #DEE8EF;">
    <div id="showClassResults">
    <h4> <?php echo 'MARKS FOR ALL STUDENTS';?></h4>
     
        <table width="550" height="200px" border="0" cellspacing="1" cellpadding="2">
          <tr style="font-weight: bold; color: #1f3477; ">
           
          </tr>
          <tr style="font-weight: bold; background-color: #999999; ">
          <td width="50">Index</td>
          <td width="140">Student name</td>
            <td width="140">Subject name</td>
            <td width="50">Test Score</td>
            <td width="50">Exam Score</td>
            <td width="55">Total Score</td>
            <td width="55"></td>
          </tr>
          <?php



// $query = "SELECT registration.reg_num, registration.fname, registration.sname, marks.test_score, marks.exam_score, marks.total_score, marks.grade, subjects.subj_name\n"

//     . "   FROM registration, marks, subjects\n"

//     . "   WHERE registration.class='$class' AND registration.reg_num=marks.reg_num AND marks.subj_id='$sid' AND marks.subj_id=subjects.id";
$query = "SELECT reg_num, fname, sname FROM registration WHERE class = '{$class}' ";
if($db_result = $cxn->query($query))
{
$bg = 1;
while($result = $db_result->fetch_assoc())
{
  if($bg%2==1)
  {
    echo "<tr >";
  }
  else
  {
    echo "<tr style='background: #e0eff6 url(images/frm_chg.gif) repeat-x;'>";
  }

  echo "<td><input type='text' name='reg' size='3' value='".$result['reg_num']."' disabled /></td>";

   echo "<td align='left'>".$result['fname']." ".$result['sname']."</td>";
   ?> <form action="" method="post" ><?php

   $query3 = "SELECT marks.test_score, marks.exam_score, marks.total_score, marks.grade, subjects.subj_name
   FROM marks, subjects
   WHERE marks.reg_num='{$result['reg_num']}' AND marks.subj_id='$sid' AND subjects.subj_name='{$subject}' ";

  if($ds = $cxn->query($query3))
  {
    while($resultq = $ds->fetch_assoc())
    {
      $subj_name = $resultq['subj_name'];
      $test_score ="";
      $exam_score = "";
      $total_score = "";

       echo "<td>".$subj_name."</td>";
        echo "<td><input type='text' id='test_score' name='test_score' onblur='add();' size='3' value='".$resultq['test_score']."' /></td>";
        echo "<td><input type='text' id='exam_score' name='exam_score' onblur='add();' size='3' value='".$resultq['exam_score']."' /></td>";
        echo "<td><input type='text' id='total_score' name='total_score' size='3' value='".$resultq['total_score']."'  /></td>";
        ?>
        <td><a href="edit.php?&uname=<?php echo $result['fname'];?>" class="btn btn-sm btn-success">Edit</a>
                           <td>

        
         </form> <?php
          }
        } 
  echo "<td>&nbsp;</td>";
  echo "<td>&nbsp;</td></tr>";
  $bg++;
}


$db_result->close();
}
else echo $cxn->error;
$cxn->close();


          ?>
         
        </table>
        
      </div>
    </div>
    </div>
    
    
</div>
</div>
<div class='btm'>
    <a href='../index1.php'>Home </a>
    <a href='../registration'> Registration </a>
    <a href='../results'> View results </a>
    <br/>&copy; All rights reserved. <br/> 
    An Ivan Masaba Production 2022
</div>
<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>
</body>
</html>
