<?php
  // This file contains all the basic functions 
  function mysql_prep($value){
    $magic_quotes_active = get_magic_quotes_gpc();
	$new_enough_php = function_exists("mysql_real_escape_string");//i.e PHP >= v4.3.0
	if($new_enough_php){
	  //undo any magic quotes effect so mysql_real_escape_string can do the work
	  if($magic_quotes_active){ $value = stripslashes($value);}
	   $value = mysql_real_escape_string($value);
	  }  else{ // before PHP v4.3.0
	    //if any quotes aren't already on then add slashes manually
		if(!$magic_quotes_active){ $value = addslashes($value);}
		 //if magic quotes are active, then the slashes already exist
	  }
	  return $value;
	 }
	
   function redirect_to($location = NULL){
   if($location != NULL){
       header("Location: {$location}");
	  exit;
	  }
   }
	
    function confirm_query($result_set){
	  if(!$result_set){
			     die("Database query failed");
			   }
	}
	
	function get_all_subjects($public = true){
	  global $connection;
	    $query = "SELECT * 
			     FROM subjects ";		 
		 if($public){	 
				$query .= "WHERE visible = 1 ";
			}
		 $query .= "ORDER BY position ASC";
		 $subject_set = mysql_query($query,$connection);
		  confirm_query($subject_set);
		  return $subject_set;
	}
	
	function get_pages_for_subject($subject_id, $public = true){
	global $connection;
	  $query = "SELECT * 
				FROM pages ";
      $query .= "WHERE subject_id = {$subject_id} ";		 
		 if($public){	 
			$query .= "AND visible = 1 ";
			}				
	  $query .= "ORDER BY position ASC";
				 $page_set = mysql_query($query,$connection);
				       confirm_query($page_set);
			return $page_set;		   
	}

	function get_subject_by_id($subject_id){
	   global $connection;
	  $query = "SELECT * ";
	  $query .= "FROM subjects ";
	  $query .= "WHERE id=" . $subject_id . " ";
	  $query .= "LIMIT 1"; //if there are many results return only 1 row.
	 $result_set = mysql_query($query,$connection);
      confirm_query($result_set);
    //if no rows are returned fetch_array will return false	  
     if($subject = mysql_fetch_array($result_set)){
      return $subject;	 }
	  else{
	    return NULL;
	  }
	}
	
	function get_page_by_id($page_id){
	    global $connection;
		$query = "SELECT * ";
	  $query .= "FROM pages ";
	  $query .= "WHERE id=" . $page_id . " ";
	  $query .= "LIMIT 1"; //if there are many results return only 1 row.
	 $result_set = mysql_query($query,$connection);
      confirm_query($result_set);
    //if no rows are returned fetch_array will return false	  
     if($page = mysql_fetch_array($result_set)){
      return $page;	 }
	  else{
	    return NULL;
	  }
	}
	
	function get_default_page($subject_id){
	   //get all visible pages
	   $page_set = get_pages_for_subject($subject_id, true);
	   if($first_page = mysql_fetch_array($page_set)){
	     return $first_page;
	   } else{
	     return NULL;
	   }
	}
	
	function find_selected_page(){
	global $sel_subject;
	global $sel_page;
	if(isset($_GET['subj'])){
		$sel_subject = get_subject_by_id($_GET['subj']);
	    $sel_page = get_default_page($sel_subject['id']);
	}
	elseif(isset($_GET['page'])){ 	
       $sel_subject = NULL;
	   $sel_page = get_page_by_id($_GET['page']);
	}
	else{
		$sel_subject = NULL;
		$sel_page = NULL;
	}
	}
	
	function navigation($sel_subject, $sel_page,$public = false){
	  $output = "<ul class=\"subjects\">";
			 
			 // 3. Perform database query
			$subject_set = get_all_subjects($public);
			  //  4. use the returned data
			  while($subject = mysql_fetch_array($subject_set)){
			    $output .= "<li";
				  //check to see if a subject is selected
				if($subject["id"] == $sel_subject['id']){
				   //if true add class=selected to subject
					$output .= " class=\"selected\"";
					}
				$output .= "><a href=\"edit_subject.php?subj=". urlencode($subject["id"]) .
				"\">{$subject["menu_name"]}</a></li>";
				$page_set = get_pages_for_subject($subject["id"],$public);
				 	$output .= "<ul class=\"pages\">";
			  while($page = mysql_fetch_array($page_set)){
			    $output .= "<li";
				 //check to see if a page is selected
				if($page["id"] == $sel_page['id']){
				  //if true add class=selected to page
					$output .= " class=\"selected\"";
					}
				$output .= "><a href=\"content.php?page=" . urlencode($page["id"]) . 
				"\">{$page["menu_name"]}</a></li>";
			  }
			  $output .= "</ul>";
			  }
			
			   $output .= " </ul> ";
			   
			   return $output;
	}
	
	function public_navigation($sel_subject, $sel_page,$public = true){
	  $output = "<ul class=\"subjects\">";
			 
			 // 3. Perform database query
			$subject_set = get_all_subjects($public);
			  //  4. use the returned data
			  while($subject = mysql_fetch_array($subject_set)){
			    $output .= "<li";
				  //check to see if a subject is selected
				if($subject["id"] == $sel_subject['id']){
				   //if true add class=selected to subject
					$output .= " class=\"selected\"";
					}
				$output .= "><a href=\"index.php?subj=". urlencode($subject["id"]) .
				"\">{$subject["menu_name"]}</a></li>";
				if($subject["id"] == $sel_subject['id']){
						$page_set = get_pages_for_subject($subject["id"],$public);
						 $output .= "<ul class=\"pages\">";
					  while($page = mysql_fetch_array($page_set)){
						$output .= "<li";
						 //check to see if a page is selected
						if($page["id"] == $sel_page['id']){
						  //if true add class=selected to page
							$output .= " class=\"selected\"";
							}
						$output .= "><a href=\"index.php?page=" . urlencode($page["id"]) . 
						"\">{$page["menu_name"]}</a></li>";
					  }
					  $output .= "</ul>";
					   }
			  }
			
			   $output .= " </ul> ";
			   
			   return $output;
	}
	
	?>