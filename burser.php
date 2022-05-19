<?php 
	session_start();
	if( $_SESSION['authenticated'] != 'yes' )
	{header("location: ../login.php");}
	require_once($_SERVER['DOCUMENT_ROOT'].'/schoolmanager/connection/connection.php');
	$access_level = $_SESSION['access_level']; 
	
	//Code to permit student to register
	if( isset($_POST["permit_register"]) && $cxn && $_POST["reg_num"] != "" )
	{
		$student = $_POST["reg_num"];
		$query = "SELECT * FROM login WHERE reg_num='$student'";
		if( $result = $cxn->query($query) )
		{
			if( $row = $result->fetch_assoc() )
			{
			 	if( $row['registration'] == 'PERMITED' )
				{
					$response = "<h6>Student $student already permited to register</h6>";
					unset($student);
				}
				else
				{
					$cxn->query("UPDATE login SET registration='PERMITED' WHERE reg_num='$student'");
					$response = "<br/>Permision granted for ".$student;
					unset($student);
				}
			}
			else
				$response = "<h6>No such user was found </h6>".$cxn->error;
		}
		else
			$response = "<h6>No connection</h6> ".$cxn->error;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>registration</title>
<script type="text/javascript" src="../javascript.js"></script>
<script type="text/javascript" src="burser.js"></script>
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
    <a href="../home.php" style="background: url(../images/frontpage.gif) no-repeat; padding-left: 22px;">Home</a>&nbsp;&nbsp;
    <a href="../sign out.php" style="background: url(../images/b_drop.png) no-repeat; padding-left: 18px;">Sign out</a>
</div>
<div id="greeting" style=" float: left;">Welcome, current_user</div>
</div>
  <div class="content">
     <div class="sidebar">
        <h4>Select an activity</h4>
        <h3 style="background-image: url(../images/frontpage1.png);" ><a href='../index.php'>Home</a></h3>
        <h3><a href="">Registration</a></h3>
        <h3 style="background-image: url(images/email_initiator.gif);" ><a href='../results/'>View results</a></h3>
        <h3 style="background-image: url(../images/inbox1.png);" ><a href="../notices">Notices and forums</a></h3>
        <h3 style="background-image: url(images/review_shared.gif);" ><a href="../planner">Carlender</a></h3>
        <h3 style="background-image: url(../images/icon-30-cpanel.png);" ><a href="../options">Change your settings</a></h3>
     </div>
     <div class="contents">
       <div id="today" style=" text-align: right; ">
         <div id="noticeState" style="font: bold 11px 'Arial'; padding: 0px 10px 10px 10px;">&nbsp;</div>
       </div>
       
       <div style=" padding: 8px 5px; border: solid 1px #999999; background-color: #f9f9fb;">
       <div class='reg_form' style="padding: 0px 10px 10px 10px;">
           <fieldset><legend>Allow to register</legend>
                Enter the student's registration number to permit him to register.
               <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="reg_permision" style="margin: 10px;">
               	<input name="reg_num" type="text" size="30" value="<?php echo $student; ?>" maxlength="20" />
                <input name="permit_register" type="submit" value="&nbsp;permit&nbsp;" style='font: bold 11px arial;' />
                <?php echo $response; ?>
               </form>
           </fieldset>
      <div class="search_box">
          <form action="" method="post" name="find_student" style="margin: 3px;">
            <table width="401" border="0">
              <tr>
                <td width="56" >SEARCH:</td>
                <td align="left"><input onkeyup="showHint(this.value)" id="search_name" onfocus="magic('on')" maxlength="25" onblur="magic('off')" /></td>
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
       </div>
       <div class='reg_form' style="padding: 10px 10px 15px 10px; margin-top: 10px;">
       	<h5 style=" border-bottom: solid 1px #306396; padding-bottom: 2px; margin-bottom: 10px;">Search results:</h5>
        <div id="show_hint" style="margin: 0px 15px;">&nbsp;</div>
       </div>
    </div>    
    </div>
</div>
<div class='btm'>
    <a href='../index.php'>Home </a>
    <a href='../registration/'> Registration </a>
    <a href='../results/'> View results </a>
    <a href="../notices"> Notices and forums </a>
    <a href="../options.php"> Change your settings</a>
    <br/>&copy; All rights reserved. <br/> An Irakiza Andrew Production 2009
</div>
</body>
</html>
