//fuction to show the right results from showthis.php
function show(str1, str2)
{
  var subject = document.getElementById("selectSubject").value;
  var myClass = str1;
  var stream = str2;
  const xhttp = new XMLHttpRequest();
  

  var url="showThis.php";
  url=url+"?class="+myClass+"&stream="+stream+"&subject="+subject;
  url=url+"&sid="+Math.random();
  console.log(url);
  xhttp.open("GET",url,true);
  xhttp.onreadystatechange = function() 
  { 
	if (this.readyState==4 && this.status == 200)
	{ 
	  document.getElementById("showClassResults").innerHTML = this.responseText;
	  console.log( url );
	}
  };
  xhttp.send();
}