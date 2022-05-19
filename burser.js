// JavaScript Document

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

//does the magic with the search-box i.e change background and staff
function magic(action)
{
	document.getElementById("search_name").style.width = "340px";
	if( action == "off" )
	{
		document.getElementById("search_name").style.color = "#888888";
		document.getElementById("search_name").style.background = "#f1f4f9 url(images/search_bg.gif) right no-repeat";
	}
	else
	{
		document.getElementById("search_name").value = "";
		document.getElementById("search_name").style.color = "#000000";
		document.getElementById("search_name").style.fontStyle = "normal";
		document.getElementById("search_name").style.background = "#ffffff url(images/search_bg.gif) right no-repeat";
	}
}