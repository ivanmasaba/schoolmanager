<?php
	require_once( $_SERVER['DOCUMENT_ROOT'].'/schoolmanager/connection/connection.php');
	$content = $_POST['appointment'];
	$recipient = $_POST['recipient'];
	$timesent = time();
	if( $cxn )
	{
		$query = "INSERT INTO notices VALUES(NULL, '$content', '$recipient', 0, '$timesent', 'dust')";
		if( $cxn->query($query) )
			echo "Your notice has been sent";
		else
			echo "Query not executed ".$cxn->error;
	}
	else
		echo "No connection ".$cxn->error;
?>