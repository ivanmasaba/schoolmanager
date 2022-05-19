<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/schoolmanager/connection/connection.php');
$class = $_GET['class'];
$stream = $_GET['stream'];
$subject = $_GET['subject'];
$mark1 = strtolower($subject).'_test_score';
$mark2 = strtolower($subject).'_exam_score';
$mark3 = strtolower($subject).'_total_score';

echo '
		<table width="570" border="0" cellspacing="1" cellpadding="2">
		  <tr>
			<tr style="font-weight: bold; color: #1f3477; ">
			<td width="90" align="right">Select subject:</td>
			<td colspan="2" align="left"><select id="selectSubject" onchange="show(\''.$class.'\', \''.$stream.'\')" >		
				<option value="'.$subject.'">&nbsp; '.$subject.' &nbsp;</option> ';
				if( $result = $cxn->query("SELECT subj_name FROM subjects") )
				{
					while( $subjects = $result->fetch_assoc() )
					{
						echo "<option value='".$subjects['subj_name']."'>&nbsp;".$subjects['subj_name']."</option>";
					}
				}
				else echo $cxn->error;
				$result->close();
			echo '
			<td width="50" align="right">Class:</td>
			<td colspan="3" align="left"> '.$class.". ".$stream.' </td>
		  </tr>
		  <tr >
			<td colspan="7">&nbsp;</td>
		  </tr>
		  <tr style="font-weight: bold; background-color: #999999; ">
			<td>Index No.</td>
			<td width="170" >Student name</td>
			<td width="50">Test score</td>
			<td width="50">Exam score</td>
			<td width="50">Total score</td>
			<td width="50">Grade</td>
		  </tr>';
		  $query = "SELECT reg_num, fname, sname FROM registration WHERE class = '{$class}' AND stream = '{$stream}' ";
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
				echo "<td>".$result['reg_num']."<input type='hidden' name='".$bg."' size='3' value='".$result['reg_num']."' /></td>";
				echo "<td align='left'>".$result['fname']." ".$result['sname']."</td>";
				
	$query3 = "SELECT marks.test_score, marks.exam_score, marks.total_score, marks.grade
			   FROM marks, subjects
			   WHERE marks.reg_num='{$result['reg_num']}' AND marks.subj_id=subjects.id AND subjects.subj_name='{$subject}' ";

				if($ds = $cxn->query($query3))
				{
					while($resultq = $ds->fetch_assoc())
					{
							echo "<td>".$resultq['test_score']."</td>";
							echo "<td>".$resultq['exam_score']."</td>";
							echo "<td>".$resultq['total_score']."</td>";
							echo "<td>".$resultq['grade']."</td>";
					}
				} 
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td></tr>";
				$bg++;
			}
		//	echo $db_result->error;
		//	echo $db_result->num_rows;
			$db_result->close();
		  }
		  else echo $cxn->error;
		  $cxn->close();
		  echo '<tr >
			<td colspan="7" style="border-top:solid 1px #aaa">&nbsp;</td>
		  </tr>
		</table>';
   
?>