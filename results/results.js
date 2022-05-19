// JavaScript Document for results folder

var xmlHttp;

//Function to calculte the total and grade 
//when the results inboxes loose or gain focus
function total_grade( str, str1, str2, total, grade)
{
	var mark1 = document.getElementById(str).value;
	var mark2 = document.getElementById(str1).value;
	var mark3 = document.getElementById(str2).value;
	var average;
	if( mark1 == "" )
	{
		if( mark2 == "" && mark3 == "" )
		{
			document.getElementById(total).innerText = "";
			document.getElementById(grade).innerText = "";
			return; 
		}
		else if( mark3 == "" )
		{
			average = parseInt(mark2) ; 
		}
		else if( mark2 == "" )
		{
			average = parseInt(mark3) ; 
		}
		else
		{
			average = ( parseInt(mark2) + parseInt(mark3) )/2; 
		}
		document.getElementById(total).innerText = Math.round(average);
		document.getElementById(grade).innerText = gradeResult(average);
	}
	else if( parseInt(mark1) <= 100 || parseInt(mark1) <= 0 )
	{
		if( mark2 == "" && mark3 == "" )
		{
			average = parseInt(mark1); 
		}
		else if( mark3 == "" )
		{
			average = ( parseInt(mark1) + parseInt(mark2) )/2; 
		}
		else if( mark2 == "" )
		{
			average = ( parseInt(mark1) + parseInt(mark3) )/2; 
		}
		else
		{
			average = ( parseInt(mark1) + parseInt(mark2) + parseInt(mark3) )/3; 
		}
		document.getElementById(total).innerText = Math.round(average);
		document.getElementById(grade).innerText = gradeResult(average);
	}
	else
	{
		alert("Incorect mark entered, please revise.");
		document.getElementById(str).value = "";
		average = parseInt(document.getElementById(total).innerText);
	}
}

// Function to grade the results
function gradeResult( mark )
{
	if( mark <=100 && mark >=0 )
	{
		if( mark >= 80 )
			return "D1";
		else if( mark >= 75 )
			return "D2";
		else if( mark >= 70 )
			return "C3";
		else if( mark >= 65 )
			return "C4";
		else if( mark >= 60 )
			return "C5";
		else if( mark >= 50 )
			return "C6";
		else if( mark >= 45 )
			return "P7";
		else if( mark >= 40 )
			return "P8";
		else if( mark <= 39 )
			return "F9";		
	}
}

// Function to check browser Ajax suport
function GetXmlHttpObject()
{
var xmlHttp=null;
try
  {
  // Firefox, Opera 8.0+, Safari
  xmlHttp=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
  try
    {
    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
  catch (e)
    {
    xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
return xmlHttp;
}

// Keep checking in the server for new messages
/*setInterval(checkMsg, 3000);

function checkMsg()
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	  {
	  alert ("Your browser does not support AJAX!");
	  return;
	  } 
	var url="checkMsg.php";
	url=url+"?sid="+Math.random();
	xmlHttp.onreadystatechange=noticesChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
} 

function noticesChanged() 
{ 
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("noticeState").innerHTML=xmlHttp.responseText;
	}
}*/



// Function to display and change tabs
function tabOver(str, str1)
{
	document.getElementById('tab1').className = "tabs";
	document.getElementById('tab2').className = "tabs";
	document.getElementById('Create_report').style.display="none";
	document.getElementById('Class_results').style.display="none";
	document.getElementById(str).style.display="block";
	document.getElementById(str1).className = "tabs_active";
}