<?php 
	session_start();
	if( $_SESSION['authenticated'] != 'yes' )
	{header("location: ../login.php");}
	require_once($_SERVER['DOCUMENT_ROOT'].'/schoolmanager/connection/connection.php');
	$access_level = $_SESSION['access_level']; 
	$show_this = ""; //This variable will be used to determine which form to show
	//Code to change or upload person's picture
	
	$password_change_msg = "";
	$upload_info = "";
	$create_user_msg = "";
	$response = "";
	
	if( isset($_POST["change_pic"]) )
	{
		$uploaddir = 'C:/xampp/htdocs/schoolmanager/pics/';
		$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
		
		if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) 
		{
			$upload_info = "<div class='info'>Picture is valid, and was successfully changed.</div>\n";
		} 
		else 
		{
			$upload_info = "<h6>";
			$upload_info .= upload_error($_FILES["userfile"]["error"])."</h6>\n";
		}
				
		$uploads_dir = '/uploads';
		if($_FILES["userfile"]["error"] == UPLOAD_ERR_OK) 
		{
			$tmp_name = $_FILES["userfile"]["tmp_name"][$key];
			$name = $_FILES["userfile"]["name"][$key];
			move_uploaded_file($tmp_name, "$uploads_dir/$name");
		}
		else
			$_FILES["userfile"]["error"];
		echo 'file name: '.$_FILES["userfile"]["name"].'<br>';
		echo 'type: '.$_FILES["userfile"]["type"].'<br>';
		echo 'temporary folder: '.$_FILES["userfile"]["tmp_name"].'<br>';
		echo 'error: '.$_FILES["userfile"]["error"].'<br>';
		$show_this = "upload_new_pic";
	}
	//function that has a record of all errors
	//it takes in an error-code then produces the right error message
	function upload_error($error_code)
	{
	
		if( $error_code == 0 ) 
		{ return  ' There is no error, the file uploaded with success.'; } 
		elseif( $error_code == 1 ) 
		{ return  'ERROR: The uploaded file exceeds the maximam upload size.<br/> Reduce size of the image.'; }
		elseif( $error_code == 2 ) 
		{ return  'ERROR: The uploaded file exceeds the maximam upload size.<br/> Reduce size of the image.'; }
		elseif( $error_code == 3 ) 
		{ return  'ERROR: The uploaded file was only partially uploaded. <br/> Please try again.'; }
		elseif( $error_code == 4 ) 
		{ return  'ERROR: No file was uploaded.'; }
		elseif( $error_code == 6 ) 
		{ return  'ERROR: Missing a temporary folder. <br/> Try again later'; }
		elseif( $error_code == 7 ) 
		{ return  'ERROR: Failed to write file to disk. <br/> Try again later'; }
	}
	
	// Code to change a user's password.
	if(isset($_POST['change_password']))
	{
		$old_password = $_POST['old_password'];
		$new_password = $_POST['new_password'];
		$confirm_password = $_POST['confirm_password'];
		$current_uname = $_SESSION['current_uname'];
		$error_fill = 0;
		//check for empty fields
		foreach( $_POST as $field => $value )
		{
			if ( $value == "")
			{
				$password_change_msg = "<h6>error: All fields must be filled out.<br/></h6>";
				$error_fill = 1;
			}
		}
		
		//verify user's current password for security purpose
		if( $result1 = $cxn->query("SELECT password FROM login WHERE uname = '$current_uname'") )
		{
			if ( $current_pass = $result1->fetch_assoc() )
			{
				if( $current_pass['password'] != $old_password)
				{
					$password_change_msg = "<h6>error: The current password entered is incorrect<br/></h6>";
					$error_fill = 1;		
				}
				//verify that the passwords that have been entered are the same
				else if ( $new_password != $confirm_password)
				{ 
					$password_change_msg = "<h6>error: Passwords supplied do not match<br/></h6>"; 
					$error_fill = 1;
				}
			}
		}
		else
		{
			$password_change_msg = "<h6>An error has occured.<br/></h6>">$cxn->error;
			$error_fill = 1;
		}
		$result1->close();
		// if no errors, go ahead and change passwords
		if ( $error_fill == 0 )
		{
			$query = "UPDATE login SET password = '$new_password' WHERE uname = '$current_uname'";
			if ($cxn->query($query) && $cxn->affected_rows )
				$password_change_msg = "<div class='info'>Your password has been succesfully changed<br/></div>";
			else
				$password_change_msg = "<h6> Password change failed. ".$cxn->error."x</h6>";
		}
		$show_this = "change_current_pass";
	}
	
	// Code to create a new user.
	if(isset($_POST['create_new_user']))
	{
		$reg_num = $_POST['new_user_id'];
		$access_level = $_POST['user_type'];
		$user_name = $_POST['new_username'];
		$password = $_POST['new_password'];
		$error_fill = 0;
		//check for empty fields
		if ( $reg_num == "")
		{
			$create_user_msg = "<h6>error: Please enter index number or staff ID.<br/></h6>";
			$error_fill = 1;
		}
				
		// if no errors, go ahead and create user
		if ( $error_fill == 0 )
		{
			$query = "INSERT INTO login(reg_num, uname, password, level) VALUES('$reg_num', '$user_name', '$password', '$access_level')";
			$cxn->query($query);
			if( $cxn->affected_rows )
			{
				$create_user_msg = "<div class='info'><b>An account has been created for:</b><br>";
				$create_user_msg .= "<b>User:</b> $user_name<br/>";
				$create_user_msg .= "<b>Type of user:</b> $access_level<br/>";
				$create_user_msg .= "<b>Index no./ Staff ID:</b> $reg_num<br/>";
				$create_user_msg .= "<b>Password:</b> $password";
				$create_user_msg .= "<hr/>*Please take note of the password<br/>";
				$create_user_msg .= "</div>";
			}
			else
				$create_user_msg = " User creation failed. ".$cxn->error;
		}
		$show_this = "add_new_user";
	}
	
	//Permit user to change deatils
	if( isset($_POST["permit_button"]) && $cxn && $_POST["permit_id"] != "" )
	{
		$user = $_POST["permit_id"];
		$query = "SELECT * FROM login WHERE reg_num='$user'";
		if( $result = $cxn->query($query) )
		{
			if( $row = $result->fetch_assoc() )
			{
			 	if( $row['change_details'] == 'PERMITED' )
				{
					$response = "<h6>WARNING: User <b>$user</b> is already permited to change details</h6>";
				}
				else
				{
					if( $cxn->query("UPDATE login SET change_details='PERMITED' WHERE reg_num = '$user'") )
					{
						$response = "<div class='info'>Permision granted for <b>".$user."</b></div>";
					}
					else
					$response = "<h6>ERROR: Grant permision failed </h6>";
				}
			}
			else
				$response = "<h6>error: No such user was found </h6>".$cxn->error;
		}
		else
			$response = "<h6>error: No connection</h6> ".$cxn->error;
		$show_this = "permit_change";
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>options</title>
<script type="text/javascript" src="../common/javascript.js"></script>
<script type="text/javascript" src="options.js"></script>
<link rel="stylesheet" type="text/css" href="../styles.css">
<link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body onload="showCorrectForm('<?php echo $show_this;?>')">
<div class="top">
    <h1>SCHOOL MANAGER</h1>
    <h2>access your school everywhere!</h2>
</div>
<div class="bar">
<div id="current_time" style="color: #49AF3A; text-align:right; margin-bottom: 10px;"><?php echo date("l, d.M H:i", time()); ?></div>
<div style="float: right;">
    <a href="../index.php" style="background: url(../images/frontpage.gif) no-repeat; padding-left: 22px;">Home</a>&nbsp;&nbsp;
    <a href="../sign out.php" style="background: url(../images/b_drop.png) no-repeat; padding-left: 18px;">Sign out</a>
</div>
<div id="greeting" style=" float: left;">Welcome, <?php echo $_SESSION['current_uname'];?></div>
</div>
  <div class="content">
     <div class="sidebar">
        <h4>Select an activity</h4>
        <h3 style="background-image: url(../images/frontpage1.png);" ><a href='../index.php'>Home</a></h3>
        <h3><a href="../adminr">Add Results</a></h3>
		<h3><a href="../adminreg/">Account info</a></h3>
        <h3 style="background-image: url(images/email_initiator.gif);" ><a href='../advres/'>View results</a></h3>
        <h3 style="background-image: url(../images/icon-30-cpanel.png);" ><a href="#">Change your settings</a></h3>
     </div>
     <div class="contents">
       <div id="today" style=" text-align: right; ">
       </div>
       <div style=" padding: 8px 5px; border: solid 1px #999999; background-color: #f9f9fb;">
       <div class="search_box">
          <form action="" method="post" name="find_student" style="margin: 3px;">
            <table width="200" border="0">
              <tr>
                <td >SEARCH:</td>
                <td><input onkeyup="showHint(this.value)" id="search_name" onfocus="magic('on')" maxlength="25" onblur="magic('off')" /></td>
              </tr>
              <tr>
                <td><img src="images/magnify.gif" alt="search icon" /></td>
                <td align="left" style="font-size:14px; line-height: 20px">
                Find a student quickly<br/>
                <span style="color:#333333; font-size:12px">Enter name for the student in the box.</span></td>
              </tr>
            </table> 
          </form>
       </div>
       <div class='reg_form' style="padding: 0px 10px 30px 10px;">
       <br/>
       <!--Form used to change one's password-->
       <h5 id="first" onclick="show_hide('change_current_pass', 'first')">Change your password</h5>
          <form action="<?php $_SERVER['PHP_SELF'];?>" id="change_current_pass" method="post" name="change_current_password" style="margin: 10px; display:none">
            Enter you current password then the new one.
          <table width="100%%" border="0" cellpadding="5" style="color: #000000;">
            <tr>
              <td width="25%" align="right">Current password:</td>
              <td width="75%"><input name="old_password" type="password" size="45" maxlength="25" style='font-size:12px;'/></td>
            </tr>
              <tr>
                <td align="right">New password:</td>
                <td><input name="new_password" type="password" size="45" maxlength="25" style='font-size:12px;' /></td>
              </tr>
              <tr>
                <td align="right">Confirm password:<br>&nbsp;</td>
                <td><input name="confirm_password" type="password" size="45" maxlength="25" style='font-size:12px;' /><br/>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2" align="right" style="border-top:solid 1px #cccccc; padding-top: 5px;" >
                  <input name="change_password" type="submit" value="&nbsp;change password&nbsp;" style='font: bold 11px arial;' />
                  <input name="cancel" type="button" value="&nbsp;cancel&nbsp;" style='font: bold 11px arial;' /></td>
              </tr>
            </table>
            <?php echo $password_change_msg; ?>
       </form>
       <!--form to allow a user to change their image-->
       <h5 id="second" onclick="show_hide('upload_new_pic', 'second')">Change your image</h5>
        <form enctype="multipart/form-data" id="upload_new_pic" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" style="margin: 10px; display:none">
        Hit the browse button to upload your image.
            <table width="100%" border="0" cellpadding="2">
              <tr>
                <td><!-- MAX_FILE_SIZE precedes the file input field but iis hidden -->
                <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
                <!-- Name of input element that determine name in $_FILES array -->
                <input name="userfile" type="file" size="40" /><br/>&nbsp;</td>
              </tr>
              <tr>
                <td align="right" style="border-top:solid 1px #cccccc; padding-top: 5px;" >
                <input type="submit" name="change_pic" value="&nbsp;change image&nbsp;" style="font: bold 11px arial;" /></td>
              </tr>
            </table>
        <?php echo $upload_info; ?>
        </form>
        <!--Below is the form to create a new user. This data is stored in the login table in the database-->
        <h5 id="third" onclick="show_hide('add_new_user', 'third')">Add new system user</h5>
         <form action="<?php $_SERVER['PHP_SELF'];?>" id="add_new_user" method="post" name="add_new_user" style="margin: 10px; display:none">
           Simply supply the information below:<br/>
           <h4 style="background:url(../images/P_Info_win.gif) left no-repeat; padding: 3px 20px; margin:5px 0px;">Password will automatically be generated.</h4>
           <table width="100%" border="0" cellpadding="5" style="color: #000000; margin: 5px 0px">
            <tr>
              <td width="14%" align="right">User ID:</td>
              <td width="40%"><input size="30" onkeyup="help_fill(this.value)" name="new_user_id" id="new_user_id" maxlength="25" style='font-size:12px;'/></td>
              <td width="18%" align="right">Type of user:</td>
              <td width="28%"><select name="user_type" id="user_type">
                <option value="student" selected="selected">Student</option>
                <option value="teacher">Teacher</option>
                <option value="admin">Administrator</option>
                <option value="bursar">Bursar</option>
              </select></td>
            </tr>
              <tr>
                <td align="right">Password:</td>
                <td colspan="3"><input name="new_password" id="newu_password" size="30" maxlength="25" style='font:bold 12px Arial;' /></td>
              </tr>
              <tr>
                <td align="right">Username:<br>&nbsp;</td>
                <td colspan="3"><input name="new_username" id="new_uname" size="30" maxlength="25" style='font-size:12px;' /><br/>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="4" align="right" style="border-top:solid 1px #cccccc; padding-top: 5px;" >
                  <input name="create_new_user" type="submit" value="&nbsp; create new user &nbsp;" style='font: bold 11px arial;' />
                  <input name="cancel" onclick="clearForm('add_new_user')" type="button" value="&nbsp; cancel &nbsp;" style='font: bold 11px arial;' /></td>
              </tr>
            </table>
            <?php echo $create_user_msg;?>
         </form>
         <!--Below is the form used by the system admin to allow a user to edit their details-->
          <h5 id="fourth" onclick="show_hide('permit_change', 'fourth')">Permit student to change details</h5>
         <form action="<?php $_SERVER['PHP_SELF'];?>" id="permit_change" method="post" name="permit_change" style="margin: 10px; display:none">
           <br/><h4 style="background:url(../images/P_Info_win.gif) left no-repeat; padding: 3px 20px; margin:5px 0px;">Enter the student's index number.</h4>
           <table width="100%" border="0" cellpadding="5" style="color: #000000; margin: 5px 0px">
              <tr>
                <td width="19%" align="right">Index number:<br>
                &nbsp;</td>
                <td width="81%">
                    <input name="permit_id" type="text" size="30" maxlength="25" style='font-size:12px;' /> 
                    <input name="permit_button" type="submit" value="  permit student  " style='font: bold 11px arial;' /><br/>
                    &nbsp;
                </td>
              </tr>
              <tr>
                <td colspan="2" style="border-top:solid 1px #cccccc; padding-top: 5px;" ><?php echo $response; ?></td>
              </tr>
            </table>            
         </form>
         <br/>
       </div>
       <div id="show_hint">&nbsp;</div>
    </div>    
    </div>
</div>
<div class='btm'>
    <a href='../index.php'>Home </a>
    <a href='../registration/'> Registration </a>
    <a href='../results/'> View results </a>
    <a href="../options"> Change your settings</a>
    <br/>&copy; All rights reserved. <br/> An Ivan Masaba Production 2022
</div>
</body>
</html>