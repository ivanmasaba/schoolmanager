<?php 
	session_start();
	if( $_SESSION['authenticated'] != 'yes' )
	{header("location: ../login.php");}
	require_once($_SERVER['DOCUMENT_ROOT'].'/schoolmanager/connection/connection.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/schoolmanager/common/sidebar.php');
	$current_user = $_SESSION['current_uname'];
  $reg_num = $_SESSION['index_number'];
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Results</title>
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
echo "<h3><a href=\"../adminr\">Add Results</a></h3>";
echo "<h3><a href=\"../adminreg/\">Account info</a></h3>";
echo "<h3 style=\"background-image: url(../images/email_initiator.gif);\" ><a href=\"../advres/\">View results</a></h3>";
echo "<h3 style=\"background-image: url(../images/icon-30-cpanel.png);\" ><a href=\"../options/\">Change your settings</a></h3>";

?>
    
 </div>
 <div class="contents">
  
   <a class="tabs" id="tab2" onclick="tabOver('Class_results', 'tab2')">Stream results</a>
    
    <div id="Create_report" class="tab_body">
    <div style="background-color: #FFFFFF; padding: 10px 3px; border: 1px solid #DEE8EF;">
    <h4> <?php echo 'MARKS FOR ALL STUDENTS';?></h4>
      <form action="" method="post" name="create report">
        <table width="550" border="0" cellspacing="1" cellpadding="2">
          <tr style="font-weight: bold; color: #1f3477; ">
           
          </tr>
          <tr style="font-weight: bold; background-color: #999999; ">
          <td width="140">Student name</td>
            <td width="140">Subject name</td>
            <td width="50">Test Score</td>
            <td width="50">Exam Score</td>
            <td width="55">Total Score</td>
            <td width="55">Grade</td>
          </tr>
          <?php
          
$query = 'SELECT * FROM marks LEFT JOIN (subjects, registration)  ON  marks.subj_id=subjects.id 
            AND marks.reg_num=registration.reg_num';	
              if( $result = $cxn->query($query) )
              {
                $bg = 1;
                while( $user_row = $result->fetch_assoc() )
                {
                    
				
						$style =  "style='border-top:solid 1px #aaa'";
					
						if( $bg%2 == 0 ){
              echo "<tr style='background: #f9f9fd;'>";
            }else{
              echo "<tr style=$style>";
            }
               $fname   = $user_row['fname'];
               $sname   = $user_row['sname'];
               echo "<td style='border-top:solid 1px #aaa'>$fname $sname </td>";
               $subject   = $user_row['subj_name'];
                echo "<td align='left' $style> &nbsp;".$subject."</td>";
                
                $test_score   = $user_row['test_score'];
                $exam_score   = $user_row['exam_score'];
                $total_score  = $user_row['total_score'];
                $grade        = $user_row['grade'];
                echo "<td style='border-top:solid 1px #aaa'>$test_score</td>";
                echo "<td style='border-top:solid 1px #aaa'>$exam_score</td>";
                echo "<td style='border-top:solid 1px #aaa'>$total_score</td>";
                echo "<td style='border-top:solid 1px #aaa'>$grade</td>";
    
              echo "</tr>";
              
              $bg++;
                    }
                    $result->close();
              }
              
          ?>
         
        </table>
      </form>  
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
