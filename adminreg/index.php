<?php 
	session_start();
	if( $_SESSION['authenticated'] != 'yes' )
	{header("location: ../login.php");}
	require_once($_SERVER['DOCUMENT_ROOT'].'/schoolmanager/connection/connection.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/schoolmanager/common/sidebar.php');
	$current_user = $_SESSION['current_uname'];
	$access_level = $_SESSION['access_level'];

	if( $access_level == 'teacher' ){
        $cid = $_SESSION['class'];
    $sid = $_SESSION['subject'];
    $c = $cxn->query("SELECT class_name FROM class WHERE id='$cid'");
    $cl = mysqli_fetch_assoc($c);
    $class = $cl['class_name'];
     
    $s = $cxn->query("SELECT subj_name FROM subjects WHERE id='$sid'");
	$sub = mysqli_fetch_assoc($s);
    $subject = $sub['subj_name'];
    }
    

	$current_user_type = 'new';
	if( $current_user_type == 'new' )
	{	$tab1='tabs_active'; $tab2='tabs'; }
  	else
	{	$tab2='tabs_active'; $tab1='tabs'; }

	$password_change_msg = "";
	$form_msg = "";
	$new_form_msg = "";
	    $staff_id =  "";
	    $fname = "";
		$sname = "";
		$class = "";
		$subject = "";
		$index_number = "";
		$birth_date = "";
		$email = "";
		$phone = "";
		$address = "";
	
	
	
	if(isset($_POST['reg_new']))
	{
		$tab1='tabs_active'; 
		$tab2='tabs';
		$current_user_type = 'new';
		$error_fill = 0;
		$new_form_msg = "<div class='info' >";
		$staff_id =  $current_user;
		$fname = $_POST['fname'];
		$sname = $_POST['sname'];
		$class = $_POST['class'];
		$subject = $_POST['subject'];
    $birth_date = date('Y-m-d', strtotime($_POST['birth_date']));
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$address = $_POST['address'];
		$reg_type = 'admin';
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
			$sql = "SELECT id FROM staff WHERE staff_id = '$current_user'";

			$res = $cxn->query($sql);

			if(!empty($res)){
				$new_form_msg .= $current_user . " " . "already exits";
			}else{
	$query = "INSERT INTO staff( staff_id, class_id, subj_id, fname, sname, birth_date, email, phone, address) 
	VALUES('$staff_id', '$class', '$subject', '$fname', '$sname', '$birth_date', '$email', '$phone', '$address')";
			if( $result1 = $cxn->query("SELECT password FROM login WHERE uname = '$current_user'") )
			{
				if ( $current_pass = $result1->fetch_assoc() )
				{
					
						$cxn->query($query);
						if( $cxn->affected_rows )
						{
							$new_form_msg .= "Thank you for taking time to register";
						}
						else
							$new_form_msg .= " Registration failed. ".$cxn->error;
					
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
    <a href="../index.php" style="background: url(../images/frontpage.gif) no-repeat; padding-left: 22px;">Home</a>&nbsp;&nbsp;
    <a href="../sign out.php" style="background: url(../images/b_drop.png) no-repeat; padding-left: 18px;">Sign out</a>
</div>
<div id="greeting" style=" float: left;">Welcome, <?php echo "<b>" . $current_user . "</b>"; ?></div>
</div>
  <div class="content">
     <div class="sidebar">

	 <h4>Select an activity</h4>
        <h3 style="background-image: url(../images/frontpage1.png);" ><a href='../'>Home</a></h3>
        <?php     if( $access_level == 'teacher' ){ ?>
        <h3><a href="../adminr/">Add Results</a></h3>
        <h3 style="background-image: url(images/email_initiator.gif);" ><a href='../advres/'>View results</a></h3>
        <?php } ?>
     <h3><a href="../adminreg/">Account info</a></h3>
        <h3 style="background-image: url(../images/icon-30-cpanel.png);" ><a href="../options/">Change your settings</a></h3>
     </div>

     <div class="contents">
       <div id="today" style=" text-align: right; ">
         <div id="noticeState" style="font: bold 11px 'Arial'; padding: 0px 10px 10px 10px;">&nbsp;</div>
       </div>
       
        <a href="#" id="tab1" class="<?php echo $tab1; ?>" onclick="tabOver('composeNotice', 'tab1')">New <?php echo $access_level;  ?></a>
        
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
                <td colspan='2'><h5>Personal information &nbsp;</h5></td>
              </tr>
              <tr >
                <td width='25%' align='right'>First name:</td>
                <td width='75%'><input name='fname' type='text' value="<?php echo $current_user; ?>" size='35' maxlength='20'></td>
              </tr>
              <tr>
                <td align='right'>Other name:</td>
                <td><input name='sname' type='text' value="<?php echo $sname; ?>" size='35' maxlength='30' /></td>
              </tr>
              <tr >
			  <tr>
                <td align='right'>Class:</td>
                <td><select name='class' >
				<option value="" ></option>
				<?php   
                	if( $result = $cxn->query("SELECT * FROM class") )
					{
						while( $c = $result->fetch_assoc() )
						{
							echo "<option value='".$c['id']."' >&nbsp;".$c['class_name']."</option>";
						}
					}
					else echo $cxn->error;
					$result->close();
					?>
                    </select>
                    &nbsp;Subject:
                    <select name='subject'>
					<option value="" ></option>
				<?php  
                	if( $result = $cxn->query("SELECT * FROM subjects") )
					{
						while( $subjects = $result->fetch_assoc() )
						{
							echo "<option value='".$subjects['id']."'  >&nbsp;".$subjects['subj_name']."</option>";
						}
					}
					else echo $cxn->error;
					$result->close();
					?>
                    </select></td>
              </tr>
              <tr >
                <td align='right'>Date of birth:</td>
                <td ><input name='birth_date' type='date' id="birth_date" value="<?php echo $birth_date; ?>" size='35' maxlength='20'></td>
              </tr>
              <tr>
                <td align='right'>e-mail:</td>
                <td><input name='email' type='email' id="email" value="<?php echo $email; ?>" size='35' maxlength='30' /></td>
              </tr>
              <tr >
                <td align='right'>Phone numbers:</td>
                <td><input name='phone' type='text' value="<?php echo $phone; ?>" size='35' maxlength='30' /></td>
              </tr>
              <tr>
                <td align='right'>Address:</td>
                <td><input name='address' type='text' value="<?php echo $address; ?>" size='35' maxlength='50' /></td>
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
         
        </div>
        
    </div>
</div>
<div class='btm'>
    <a href='../index.php'>Home </a>
    <a href='../adminr/'> Add Results </a>
	<a href='../adminreg/'> Account info </a>
    <a href='../advres/'> View results </a>
    <br/>&copy; All rights reserved. <br/> An Ivan Masaba Production 2022
</div>
</body>
</html>
