// This file contains the javascript
// common to all or most pages

//This avariable will be used to hold the XmlHttpObect
var xmlHttp;

// Function to check browser Ajax suport
//There's a need to do this check on all pages where Ajax is used.
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
//For those pages where unread messages are shown.
setInterval(checkMsg, 3000);
/*
function checkMsg()
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	//while we're at it let's show the right time
	var todayDate = new Date();
	document.getElementById("current_time").innerHTML = todayDate;
	//show the right greeting
	if(todayDate.getHours() < 12)
		document.getElementById("greeting").innerHTML = 'Good morning, <?php echo $_SESSION[\'current_user\'];?>';
	else if(todayDate.getHours() < 16)
		document.getElementById("greeting").innerHTML = "Good afternoon, <?php echo $_SESSION['current_user'];?>";
	else if(todayDate.getHours() <= 23)
		document.getElementById("greeting").innerHTML = 'Good evening, <\?php echo $_SESSION[\'current_user\'];\?>';
	var url="checkMsg.php";
	url=url+"?sid="+Math.random();
	xmlHttp.open("GET",url,true);
	xmlHttp.onreadystatechange = function() 
	{ 
		if (xmlHttp.readyState==4)
		{ 
			document.getElementById("noticeState").innerHTML=xmlHttp.responseText;
		}
	}
	xmlHttp.send();
} */

// Function to display drop dowm menus
function dropDown(str, str0)
{
	var str1;
	if( document.title != "notices" )
	{
		return;
	}
	else
	{
		if( document.getElementById(str).style.display=="block" )
		{
			document.getElementById(str).style.display="none";
			str1 = 'down';
			
		}
		else
		{
			document.getElementById(str).style.display="block";
			str1 = 'up';
		}
	}
	swap(str0, str1);
}

function swap(str, str0)
{
	if( document.images )
	{
		if( str0 == 'up' )
		{
			document.images[str].src="../images/btnUpSmall.gif";
		}
		else
		{
			document.images[str].src="../images/btnDownSmall.gif";
		}
	}
}

// Function to display and change tabs
function tabOver(str, str2)
{
	document.getElementById('tab1').className = "tabs";
	document.getElementById('tab2').className = "tabs";
	document.getElementById('viewMessages').style.display="none";
	document.getElementById('composeNotice').style.display="none";
	document.getElementById(str).style.display="block";
	document.getElementById(str2).className = "tabs_active";
}

//This is the function called by the cancel buttons on differet forms
//It takes in the forms name and clears all text fileds
function clearForm(formName)
{
	var myform = document.forms[2];
	for (var i = 0; i < myform.elements.length; i++) 
	{
		if (myform.elements[i].type == "text") 
		{
			myform.elements[i].value = "";
		}
	}
}