<?php 
	session_start();
	require_once("connection/connection.php");
    require_once("connection/form_functions.php");
    require_once("connection/functions.php");	
	
	if(isset($_POST['login']))
	{
	  $errors = array();
	// perform validation on the form data
	$required_fields = array('uname','password');
	$errors = array_merge($errors, check_required_fields($required_fields,
	$_POST));
	
	$fields_with_lengths = array('uname' => 30, 'password' => 30);
	$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths,
	$_POST));	
	
	//clean up the form data before putting in the database
	$uname = trim(mysql_prep($_POST['uname']));
	$password = trim(mysql_prep($_POST['password']));
	   if(empty($errors)){
		if( $cxn )
		{
		$query = "SELECT * FROM login WHERE uname = '{$uname}'";
	  $query .= "AND password = '{$password}' ";
		if( $result = $cxn->query($query) )
		{
			if($user_row = mysqli_fetch_assoc($result))
			{
				if($user_row['uname'] == $uname && $user_row['password'] == $password)
				{
					$reg_num = $user_row['reg_num'];
					$query1 = "SELECT * FROM registration WHERE reg_num = '$reg_num'";
					$query2 = "SELECT * FROM staff WHERE staff_id = '$uname'";
					if($user_row['level'] == 'student')
					{
						$new_result = $cxn->query($query1);
						$user_details = mysqli_fetch_assoc($new_result);
						$_SESSION['sname'] = $user_details['sname'];
						$_SESSION['fname'] = $user_details['fname'];
						$_SESSION['class'] = $user_details['class'];
						$_SESSION['stream'] = $user_details['stream'];
						$_SESSION['birthDate'] = $user_details['birth_date'];
						$_SESSION['email'] = $user_details['email'];
						$_SESSION['index_number'] = $user_row['reg_num'];
						$_SESSION['current_uname'] = $user_row['uname'];
						$_SESSION['access_level'] = $user_row['level'];
						$_SESSION['fathersname'] = $user_details['fathers_name'];
						$_SESSION['mothers_name'] = $user_details['mothers_name'];
						$_SESSION['parent_number'] = $user_details['parent_number'];
						$_SESSION['parent_address'] = $user_details['parent_address'];
						$_SESSION['illness'] = $user_details['illness'];
						$_SESSION['disability'] = $user_details['disability'];
						$_SESSION['authenticated'] = 'yes';
					header("location: index1.php"); 
					exit;
					}
					else
					{
						$new_result = $cxn->query($query2);
						$user_details = mysqli_fetch_assoc($new_result);
						$_SESSION['sname'] = $user_details['sname'];
						$_SESSION['fname'] = $user_details['fname'];
						$_SESSION['class'] = $user_details['class_id'];
						$_SESSION['subject'] = $user_details['subj_id'];
						$_SESSION['birthDate'] = $user_details['birth_date'];
						$_SESSION['email'] = $user_details['email'];
						$_SESSION['phone'] = $user_details['phone'];
						$_SESSION['address'] = $user_details['address'];

						$_SESSION['index_number'] = $user_row['reg_num'];
						$_SESSION['current_uname'] = $user_row['uname'];
						$_SESSION['access_level'] = $user_row['level'];
					$_SESSION['authenticated'] = 'yes';
					header("location: index.php"); 
					exit;
					}					
					
				}
				else
				{
					$msg = 'Incorrect password for ' . $user_row['uname'];
				}
			}	
			else
			{
				$msg = 'Incorrect login';
			}
			$result->close();
		}
		else
			$msg = 'Query not executed';
		}
	}
	}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>School Manager</title>
    <script src="getuser.js"></script>
    <link rel="stylesheet" type="text/css" href="default.css">
</head>

<body>
  <div class="school_manager">
     <div class="top">
        <h1>SCHOOL MANAGER</h1>
        <h2>access your school everywhere!</h2>
     </div>
     <div class="bar">
     	<div style="float: left; font: normal 16px 'Arial';">Login page</div>
        <div id="current_time" style="float: right; color: #999999"><?php echo date("l, d.M", time())."<br>".date("H:i", time()); ?></div>
     </div>
     <div class="content">
      <fieldset>  
       <legend>login to proceed </legend>
        <form action="login.php" method="post" >
        <table width="330" border="0" align="center" cellpadding="2">
          <tr>
            <td width="115" rowspan="2" style=" font-weight: normal;"><img src="images/connected_data_big copy.gif" />
            <br /> Enter your username and password.</td>
            <td width="205"><br>
              <label >User name:</label><br>
            <input name="uname" value="ivan" type="text" size="30" maxlength="20" id="user_name" onblur="getUser(this.value)" /></td>
          </tr>
          <tr>
            <td><label >Password:</label><br>
            <input name="password" value="9999" type="password" size="30" maxlength="20" /></td>
          </tr>
          <tr>
            <td width="115" rowspan="2" style=" font-weight: normal;">&nbsp;</td>
            <td><input name="login" type="submit" value="login" class="submit" /></td>
          </tr>
          <tr>
            <td id="response">&nbsp;<?php
   if(!empty($message)){echo "<p class=\"message\">" . $msg .
		  "</p>";}	
			// echo $msg; 
			?></td>
          </tr>
			 <tr>
			  <td> Student:</td><td>username: mark </td><td>password:1000 </td>
   		  </tr>
        </table>
      </form>
      </fieldset>
     </div>
     <div class='btm'>&copy; All rights reserved. <br/> An Ivan Masaba Production 2022</div>
   </div>
</body>
</html>
