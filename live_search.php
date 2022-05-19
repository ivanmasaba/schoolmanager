<?php
	header("Cache-Control: no-cache, must-revalidate");
	 // Date in the past
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

	require_once( $_SERVER['DOCUMENT_ROOT'].'/schoolmanager/connection/connection.php');
	$hint = $_GET["hint"];
	$hint .= '%';
	$num = 1;
	if( $cxn )
	{
		$query = "SELECT * FROM registration WHERE fname LIKE '$hint' || sname LIKE '$hint'";
		if( $result = $cxn->query($query) )
		{
			echo "<table width='100%' cellspacing='0' cellpadding='3'>";
			echo "<tr style='background:#053a83; color: #FFFFFF'><th scope='col'> &nbsp; </th>";
			echo "<th scope='col'> Registration number </th>";
			echo "<th scope='col'> Full name </th>";
			echo "<th scope='col'> Class </th></tr>";
			while ( $row = $result->fetch_assoc() )
			{
				if( $num%2 == 1 )
				{
					echo "<tr><td>".$num.".</td>";
					echo "<td>".$row['reg_num']."</td>";
					echo "<td>".$row['fname']." ".$row['sname']."</td>";
					echo "<td>".$row['class'].".".$row['stream']."</td></tr>";
				}
				else
				{
					echo "<tr style='background:#F4F5FD;'><td>".$num.".</td>";
					echo "<td>".$row['reg_num']."</td>";
					echo "<td>".$row['fname']." ".$row['sname']."</td>";
					echo "<td>".$row['class'].".".$row['stream']."</td></tr>";
				}
				$num++;
			}
			echo "</table>";
		}
		else
			$response = "No results ".$cxn->error;
	}
	else
		$response = "No connection ".$cxn->error;

	echo $response;

?>