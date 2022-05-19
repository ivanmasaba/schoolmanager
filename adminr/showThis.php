<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/schoolmanager/connection/connection.php');
$class = $_GET['class'];
$stream = $_GET['stream'];
$subject = $_GET['subject'];
$paper = $_GET['paper'];
$mark1 = strtolower($subject).$paper.'_bot';
$mark2 = strtolower($subject).$paper.'_mot';
$mark3 = strtolower($subject).$paper.'_eot';
echo '
		<table width="570" border="0" cellspacing="1" cellpadding="2">
		  <tr>
			<tr style="font-weight: bold; color: #1f3477; ">
			<td width="90" align="right">Select subject:</td>
			<td colspan="2" align="left"><select id="selectSubject" onchange="showThis(\''.$class.'\', \''.$stream.'\')" >		
				<option value="'.$subject.'">&nbsp; '.$subject.' &nbsp;</option> ';
				if( $result = $cxn->query("SELECT name FROM subjects") )
				{
					while( $subjects = $result->fetch_assoc() )
					{
						echo "<option value='".$subjects['name']."'>&nbsp;".$subjects['name']."</option>";
					}
				}
				else echo $cxn->error;
				$result->close();
			echo '</select>
			&nbsp;&nbsp;Paper: &nbsp;<select id="selectPaper" onchange="showThis(\''.$class.'\', \''.$stream.'\')" >
				<option value="'.$paper.'">&nbsp; '.$paper.' &nbsp;</option>
				<option value="1">&nbsp; 1 &nbsp;</option>
				<option value="2">&nbsp; 2 &nbsp;</option>
				<option value="3">&nbsp; 3 &nbsp;</option>
			</select></td>
			<td width="50" align="right">Class:</td>
			<td colspan="3" align="left"> '.$class.". ".$stream.' </td>
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
		  </tr>';
		  $query = "SELECT reg_num, fname, sname, $mark1, $mark2, $mark3 FROM registration, results WHERE registration.class = '$class' AND registration.stream = '$stream' AND reg_num = student";
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
				echo "<td><input name='".$bg.'_mot'."' size='3' value='".$result[$mark1]."' /></td>";
				echo "<td><input name='".$bg.'_bot'."' size='3' value='".$result[$mark2]."' /></td>";
				echo "<td><input name='".$bg.'_eot'."' size='3' value='".$result[$mark3]."' /></td>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td></tr>";
				$bg++;
			}
			echo $db_result->error;
			echo $db_result->num_rows;
			$db_result->close();
		  }
		  else echo $cxn->error;
		  $cxn->close();
		  echo '<tr >
			<td colspan="7" style="border-top:solid 1px #aaa">&nbsp;</td>
		  </tr>
		  <tr align="left">
			<td colspan="7">
				<input type="submit" name="editClassResults" style="font: bold 11px Arial" value="save changes">
				<input type="button" style="font: bold 11px Arial" value="discard changes">
			</td>
		  </tr>
		</table>';
   
?>