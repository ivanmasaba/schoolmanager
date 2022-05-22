<?php 
	session_start();
	if( $_SESSION['authenticated'] != 'yes' )
	{header("location: ../login.php");}
	require_once($_SERVER['DOCUMENT_ROOT'].'/schoolmanager/connection/connection.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/schoolmanager/common/sidebar.php');
	$current_user = $_SESSION['current_uname'];
	$current_user_type = 'new';
	if( $current_user_type == 'new' )
	{	$tab1='tabs_active'; $tab2='tabs'; }
  	else
	{	$tab2='tabs_active'; $tab1='tabs'; }

	$password_change_msg = "";
	$form_msg = "";
	$new_form_msg = "";
	
	$fname = "";
		$sname = "";
		$index_number = "";
		$class = "";
		$stream = "";
		$old_password = "";
		$new_password = "";
		$confirm = "";
		$birth_date = "";
		$email = "";
		$fathers_name = "";
		$mothers_name = "";
		$parent_number = "";
		$parent_address = "";
		$illness = "";
		$disability = "";
		$others = "";
	
	
	
	
	// Code for validating then regestering students.
	if(isset($_POST['reg_old'])){
		$tab2='tabs_active'; 
		$tab1='tabs';
		$current_user_type = 'old';
		$error_fill = 0;
		$old_password = $_POST['old_password'];
		$new_password = $_POST['new_password'];
		$confirm_password = $_POST['confirm'];
		//check for empty fields
		$form_msg = "<div class='info' >";
		foreach( $_POST as $field => $value )
		{
			if ( $value == "")
			{
				$password_change_msg .= "*All fields must be filled out.<br/>";
				$error_fill = 1;
			}
		}
		
		//verify user's current password for security purpose
		if( $result1 = $cxn->query("SELECT password FROM login WHERE uname = '$current_user'") )
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
			$query = "UPDATE login SET password = '$new_password' WHERE uname = '$current_user'";
			if ($cxn->query($query) && $cxn->affected_rows )
				$password_change_msg = "<div class='info'>Your password has been succesfully changed<br/></div>";
			else
				$password_change_msg = "<h6> Password change failed. ".$cxn->error."x</h6>";
		}
		$show_this = "change_current_pass";
  }    
  
	else if(isset($_POST['reg_new']))
	{
		$tab1='tabs_active'; 
		$tab2='tabs';
		$current_user_type = 'new';
		$error_fill = 0;
		$new_form_msg = "<div class='info' >";
		$fname = $_POST['fname'];
		$sname = $_POST['sname'];
		$index_number = $_POST['index_number'];
		$class = $_POST['class'];
		$stream = $_POST['stream'];
    $old_password = $_POST['old_password'];
    $birth_date = date('Y-m-d', strtotime($_POST['birth_date']));
		$email = $_POST['email'];
		$fathers_name = $_POST['fathers_name'];
		$mothers_name = $_POST['mothers_name'];
		$parent_number = $_POST['parent_number'];
		$parent_address = $_POST['parent_address'];
		$illness = $_POST['illness'];
		$disability = $_POST['disability'];
		$others = $_POST['other_sickness'];
		$reg_type = 'new student';
		//check for empty fields
		foreach( $_POST as $field => $value )
		{
			if ( $value == "")
			{
				$new_form_msg .= "Some fields are empty.";
			}
		}
				
		//enter them into the database
		// if no errors, enter values into the database
		if ( $error_fill == 0 )
		{
			$query = "INSERT INTO registration(reg_num, fname, sname, class, stream, birth_date, email, fathers_name, mothers_name, parent_number, parent_address, illness, disability, others) 
			VALUES('$index_number', '$fname', '$sname', '$class', '$stream', '$birth_date', '$email', '$fathers_name', '$mothers_name', '$parent_number', '$parent_address', '$illness', '$disability', '$others');";
			if( $result1 = $cxn->query("SELECT password FROM login WHERE reg_num = '$index_number'") )
			{
				if ( $current_pass = $result1->fetch_assoc() )
				{
					if( $current_pass['password'] != $old_password)
					{
						$new_form_msg .= "*The current password entered ". $old_password ." is incorrect.";
					}
					else
					{
						$cxn->query($query);
						if( $cxn->affected_rows )
						{
							$new_form_msg .= "Thank you for taking time to register";
						}
						else
							$new_form_msg .= " Registration failed. ".$cxn->error;
					}
				}
				else
				{
					$new_form_msg .= "User does not exist ".$cxn->error;
				}
			}
			else
			{
				$new_form_msg .= " Password not read. ".$cxn->error;
			}
		}
		$new_form_msg .= "</div>";
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>registration</title>
<script type="text/javascript" src="../common/javascript.js"></script>
<script type="text/javascript" src="registration.js"></script>
<link rel="stylesheet" type="text/css" href="styles.css">
<link rel="stylesheet" type="text/css" href="../styles.css">
</head>

<body>
<div class="top">
    <h1>SCHOOL MANAGER</h1>
    <h2>access your school everywhere!</h2>
</div>
<div class="bar">
<div style="float: right;">
    <a href="../index1.php" style="background: url(../images/frontpage.gif) no-repeat; padding-left: 22px;">Home</a>&nbsp;&nbsp;
    <a href="../sign out.php" style="background: url(../images/b_drop.png) no-repeat; padding-left: 18px;">Sign out</a>
</div>
<div id="greeting" style=" float: left;">Welcome, <?php echo "<b>" . $current_user . "</b>"; ?></div>
</div>
  <div class="content">
     <div class="sidebar">
     <?php 

echo "<h4>Select an activity</h4>";
echo "<h3 style=\"background-image: url(../images/frontpage1.png);\" ><a href=\"../index1.php\">Home</a></h3>";
echo "<h3><a href='../registration/'>Registration</a></h3>";
echo "<h3 style=\"background-image: url(../images/email_initiator.gif);\" ><a href=\"../results/\">View results</a></h3>";

?>
     </div>
     <div class="contents">
       <div id="today" style=" text-align: right; ">
         <div id="noticeState" style="font: bold 11px 'Arial'; padding: 0px 10px 10px 10px;">&nbsp;</div>
       </div>
       
        <a href="#" id="tab1" class="<?php echo $tab1; ?>" onclick="tabOver('composeNotice', 'tab1')">New student</a>
        <a href="#" id="tab2" class="<?php echo $tab2; ?>" onclick="tabOver('viewMessages', 'tab2')">Continuing student</a>
        
        <div id="composeNotice" style=" padding: 0px 5px; border: solid 1px #999999; background-color: #f9f9fb; 
		<?php if( $current_user_type == 'new' )
                echo "display: block";
              else
                echo "display: none"; ?>" >
         <form name='new_student' method='post' action="<?php $_SERVER['PHP_SELF']; ?>" >
            <?php echo $new_form_msg; ?>
            <input name='reg_new' type='submit' value='register' style='font: bold 11px arial; margin: 10px 0px;'/>
            <div class='reg_form'>
            <table width='100%' border='0' cellpadding='1' cellspacing='0'>
              <tr>
                <td colspan='2'><h5>School information &nbsp;</h5></td>
              </tr>
              <tr >
                <td width='25%' align='right'>First name:</td>
                <td width='75%'><input name='fname' type='text' value="<?php echo $fname; ?>" size='35' maxlength='20'></td>
              </tr>
              <tr>
                <td align='right'>Other name:</td>
                <td><input name='sname' type='text' value="<?php echo $sname; ?>" size='35' maxlength='30' /></td>
              </tr>
              <tr >
                <td align='right'>Index number:</td>
                <td><input name='index_number' type='text' value="<?php echo $index_number; ?>" size='35' maxlength='20' /></td>
              </tr>
              <tr>
                <td align='right'>Class:</td>
                <td><select name='class' >
                        <option value='senior one'>Senior one</option>
                        <option value='senior two'>Senior two</option>
                        <option value='senior three'>Senior three</option>
                        <option value='senior four'>Senior four</option>
                    </select>
                    &nbsp;Stream:
                    <select name='stream'>
                        <option value='A'>&nbsp;A&nbsp;</option>
                        <option value='B'>&nbsp;B&nbsp;</option>
                        <option value='C'>&nbsp;C&nbsp;</option>
                    </select></td>
              </tr>
              <tr >
                <td align='right'>Current password:</td>
                <td><input name='old_password' type='password' size='35' maxlength='20' /></td>
              </tr>
              <tr >
                <td align='right'>Date of birth:</td>
                <td ><input name='birth_date' type='date' id="birth_date" value="<?php echo $birth_date; ?>" size='35' maxlength='20'></td>
              </tr>
              <tr>
                <td align='right'>e-mail:</td>
                <td><input name='email' type='text' id="email" value="<?php echo $email; ?>" size='35' maxlength='30' /></td>
              </tr>
            <tr>
                <td colspan='2'><h5>Parent information &nbsp;</h5></td>
              </tr>
              <tr >
                <td align='right'>Father's name:</td>
                <td><input name='fathers_name' type='text' value="<?php echo $fathers_name; ?>" size='35' maxlength='40' /></td>
              </tr>
              <tr>
                <td align='right'>Mother's name:</td>
                <td><input name='mothers_name' type='text' value="<?php echo $mothers_name; ?>" size='35' maxlength='40' /></td>
              </tr>
              <tr >
                <td align='right'>Phone numbers:</td>
                <td><input name='parent_number' type='text' value="<?php echo $parent_number; ?>" size='35' maxlength='30' /></td>
              </tr>
              <tr>
                <td align='right'>Address:</td>
                <td><input name='parent_address' type='text' value="<?php echo $parent_address; ?>" size='35' maxlength='50' /></td>
              </tr>
              <tr >
                <td colspan='2'><h5>Medical history &nbsp;</h5></td>
              </tr>
              <tr>
                <td align='right'>Any  illness:</td>
                <td><input name='illness' type='text' value="<?php echo $illness; ?>" size='35' maxlength='50' /></td>
              </tr>
              <tr >
                <td align='right'>Physical disabilty(if any):</td>
                <td><input name='disability' type='text' value="<?php echo $disability; ?>" size='35' maxlength='50' /></td>
              </tr>
              <tr>
                <td align='right'>Others:</td>
                <td><input name='other_sickness' type='text' value="<?php echo $others; ?>" size='35' maxlength='50' /></td>
              </tr>
            </table>
            </div>
            <input name='reg_new' type='submit' value='register' style='font: bold 11px arial; margin: 10px 0px;'/>
          </form>
        </div>
        
        <div id="viewMessages" style=" padding: 0px 8px; border: solid 1px #999999; background-color: #f9f9fb;
		<?php if( $current_user_type == 'new' )
                echo "display: none";
              else
                echo "display: block"; ?>">
         <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="continuing" >
            <input name='reg_old' type='submit' value='change password' style='font: bold 11px arial; margin: 10px 0px;'/><br />
            <div class='reg_form'>	
            <table width="595px" border="0" cellpadding="4">
              <tr>
                <td colspan='3'><h5>Change Password &nbsp;</h5></td>
              </tr>
              <tr >
                <td align='right'>Current password:</td>
                <td><input name='old_password' type='password' size='35' maxlength='20' /></td>
                <td>&nbsp;</td>
              </tr>
              <tr >
                <td align='right'>New password:</td>
                <td><input name='new_password' type='password' size='35' maxlength='20' /></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align='right'>Confirm password:</td>
                <td><input name='confirm' type='password' size='35' maxlength='20' /></td>
                <td>&nbsp;</td>
              </tr>
            </table>
            </div>
            <input name='reg_old' type='submit' value='change password' style='font: bold 11px arial; margin: 10px 0px;'/><br />
			<?php echo $password_change_msg; ?>
			</form>
        </div>
        
    </div>
</div>
<div class='btm'>
    <a href='../index1.php'>Home </a>
    <a href='../registration/'> Registration </a>
    <a href='../results/'> View results </a>
    <br/>&copy; All rights reserved. <br/> An Ivan Masaba Production 2022
</div>
</body>
</html>
