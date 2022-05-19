<?php 
	session_start();
	if( $_SESSION['authenticated'] != 'yes' )
	{header("location: ../login.php");}
	require_once($_SERVER['DOCUMENT_ROOT'].'/schoolmanager/connection/connection.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/schoolmanager/common/sidebar.php');
	$current_user = $_SESSION['index_number'];
	$class = $_SESSION['class'];
	$stream = $_SESSION['stream'];
	
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
    <div id="greeting" style=" float: left;">Welcome, <? $current_user ?></div>
</div>
<div class="content">
 <div class="sidebar">
    <h4>Select an activity</h4>
    <h3 style="background-image: url(../images/frontpage1.png);" ><a href='../index1.php'>Home</a></h3>
    <h3><a href='../registration'>Registration</a></h3>
    <h3 style="background-image: url(images/email_initiator.gif);" ><a href="#">View results</a></h3>  
    
    
 </div>
 <div class="contents">
   <div id="today" style="margin-bottom: 10px;">     
     <div id="noticeState" style="font: bold 11px 'Arial'; padding: 0px 10px; text-align: right;">&nbsp;</div>
     <div class="menuBar">
         Select class:&nbsp; <select name="user_type" id="user_type">
           <option value="S1" selected="selected">Senior One</option>
           <option value="S2">Senior Two</option>
           <option value="S3">Senior Three</option>
           <option value="S4">Senior Four</option>
         </select>&nbsp;&nbsp;&nbsp;
         Select stream:&nbsp; <select name="user_type" id="user_type">
           <option value='a' selected="selected">&nbsp;A&nbsp;</option>
           <option value='b'>&nbsp;B&nbsp;</option>
           <option value='c'>&nbsp;C&nbsp;</option>
         </select>
     </div>
   </div>
   <a class="tabs_active" id="tab1" onclick="tabOver('Create_report', 'tab1')">Create report</a> 
   <a class="tabs" id="tab2" onclick="tabOver('Class_results', 'tab2')">Class results</a>
    
    <div id="Create_report" class="tab_body">
    <div style="background-color: #FFFFFF; padding: 10px 3px; border: 1px solid #DEE8EF;">
    <h4>Senior two student report.</h4>
      <form action="" method="post" name="create report">
        <table width="550" border="0" cellspacing="1" cellpadding="2">
          <tr style="font-weight: bold; color: #1f3477; ">
            <td width="85" align="right">Name:</td>
            <td colspan="2">&nbsp;</td>
            <td width="55" align="right">Class:</td>
            <td colspan="3" align="left"><?php echo $class.". ".$stream; ?></td>
          </tr>
          <tr style="font-weight: bold; background-color: #999999; ">
            <td width="140">Subject name</td>
            <td>Subject code</td>
            <td width="50">B.O.T</td>
            <td>M.O.T</td>
            <td width="50">E.O.T</td>
            <td width="55">Average</td>
            <td width="55">Grade</td>
          </tr>
          <?php
              $query = 'SELECT * FROM subjects';					  
              if( $result = $cxn->query($query) )
              {
                $bg = 1;
                while( $user_row = $result->fetch_assoc() )
                {
                    $x = 1;
					while( $x <= $user_row['papers'] )
					{
						$style =  "style='border-top:solid 1px #aaa'";
						if( $x != 1 )
						{
							$user_row['name'] = "";
							$style =  "";
						}
						if( $bg%2 == 0 )
							echo "<tr style='background: #f9f9fd;'>";
						else
							echo "<tr>";
						echo "<td align='left' $style> &nbsp;".$user_row['name']."</td>";
						echo "<td style='border-top:solid 1px #aaa'>".$x."</td>";
						$bot_id = "'".$user_row['code']."bot'";
						$mot_id = "'".$user_row['code']."mot'";
						$eot_id = "'".$user_row['code']."eot'";
						$total_id = "'".$user_row['code']."total'";
						$grade_id = "'".$user_row['code']."grade'";
						echo "<td style='border-top:solid 1px #aaa'><input name='' id=".$bot_id." size='3' maxvalue='3' onkeyup=\"total_grade(".$bot_id.", ".$mot_id.", ".$eot_id.", ".$total_id.", ".$grade_id.")\"></td>";	
						echo "<td style='border-top:solid 1px #aaa'><input name='' id=".$mot_id." size='3' maxvalue='3' onkeyup=\"total_grade(".$mot_id.", ".$bot_id.", ".$eot_id.", ".$total_id.", ".$grade_id.")\"></td>";	
						echo "<td style='border-top:solid 1px #aaa'><input name='' id=".$eot_id." size='3' maxvalue='3' onkeyup=\"total_grade(".$eot_id.", ".$bot_id.", ".$mot_id.", ".$total_id.", ".$grade_id.")\"></td>";		
						echo "<td id=".$total_id." style='border-top:solid 1px #aaa' >&nbsp;</td>";
						echo "<td id=".$grade_id." style='border-top:solid 1px #aaa' >&nbsp;</td></tr>";
						$x++;
					}
					$bg++;
                }
                $result->close();
              }
          ?>
          <tr>
            <td colspan="7" style='border-top:solid 1px #aaa'>&nbsp;</td>
          </tr>
          <tr style="font-weight: bold; color: #1f3477; ">
            <td>Average:</td>
            <td>&nbsp;</td>
            <td colspan="5">Position:</td>
          </tr>
          <tr style="font-weight: bold; color: #1f3477; ">
            <td>Comment:</td>
            <td colspan="6"><textarea name="comment" cols="" rows="2"></textarea></td>
          </tr>
        </table>
      </form>  
    </div>
    </div>
    
    <div id="Class_results" class="tab_body" style="display: none;">
     <div id="showClassResults" style="background-color: #FFFFFF; padding: 10px 3px; border: 1px solid #DEE8EF;">
       <h4>Senior <?php echo $class;?> student results.</h4>
        <form action="" method="post">
            <table width="570" border="0" cellspacing="1" cellpadding="2">
              <tr>
                <tr style="font-weight: bold; color: #1f3477; ">
                <td width="90" align="right">Select subject:</td>
                <td colspan="2" align="left"><select id="selectSubject" onchange="showThis('<?php echo $class;?>', '<?php echo $stream;?>')" >
                <option value="">&nbsp; &nbsp;</option>
				<?php
                	if( $result = $cxn->query("SELECT name FROM subjects") )
					{
						while( $subjects = $result->fetch_assoc() )
						{
							echo "<option value='".$subjects['name']."'>&nbsp;".$subjects['name']."</option>";
						}
					}
					else echo $cxn->error;
					$result->close();
				?></select>
                &nbsp;&nbsp;Paper: &nbsp;<select id="selectPaper" onchange="showThis('<?php echo $class;?>', '<?php echo $stream;?>')" >
                    <option value="1">&nbsp; 1 &nbsp;</option>
                    <option value="2">&nbsp; 2 &nbsp;</option>
                    <option value="3">&nbsp; 3 &nbsp;</option>
                </select></td>
                <td width="50" align="right">Class:</td>
                <td colspan="3" align="left"><?php echo " ".$class.". ".$stream; ?></td>
              </tr>
              <tr >
                <td colspan="7">&nbsp;</td>
              </tr>
              <tr style="font-weight: bold; background-color: #999999; ">
                <td>Index No.</td>
                <td width="170" >Student name</td>
                <td width="50">B.O.T</td>
                <td>M.O.T</td>
                <td width="50">E.O.T</td>
                <td width="50">Average</td>
                <td width="50">Grade</td>
              </tr>
              <?php
              $query1 = "SELECT reg_num, fname, sname FROM registration WHERE class = '$class' AND stream = '$stream'";
			  $query = 'SELECT student, subject, bot, mot, eot, fname, sname FROM results, registration WHERE results.student = registration.reg_num';
              if($result1 = $cxn->query($query1))
              {
                $bg = 1;
                while($student = $result1->fetch_assoc())
                {
                    if($bg%2==1)
                    {
                        echo "<tr >";
                    }
                    else
                    {
                        echo "<tr style='background: #ccc url(images/frm_chg.gif) repeat-x;'>";
                    }
                    echo "<td>".$student['reg_num']."</td>";
                    echo "<td align='left'>".$student['fname']." ".$student['sname']."</td>";
                    echo "<td><input type='text' name='input28' size='3' value='".$user_row['bot']."' /></td>";
                    echo "<td><input type='text' name='input44' size='3' value='".$user_row['mot']."' /></td>";
                    echo "<td><input type='text' name='input45' size='3' value='".$user_row['eot']."' /></td>";
                    echo "<td>&nbsp;</td>";
                    echo "<td>&nbsp;</td></tr>";
                    $bg++;
                }
              }
              ?>
              <tr >
                <td colspan="7" style="border-top:solid 1px #aaa">&nbsp;</td>
              </tr>
              <tr style="font-weight: bold; color: #1f3477; ">
                <td align="right">Comment:</td>
                <td colspan="6"><textarea name="comment_class" cols="" rows="2"></textarea></td>
              </tr>
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
