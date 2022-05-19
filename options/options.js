// JavaScript Document

//does the magic with the search-box i.e change background and staff
function magic(action)
{
	if( action == "off" )
	{
		document.getElementById("search_name").style.color = "#888888";
		document.getElementById("search_name").style.fontStyle = "italic";
		document.getElementById("search_name").style.width = "340px";
		document.getElementById("search_name").style.background = "#f1f4f9 url(images/search_bg.gif) right no-repeat";
	}
	else
	{
		document.getElementById("search_name").value = "";
		document.getElementById("search_name").style.color = "#000000";
		document.getElementById("search_name").style.fontStyle = "normal";
		document.getElementById("search_name").style.width = "340px";
		document.getElementById("search_name").style.background = "#ffffff url(images/search_bg.gif) right no-repeat";
	}
}

var xmlHttp;
//function for live search to locate a name
function showHint( str )
{
	if ( str.length==0 )
	{ 
	  document.getElementById("show_hint").innerHTML = "";
	  return;
	}
	xmlHttp=GetXmlHttpObject();
	if ( xmlHttp==null )
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	} 
	var url="live_search.php";
	url=url+"?hint="+str;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
} 

function stateChanged() 
{ 
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("show_hint").innerHTML = xmlHttp.responseText;
	}
}

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

//Does the show and hide different forms
//changes the arrow image
function show_hide( object_name, heading )
{
	if( document.getElementById(object_name).style.display == "none" )
	{
		document.getElementById("change_current_pass").style.display = "none";
		document.getElementById("upload_new_pic").style.display = "none";
		document.getElementById("add_new_user").style.display = "none";
		document.getElementById("permit_change").style.display = "none";
		document.getElementById("first").style.background = "url(images/ClickDownNormal.gif) right no-repeat";
		document.getElementById("second").style.background = "url(images/ClickDownNormal.gif) right no-repeat";
		document.getElementById("third").style.background = "url(images/ClickDownNormal.gif) right no-repeat";
		document.getElementById("fourth").style.background = "url(images/ClickDownNormal.gif) right no-repeat";
		document.getElementById(object_name).style.display = "block";
		document.getElementById(heading).style.background = "url(images/ClickDownExpanded.gif) right no-repeat";
	}
	else
	{
		document.getElementById(object_name).style.display = "none";
		document.getElementById(heading).style.background = "url(images/ClickDownNormal.gif) right no-repeat";
	}
}
//Helps fill the create new user form
function help_fill(hint)
{
	var num1 =  parseInt( (Math.random()*25) + 97 );
	var num2 =  parseInt( (Math.random()*25) + 97 );
	var num3 =  parseInt( (Math.random()*25) + 97 );
	var num4 =  parseInt( (Math.random()*25) + 97 );
	var num5 =  parseInt( (Math.random()*25) + 97 );
	var num6 =  parseInt( (Math.random()*25) + 97 );
	document.getElementById("new_uname").value = hint;
	//use 6 random numbers between 96 and 123 to generate a password
	if( document.getElementById("new_user_id").value == "")
	{
		document.getElementById("newu_password").value =  "";
	}
	else if( document.getElementById("newu_password").value == "" )
	{
		document.getElementById("newu_password").value =  String.fromCharCode(num1, num2, num3, num4, num5, num6);
	}
}
//which form should I show
function showCorrectForm(formName)
{
	
	if(formName == "")
		return;
	else
		document.getElementById(formName).style.display = "block";
}