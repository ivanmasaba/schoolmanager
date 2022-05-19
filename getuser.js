// JavaScript Document

var xmlHttp;

function getUser(str)
{
if (str.length==0)
  { 
  	document.getElementById("response").innerHTML="";
  	return;
  }
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  	alert ("Your browser does not support AJAX!");
  	return;
  } 
var url="getuser.php";
url=url+"?uname="+str;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
} 

function stateChanged() 
{ 
if (xmlHttp.readyState==4)
{ 
	document.getElementById("response").innerHTML=xmlHttp.responseText;
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

setInterval(showTime, 5000);

function showTime()
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	  {
	  alert ("Your browser does not support AJAX!");
	  return;
	  } 
	var url="current_time.php";
	url=url+"?sid="+Math.random();
	xmlHttp.onreadystatechange=timeChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
} 

function timeChanged() 
{ 
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("current_time").innerHTML=xmlHttp.responseText;
	}
}