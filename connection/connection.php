<?php
	//login cridentials
	
    $db_hostname = 'localhost';
	$user_name = 'root';
	$user_password = '';
	$db_name = 'school_manager';
	
	/* 1. create database connection
  $cxn = mysqli_connect($db_hostname,$user_name,$user_password) or 
        die("Database connection failed: " . mysql_error());
 

 // 2. select a database to use
  $db_select = mysqli_select_db($db_name,$cxn) or 
     die("Database selection failed: " . mysql_error());
	*/
	
	
  $cxn = new mysqli($db_hostname, $user_name, $user_password, $db_name) or die('No database connection!');
?>