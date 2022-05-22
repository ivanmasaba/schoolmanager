<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/schoolmanager/connection/connection.php');
$test = $_GET['test'];
$exam = $_GET['exam'];
$total = $_GET['total'];
$reg = $_GET['reg'];
?>

<?php 
  $sql = "UPDATE marks SET test_score='$test', exam_score='$exam', total_score='$total' 
          WHERE   reg_num='$reg' ";

				$cxn->query($sql);
				if( $cxn->affected_rows )
				{
					$new_form_msg .= "Marks updates successfully";
				}
				else
					$new_form_msg .= " Marks update failed. ".$cxn->error;

?>



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
						<td width="55"></td>
						</tr>
						<?php



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
					echo "<td align='left'>".$result['fname']." ".$result['sname']."</td>";

					$query3 = "SELECT marks.test_score, marks.exam_score, marks.total_score, marks.grade, subjects.subj_name
					FROM marks, subjects
					WHERE marks.reg_num='{$result['reg_num']}' AND marks.subj_id='$sub_id' AND subjects.subj_name='{$subject}' ";

					if($ds = $cxn->query($query3))
					{
					while($resultq = $ds->fetch_assoc())
					{
					echo "<td>".$resultq['subj_name']."</td>";
					echo "<td><input type='text' id='test_score' name='test_score' onblur='add();' size='3' value='".$resultq['test_score']."' /></td>";
					echo "<td><input type='text' id='exam_score' name='exam_score' onblur='add();' size='3' value='".$resultq['exam_score']."' /></td>";
					echo "<td><input type='text' id='total_score' name='total_score' size='3' value='".$resultq['total_score']."' disabled /></td>";
					echo "<td> <input  type='submit' name='edit' size='3' value='EDIT' onclick='show(";?> <?php echo $result['reg_num'];?> <?php echo ");' /> </td>";
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
					</form>  
				