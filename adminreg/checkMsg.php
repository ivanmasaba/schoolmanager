<?php
	require_once( $_SERVER['DOCUMENT_ROOT'].'/schoolmanager/connection/connection.php');
	if( $cxn )
	{
		$query = "SELECT * FROM notices WHERE notices.read = '0'";
		if( $result = $cxn->query($query) )
		{
			$i = 0;
			while ( $row = mysqli_fetch_assoc($result) )
				$i++;
			echo "You have $i unread notices. ";
		}
		else
			echo "Query not executed ".$cxn->error;
	}
	else
		echo "No connection ".$cxn->error;
?>