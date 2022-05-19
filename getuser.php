<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/schoolmanager/connection/connection.php'); 
	$uname = $_GET['uname'];
	if( $cxn )
	{
		$query = "SELECT * FROM login WHERE uname = '$uname'";
		if($result = $cxn->query($query))
		{
			if($user_row = mysqli_fetch_assoc($result))
			{
				echo "&nbsp;";
			}	
			else
			{
				echo "user '".$_GET['uname']."' does not exist";
			}
			$result->close();
		}
		$cxn->close();
	}
?>